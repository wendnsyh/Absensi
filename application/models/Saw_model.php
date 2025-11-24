<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw_model extends CI_Model
{
    public function get_bobot()
    {
        return $this->db->get('bobot_kriteria')->row_array();
    }

    public function get_penilaian($bulan = null, $tahun = null, $id_divisi = null)
    {
        $this->db->select("pk.id_penilaian, pk.id_pegawai, pk.hari_kerja, pk.skills, pk.attitude, pk.bulan, pk.tahun,
            p.nama_pegawai AS nama, p.nip AS nip, p.id_divisi, d.nama_divisi AS divisi");
        $this->db->from('penilaian_karyawan pk');
        $this->db->join('pegawai p', 'p.id_pegawai = pk.id_pegawai', 'left');
        $this->db->join('divisi d', 'd.id_divisi = p.id_divisi', 'left');

        if ($bulan) $this->db->where('pk.bulan', $bulan);
        if ($tahun) $this->db->where('pk.tahun', $tahun);
        if ($id_divisi) $this->db->where('p.id_divisi', $id_divisi);

        return $this->db->get()->result_array();
    }

    public function get_all_penilaian($bulan = null, $tahun = null)
    {
        if (!$bulan) $bulan = date('m');
        if (!$tahun) $tahun = date('Y');

        $this->db->select("p.id_pegawai, p.nip, p.nama_pegawai AS nama, d.nama_divisi AS divisi,
            COALESCE(pk.skills,0) AS skills, COALESCE(pk.attitude,0) AS attitude, COALESCE(pk.hari_kerja,0) AS hari_kerja");
        $this->db->from('pegawai p');
        $this->db->join('divisi d', 'd.id_divisi = p.id_divisi', 'left');
        $this->db->join("penilaian_karyawan pk", "pk.id_pegawai = p.id_pegawai AND pk.bulan = {$this->db->escape_str($bulan)} AND pk.tahun = {$this->db->escape_str($tahun)}", "left");
        return $this->db->get()->result_array();
    }

    public function get_total_hadir_by_nip($nip, $bulan, $tahun)
    {
        $this->db->from('absensi_harian');
        $this->db->where('nip', $nip);
        $this->db->where("MONTH(tanggal)", $bulan);
        $this->db->where("YEAR(tanggal)", $tahun);
        $this->db->where("jam_in IS NOT NULL", null, false);
        $this->db->where("jam_in !=", "");
        return $this->db->count_all_results();
    }

    public function simpan_penilaian($id_pegawai, $hari_kerja, $skills, $attitude, $bulan, $tahun)
    {
        $data = [
            'id_pegawai' => $id_pegawai,
            'hari_kerja' => $hari_kerja,
            'skills' => $skills,
            'attitude' => $attitude,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        $cek = $this->db->get_where('penilaian_karyawan', [
            'id_pegawai' => $id_pegawai,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])->row();

        if ($cek) {
            $this->db->where('id_penilaian', $cek->id_penilaian);
            return $this->db->update('penilaian_karyawan', $data);
        } else {
            return $this->db->insert('penilaian_karyawan', $data);
        }
    }
}
