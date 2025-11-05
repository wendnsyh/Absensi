<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw_model extends CI_Model
{

    public function get_bobot()
    {
        return $this->db->get('bobot_kriteria')->row_array();
    }

    public function get_penilaian()
    {
        return $this->db->get('penilaian_karyawan')->result_array();
    }

    public function update_bobot($data)
    {
        $this->db->update('bobot_kriteria', $data);
    }


    public function get_unique_pegawai_from_absensi()
    {
        $this->db->select('nip, nama');
        $this->db->from('absensi_harian');
        $this->db->group_by('nip');
        return $this->db->get()->result_array();
    }

    public function get_total_hadir_by_nip($nip)
    {
        $this->db->where('nip', $nip);
        $this->db->where('keterangan', 'Hadir');
        return $this->db->count_all_results('absensi_harian');
    }


    public function simpan_penilaian($nip, $hari_kerja, $skills, $attitude)
    {
        // Cek apakah sudah ada penilaian sebelumnya
        $cek = $this->db->get_where('penilaian_karyawan', ['nip' => $nip])->row_array();

        if ($cek) {
            // update data jika sudah ada
            $this->db->where('nip', $nip);
            $this->db->update('penilaian_karyawan', [
                'hari_kerja' => $hari_kerja,
                'skills' => $skills,
                'attitude' => $attitude
            ]);
        } else {
            // insert baru
            $this->db->insert('penilaian_karyawan', [
                'nip' => $nip,
                'hari_kerja' => $hari_kerja,
                'skills' => $skills,
                'attitude' => $attitude
            ]);
        }
    }

    public function get_all_penilaian()
    {
        $this->db->select('pk.*, ah.nama');
        $this->db->from('penilaian_karyawan pk');
        $this->db->join('absensi_harian ah', 'pk.nip = ah.nip', 'left');
        $this->db->group_by('pk.nip');
        return $this->db->get()->result_array();
    }

    public function hitung_saw()
    {
        $penilaian = $this->db->get('penilaian_karyawan')->result_array();
        $bobot = $this->get_bobot();

        if (empty($penilaian)) {
            return [];
        }

        $max_hari = max(array_column($penilaian, 'hari_kerja'));
        $max_skills = max(array_column($penilaian, 'skills'));
        $max_attitude = max(array_column($penilaian, 'attitude'));

        $hasil = [];
        foreach ($penilaian as $p) {
            $normal_hari = ($max_hari > 0) ? $p['hari_kerja'] / $max_hari : 0;
            $normal_skills = ($max_skills > 0) ? $p['skills'] / $max_skills : 0;
            $normal_attitude = ($max_attitude > 0) ? $p['attitude'] / $max_attitude : 0;

            $nilai_akhir = (
                ($normal_hari * $bobot['hari_kerja']) +
                ($normal_skills * $bobot['skills']) +
                ($normal_attitude * $bobot['attitude'])
            ) * 100;

            $hasil[] = [
                'nip' => $p['nip'],
                'nama' => $p['nama'],
                'hari_kerja' => $p['hari_kerja'],
                'skills' => $p['skills'],
                'attitude' => $p['attitude'],
                'nilai_akhir' => round($nilai_akhir, 3)
            ];
        }

        usort($hasil, fn($a, $b) => $b['nilai_akhir'] <=> $a['nilai_akhir']);
        return $hasil;
    }
}
