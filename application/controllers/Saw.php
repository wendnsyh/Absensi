<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model');
        $this->load->model('Divisi_model');
        $this->load->model('Saw_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->library(['session', 'form_validation']);
    }


    private function set_weather_data(&$data)
    {
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";

        $weather_data = @json_decode(@file_get_contents($api_url), true);

        if ($weather_data && isset($weather_data['current'])) {
            $data['temperature']   = $weather_data['current']['temperature_2m'];
            $data['wind_speed']    = $weather_data['current']['wind_speed_10m'];
            $data['humidity']      = $weather_data['current']['relative_humidity_2m'];
            $data['weather_code']  = $weather_data['current']['weather_code'];
            $data['update_time']   = date('d M Y H:i', strtotime($weather_data['current']['time']));
            $data['sunrise']       = date('H:i', strtotime($weather_data['daily']['sunrise'][0]));
            $data['sunset']        = date('H:i', strtotime($weather_data['daily']['sunset'][0]));
        } else {
            $data['temperature'] = '-';
            $data['wind_speed']  = '-';
            $data['humidity']    = '-';
            $data['weather_code'] = '-';
            $data['sunrise']     = '-';
            $data['sunset']      = '-';
        }

        $weather_codes = [
            0 => 'Cerah',
            1 => 'Cerah Berawan',
            2 => 'Berawan',
            3 => 'Mendung',
            45 => 'Kabut',
            48 => 'Kabut Beku',
            51 => 'Gerimis Ringan',
            61 => 'Hujan Ringan',
            63 => 'Hujan Sedang',
            65 => 'Hujan Lebat',
            80 => 'Hujan Lokal',
            95 => 'Badai Petir'
        ];

        $data['weather_text'] = $weather_codes[$data['weather_code']] ?? 'Tidak Diketahui';
    }

    public function index()
    {
        $data['title'] = "Hasil Perhitungan SAW";
        $data['divisi_list'] = $this->Divisi_model->get_all();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->set_weather_data($data);

        $periode_type = $this->input->get('periode_type');
        $periode_key  = $this->input->get('periode_key');
        $divisi       = $this->input->get('divisi');

        $data['periode_type'] = $periode_type;
        $data['periode_key']  = $periode_key;
        $data['divisi']       = $divisi;

        if (!$periode_type || !$periode_key) {
            $data['penilaian'] = [];
            $data['normalisasi'] = [];
            $data['ranking'] = [];
        } else {

            $penilaian = $this->Saw_model->get_penilaian($periode_type, $periode_key, $divisi);
            $data['penilaian'] = $penilaian;

            if ($penilaian) {

                // Ambil max
                $max_skill     = max(array_column($penilaian, 'skill'));
                $max_attitude  = max(array_column($penilaian, 'attitude'));
                $max_kehadiran = max(array_column($penilaian, 'kehadiran'));

                $normal = [];
                foreach ($penilaian as $p) {
                    $normal[] = [
                        'nama_pegawai' => $p['nama_pegawai'],
                        'n_skill'      => $p['skill'] / $max_skill,
                        'n_attitude'   => $p['attitude'] / $max_attitude,
                        'n_kehadiran'  => $p['kehadiran'] / $max_kehadiran
                    ];
                }
                $data['normalisasi'] = $normal;

                // Bobot
                $w1 = 0.4;
                $w2 = 0.3;
                $w3 = 0.3;

                // Hitung nilai akhir
                $ranking = [];
                foreach ($normal as $n) {
                    $ranking[] = [
                        'nama_pegawai' => $n['nama_pegawai'],
                        'nilai_akhir'  => ($n['n_skill'] * $w1) +
                            ($n['n_attitude'] * $w2) +
                            ($n['n_kehadiran'] * $w3)
                    ];
                }

                usort($ranking, function ($a, $b) {
                    return $b['nilai_akhir'] <=> $a['nilai_akhir'];
                });

                $data['ranking'] = $ranking;
            } else {
                $data['normalisasi'] = [];
                $data['ranking'] = [];
            }
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);
        $this->load->view('template/footer');
    }


    public function input_penilaian()
    {
        $data['title'] = "Input Penilaian SAW";
        $data['divisi_list'] = $this->Divisi_model->get_all();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->set_weather_data($data);

        $periode_type = $this->input->get('periode_type');
        $periode_key  = $this->input->get('periode_key');
        $divisi       = $this->input->get('divisi');

        $data['periode_type'] = $periode_type;
        $data['periode_key']  = $periode_key;
        $data['divisi']       = $divisi;

        if ($periode_type && $periode_key) {

            $data['pegawai_list'] = $this->Saw_model->get_pegawai_by_periode($periode_type, $periode_key, $divisi);
        } else {
            $data['pegawai_list'] = [];
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/penilaian', $data);
        $this->load->view('template/footer');
    }

    public function simpan_penilaian()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $skill      = $this->input->post('skill');
        $attitude   = $this->input->post('attitude');
        $kehadiran  = $this->input->post('kehadiran');

        $periode_type = $this->input->post('periode_type');
        $periode_key  = $this->input->post('periode_key');

        foreach ($id_pegawai as $i => $idpg) {
            $insert = [
                'id_pegawai'   => $idpg,
                'skill'        => $skill[$i],
                'attitude'     => $attitude[$i],
                'kehadiran'    => $kehadiran[$i],
                'periode_type' => $periode_type,
                'periode_key'  => $periode_key
            ];
            $this->Saw_model->insert_penilaian($insert);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">Penilaian berhasil disimpan.</div>');
        redirect('saw/input');
    }




    public function bobot()
    {
        $data['title'] = "Pengaturan Bobot SAW";

        // Ambil bobot dari database
        $data['bobot'] = $this->Saw_model->get_bobot();

        $this->set_weather_data($data);
        $data['user'] = $this->db
            ->get_where('user', ['email' => $this->session->userdata('email')])
            ->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer');
    }

    public function update_bobot()
    {
        $skill = $this->input->post('skill');
        $attitude = $this->input->post('attitude');
        $kehadiran = $this->input->post('kehadiran');

        // Validasi jumlah bobot harus 1 (1.0)
        if (($skill + $attitude + $kehadiran) != 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Jumlah bobot harus 1.0</div>'
            );
            redirect('saw/bobot');
        }

        $this->Saw_model->update_bobot([
            'skill' => $skill,
            'attitude' => $attitude,
            'kehadiran' => $kehadiran
        ]);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Bobot berhasil diperbarui!</div>'
        );

        redirect('saw/bobot');
    }
}
