<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }

        // VALIDASI
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            [
                'required' => 'Username wajib diisi'
            ]
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim',
            [
                'required' => 'Password wajib diisi'
            ]
        );

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db
            ->get_where('user', ['username' => $username])
            ->row_array();

        if (!$user) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Username tidak terdaftar</div>'
            );
            redirect('auth');
        }

        if ($user['is_active'] != 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Akun belum aktif</div>'
            );
            redirect('auth');
        }

        if (!password_verify($password, $user['password'])) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Password salah</div>'
            );
            redirect('auth');
        }

        // LOGIN BERHASIL
        $this->session->set_userdata([
            'username' => $user['username'],
            'role_id'  => $user['role_id']
        ]);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Anda berhasil logout</div>'
        );
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
