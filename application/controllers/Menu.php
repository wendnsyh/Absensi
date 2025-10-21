<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property Menu_model $menu
 */

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Menu Management";

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Menu baru telah dibuat!</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = "Submenu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Menu', 'required');
        $this->form_validation->set_rules('icon', 'Menu', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sub Menu baru telah dibuat!</div>');
            redirect('menu/submenu');
        }
    }

    public function editSubmenu($id)
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Gagal update submenu!</div>');
        } else {
            $updateData = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            $this->db->where('id', $id);
            $this->db->update('user_sub_menu', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Submenu berhasil diupdate!</div>');
        }
        redirect('menu/submenu');
    }

    public function deleteSubmenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Submenu berhasil dihapus!</div>');
        redirect('menu/submenu');
    }

    public function edit_menu($id = null)
    {
        // Jika ID tidak diberikan, arahkan kembali ke halaman menu atau tampilkan error
        if ($id === null) {
            redirect('menu');
        }

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get_where('user_menu', ['id' => $id])->row_array();

        $this->form_validation->set_rules('menu', 'Nama Menu', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/edit_menu', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->set('menu', $this->input->post('menu'));
            $this->db->where('id', $id);
            $this->db->update('user_menu');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data Anda telah disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button> </div>');
            redirect('menu');
        }
    }

    public function delete_menu($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Menu berhasil dihapus!</div>');
        redirect('menu');
    }
}
