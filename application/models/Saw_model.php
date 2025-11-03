<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw_model extends CI_Model
{
    private $bobot_table = 'bobot_kriteria';
    private $nilai_table = 'penilaian_karyawan';

    // ===== Ambil bobot kriteria =====
    public function get_bobot()
    {
        $query = $this->db->get($this->bobot_table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return ['hari_kerja' => 0.5, 'skills' => 0.3, 'attitude' => 0.2];
    }

    public function update_bobot($data)
    {
        $this->db->truncate($this->bobot_table);
        $this->db->insert($this->bobot_table, $data);
    }

    // ===== Penilaian per pegawai =====
    public function get_penilaian_by_nip($nip)
    {
        return $this->db->get_where($this->nilai_table, ['nip' => $nip])->row_array();
    }

    public function simpan_penilaian($data)
    {
        $cek = $this->db->get_where($this->nilai_table, ['nip' => $data['nip']])->num_rows();
        if ($cek > 0) {
            $this->db->where('nip', $data['nip']);
            $this->db->update($this->nilai_table, $data);
        } else {
            $this->db->insert($this->nilai_table, $data);
        }
    }

    // ===== Perhitungan SAW =====
    public function hitung_saw()
    {
        $bobot = $this->get_bobot();

        // Ambil data dari absensi_harian (total hari kerja)
        $pegawai = $this->db->query("
            SELECT nip, nama, COUNT(tanggal) AS hari_kerja
            FROM absensi_harian
            WHERE keterangan NOT IN ('Sakit', 'Izin')
            GROUP BY nip
        ")->result_array();

        $hasil = [];
        foreach ($pegawai as $p) {
            $nilai = $this->get_penilaian_by_nip($p['nip']);
            $p['skills'] = $nilai ? $nilai['skills'] : 0;
            $p['attitude'] = $nilai ? $nilai['attitude'] : 0;

            $p['nilai_akhir'] =
                ($p['hari_kerja'] * $bobot['hari_kerja']) +
                ($p['skills'] * $bobot['skills']) +
                ($p['attitude'] * $bobot['attitude']);

            $hasil[] = $p;
        }

        // Urutkan dari tertinggi ke terendah
        usort($hasil, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);
        return $hasil;
    }
  
}
