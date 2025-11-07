<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saw_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->library(['session', 'form_validation']);
    }

    public function index()
    {
        // 🌤️ Cuaca
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";
        $weather_data = json_decode(file_get_contents($api_url), true);

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
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->model('Saw_model');
        $data['title'] = 'Hasil Penilaian SAW';

        $penilaian = $this->Saw_model->get_penilaian();
        $bobot = $this->Saw_model->get_bobot();

        $hasil = [];

        if (!empty($penilaian)) {
            // Normalisasi dan hitung nilai akhir
            $max_hari = max(array_column($penilaian, 'hari_kerja')) ?: 1;
            $max_skills = max(array_column($penilaian, 'skills')) ?: 1;
            $max_attitude = max(array_column($penilaian, 'attitude')) ?: 1;

            foreach ($penilaian as $p) {
                $nilai_normalisasi = [
                    'hari_kerja' => ($max_hari > 0 ? $p['hari_kerja'] / $max_hari : 0),
                    'skills' => ($max_skills > 0 ? $p['skills'] / $max_skills : 0),
                    'attitude' => ($max_attitude > 0 ? $p['attitude'] / $max_attitude : 0)
                ];

                $nilai_akhir = (
                    ($nilai_normalisasi['hari_kerja'] * $bobot['hari_kerja']) +
                    ($nilai_normalisasi['skills'] * $bobot['skills']) +
                    ($nilai_normalisasi['attitude'] * $bobot['attitude'])
                );

                $hasil[] = [
                    'nip' => $p['nip'],
                    'nama' => $p['nama'],
                    'hari_kerja' => $p['hari_kerja'],
                    'skills' => $p['skills'],
                    'attitude' => $p['attitude'],
                    'nilai_akhir' => round($nilai_akhir, 3)
                ];
            }

            // Urutkan berdasarkan nilai tertinggi
            usort($hasil, function ($a, $b) {
                return $b['nilai_akhir'] <=> $a['nilai_akhir'];
            });
        }

        $data['hasil'] = $hasil;
        $data['title'] = 'Hasil SAW';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);
        $this->load->view('template/footer', $data);
    }

    private function generate_penilaian_otomatis()
    {
        $pegawai_list = $this->Saw_model->get_unique_pegawai_from_absensi();

        foreach ($pegawai_list as $pegawai) {
            $nip = $pegawai['nip'];
            $hari_kerja = $this->Saw_model->get_total_hadir_by_nip($nip);

            // nilai default jika belum ada
            $skills = 0;
            $attitude = 0;

            $this->Saw_model->simpan_penilaian($nip, $hari_kerja, $skills, $attitude);
        }
    }

    public function bobot()
    {
        // 🌤️ Cuaca
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";
        $weather_data = json_decode(file_get_contents($api_url), true);

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
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['bobot'] = $this->Saw_model->get_bobot();
        $data['title'] = 'Bobot Kriteria';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer', $data);
    }

    public function update_bobot()
    {
        $hari_kerja = $this->input->post('hari_kerja');
        $skills = $this->input->post('skills');
        $attitude = $this->input->post('attitude');

        $total = $hari_kerja + $skills + $attitude;

        if ($total != 100) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Total bobot harus sama dengan 100%.</div>');
        } else {
            $data = [
                'hari_kerja' => $hari_kerja,
                'skills' => $skills,
                'attitude' => $attitude
            ];
            $this->Saw_model->update_bobot($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Bobot berhasil diperbarui!</div>');
        }
        redirect('saw/bobot');
    }

    public function input_penilaian()
    {
        // 🌤️ Cuaca
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";
        $weather_data = json_decode(file_get_contents($api_url), true);

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
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // Ambil daftar karyawan unik dari absensi harian
        $data['pegawai'] = $this->Saw_model->get_unique_pegawai_from_absensi();
        $data['title'] = 'Input Penilaian Karyawan';
        $data['penilaian'] = $this->Saw_model->get_all_penilaian();

        $this->form_validation->set_rules('nip', 'NIP', 'required');
        $this->form_validation->set_rules('skills', 'Skills', 'required|numeric');
        $this->form_validation->set_rules('attitude', 'Attitude', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('saw/penilaian', $data);
            $this->load->view('template/footer', $data);
        } else {
            $nip = $this->input->post('nip');
            $skills = $this->input->post('skills');
            $attitude = $this->input->post('attitude');

            // Ambil total hari hadir dari tabel absensi_harian
            $hari_kerja = $this->Saw_model->get_total_hadir_by_nip($nip);

            // Simpan ke tabel penilaian_karyawan
            $this->Saw_model->simpan_penilaian($nip, $hari_kerja, $skills, $attitude);

            $this->session->set_flashdata('message', '<div class="alert alert-success">Penilaian berhasil disimpan!</div>');
            redirect('saw/input_penilaian');
        }
    }
}
