<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_model extends CI_Model
{
    // Fungsi untuk mendapatkan rekap absensi per pegawai dalam periode tertentu
    public function get_absensi_rekap_for_period($start_date, $end_date)
    {
        $this->db->select('
            nama,
            nip,
            SUM(hadir) as total_hadir,
            SUM(terlambat_kurang_30) as total_telat_kurang_30,
            SUM(terlambat_30_90) as total_telat_30_90,
            SUM(terlambat_lebih_90) as total_telat_lebih_90,
            SUM(sakit) as total_sakit,
            SUM(izin) as total_izin,
            SUM(alfa) as total_alfa,
            SUM(cuti) as total_cuti,
            SUM(dinas_luar) as total_dinas_luar,
            SUM(tidak_finger_masuk) as total_tidak_finger_masuk,
            SUM(tidak_finger_pulang) as total_tidak_finger_pulang
        ');
        $this->db->from('absensi');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('nip');
        $this->db->order_by('nama', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}
