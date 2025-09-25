<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property User_model $User_model
 */

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        is_logged_in();
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Dashboard";

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/footer');
    }

    public function manage_user()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Manajemen Akun";
        $data['users'] = $this->User_model->getAllUsers();
        $data['roles'] = $this->User_model->getUserRoles();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/manage_user', $data);
        $this->load->view('template/footer');
    }

    public function addUser()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

        if ($this->form_validation->run() == false) {
            $this->manage_user();
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2, // default Admin, tidak bisa buat Super Admin
                'is_active' => 1
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">Admin berhasil ditambahkan!</div>'
            );
            redirect('admin/manageUser');
        }
    }

    public function deleteUser($id)
    {
        $user = $this->db->get_where('user', ['id' => $id])->row_array();

        if ($user['role_id'] == 1) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">Super Admin tidak bisa dihapus!</div>'
            );
        } else {
            $this->db->delete('user', ['id' => $id]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">User berhasil dihapus!</div>'
            );
        }

        redirect('admin/manageUser');
    }

    public function role()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Role";

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('template/footer');
    }


    public function editRole($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Edit Role";

        // ambil data role berdasarkan ID
        $data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();

        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // tampilkan form edit
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/edit_role', $data);
            $this->load->view('template/footer');
        } else {
            // update ke database
            $this->db->set('role', $this->input->post('role'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user_role');

            $this->session->set_flashdata('message', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        Role berhasil diperbarui!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
            redirect('admin/role');
        }
    }

    public function roleaccess($role_id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Role Access";

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/role_akses', $data);
        $this->load->view('template/footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Akses telah diubah!</div>');
    }
}
