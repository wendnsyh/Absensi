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
        // Ambil semua pegawai unik dari absensi_harian
        $pegawai = $this->get_unique_pegawai_from_absensi();
        $data = [];

        foreach ($pegawai as $p) {
            // Hitung total kehadiran (Hadir) dari absensi_harian
            $total_hadir = $this->get_total_hadir_by_nip($p['nip']);

            // Ambil nilai skills & attitude dari tabel penilaian_karyawan
            $penilaian = $this->db->get_where('penilaian_karyawan', ['nip' => $p['nip']])->row_array();

            $data[] = [
                'nip' => $p['nip'],
                'nama' => $p['nama'],
                'hari_kerja' => $total_hadir,
                'skills' => $penilaian['skills'] ?? 0,
                'attitude' => $penilaian['attitude'] ?? 0
            ];
        }

        return $data;
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
        $this->db->select('
        ah.nip,
        ah.nama,
        COUNT(ah.tanggal) AS hari_kerja,
        COALESCE(pk.skills, 0) AS skills,
        COALESCE(pk.attitude, 0) AS attitude
    ');
        $this->db->from('absensi_harian ah');
        $this->db->join('penilaian_karyawan pk', 'ah.nip = pk.nip', 'left');
        $this->db->group_by('ah.nip, ah.nama, pk.skills, pk.attitude');
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
    public function get_total_hadir_by_nip($nip)
    {
        $this->db->from('absensi_harian');
        $this->db->where('nip', $nip);
        $this->db->where('jam_in IS NOT NULL', null, false);
        $this->db->where('jam_out IS NOT NULL', null, false);
        $this->db->where('jam_in !=', '');
        $this->db->where('jam_out !=', '');
        $this->db->where_not_in('hari', ['Sab', 'Mgg']); // abaikan Sabtu, Minggu
        return $this->db->count_all_results();
    }

    public function update_penilaian_field($nip, $field, $value)
    {
        $exists = $this->db->get_where('penilaian_karyawan', ['nip' => $nip])->num_rows();
        if ($exists > 0) {
            $this->db->where('nip', $nip);
            $this->db->update('penilaian_karyawan', [$field => $value]);
        } else {
            $this->db->insert('penilaian_karyawan', [
                'nip' => $nip,
                $field => $value
            ]);
        }
    }

    public function update_hari_kerja_otomatis()
    {
        $absensi = $this->db->select('nip, COUNT(*) as total_hari')
            ->from('absensi_harian')
            ->where('status', 'Hadir')
            ->group_by('nip')
            ->get()
            ->result_array();

      
        foreach ($absensi as $row) {
            $this->db->where('nip', $row['nip']);
            $exists = $this->db->get('penilaian_karyawan')->num_rows();

            if ($exists > 0) {
                $this->db->where('nip', $row['nip']);
                $this->db->update('penilaian_karyawan', ['hari_kerja' => $row['total_hari']]);
            } else {
                $this->db->insert('penilaian_karyawan', [
                    'nip' => $row['nip'],
                    'hari_kerja' => $row['total_hari']
                ]);
            }
        }
    }
}
