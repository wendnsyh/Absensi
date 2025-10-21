<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Karyawan_model', 'karyawan');
        $this->load->library('form_validation'); // <-- Tambahkan ini
    }

    public function index()
    {
        $data['title'] = 'Data Karyawan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['karyawan'] = $this->karyawan->getAll();

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
        $this->load->view('karyawan/index', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        // Aturan validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[karyawan.nik]', [
            'is_unique' => 'NIK sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Jika gagal validasi, balik ke halaman index
            $this->index();
        } else {
            $data = [
                'nama'    => $this->input->post('nama'),
                'nik'     => $this->input->post('nik'),
                'jabatan' => $this->input->post('jabatan'),
                'divisi'  => $this->input->post('divisi'),
            ];

            $this->karyawan->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data karyawan berhasil ditambahkan!</div>');
            redirect('karyawan');
        }
    }

    public function edit($id)
    {
        // Aturan validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Jika gagal validasi, balik ke halaman index
            $this->index();
        } else {
            $data = [
                'nama'    => $this->input->post('nama'),
                'nik'     => $this->input->post('nik'),
                'jabatan' => $this->input->post('jabatan'),
                'divisi'  => $this->input->post('divisi'),
            ];

            $this->karyawan->update($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data karyawan berhasil diupdate!</div>');
            redirect('karyawan');
        }
    }
}
