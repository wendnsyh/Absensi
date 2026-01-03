<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanAbsensi_model extends CI_Model
{
  
    public function get_laporan($start, $end, $divisi_id = null)
    {
        $this->db->select("
            p.nip,
            p.nama_pegawai,
            a.tanggal,
            a.jam_in,
            a.jam_out,
            a.status_pulang,
            a.bukti
        ");
        $this->db->from('absensi_harian a');
        $this->db->join('pegawai p', 'p.nip = a.nip');
        $this->db->where('a.tanggal >=', $start);
        $this->db->where('a.tanggal <=', $end);

        if (!empty($divisi_id)) {
            $this->db->where('p.divisi_id', $divisi_id);
        }

        $this->db->order_by('p.nama_pegawai', 'ASC');
        $this->db->order_by('a.tanggal', 'ASC');

        return $this->db->get()->result_array();
    }

   
    public function get_laporan_pdf($start, $end, $divisi_id = null)
    {
        return $this->get_laporan($start, $end, $divisi_id);
    }
}
