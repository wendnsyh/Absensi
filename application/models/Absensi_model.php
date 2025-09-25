<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    public function get_all_absensi($limit, $start, $bulan = null, $tahun = null, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        if (!empty($bulan) && !empty($tahun)) {
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
        }
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get('absensi', $limit, $start);
        return $query->result_array();
    }

    public function count_all_absensi($bulan = null, $tahun = null, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        if ($bulan && $tahun) {
            $this->db->where('MONTH(tanggal)', $bulan);
            $this->db->where('YEAR(tanggal)', $tahun);
        }
        return $this->db->get('absensi')->num_rows();
    }

    public function insert_batch($data)
    {
        return $this->db->insert_batch('absensi', $data);
    }

    public function add_absensi($data)
    {
        return $this->db->insert('absensi', $data);
    }

    public function delete_absensi($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('absensi');
    }

    public function get_all_pegawai()
    {
        return $this->db->get('pegawai')->result_array();
    }

    public function get_pegawai_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('pegawai')->row_array();
    }

    public function get_absensi_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('absensi')->row_array();
    }

    // Fungsi untuk memeriksa apakah data absensi sudah ada
    public function absensi_exists($nip, $bulan, $tahun)
    {
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get('absensi')->num_rows() > 0;
    }

    // Fungsi untuk memperbarui data absensi yang sudah ada
    public function update_absensi($nip, $bulan, $tahun, $data)
    {
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->update('absensi', $data);
    }
}
