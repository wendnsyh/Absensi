<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiHarian_model extends CI_Model
{
    private $table = 'absensi_harian';

    public function insert_batch($data)
    {
        if (!empty($data)) {
            return $this->db->insert_batch($this->table, $data);
        }
        return false;
    }

    public function get_rekap_bulanan($bulan, $tahun, $limit = null, $start = 0, $keyword = null)
    {
        $this->db->select('nip, nama, MIN(tanggal) as tanggal');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('nip, nama');
        $this->db->order_by('nama', 'ASC');

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();
    }

    public function get_detail_pegawai($nip, $bulan, $tahun)
    {
        $this->db->from($this->table);
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_by_nip_bulan_tahun($nip, $bulan, $tahun)
    {
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    // --- FUNGSI BARU UNTUK PAGINATION & PENCARIAN (TABEL `absensi_harian`) ---

    public function get_all($limit = null, $start = 0, $bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->select('absensi_harian.*, pegawai.nama');
        $this->db->from($this->table);
        $this->db->join('pegawai', 'pegawai.nip = absensi_harian.nip', 'left');

        if ($bulan) {
            $this->db->where('MONTH(absensi_harian.tanggal)', $bulan);
        }
        if ($tahun) {
            $this->db->where('YEAR(absensi_harian.tanggal)', $tahun);
        }
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('pegawai.nama', $keyword);
            $this->db->or_like('absensi_harian.nip', $keyword);
            $this->db->group_end();
        }
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('absensi_harian.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function count_all($bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->from($this->table);
        $this->db->join('pegawai', 'pegawai.nip = absensi_harian.nip', 'left');

        if ($bulan) {
            $this->db->where('MONTH(absensi_harian.tanggal)', $bulan);
        }
        if ($tahun) {
            $this->db->where('YEAR(absensi_harian.tanggal)', $tahun);
        }
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('pegawai.nama', $keyword);
            $this->db->or_like('absensi_harian.nip', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }
}
