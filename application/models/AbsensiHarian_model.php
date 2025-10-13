<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiHarian_model extends CI_Model
{
    private $table = 'absensi_harian';

    // ✅ Simpan data absensi hasil import Excel
    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    // ✅ Ambil daftar pegawai unik (untuk tampilan list nama + NIP)
    public function get_pegawai_list()
    {
        $this->db->select('p.nama, ah.nip');
        $this->db->from($this->table . ' ah');
        $this->db->join('pegawai p', 'p.nip = ah.nip', 'left');
        $this->db->group_by('ah.nip, p.nama');
        $this->db->order_by('p.nama', 'ASC');
        return $this->db->get()->result_array();
    }

    // ✅ Detail absensi per pegawai selama 30 hari terakhir
    public function get_detail_30hari($nip)
    {
        $this->db->select('ah.*, p.nama');
        $this->db->from($this->table . ' ah');
        $this->db->join('pegawai p', 'p.nip = ah.nip', 'left');
        $this->db->where('ah.nip', $nip);
        $this->db->order_by('ah.tanggal', 'ASC');
        $this->db->limit(30);
        return $this->db->get()->result_array();
    }

    // ✅ Rekap bulanan (hanya ambil tanggal 1 setiap pegawai)
    public function get_rekap_bulanan($bulan, $tahun, $limit = null, $start = 0, $keyword = null)
    {
        $this->db->select('ah.nip, p.nama, MIN(ah.tanggal) as tanggal, ah.jam_in, ah.jam_out');
        $this->db->from($this->table . ' ah');
        $this->db->join('pegawai p', 'p.nip = ah.nip', 'left');
        $this->db->where('MONTH(ah.tanggal)', $bulan);
        $this->db->where('YEAR(ah.tanggal)', $tahun);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('p.nama', $keyword);
            $this->db->or_like('ah.nip', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('ah.nip, p.nama');
        $this->db->order_by('p.nama', 'ASC');

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();
    }

    // ✅ Hitung total rekap bulanan (untuk pagination)
    public function count_rekap_bulanan($bulan, $tahun, $keyword = null)
    {
        $this->db->from($this->table . ' ah');
        $this->db->join('pegawai p', 'p.nip = ah.nip', 'left');
        $this->db->where('MONTH(ah.tanggal)', $bulan);
        $this->db->where('YEAR(ah.tanggal)', $tahun);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('p.nama', $keyword);
            $this->db->or_like('ah.nip', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('ah.nip, p.nama');
        return $this->db->get()->num_rows();
    }

    // ✅ Detail absensi 1 pegawai dalam 1 bulan tertentu
    public function get_detail_pegawai($nip, $bulan, $tahun)
    {
        $this->db->select('ah.*, p.nama');
        $this->db->from($this->table . ' ah');
        $this->db->join('pegawai p', 'p.nip = ah.nip', 'left');
        $this->db->where('ah.nip', $nip);
        $this->db->where('MONTH(ah.tanggal)', $bulan);
        $this->db->where('YEAR(ah.tanggal)', $tahun);
        $this->db->order_by('ah.tanggal', 'ASC');
        return $this->db->get()->result_array();
    }
}
