<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_model extends CI_Model
{

    public function hitung_rekap($bulan, $tahun)
    {
        // Hapus rekap lama untuk bulan dan tahun yang sama (opsional)
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $this->db->delete('rekap_absensi');

        // Query untuk menghitung rekap dari data absensi
        $sql = "
            INSERT INTO rekap_absensi (nip, nama, bulan, tahun, hadir, sakit, izin, alfa, dinas_luar, telat_kurang_30, telat_30_90, telat_lebih_90, total_finger_incomplete)
            SELECT 
                nip,
                nama,
                MONTH(tanggal) AS bulan,
                YEAR(tanggal) AS tahun,
                SUM(hadir) AS hadir,
                SUM(sakit) AS sakit,
                SUM(izin) AS izin,
                SUM(alfa) AS alfa,
                SUM(dinas_luar) AS dinas_luar,
                SUM(terlambat_kurang_30) AS telat_kurang_30,
                SUM(terlambat_30_90) AS telat_30_90,
                SUM(terlambat_lebih_90) AS telat_lebih_90,
                SUM(tidak_finger_masuk + tidak_finger_pulang) AS total_finger_incomplete
            FROM absensi
            WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
            GROUP BY nip, nama, bulan, tahun
        ";
        return $this->db->query($sql, array($bulan, $tahun));
    }
}
