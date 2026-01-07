<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiHarian_model extends CI_Model
{
    protected $table = 'absensi_harian';

    /* =========================
       INSERT
    ========================= */
    public function insert_batch($data)
    {
        return !empty($data)
            ? $this->db->insert_batch($this->table, $data)
            : false;
    }

    public function get_by_bulan_tahun($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('absensi_harian');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result();
    }

    /* =========================
       GET BY NIP + BULAN + TAHUN
       (TANPA LOGIKA TELAT)
    ========================= */
    public function get_by_nip_bulan_tahun($nip, $bulan, $tahun)
    {
        return $this->db
            ->from($this->table)
            ->where('nip', $nip)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->order_by('tanggal', 'ASC')
            ->get()
            ->result_array();
    }

    /* =========================
       REKAP PEGAWAI BULANAN
    ========================= */
    public function get_rekap_bulanan($bulan, $tahun)
    {
        return $this->db
            ->select('a.nip, COALESCE(p.nama_pegawai, a.nama) AS nama_pegawai')
            ->from('absensi_harian a')
            ->join('pegawai p', 'p.nip = a.nip', 'left')
            ->where('MONTH(a.tanggal)', $bulan)
            ->where('YEAR(a.tanggal)', $tahun)
            ->group_by('a.nip')
            ->order_by('nama_pegawai', 'ASC')
            ->get()
            ->result_array();
    }

    /* =========================
       LIST PEGAWAI (PAGINATION)
    ========================= */
    public function get_all($limit, $start, $bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->select('nip, nama')->from($this->table);

        if ($bulan) $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun) $this->db->where('YEAR(tanggal)', $tahun);

        if ($keyword) {
            $this->db->group_start()
                ->like('nama', $keyword)
                ->or_like('nip', $keyword)
                ->group_end();
        }

        return $this->db
            ->group_by('nip')
            ->order_by('nama', 'ASC')
            ->limit($limit, $start)
            ->get()
            ->result_array();
    }

    public function count_all($bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->from($this->table);

        if ($bulan) $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun) $this->db->where('YEAR(tanggal)', $tahun);

        if ($keyword) {
            $this->db->group_start()
                ->like('nama', $keyword)
                ->or_like('nip', $keyword)
                ->group_end();
        }

        return $this->db
            ->group_by('nip')
            ->get()
            ->num_rows();
    }

    /* =========================
       DETAIL FULL (ADMIN / EXPORT)
    ========================= */
    public function get_harian_full($bulan, $tahun)
    {
        return $this->db
            ->select('a.*, COALESCE(p.nama_pegawai, a.nama) AS nama_fix')
            ->from('absensi_harian a')
            ->join('pegawai p', 'p.nip = a.nip', 'left')
            ->where('MONTH(a.tanggal)', $bulan)
            ->where('YEAR(a.tanggal)', $tahun)
            ->order_by('a.nip', 'ASC')
            ->order_by('a.tanggal', 'ASC')
            ->get()
            ->result();
    }

    /* =========================
       PEGAWAI
    ========================= */
    public function get_pegawai_by_nip($nip)
    {
        return $this->db
            ->where('nip', $nip)
            ->get('pegawai')
            ->row();
    }

    /* =========================
       RANGE TANGGAL (REKAP)
    ========================= */
    public function get_rekap_range($start, $end)
    {
        return $this->db
            ->select('a.nip, COALESCE(p.nama_pegawai,a.nama) AS nama_pegawai')
            ->from('absensi_harian a')
            ->join('pegawai p', 'p.nip=a.nip', 'left')
            ->where('a.tanggal >=', $start)
            ->where('a.tanggal <=', $end)
            ->group_by('a.nip')
            ->order_by('nama_pegawai', 'ASC')
            ->get()
            ->result_array();
    }
}
