<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function getAllUsers()
    {
        return $this->db->get('user')->result_array();
    }

    public function getUserRoles()
    {
        return $this->db->get('user_role')->result_array();
    }

    public function insertUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function deleteUser($id)
    {
        return $this->db->delete('user', ['id' => $id]);
    }
}
