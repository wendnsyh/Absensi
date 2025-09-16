<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in(); // helper login
        $this->load->model('Karyawan_model');
    }

    public function index()
    {
        $data['title'] = 'Data Karyawan';
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['karyawan'] = $this->Karyawan_model->getAll();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('karyawan/index', $data);
        $this->load->view('template/footer');
    }

    public function add()
    {
        $nip = $this->input->post('nip', true);

        // cek apakah nip sudah ada
        $cek = $this->db->get_where('karyawan', ['nip' => $nip])->row_array();
        if ($cek) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah terdaftar, gunakan NIP lain!</div>');
            redirect('karyawan');
        }

        $data = [
            'nama' => $this->input->post('nama', true),
            'nip' => $this->input->post('nip', true),
            'tanggal_masuk' => $this->input->post('tanggal_masuk', true),
            'divisi' => $this->input->post('divisi', true),
        ];

        $this->Karyawan_model->insert($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Karyawan berhasil ditambahkan!</div>');
        redirect('karyawan');
    }

    public function edit($id)
    {
        $nip = $this->input->post('nip', true);

        // cek nip, tapi abaikan nip milik dirinya sendiri
        $cek = $this->db->get_where('karyawan', ['nip' => $nip, 'id_karyawan !=' => $id])->row_array();
        if ($cek) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">NIP sudah digunakan karyawan lain!</div>');
            redirect('karyawan');
        }
        
        $data = [
            'nama' => $this->input->post('nama', true),
            'nip' => $this->input->post('nip', true),
            'tanggal_masuk' => $this->input->post('tanggal_masuk', true),
            'divisi' => $this->input->post('divisi', true),
        ];

        $this->Karyawan_model->update($id, $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Karyawan berhasil diperbarui!</div>');
        redirect('karyawan');
    }

    public function delete($id)
    {
        $this->Karyawan_model->delete($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Karyawan berhasil dihapus!</div>');
        redirect('karyawan');
    }
}
