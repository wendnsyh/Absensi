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
    public function get_by_nip_bulan_tahun($nip, $bulan, $tahun)
    {
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $query = $this->db->get('absensi_harian');
        return $query->result_array();
    }
    public function get_rekap_bulanan($bulan, $tahun)
    {
        $this->db->select('nip, nama, COUNT(*) as total_hari');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->group_by('nip');
        return $this->db->get()->result_array();
    }
    public function get_all()
    {
        return $this->db->get($this->table)->result_array();
    }


    public function get_pegawai_by_nip($nip)
    {
        $this->db->where('nip', $nip);
        return $this->db->get('pegawai')->row_array();
    }

    public function get_detail_absensi($nip, $bulan, $tahun)
    {
        $data = $this->get_by_nip_bulan_tahun($nip, $bulan, $tahun);
        $result = [];

        // Standar kerja
        $jam_normal_masuk = strtotime('07:30:00');
        $jam_normal_pulang = strtotime('16:00:00');
        $menit_per_hari = 8.5 * 60; // 510 menit

        $total_menit_telat = 0;
        $total_tidak_finger = 0;
        $kategori_count = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Libur' => 0
        ];

        foreach ($data as $d) {
            $tanggal = $d['tanggal'];
            $hari = date('D', strtotime($tanggal)); // Mon, Tue, Wed, Thu, Fri, Sat, Sun
            $jam_in = $d['jam_in'];
            $jam_out = $d['jam_out'];
            $kategori_telat = '';
            $status_pulang = '';
            $menit_telat = 0;

            // Deteksi Libur (Sabtu / Minggu)
            if ($hari == 'Sat' || $hari == 'Sun') {
                $kategori_telat = 'Libur';
                $status_pulang = 'Libur';
                $kategori_count['Libur']++;
            } else {
                // Jika tidak finger (jam in dan out sama atau kosong)
                if ((empty($jam_in) && empty($jam_out)) || ($jam_in == $jam_out)) {
                    $kategori_telat = 'Tidak Finger';
                    $status_pulang = 'Tidak Finger';
                    $total_tidak_finger++;
                    $kategori_count['Tidak Finger']++;
                } else {
                    // Hitung keterlambatan
                    $masuk = strtotime($jam_in);
                    if ($masuk > $jam_normal_masuk) {
                        $menit_telat = ($masuk - $jam_normal_masuk) / 60;
                        $total_menit_telat += $menit_telat;

                        if ($menit_telat < 30) {
                            $kategori_telat = 'Telat < 30 Menit';
                            $kategori_count['Telat < 30 Menit']++;
                        } elseif ($menit_telat <= 90) {
                            $kategori_telat = 'Telat 30–90 Menit';
                            $kategori_count['Telat 30–90 Menit']++;
                        } else {
                            $kategori_telat = 'Telat > 90 Menit';
                            $kategori_count['Telat > 90 Menit']++;
                        }
                    } else {
                        $kategori_telat = 'Tepat Waktu';
                        $kategori_count['Tepat Waktu']++;
                    }

                    // Cek status pulang
                    $pulang = strtotime($jam_out);
                    if ($pulang < $jam_normal_pulang) {
                        $status_pulang = 'Pulang Cepat';
                    } else {
                        $status_pulang = 'Normal';
                    }
                }
            }

            $result[] = [
                'tanggal' => $tanggal,
                'hari' => $hari,
                'jam_in' => $jam_in,
                'jam_out' => $jam_out,
                'kategori_telat' => $kategori_telat,
                'menit_telat' => round($menit_telat),
                'status_pulang' => $status_pulang
            ];
        }

        // Konversi total menit telat ke hari/jam/menit
        $total_hari = floor($total_menit_telat / $menit_per_hari);
        $sisa = $total_menit_telat % $menit_per_hari;
        $jam = floor($sisa / 60);
        $menit = $sisa % 60;

        return [
            'absensi' => $result,
            'summary' => [
                'total_tidak_finger' => $total_tidak_finger,
                'total_menit_telat' => round($total_menit_telat),
                'konversi_telat' => [
                    'hari' => $total_hari,
                    'jam' => $jam,
                    'menit' => $menit
                ],
                'kategori' => $kategori_count
            ]
        ];
    }

    public function get_statistik($bulan, $tahun)
    {
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $data = $this->db->get('absensi_harian')->result_array();

        $kategori = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Libur' => 0
        ];

        foreach ($data as $d) {
            if (isset($kategori[$d['kategori_telat']])) {
                $kategori[$d['kategori_telat']]++;
            }
        }

        return $kategori;
    }

    public function get_by_bulan_tahun($bulan, $tahun)
    {
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get('absensi_harian')->result_array();
    }

    public function get_all_by_bulan_tahun($bulan, $tahun)
    {
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get($this->table)->result_array();
    }
}
