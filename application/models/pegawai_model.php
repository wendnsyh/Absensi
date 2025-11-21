<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{
    public function get_by_nip_or_nama($nip, $nama)
    {
        return $this->db->where('nip', $nip)
            ->or_where('nama_pegawai', $nama)
            ->get('pegawai')
            ->row_array();
    }

    public function get_by_nip($nip)
    {
        return $this->db->get_where('pegawai', ['nip' => $nip])->row_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('pegawai', ['id_pegawai' => $id])->row_array();
    }

    public function insert($data)
    {
        $this->db->insert('pegawai', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_pegawai', $id)->update('pegawai', $data);
    }

    public function delete($id)
    {
        $this->db->delete('pegawai', ['id_pegawai' => $id]);
    }

    public function get_divisi_list()
    {
        $this->db->select('DISTINCT(divisi) as divisi');
        $this->db->from('pegawai');
        $this->db->where('divisi IS NOT NULL');
        $this->db->where('divisi !=', '');
        return $this->db->get()->result();
    }

    public function get_all()
    {
        return $this->db->order_by('nama_pegawai', 'ASC')->get('pegawai')->result();
    }
}
