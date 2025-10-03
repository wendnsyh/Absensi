<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    public function get_all_absensi($limit, $start, $bulan, $tahun, $keyword = null)
    {
        $this->db->limit($limit, $start);

        // filter tahun kalau ada
        if ($tahun != 0) {
            $this->db->where('YEAR(tanggal)', $tahun);
        }

        // filter bulan kalau ada
        if ($bulan != 0) {
            $this->db->where('MONTH(tanggal)', $bulan);
        }

        // filter keyword (nama/nip)
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
            $this->db->group_end();
        }
        $this->db->order_by('nama', 'ASC');

        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('absensi')->result_array();
    }

    public function count_all_absensi($bulan, $tahun, $keyword = null)
    {
        if ($tahun != 0) {
            $this->db->where('YEAR(tanggal)', $tahun);
        }

        if ($bulan != 0) {
            $this->db->where('MONTH(tanggal)', $bulan);
        }

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
            $this->db->group_end();
        }

        return $this->db->count_all_results('absensi');
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
    public function get_monthly_summary($bulan, $tahun)
    {
        $this->db->select('
        SUM(hadir) as total_hadir,
        SUM(sakit) as total_sakit,
        SUM(izin) as total_izin,
        SUM(alfa) as total_alfa,
        SUM(dinas_luar) as total_dinas_luar,
        SUM(terlambat_kurang_30) + SUM(terlambat_30_90) + SUM(terlambat_lebih_90) as total_telat
    ');
        $this->db->from('absensi');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Fungsi untuk menghitung total pegawai
    public function get_total_pegawai()
    {
        return $this->db->count_all('pegawai');
    }
}
