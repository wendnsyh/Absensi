<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public function getAll()
    {
        return $this->db->get('karyawan')->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('karyawan', ['id_karyawan' => $id])->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('karyawan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_karyawan', $id);
        return $this->db->update('karyawan', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('karyawan', ['id_karyawan' => $id]);
    }
}
