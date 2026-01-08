<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $data['title'] = 'Data Pegawai';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['divisi_list'] = $this->Pegawai_model->get_divisi_list();
        $data['pegawai'] = $this->Pegawai_model->get_all();
        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->form_validation->set_rules('nama_pegawai', 'Nama', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->index();
            return;
        }

        $data = [
            'nama_pegawai' => $this->input->post('nama_pegawai', true),
            'nip' => $this->input->post('nip', true),
            
            'id_divisi' => $this->input->post('id_divisi') ?: null
        ];

        $this->Pegawai_model->insert($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Pegawai berhasil ditambahkan!</div>');
        redirect('pegawai');
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->form_validation->set_rules('nama_pegawai', 'Nama', 'required|trim');

        if ($this->form_validation->run() === false) {
            $this->index();
            return;
        }

        $data = [
            'nama_pegawai' => $this->input->post('nama_pegawai', true),
            'nip' => $this->input->post('nip', true),
            'id_divisi' => $this->input->post('id_divisi') ?: null
        ];

        $this->Pegawai_model->update($id, $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Pegawai berhasil diperbarui!</div>');
        redirect('pegawai');
    }

    public function delete($id)
    {
        $this->Pegawai_model->delete($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Pegawai berhasil dihapus!</div>');
        redirect('pegawai');
    }
}
