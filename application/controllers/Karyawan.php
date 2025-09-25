<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property Karyawan_model $Karyawan_model
 * @property CI_URI  $uri
 */

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
        $this->load->library('pagination');

        $keyword = $this->input->get('keyword'); // ambil keyword dari form GET
        $config['base_url'] = base_url('karyawan/index');
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;

        // Hitung total baris (dengan filter pencarian)
        $config['total_rows'] = $this->Karyawan_model->countAll($keyword);

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
        $data['title'] = 'Data Karyawan';
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['karyawan'] = $this->Karyawan_model->getData($config['per_page'], $start, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword'] = $keyword;

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
