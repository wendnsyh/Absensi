<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw_model extends CI_Model
{
    /* -------------------------------
       PERIODE LIST (OTOMATIS dari absensi_harian)
    --------------------------------*/
    public function get_periode_list()
    {
        $list = [
            'monthly'  => [],
            'quarter'  => [],
            'semester' => [],
            'yearly'   => []
        ];

        // ambil tahun+bulan unik dari absensi
        $rows = $this->db
            ->select("YEAR(tanggal) AS tahun, MONTH(tanggal) AS bulan", false)
            ->distinct()
            ->order_by("tahun DESC, bulan DESC")
            ->get("absensi_harian")
            ->result_array();

        // kumpulkan tahun unik
        $years = [];
        foreach ($rows as $r) {
            $years[$r['tahun']] = true;
            $m = str_pad($r['bulan'], 2, "0", STR_PAD_LEFT);
            $y = $r['tahun'];
            $list['monthly'][] = [
                'key'   => "$y-$m",
                'label' => date("F Y", strtotime("$y-$m-01"))
            ];
        }

        // quarters & semesters & yearly (per tahun)
        foreach (array_keys($years) as $y) {
            // quarters
            $list['quarter'][] = ['key' => "$y-Q1", 'label' => "Triwulan Q1 Tahun $y"];
            $list['quarter'][] = ['key' => "$y-Q2", 'label' => "Triwulan Q2 Tahun $y"];
            $list['quarter'][] = ['key' => "$y-Q3", 'label' => "Triwulan Q3 Tahun $y"];
            $list['quarter'][] = ['key' => "$y-Q4", 'label' => "Triwulan Q4 Tahun $y"];

            // semesters
            $list['semester'][] = ['key' => "$y-S1", 'label' => "Semester 1 Tahun $y"];
            $list['semester'][] = ['key' => "$y-S2", 'label' => "Semester 2 Tahun $y"];

            // yearly
            $list['yearly'][] = ['key' => "$y", 'label' => "Tahun $y"];
        }

        return $list;
    }

    /* ------------------------------------------------
       Hitung rentang tanggal dari tipe periode + key
       - monthly: key = YYYY-MM
       - quarter: key = YYYY-Q1
       - semester: key = YYYY-S1
       - yearly: key = YYYY
    -------------------------------------------------*/
    public function get_date_range($type, $key)
    {
        if (!$type || !$key) return [null, null];

        if ($type === 'monthly') {
            list($y, $m) = explode('-', $key);
            $start = "$y-$m-01";
            $end = date("Y-m-t", strtotime($start));
            return [$start, $end];
        }

        if ($type === 'quarter') {
            // key: YYYY-Q1
            list($y, $qraw) = explode('-', $key);
            $q = str_replace('Q', '', $qraw);
            $start_month = ($q - 1) * 3 + 1;
            $start = sprintf("%s-%02d-01", $y, $start_month);
            $end = date("Y-m-t", strtotime("+2 months", strtotime($start)));
            return [$start, $end];
        }

        if ($type === 'semester') {
            // key: YYYY-S1
            list($y, $sraw) = explode('-', $key);
            $s = str_replace('S', '', $sraw);
            $start_month = ($s == '1' || $sraw == 'S1') ? 1 : 7;
            $start = sprintf("%s-%02d-01", $y, $start_month);
            $end = date("Y-m-t", strtotime("+5 months", strtotime($start)));
            return [$start, $end];
        }

        if ($type === 'yearly') {
            $y = $key;
            return ["$y-01-01", "$y-12-31"];
        }

        return [null, null];
    }

    /* ------------------------------------------------
       GET PEGAWAI BERDASARKAN PERIODE
       - Mengembalikan array associative (result_array)
       - Menggabungkan data master pegawai bila tersedia
       - Menghitung hari kerja: COUNT(DISTINCT tanggal) yang memenuhi kondisi kehadiran
    -------------------------------------------------*/
    public function get_pegawai_by_periode($periode_type, $periode_key, $divisi = null)
    {
        list($start, $end) = $this->get_date_range($periode_type, $periode_key);

        if (!$start || !$end) return [];

        $this->db->select("
        ah.nip,
        p.id_pegawai,
        p.nama_pegawai AS nama,
        p.id_divisi,
        d.nama_divisi,
        COUNT(
            DISTINCT CASE 
                WHEN (ah.jam_in IS NOT NULL AND ah.jam_in != '') 
                  OR (ah.jam_out IS NOT NULL AND ah.jam_out != '') 
                THEN ah.tanggal 
            END
        ) AS hari_kerja
    ");

        $this->db->from("absensi_harian ah");
        $this->db->join("pegawai p", "p.nip = ah.nip", "left");
        $this->db->join("divisi d", "d.id_divisi = p.id_divisi", "left");

        $this->db->where("ah.tanggal >=", $start);
        $this->db->where("ah.tanggal <=", $end);

        if (!empty($divisi)) {
            $this->db->where("p.id_divisi", $divisi);
        }

        $this->db->group_by("ah.nip");
        $this->db->order_by("nama", "ASC");

        return $this->db->get()->result_array();
    }


    /* ------------------------------------------------
       Hitung total hadir berdasarkan id_pegawai OR nip untuk rentang tanggal
       - jika id_pegawai diberikan -> hitung dari absensi_harian join pegawai by id
       - jika nip diberikan -> hitung dari absensi_harian by nip
    -------------------------------------------------*/
    public function get_total_hadir_by_date_range($id_pegawai = null, $nip = null, $start = null, $end = null)
    {
        if (!$start || !$end) return 0;

        $this->db->from("absensi_harian ah");

        if ($id_pegawai) {
            // join ke master untuk dapat nip yg sesuai
            $this->db->join("pegawai p", "p.nip = ah.nip", "inner");
            $this->db->where("p.id_pegawai", $id_pegawai);
        } elseif ($nip) {
            $this->db->where("ah.nip", $nip);
        } else {
            return 0;
        }

        $this->db->where("ah.tanggal >=", $start);
        $this->db->where("ah.tanggal <=", $end);

        // hitung hanya hari dengan jam masuk/pulse / atau keterangan hadir
        $this->db->where("( (ah.jam_in IS NOT NULL AND ah.jam_in != '') OR (ah.jam_out IS NOT NULL AND ah.jam_out != '') )", null, false);

        // count distinct tanggal
        $this->db->select("COUNT(DISTINCT ah.tanggal) AS total", false);
        $res = $this->db->get()->row_array();
        return (int) ($res['total'] ?? 0);
    }
    public function insert_penilaian($data)
    {
        return $this->db->insert("penilaian_karyawan", $data);
    }

    public function update_penilaian($id, $data)
    {
        return $this->db->where("id_penilaian", $id)->update("penilaian_karyawan", $data);
    }
    /* ------------------------------------------------
       Get existing penilaian untuk periode => return associative array keyed by id_pegawai or nip
    -------------------------------------------------*/
    public function get_existing_penilaian_map($periode_type, $periode_key)
    {
        $rows = $this->db
            ->where("periode_type", $periode_type)
            ->where("periode_key", $periode_key)
            ->get("penilaian_karyawan")
            ->result_array();

        $map = [];
        foreach ($rows as $r) {
            if (!empty($r['id_pegawai'])) {
                $map['id_' . $r['id_pegawai']] = $r;
            } else {
                $map['nip_' . $r['nip']] = $r;
            }
        }
        return $map;
    }

    public function get_existing_penilaian($periode_type, $periode_key)
    {
        return $this->db
            ->where("periode_type", $periode_type)
            ->where("periode_key", $periode_key)
            ->get("penilaian_karyawan")
            ->result_array();
    }


    /* ------------------------------------------------
       Insert / Upsert penilaian
       - Jika sudah ada penilaian untuk (id_pegawai or nip) + periode -> update
       - Else -> insert
    -------------------------------------------------*/
    public function insert_penilaian_upsert($data)
    {
        // data must include periode_type & periode_key
        $periode_type = $data['periode_type'] ?? null;
        $periode_key = $data['periode_key'] ?? null;

        if (!$periode_type || !$periode_key) return false;

        // prefer id_pegawai lookup
        if (!empty($data['id_pegawai'])) {
            $chk = $this->db->get_where("penilaian_karyawan", [
                'id_pegawai' => $data['id_pegawai'],
                'periode_type' => $periode_type,
                'periode_key' => $periode_key
            ])->row_array();

            if ($chk) {
                $this->db->where('id_penilaian', $chk['id_penilaian']);
                return $this->db->update("penilaian_karyawan", $data);
            } else {
                return $this->db->insert("penilaian_karyawan", $data);
            }
        }

        // else try by nip
        if (!empty($data['nip'])) {
            $chk = $this->db->get_where("penilaian_karyawan", [
                'nip' => $data['nip'],
                'periode_type' => $periode_type,
                'periode_key' => $periode_key
            ])->row_array();

            if ($chk) {
                $this->db->where('id_penilaian', $chk['id_penilaian']);
                return $this->db->update("penilaian_karyawan", $data);
            } else {
                return $this->db->insert("penilaian_karyawan", $data);
            }
        }

        return false;
    }

    /* ------------------------------------------------
       Ambil penilaian utk perhitungan SAW (dari table penilaian_karyawan)
    -------------------------------------------------*/
    public function get_penilaian($periode_type, $periode_key, $divisi = null)
    {
        $this->db->select("pk.*, p.nama_pegawai, p.nip AS pegawai_nip, p.id_divisi");
        $this->db->from("penilaian_karyawan pk");
        $this->db->join("pegawai p", "p.id_pegawai = pk.id_pegawai", "left");
        $this->db->where("pk.periode_type", $periode_type);
        $this->db->where("pk.periode_key", $periode_key);

        if (!empty($divisi)) {
            $this->db->where("p.id_divisi", $divisi);
        }

        $this->db->order_by("p.nama_pegawai", "ASC");
        return $this->db->get()->result_array();
    }

    /* ------------------------------------------------
       BOBOT
    -------------------------------------------------*/
    public function get_bobot()
    {
        return $this->db->get("bobot")->row_array();
    }

    public function update_bobot($data)
    {
        return $this->db->update("bobot", $data);
    }

    public function hitung_saw($periode_type, $periode_key, $divisi = null)
    {
        // 1. Ambil data mentah
        $rows = $this->get_penilaian($periode_type, $periode_key, $divisi);
        if (empty($rows)) return [];

        // 2. Ambil bobot (dalam persen)
        $bobot = $this->get_bobot();

        $w_skill     = $bobot['skill'] / 100;
        $w_attitude  = $bobot['attitude'] / 100;
        $w_hadir     = $bobot['kehadiran'] / 100;

        // 3. Cari nilai maksimum (benefit)
        $max = [
            'skill'     => max(array_column($rows, 'skill')),
            'attitude'  => max(array_column($rows, 'attitude')),
            'kehadiran' => max(array_column($rows, 'kehadiran'))
        ];

        $result = [];

        foreach ($rows as $r) {

            // 4. NORMALISASI
            $n_skill     = $max['skill'] > 0 ? $r['skill'] / $max['skill'] : 0;
            $n_attitude  = $max['attitude'] > 0 ? $r['attitude'] / $max['attitude'] : 0;
            $n_hadir     = $max['kehadiran'] > 0 ? $r['kehadiran'] / $max['kehadiran'] : 0;

            // 5. NILAI AKHIR
            $score =
                ($n_skill * $w_skill) +
                ($n_attitude * $w_attitude) +
                ($n_hadir * $w_hadir);

            $result[] = [
                'raw' => $r,
                'normalisasi' => [
                    'skill' => round($n_skill, 4),
                    'attitude' => round($n_attitude, 4),
                    'kehadiran' => round($n_hadir, 4)
                ],
                'score' => round($score, 4)
            ];
        }

        // 6. Ranking
        usort($result, fn($a, $b) => $b['score'] <=> $a['score']);

        return $result;
    }
}
