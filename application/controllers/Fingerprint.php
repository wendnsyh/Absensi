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

    public function import_finger()
    {
        if (!isset($_FILES['file']['tmp_name'])) {
            redirect('absensi/absen_harian');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet();

        // === BACA PERIODE DARI EXCEL ===
        $periode_text = trim($sheet->getCell('C2')->getValue());

        $tahun = date('Y');
        $bulan = date('m');

        if ($periode_text) {

            // Ambil semua tanggal dari teks
            preg_match_all(
                '/(\d{2}[\/\-]\d{2}[\/\-]\d{4})/',
                $periode_text,
                $matches
            );

            if (count($matches[1]) >= 1) {

                // Ambil tanggal pertama sebagai acuan bulan
                $tanggal_awal = str_replace('-', '/', $matches[1][0]);
                $dt = DateTime::createFromFormat('d/m/Y', $tanggal_awal);

                if ($dt) {
                    $bulan = $dt->format('m');
                    $tahun = $dt->format('Y');
                }
            }
        }
        $data_insert = [];

        $highestRow = $sheet->getHighestRow();

        for ($row = 5; $row <= $highestRow; $row++) {

            $nama = trim($sheet->getCell("B{$row}")->getValue());
            if ($nama == '') continue;

            // === PEGAWAI ===
            $pegawai = $this->db->get_where('pegawai', ['nama_pegawai' => $nama])->row();

            if ($pegawai) {
                $nip = $pegawai->nip;
            } else {
                $nip = time() + $row;
                $this->db->insert('pegawai', [
                    'nip' => $nip,
                    'nama_pegawai' => $nama
                ]);
            }

            // === LOOP TANGGAL 1–31 (Kolom D s/d AH) ===
            for ($colIndex = 4; $colIndex <= 34; $colIndex++) {

                $tanggal_ke = $colIndex - 3;
                if (!checkdate($bulan, $tanggal_ke, $tahun)) continue;

                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $raw = trim($sheet->getCell($col . $row)->getValue());
                if ($raw == '') continue;

                $raw = str_replace("\r", "", $raw);
                $lines = array_values(array_filter(array_map('trim', explode("\n", $raw))));

                $jam_in = null;
                $jam_out = null;

                if (count($lines) == 1) {
                    $jam_in = $lines[0];
                } elseif (count($lines) > 1) {
                    $jam_in = $lines[0];
                    $jam_out = end($lines);
                }

                $tanggal = "{$tahun}-{$bulan}-" . sprintf('%02d', $tanggal_ke);

                $data_insert[] = [
                    'nip'        => $nip,
                    'nama'       => $nama,
                    'tanggal'    => $tanggal,
                    'hari'       => date('l', strtotime($tanggal)),
                    'jam_in'     => $jam_in,
                    'jam_out'    => $jam_out,
                    'keterangan' => 'HADIR'
                ];
            }
        }

        if ($data_insert) {
            $this->AbsensiHarian_model->insert_batch($data_insert);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Import berhasil (Periode otomatis)</div>'
            );
        }

        redirect('absensi/absen_harian');
    }
    public function edit_kehadiran($nip, $bulan, $tahun)
    {
        $this->load->model('AbsensiHarian_model');
        $this->load->model('Pegawai_model');

        $pegawai = $this->Pegawai_model->get_by_nip($nip);

        // Ambil semua absensi bulan ini
        $data_absen = $this->AbsensiHarian_model
            ->get_by_nip_bulan_tahun($nip, $bulan, $tahun);

        // Jadikan map tanggal => data
        $map = [];
        foreach ($data_absen as $a) {
            $map[$a['tanggal']] = $a;
        }

        // Generate 1 bulan penuh
        $hari_dalam_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $rows = [];

        for ($i = 1; $i <= $hari_dalam_bulan; $i++) {
            $tgl = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);

            $rows[] = [
                'tanggal'    => $tgl,
                'hari'       => date('l', strtotime($tgl)),
                'jam_in'     => $map[$tgl]['jam_in'] ?? null,
                'jam_out'    => $map[$tgl]['jam_out'] ?? null,
                'keterangan' => $map[$tgl]['keterangan'] ?? ''
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
            'email' => $this->session->userdata('email')
        ])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/edit_kehadiran', $data);
        $this->load->view('template/footer');
    }



    public function simpan_kehadiran()
    {
        $post = $this->input->post();
        $nip  = $post['nip'];
        $bulan = $post['bulan'];
        $tahun = $post['tahun'];

        foreach ($post['tanggal'] as $i => $tanggal) {

            $ket = trim($post['keterangan'][$i]);

            // Ambil data existing
            $existing = $this->db->get_where('absensi_harian', [
                'nip' => $nip,
                'tanggal' => $tanggal
            ])->row();

            /* =============================
           1. JIKA ADA JAM FINGER → LEWATI
        ============================== */
            if ($existing && ($existing->jam_in || $existing->jam_out)) {
                continue;
            }

            /* =============================
           2. JIKA TIDAK PILIH APA-APA
        ============================== */
            if ($ket === '') {
                continue;
            }

            /* =============================
           3. UPDATE JIKA SUDAH ADA
        ============================== */
            if ($existing) {

                $this->db->update('absensi_harian', [
                    'keterangan' => $ket
                ], [
                    'id' => $existing->id
                ]);
            } else {

                /* =============================
               4. INSERT BARU (HARI KOSONG)
            ============================== */
                $this->db->insert('absensi_harian', [
                    'nip' => $nip,
                    'tanggal' => $tanggal,
                    'hari' => date('l', strtotime($tanggal)),
                    'keterangan' => $ket,
                    'jam_in' => null,
                    'jam_out' => null
                ]);
            }
        }

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Kehadiran berhasil disimpan</div>'
        );

        redirect("absensi/detail_harian/$nip/$bulan/$tahun");
    }
}
