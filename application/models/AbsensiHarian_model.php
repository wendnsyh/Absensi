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
        $this->db->select('nip, nama, tanggal, hari, jam_in, jam_out, keterangan');
        $this->db->from($this->table);
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result_array();
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

    // 🔹 Ambil data pegawai berdasarkan NIP
    public function get_pegawai_by_nip($nip)
    {
        $this->db->where('nip', $nip);
        return $this->db->get('pegawai')->row_array();
    }

    // 🔹 Ambil semua data absensi + detail perhitungan
    public function get_detail_absensi($nip, $bulan, $tahun)
    {
        $data = $this->get_by_nip_bulan_tahun($nip, $bulan, $tahun);
        $result = [];

        $jam_normal_masuk = strtotime('07:30:00');
        $jam_normal_pulang = strtotime('16:00:00');
        $menit_per_hari = 8.5 * 60;

        $total_menit_telat = 0;
        $total_tidak_finger = 0;
        $kategori_count = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Sakit' => 0,
            'Izin' => 0,
            'Cuti' => 0,
            'Dinas Luar' => 0,
            'WFH' => 0,
            'Tanpa Keterangan' => 0,
            'Libur' => 0
        ];

        foreach ($data as $d) {
            $tanggal = $d['tanggal'];
            $hari = date('D', strtotime($tanggal));
            $jam_in = trim($d['jam_in']);
            $jam_out = trim($d['jam_out']);
            $ket_db = isset($d['keterangan']) ? trim($d['keterangan']) : '';

            $kategori_telat = '';
            $status_pulang = '';
            $menit_telat = 0;
            $keterangan = '-';

            // Libur (Sabtu/Minggu)
            if ($hari == 'Sat' || $hari == 'Sun') {
                $kategori_telat = 'Libur';
                $status_pulang = 'Libur';
                $keterangan = 'Libur';
                $kategori_count['Libur']++;
            }

            // Keterangan dari jam_in/jam_out/keterangan
            elseif (preg_match('/\b(S|SAKIT)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'Sakit';
                $kategori_telat = 'Sakit';
                $kategori_count['Sakit']++;
            } elseif (preg_match('/\b(I|IZIN)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'Izin';
                $kategori_telat = 'Izin';
                $kategori_count['Izin']++;
            } elseif (preg_match('/\b(C|CUTI)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'Cuti';
                $kategori_telat = 'Cuti';
                $kategori_count['Cuti']++;
            } elseif (preg_match('/\b(A|ALPA)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'Tanpa Keterangan';
                $kategori_telat = 'Tanpa Keterangan';
                $kategori_count['Tanpa Keterangan']++;
            } elseif (preg_match('/\b(DL|DINAS LUAR)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'Dinas Luar';
                $kategori_telat = 'Dinas Luar';
                $kategori_count['Dinas Luar']++;
            } elseif (preg_match('/\b(WFH)\b/i', $jam_in . ' ' . $jam_out . ' ' . $ket_db)) {
                $keterangan = 'WFH';
                $kategori_telat = 'WFH';
                $kategori_count['WFH']++;
            }

            // Tidak finger
            elseif (($jam_in == $jam_out && !empty($jam_in)) || ($jam_in == '00:00:00' && $jam_out == '00:00:00')) {
                $kategori_telat = 'Tidak Finger';
                $status_pulang = 'Tidak Finger';
                $keterangan = 'Tidak Finger';
                $total_tidak_finger++;
                $kategori_count['Tidak Finger']++;
            }

            // Kosong
            elseif (empty($jam_in) && empty($jam_out)) {
                $kategori_telat = 'Tanpa Keterangan';
                $keterangan = 'Tanpa Keterangan';
                $kategori_count['Tanpa Keterangan']++;
            }

            // Hadir normal
            else {
                $masuk = strtotime($jam_in);
                $selisih = max(0, ($masuk - $jam_normal_masuk) / 60);
                $menit_telat = round($selisih);

                if ($menit_telat == 0) {
                    $kategori_telat = 'Tepat Waktu';
                    $kategori_count['Tepat Waktu']++;
                } elseif ($menit_telat < 30) {
                    $kategori_telat = 'Telat < 30 Menit';
                    $kategori_count['Telat < 30 Menit']++;
                } elseif ($menit_telat <= 90) {
                    $kategori_telat = 'Telat 30–90 Menit';
                    $kategori_count['Telat 30–90 Menit']++;
                } else {
                    $kategori_telat = 'Telat > 90 Menit';
                    $kategori_count['Telat > 90 Menit']++;
                }

                $total_menit_telat += $menit_telat;
                $status_pulang = 'Normal';
                $keterangan = 'Hadir';
            }

            $result[] = [
                'tanggal' => $tanggal,
                'hari' => $hari,
                'jam_in' => $jam_in ?: '-',
                'jam_out' => $jam_out ?: '-',
                'keterangan' => $keterangan,
                'kategori_telat' => $kategori_telat,
                'menit_telat' => $menit_telat,
                'status_pulang' => $status_pulang
            ];
        }

        // Konversi total menit ke hari/jam/menit
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
        $data = $this->db->get($this->table)->result_array();

        $kategori = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Sakit' => 0,
            'Izin' => 0,
            'Cuti' => 0,
            'Dinas Luar' => 0,
            'WFH' => 0,
            'Tanpa Keterangan' => 0,
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
        $this->db->select('nip, nama, tanggal, hari, jam_in, jam_out, keterangan');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_all_by_bulan_tahun($bulan, $tahun)
    {
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get($this->table)->result_array();
    }

    public function get_tren_kehadiran($bulan, $tahun)
    {
        $this->db->select('tanggal, COUNT(nip) as total_hadir');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result();
    }

    public function get_rata_jam_masuk_pulang($bulan, $tahun)
    {
        $this->db->select('AVG(TIME_TO_SEC(jam_in)) as avg_in, AVG(TIME_TO_SEC(jam_out)) as avg_out');
        $this->db->from($this->table);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $result = $this->db->get()->row();

        if ($result) {
            return [
                'rata_masuk' => gmdate('H:i', $result->avg_in),
                'rata_pulang' => gmdate('H:i', $result->avg_out),
            ];
        }
        return ['rata_masuk' => '-', 'rata_pulang' => '-'];
    }
}
