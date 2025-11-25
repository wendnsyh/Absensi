<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw_model extends CI_Model
{

    public function get_pegawai_by_periode($periode_type, $periode_key, $divisi = null)
    {
        // Periode
        switch ($periode_type) {

            case 'monthly': // format YYYY-MM
                list($year, $month) = explode('-', $periode_key);
                $this->db->where('YEAR(ah.tanggal)', $year);
                $this->db->where('MONTH(ah.tanggal)', $month);
                break;

            case 'quarterly': // Q1-2025
                list($quarter, $year) = explode('-', $periode_key);
                $q = substr($quarter, 1); // ambil angka 1/2/3/4
                $start = (($q - 1) * 3) + 1;
                $end   = $start + 2;

                $this->db->where('YEAR(ah.tanggal)', $year);
                $this->db->where("MONTH(ah.tanggal) BETWEEN $start AND $end");
                break;

            case 'semester': // S1-2025
                list($s, $year) = explode('-', $periode_key);
                if ($s == "S1") {
                    $this->db->where('YEAR(ah.tanggal)', $year);
                    $this->db->where("MONTH(ah.tanggal) BETWEEN 1 AND 6");
                } else {
                    $this->db->where('YEAR(ah.tanggal)', $year);
                    $this->db->where("MONTH(ah.tanggal) BETWEEN 7 AND 12");
                }
                break;

            case 'yearly':
                $this->db->where('YEAR(ah.tanggal)', $periode_key);
                break;
        }

        // Ambil data dari absensi
        $this->db->select("
        ah.nip,
        p.id_pegawai,
        p.nama_pegawai,
        p.nip AS pegawai_nip,
        p.id_divisi,
        d.nama_divisi,
        COUNT(ah.tanggal) AS hari_kerja
    ");

        $this->db->from("absensi_harian ah");

        $this->db->join("pegawai p", "p.nip = ah.nip", "left");
        $this->db->join("divisi d", "d.id_divisi = p.id_divisi", "left");

        // Filter divisi optional
        if ($divisi != "" && $divisi != null) {
            $this->db->where("p.id_divisi", $divisi);
        }

        $this->db->group_by("ah.nip");
        $this->db->order_by("p.nama_pegawai", "ASC");

        return $this->db->get()->result();
    }

    public function get_bobot()
    {
        return $this->db->get('bobot_saw')->row_array();
    }

    public function update_bobot($data)
    {
        return $this->db->update('bobot_saw', $data, ['id' => 1]);
    }
}
