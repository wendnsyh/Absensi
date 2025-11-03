<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saw_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->library('session');
    }

    public function index()
    {
        $latitude = -6.3452; // Koordinat Kecamatan Setu, Tangerang Selatan
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
            $data['last_update'] = '-';
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
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['hasil'] = $this->Saw_model->hitung_saw();

        $data['title'] = 'Hasil SAW';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);
        $this->load->view('template/footer');
    }

    public function bobot()
    {
        $latitude = -6.3452; // Koordinat Kecamatan Setu, Tangerang Selatan
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
            $data['last_update'] = '-';
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
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['bobot'] = $this->Saw_model->get_bobot();
        $data['title'] = 'Bobot';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer');
    }

    public function update_bobot()
    {
        $hari_kerja = $this->input->post('hari_kerja') / 100;
        $skills = $this->input->post('skills') / 100;
        $attitude = $this->input->post('attitude') / 100;

        $total = $hari_kerja + $skills + $attitude;

        if ($total > 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Total bobot tidak boleh lebih dari 100%.</div>');
        } else {
            $this->Saw_model->update_bobot([
                'hari_kerja' => $hari_kerja,
                'skills' => $skills,
                'attitude' => $attitude
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Bobot berhasil diperbarui!</div>');
        }
        redirect('saw/atur_bobot');
    }

    // ========== 2. INPUT PENILAIAN ==========
    public function input_penilaian()
    {
        $latitude = -6.3452; // Koordinat Kecamatan Setu, Tangerang Selatan
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
            $data['last_update'] = '-';
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
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->AbsensiHarian_model->get_unique_pegawai();

        // Tambahkan nilai skill & attitude jika ada
        foreach ($data['pegawai'] as &$p) {
            $nilai = $this->Saw_model->get_penilaian_by_nip($p['nip']);
            $p['attitude'] = $nilai ? $nilai['attitude'] : 0;
            $p['skills'] = $nilai ? $nilai['skills'] : 0;
        }
        $data['title'] = 'Penilaian Karyawan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/penilaian', $data);
        $this->load->view('template/footer', $data);
    }

    public function simpan_penilaian()
    {
        $attitude = $this->input->post('attitude');
        $skills = $this->input->post('skills');

        foreach ($attitude as $nip => $nilai_attitude) {
            $data = [
                'nip' => $nip,
                'attitude' => $nilai_attitude,
                'skills' => $skills[$nip]
            ];
            $this->Saw_model->simpan_penilaian($data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">Penilaian berhasil disimpan!</div>');
        redirect('saw/input_penilaian');
    }
}
