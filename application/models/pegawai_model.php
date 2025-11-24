<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{


    public function get_by_nip_or_nama($nip, $nama)
    {
        return $this->db
            ->where('nip', $nip)
            ->or_where('nama_pegawai', $nama)
            ->get('pegawai')
            ->row(); // OBJECT
    }

    public function get_by_nip($nip)
    {
        return $this->db
            ->get_where('pegawai', ['nip' => $nip])
            ->row(); // OBJECT
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where('pegawai', ['id_pegawai' => $id])
            ->row(); // OBJECT
    }


    public function insert($data)
    {
        // Cek apakah pegawai sudah ada
        $existing = $this->db->where('nip', $data['nip'])
            ->get('pegawai')
            ->row();

        if ($existing) {
            return false; // Tidak insert, sudah ada
        }

        return $this->db->insert('pegawai', $data);
    }


    public function update($id, $data)
    {
        return $this->db->where('id_pegawai', $id)
            ->update('pegawai', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id_pegawai', $id)
            ->delete('pegawai');
    }


    public function get_all()
    {
        return $this->db
            ->select('p.*, d.nama_divisi')
            ->from('pegawai p')
            ->join('divisi d', 'd.id_divisi = p.id_divisi', 'left')
            ->order_by('p.nama_pegawai', 'ASC')
            ->get()
            ->result(); // OBJECT
    }


    public function get_divisi_list()
    {
        return $this->db
            ->select('id_divisi, nama_divisi')
            ->from('divisi')
            ->order_by('nama_divisi', 'ASC')
            ->get()
            ->result(); // OBJECT
    }
}
