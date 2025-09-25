<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pegawai_model extends CI_Model
{

    public function getAll()
    {
        return $this->db->get('pegawai')->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('pegawai', ['id_pegawai' => $id])->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('pegawai', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_pegawai', $id);
        return $this->db->update('pegawai', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('pegawai', ['id_pegawai' => $id]);
    }
    public function countAll($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        return $this->db->count_all_results('pegawai');
    }

    public function getData($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        return $this->db->get('pegawai', $limit, $start)->result_array();
    }
}
