<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saw_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Divisi_model');
        $this->load->library(['session', 'form_validation']);
    }

    private function set_weather_data(&$data)
    {
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";
        $weather_data = @json_decode(@file_get_contents($api_url), true);

        if ($weather_data && isset($weather_data['current'])) {
            $data['temperature'] = $weather_data['current']['temperature_2m'];
            $data['wind_speed'] = $weather_data['current']['wind_speed_10m'];
            $data['humidity'] = $weather_data['current']['relative_humidity_2m'];
            $data['weather_code'] = $weather_data['current']['weather_code'];
            $data['update_time'] = date('d M Y H:i', strtotime($weather_data['current']['time']));
            $data['sunrise'] = date('H:i', strtotime($weather_data['daily']['sunrise'][0]));
            $data['sunset'] = date('H:i', strtotime($weather_data['daily']['sunset'][0]));
        } else {
            $data['temperature'] = '-';
            $data['wind_speed'] = '-';
            $data['humidity'] = '-';
            $data['weather_code'] = '-';
            $data['sunrise'] = '-';
            $data['sunset'] = '-';
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
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $id_divisi = $this->input->get('id_divisi') ?: null;
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['title'] = 'Hasil SAW';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['list_divisi'] = $this->Pegawai_model->get_divisi_list();
        $data['selected_divisi'] = $id_divisi;

        $this->set_weather_data($data);

        $penilaian = $this->Saw_model->get_penilaian($bulan, $tahun, $id_divisi);
        $bobot = $this->Saw_model->get_bobot();

        $hasil = [];
        if (!empty($penilaian)) {
            $max_hari = max(array_column($penilaian, 'hari_kerja')) ?: 1;
            $max_skills = max(array_column($penilaian, 'skills')) ?: 1;
            $max_attitude = max(array_column($penilaian, 'attitude')) ?: 1;

            foreach ($penilaian as $p) {
                $normal = [
                    'hari' => $p['hari_kerja'] / $max_hari,
                    'skills' => $p['skills'] / $max_skills,
                    'attitude' => $p['attitude'] / $max_attitude
                ];

                $nilai_akhir = ($normal['hari'] * $bobot['hari_kerja']) +
                    ($normal['skills'] * $bobot['skills']) +
                    ($normal['attitude'] * $bobot['attitude']);

                $hasil[] = [
                    'nama' => $p['nama'],
                    'nip' => $p['nip'],
                    'divisi' => $p['divisi'],
                    'hari_kerja' => $p['hari_kerja'],
                    'skills' => $p['skills'],
                    'attitude' => $p['attitude'],
                    'nilai_akhir' => round($nilai_akhir, 4)
                ];
            }

            usort($hasil, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);
        }

        $data['hasil'] = $hasil;
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);
        $this->load->view('template/footer');
    }

    public function input_penilaian()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $data['title'] = 'Input Penilaian Karyawan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $this->set_weather_data($data);

        // ambil master pegawai
        $data['pegawai'] = $this->Pegawai_model->get_all();
        $data['penilaian'] = $this->Saw_model->get_all_penilaian($bulan, $tahun);

        $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'required');
        $this->form_validation->set_rules('skills', 'Skills', 'required|numeric');
        $this->form_validation->set_rules('attitude', 'Attitude', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('saw/penilaian', $data);
            $this->load->view('template/footer');
            return;
        }

        $id_pegawai = $this->input->post('id_pegawai');
        $skills = $this->input->post('skills');
        $attitude = $this->input->post('attitude');

        $hari_kerja = $this->Saw_model->get_total_hadir_by_nip($this->db->get_where('pegawai', ['id_pegawai' => $id_pegawai])->row()->nip, $bulan, $tahun);

        $this->Saw_model->simpan_penilaian($id_pegawai, $hari_kerja, $skills, $attitude, $bulan, $tahun);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Penilaian berhasil disimpan!</div>');
        redirect("saw/input_penilaian?bulan=$bulan&tahun=$tahun");
    }

    public function bobot()
    {
        $data['title'] = 'Bobot Kriteria';
        $this->set_weather_data($data);
        $data['bobot'] = $this->Saw_model->get_bobot();
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer');
    }

    public function update_bobot()
    {
        $hari = (float)$this->input->post('hari_kerja');
        $skills = (float)$this->input->post('skills');
        $attitude = (float)$this->input->post('attitude');

        if (($hari + $skills + $attitude) != 100.0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Total bobot harus 100%.</div>');
        } else {
            $this->db->update('bobot_kriteria', ['hari_kerja' => $hari, 'skills' => $skills, 'attitude' => $attitude]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Bobot berhasil diperbarui.</div>');
        }
        redirect('saw/bobot');
    }
}
