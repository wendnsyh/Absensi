<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Fingerprint extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->model('Pegawai_model');
    }
    private function set_weather_data(&$data)
    {
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";
        $weather_data = @json_decode(@file_get_contents($api_url), true);

        if ($weather_data && isset($weather_data['current'])) {
            $data['temperature'] = $weather_data['current']['temperature_2m'];
            $data['wind_speed'] = $weather_data['current']['wind_speed_10m'];
            $data['humidity'] = $weather_data['current']['relative_humidity_2m'];
            $data['weather_code'] = $weather_data['current']['weather_code'];
            $data['update_time'] = date('d M Y H:i', strtotime($weather_data['current']['time']));
            $data['sunrise'] = date('H:i', strtotime($weather_data['daily']['sunrise'][0]));
            $data['sunset'] = date('H:i', strtotime($weather_data['daily']['sunset'][0]));
        } else {
            $data['temperature'] = '-';
            $data['wind_speed'] = '-';
            $data['humidity'] = '-';
            $data['weather_code'] = '-';
            $data['sunrise'] = '-';
            $data['sunset'] = '-';
        }

        $weather_codes = [
            0 => 'Cerah',
            1 => 'Cerah Berawan',
            2 => 'Berawan',
            3 => 'Mendung',
            45 => 'Kabut',
            48 => 'Kabut Beku',
            51 => 'Gerimis Ringan',
            61 => 'Hujan Ringan',
            63 => 'Hujan Sedang',
            65 => 'Hujan Lebat',
            80 => 'Hujan Lokal',
            95 => 'Badai Petir'
        ];
        $data['weather_text'] = $weather_codes[$data['weather_code']] ?? 'Tidak Diketahui';
    }

    private function normalize_name($nama)
    {
        $nama = strtolower($nama);

        // hapus gelar umum
        $nama = preg_replace('/\b(mkom|s\.kom|skom|s\.pd|dr|ir|mt|msc)\b/', '', $nama);

        // hapus simbol, titik, angka
        $nama = preg_replace('/[^a-z\s]/', ' ', $nama);

        // rapikan spasi
        $nama = preg_replace('/\s+/', ' ', $nama);

        return trim($nama);
    }


    public function import_finger()
    {
        if (!isset($_FILES['file']['tmp_name'])) {
            redirect('absensi/absen_harian');
        }

        $this->load->model('AbsensiHarian_model');

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet();

        /* =========================
       PERIODE
    ========================= */
        $periode_text = trim($sheet->getCell('C2')->getValue());
        $tahun = date('Y');
        $bulan = date('m');

        if ($periode_text) {
            preg_match('/(\d{2}[\/\-]\d{2}[\/\-]\d{4})/', $periode_text, $m);
            if ($m) {
                $dt = DateTime::createFromFormat('d/m/Y', str_replace('-', '/', $m[1]));
                if ($dt) {
                    $bulan = $dt->format('m');
                    $tahun = $dt->format('Y');
                }
            }
        }

        $data_insert = [];
        $pegawai_list = $this->db->get('pegawai')->result(); // cache pegawai
        $highestRow = $sheet->getHighestRow();

        /* =========================
       LOOP PEGAWAI (EXCEL)
    ========================= */
        for ($row = 5; $row <= $highestRow; $row++) {

            $nama_excel = trim($sheet->getCell("B{$row}")->getValue());
            if ($nama_excel === '') continue;

            $nama_normal_excel = $this->normalize_name($nama_excel);

            /* =========================
           CARI PEGAWAI (SIMILARITY)
        ========================= */
            $nip = null;
            $best_percent = 0;

            foreach ($pegawai_list as $p) {
                $nama_db = $this->normalize_name($p->nama_pegawai);

                similar_text($nama_db, $nama_normal_excel, $percent);

                if ($percent > $best_percent) {
                    $best_percent = $percent;
                    $nip = $p->nip;
                }
            }

            /* =========================
           KEPUTUSAN PEGAWAI
        ========================= */
            if ($best_percent < 85 || !$nip) {
                // ORANG BARU (AMAN)
                $nip = 'DS' . str_pad(
                    $this->db->count_all('pegawai') + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                $this->db->insert('pegawai', [
                    'nip'          => $nip,
                    'nama_pegawai' => $nama_excel
                ]);

                // refresh cache
                $pegawai_list = $this->db->get('pegawai')->result();
            }

            /* =========================
           LOOP TANGGAL
        ========================= */
            for ($colIndex = 4; $colIndex <= 34; $colIndex++) {

                $tgl_ke = $colIndex - 3;
                if (!checkdate($bulan, $tgl_ke, $tahun)) continue;

                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $raw = trim($sheet->getCell($col . $row)->getValue());
                if ($raw === '') continue;

                $lines = array_values(array_filter(array_map(
                    'trim',
                    preg_split("/\r\n|\n|\r/", $raw)
                )));

                $jam_in  = $lines[0] ?? null;
                $jam_out = (count($lines) > 1) ? end($lines) : null;

                $tanggal = "{$tahun}-{$bulan}-" . sprintf('%02d', $tgl_ke);

                /* =========================
               TELAT
            ========================= */
                $jam_masuk = '07:30:00';
                $menit_telat = 0;
                $id_denda = null;

                if ($jam_in && $jam_in > $jam_masuk) {
                    $menit_telat = floor((strtotime($jam_in) - strtotime($jam_masuk)) / 60);

                    if ($menit_telat <= 29) $id_denda = 1;
                    elseif ($menit_telat <= 90) $id_denda = 2;
                    else $id_denda = 3;
                }

                $data_insert[] = [
                    'nip'         => $nip,
                    'nama'        => $nama_excel,
                    'tanggal'     => $tanggal,
                    'bulan'       => (int)$bulan,
                    'tahun'       => (int)$tahun,
                    'hari'        => date('l', strtotime($tanggal)),
                    'jam_in'      => $jam_in,
                    'jam_out'     => $jam_out,
                    'menit_telat' => $menit_telat,
                    'id_denda'    => $id_denda,
                    'keterangan'  => 'HADIR'
                ];
            }
        }

        if (!empty($data_insert)) {
            $this->AbsensiHarian_model->insert_batch($data_insert);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Import Fingerprint berhasil</div>'
            );
        }

        redirect('absensi/absen_harian');
    }



    public function edit_kehadiran($nip)
    {
        $periode_key = $this->input->get('periode_key');
        if (!$periode_key) {
            redirect('absensi/detail_harian');
        }

        [$tahun, $bulan] = explode('-', $periode_key);

        $this->load->model('AbsensiHarian_model');
        $this->load->model('Pegawai_model');

        $pegawai = $this->Pegawai_model->get_by_nip($nip);
        $data_absen = $this->AbsensiHarian_model
            ->get_by_nip_bulan_tahun($nip, $bulan, $tahun);

        $map = [];
        foreach ($data_absen as $a) {
            $map[$a['tanggal']] = $a;
        }

        $hari_dalam_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $rows = [];

        for ($i = 1; $i <= $hari_dalam_bulan; $i++) {
            $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);

            $rows[] = [
                'tanggal'    => $tgl,
                'hari'       => date('l', strtotime($tgl)),
                'jam_in'     => $map[$tgl]['jam_in'] ?? null,
                'jam_out'    => $map[$tgl]['jam_out'] ?? null,
                'keterangan' => $map[$tgl]['keterangan'] ?? '',
                'bukti'      => $map[$tgl]['bukti'] ?? null
            ];
        }

        $data = [
            'pegawai' => $pegawai,
            'rows'    => $rows,
            'bulan'   => $bulan,
            'tahun'   => $tahun,
            'title'   => 'Edit Kehadiran'
        ];
        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('absensi/harian/edit_kehadiran', $data);
        $this->load->view('template/footer');
    }



    public function simpan_kehadiran()
    {
        $post  = $this->input->post();
        $nip   = $post['nip'];
        $bulan = $post['bulan'];
        $tahun = $post['tahun'];

        foreach ($post['tanggal'] as $i => $tanggal) {

            $ket = trim($post['keterangan'][$i] ?? '');

            $existing = $this->db->get_where('absensi_harian', [
                'nip' => $nip,
                'tanggal' => $tanggal
            ])->row();

            // JIKA ADA FINGER → SKIP
            if ($existing && ($existing->jam_in || $existing->jam_out)) {
                continue;
            }

            // JIKA KOSONG
            if ($ket === '') {
                continue;
            }

            /* =====================
           HANDLE UPLOAD BUKTI
        ===================== */
            $buktiFile = null;

            if ($ket !== 'Libur' && isset($_FILES['bukti']['name'][$i]) && $_FILES['bukti']['name'][$i] != '') {

                $config['upload_path']   = './uploads/bukti_absensi/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 2048;
                $config['file_name']     = 'bukti_' . $nip . '_' . $tanggal . '_' . time();

                $this->load->library('upload');
                $this->upload->initialize($config);

                $_FILES['file']['name']     = $_FILES['bukti']['name'][$i];
                $_FILES['file']['type']     = $_FILES['bukti']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['bukti']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['bukti']['error'][$i];
                $_FILES['file']['size']     = $_FILES['bukti']['size'][$i];

                if ($this->upload->do_upload('file')) {
                    $buktiFile = 'uploads/bukti_absensi/' . $this->upload->data('file_name');
                }
            }

            /* =====================
           UPDATE / INSERT
        ===================== */
            $data = [
                'keterangan' => $ket
            ];

            if ($buktiFile) {
                $data['bukti'] = $buktiFile;
            }

            if ($existing) {
                $this->db->where('id', $existing->id)->update('absensi_harian', $data);
            } else {
                $data['nip']     = $nip;
                $data['tanggal'] = $tanggal;
                $data['hari']    = date('l', strtotime($tanggal));
                $data['jam_in']  = null;
                $data['jam_out'] = null;

                $this->db->insert('absensi_harian', $data);
            }
        }

        $periode_key = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        redirect("absensi/detail_harian/{$nip}?periode_key={$periode_key}");
    }
}
