<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property pegawai_model $pegawai_model
 * @property CI_URI  $uri
 */

class Pegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in(); // helper login
        $this->load->model('pegawai_model');
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

        $this->load->library('pagination');

        $keyword = $this->input->get('keyword'); // ambil keyword dari form GET
        $config['base_url'] = base_url('pegawai/index');
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;

        // Hitung total baris (dengan filter pencarian)
        $config['total_rows'] = $this->pegawai_model->countAll($keyword);

        // Style Bootstrap 4
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $data['title'] = 'Data pegawai';
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['pegawai'] = $this->pegawai_model->getData($config['per_page'], $start, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
    }

    public function add()
    {
        $nip = $this->input->post('nip', true);

        // cek apakah nip sudah ada
        $cek = $this->db->get_where('pegawai', ['nip' => $nip])->row_array();
        if ($cek) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah terdaftar, gunakan NIP lain!</div>');
            redirect('pegawai');
        }

        $data = [
            'nama' => $this->input->post('nama', true),
            'nip' => $this->input->post('nip', true),
            'tanggal_masuk' => $this->input->post('tanggal_masuk', true),
            'divisi' => $this->input->post('divisi', true),
        ];

        $this->pegawai_model->insert($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">pegawai berhasil ditambahkan!</div>');
        redirect('pegawai');
    }

    public function edit($id)
    {
        $nip = $this->input->post('nip', true);

        // cek nip, tapi abaikan nip milik dirinya sendiri
        $cek = $this->db->get_where('pegawai', ['nip' => $nip, 'id_pegawai !=' => $id])->row_array();
        if ($cek) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah digunakan pegawai lain!</div>');
            redirect('pegawai');
        }

        $data = [
            'nama' => $this->input->post('nama', true),
            'nip' => $this->input->post('nip', true),
            'tanggal_masuk' => $this->input->post('tanggal_masuk', true),
            'divisi' => $this->input->post('divisi', true),
        ];

        $this->pegawai_model->update($id, $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">pegawai berhasil diperbarui!</div>');
        redirect('pegawai');
    }

    public function delete($id)
    {
        $this->pegawai_model->delete($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">pegawai berhasil dihapus!</div>');
        redirect('pegawai');
    }
}
