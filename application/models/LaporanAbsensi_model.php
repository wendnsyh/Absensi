<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanAbsensi_model extends CI_Model
{
    /* ============================
       LAPORAN INDEX (REKAP)
       ============================ */
    public function get_index($bulan, $tahun, $divisi_id = null)
    {
        $this->db->select("
        p.nip,
        p.nama_pegawai,
        COUNT(DISTINCT a.tanggal) AS total_hari_kerja
    ");
        $this->db->from('absensi_harian a');
        $this->db->join('pegawai p', 'p.nip = a.nip', 'left');

        $this->db->where('MONTH(a.tanggal)', (int)$bulan);
        $this->db->where('YEAR(a.tanggal)', (int)$tahun);

        if (!empty($divisi_id)) {
            $this->db->where('p.divisi_id', $divisi_id);
        }

        $this->db->group_by('a.nip');
        $this->db->order_by('p.nama_pegawai', 'ASC');

        return $this->db->get()->result();
    }


    /* ============================
       LAPORAN DETAIL
       ============================ */
    public function get_detail($nip, $bulan, $tahun)
    {
        return $this->db->select("
        a.tanggal,
        a.hari,
        a.jam_in,
        a.jam_out,
        a.keterangan,
        a.bukti,
        a.menit_telat,
        a.id_denda
    ")
            ->from('absensi_harian a')
            ->where('a.nip', $nip)
            ->where('MONTH(a.tanggal)', $bulan)
            ->where('YEAR(a.tanggal)', $tahun)
            ->order_by('a.tanggal', 'ASC')
            ->get()
            ->result();
    }
}
