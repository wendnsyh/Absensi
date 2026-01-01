<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsensiHarian_model extends CI_Model
{
    private $table = 'absensi_harian';

    /* ==========================
       INSERT
    ========================== */
    public function insert_batch($data)
    {
        if (!empty($data)) {
            return $this->db->insert_batch($this->table, $data);
        }
        return false;
    }

    /* ==========================
       GET PER NIP + PERIODE
    ========================== */
    public function get_by_nip_bulan_tahun($nip, $bulan, $tahun)
    {
        return $this->db
            ->select('absensi_harian.*')
            ->from($this->table)
            ->where('nip', $nip)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->order_by('tanggal', 'ASC')
            ->get()
            ->result_array();
    }

    /* ==========================
       REKAP BULANAN (Pegawai List)
    ========================== */
    public function get_rekap_bulanan($bulan, $tahun)
    {
        return $this->db
            ->select("
                a.nip,
                COALESCE(p.nama_pegawai, a.nama) AS nama_pegawai
            ")
            ->from("absensi_harian a")
            ->join("pegawai p", "p.nip = a.nip", "left")
            ->where("MONTH(a.tanggal)", $bulan)
            ->where("YEAR(a.tanggal)", $tahun)
            ->group_by("a.nip")
            ->order_by("nama_pegawai", "ASC")
            ->get()
            ->result_array();
    }

    /* ==========================
       LIST PEGAWAI ABSENSI
    ========================== */
    public function get_all($limit, $start, $bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->select('nip, nama');
        $this->db->from($this->table);

        if ($bulan)  $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun)  $this->db->where('YEAR(tanggal)', $tahun);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('nip');
        $this->db->order_by('nama', 'ASC');
        $this->db->limit($limit, $start);

        return $this->db->get()->result_array();
    }

    public function count_all($bulan = null, $tahun = null, $keyword = null)
    {
        $this->db->from($this->table);

        if ($bulan) $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun) $this->db->where('YEAR(tanggal)', $tahun);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('nip');
        return $this->db->get()->num_rows();
    }

    /* ==========================
       GET DETAIL PAGE
    ========================== */
    public function get_harian_full($bulan, $tahun)
    {
        return $this->db
            ->select("
                a.*,
                COALESCE(p.nama_pegawai, a.nama) AS nama_fix,
                COALESCE(p.nip, a.nip) AS nip_fix
            ")
            ->from('absensi_harian a')
            ->join('pegawai p', 'p.nip = a.nip', 'left')
            ->where('MONTH(a.tanggal)', $bulan)
            ->where('YEAR(a.tanggal)', $tahun)
            ->order_by('a.nip', 'ASC')
            ->order_by('a.tanggal', 'ASC')
            ->get()
            ->result();
    }

    /* ==========================
       DETAIL PER NIP
    ========================== */
    public function get_pegawai_by_nip($nip)
    {
        return $this->db
            ->select('id_pegawai, nip, nama_pegawai, divisi, jabatan')
            ->where('nip', $nip)
            ->get('pegawai')
            ->row();
    }

    /* ==========================
       PERHITUNGAN DETAIL
    ========================== */
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
            $ket_db = trim($d['keterangan'] ?? '');

            $kategori_telat = '-';
            $status_pulang = '-';
            $menit_telat = 0;
            $keterangan = '-';

            // LIBUR
            if ($hari == 'Sat' || $hari == 'Sun') {
                $kategori_telat = 'Libur';
                $kategori_count['Libur']++;
            }

            // SA -> Sakit
            elseif (preg_match('/\b(S|SAKIT)\b/i', $jam_in . " " . $jam_out . " " . $ket_db)) {
                $kategori_telat = 'Sakit';
                $kategori_count['Sakit']++;
            }

            // I -> Izin
            elseif (preg_match('/\b(I|IZIN)\b/i', $jam_in . " " . $jam_out . " " . $ket_db)) {
                $kategori_telat = 'Izin';
                $kategori_count['Izin']++;
            }

            // C -> Cuti
            elseif (preg_match('/\b(C|CUTI)\b/i', $jam_in . " " . $jam_out . " " . $ket_db)) {
                $kategori_telat = 'Cuti';
                $kategori_count['Cuti']++;
            }

            // DL
            elseif (preg_match('/\b(DL|DINAS LUAR)\b/i', $jam_in . " " . $jam_out . " " . $ket_db)) {
                $kategori_telat = 'Dinas Luar';
                $kategori_count['Dinas Luar']++;
            }

            // WFH
            elseif (preg_match('/\b(WFH)\b/i', $jam_in . " " . $jam_out . " " . $ket_db)) {
                $kategori_telat = 'WFH';
                $kategori_count['WFH']++;
            }

            // Tidak finger
            elseif (empty($jam_in) || empty($jam_out)) {
                $kategori_telat = 'Tidak Finger';
                $kategori_count['Tidak Finger']++;
                $total_tidak_finger++;
            }

            // HADIR NORMAL
            else {
                $masuk = strtotime($jam_in);
                $selisih_menit = max(0, ($masuk - $jam_normal_masuk) / 60);
                $menit_telat = round($selisih_menit);

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
            }

            $result[] = [
                'tanggal' => $tanggal,
                'hari' => $hari,
                'jam_in' => $jam_in ?: '-',
                'jam_out' => $jam_out ?: '-',
                'kategori_telat' => $kategori_telat,
                'menit_telat' => $menit_telat
            ];
        }

        // KONVERSI MENIT
        $hari_telat = floor($total_menit_telat / $menit_per_hari);
        $sisa = $total_menit_telat % $menit_per_hari;
        $jam = floor($sisa / 60);
        $menit = $sisa % 60;

        return [
            'absensi' => $result,
            'summary' => [
                'total_tidak_finger' => $total_tidak_finger,
                'total_menit_telat' => $total_menit_telat,
                'konversi_telat' => [
                    'hari' => $hari_telat,
                    'jam' => $jam,
                    'menit' => $menit
                ],
                'kategori' => $kategori_count
            ]
        ];
    }

    /* ==========================
       GRAFIK & STATISTIK
    ========================== */
    public function get_tren_kehadiran($bulan, $tahun)
    {
        return $this->db
            ->select('tanggal, COUNT(nip) as total_hadir')
            ->from($this->table)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->group_by('tanggal')
            ->order_by('tanggal', 'ASC')
            ->get()
            ->result();
    }

    public function get_rata_jam_masuk_pulang($bulan, $tahun)
    {
        $avg = $this->db
            ->select('AVG(TIME_TO_SEC(jam_in)) as avg_in, AVG(TIME_TO_SEC(jam_out)) as avg_out')
            ->from($this->table)
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->get()
            ->row();

        return [
            'rata_masuk' => $avg->avg_in ? gmdate('H:i', $avg->avg_in) : '-',
            'rata_pulang' => $avg->avg_out ? gmdate('H:i', $avg->avg_out) : '-'
        ];
    }

    public function get_unique_pegawai()
    {
        return $this->db
            ->select('nip, nama')
            ->group_by('nip')
            ->order_by('nama', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    public function get_by_bulan_tahun($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('absensi_harian');
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result();
    }
}
