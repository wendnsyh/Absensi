<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Pegawai_model $Pegawai_model
 */

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pegawai_model');
        $this->load->library('pagination');
    }

    public function index()
    {
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

        // Pagination
        $this->load->library('pagination');

        $keyword = $this->input->get('keyword');
        $filter_divisi = $this->input->get('divisi');

        $data['keyword'] = $keyword;
        $data['filter_divisi'] = $filter_divisi;

        $config['base_url'] = base_url('pegawai/index');
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE;

        // Hitung total data
        $config['total_rows'] = $this->pegawai_model->count_filtered($keyword, $filter_divisi);

        // Style Bootstrap
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        // ⬅️ INI BAGIAN PENTING
        $start = $this->uri->segment(3, 0);
        $data['start'] = $start;

        // Ambil data pegawai
        $data['pegawai'] = $this->pegawai_model->get_filtered($config['per_page'], $start, $keyword, $filter_divisi);

        // Ambil daftar divisi untuk filter & dropdown
        $data['divisi_list'] = $this->pegawai_model->get_divisi_list();

        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Data Pegawai';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
    }


    public function add()
    {
        $nip = $this->input->post('nip', true);

        if ($this->db->get_where('pegawai', ['nip' => $nip])->row_array()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah digunakan!</div>');
            redirect('pegawai');
        }

        $data = [
            'nama_pegawai'   => $this->input->post('nama', true),
            'nip'            => $this->input->post('nip', true),
            'divisi'         => $this->input->post('divisi', true),
            'jabatan'        => $this->input->post('jabatan', true),
            'status_aktif'   => 'aktif'
        ];

        $this->db->insert('pegawai', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Pegawai berhasil ditambahkan!</div>');
        redirect('pegawai');
    }


    public function edit($id)
    {
        $nip = $this->input->post('nip', true);

        // Pastikan tidak duplikasi NIP
        $exists = $this->db->get_where('pegawai', ['nip' => $nip, 'id_pegawai !=' => $id])->row_array();
        if ($exists) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah digunakan pegawai lain!</div>');
            redirect('pegawai');
        }

        $data = [
            'nama_pegawai' => $this->input->post('nama', true),
            'nip'          => $this->input->post('nip', true),
            'divisi'       => $this->input->post('divisi', true),
            'jabatan'      => $this->input->post('jabatan', true),
            'status_aktif' => $this->input->post('status_aktif', true),
        ];

        $this->db->where('id_pegawai', $id);
        $this->db->update('pegawai', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data pegawai berhasil diperbarui!</div>');
        redirect('pegawai');
    }

    public function delete($id)
    {
        $this->db->delete('pegawai', ['id_pegawai' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Pegawai berhasil dihapus!</div>');
        redirect('pegawai');
    }
}
