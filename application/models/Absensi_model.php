<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{

    public function getAll()
    {
        $this->db->select('a.*, k.nama, k.nip');
        $this->db->from('absensi a');
        $this->db->join('karyawan k', 'a.id_karyawan = k.id_karyawan');
        $this->db->order_by('a.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('absensi', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('absensi', ['id_absensi' => $id]);
    }
}
