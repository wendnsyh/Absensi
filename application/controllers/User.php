<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['title'] = "Profil Saya";

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/index', $data); 
        $this->load->view('template/footer');
    }

    public function update()
    {
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();

        $name  = $this->input->post('name');
        $email = $this->input->post('email');
        $password_baru       = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        // validasi
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            // Upload Foto jika ada
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048;
                $config['upload_path']   = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('user');
                }
            }

            // Update data dasar
            $this->db->set('name', $name);
            $this->db->set('email', $email);

            // Update password jika diisi
            if (!empty($password_baru)) {
                if ($password_baru === $konfirmasi_password) {
                    $this->db->set('password', password_hash($password_baru, PASSWORD_DEFAULT));
                } else {
                    $this->session->set_flashdata('error', '
                        <div class="alert alert-danger">Konfirmasi password tidak sesuai!</div>
                    ');
                    redirect('user');
                }
            }

            $this->db->where('id', $data['user']['id']);
            $this->db->update('user');

            $this->session->set_flashdata('success', '
                <div class="alert alert-success">Profil berhasil diperbarui!</div>
            ');
            redirect('user');
        }
    }
}
