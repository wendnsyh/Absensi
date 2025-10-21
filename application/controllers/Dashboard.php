<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AbsensiHarian_model');
        $this->load->library('session');
    }

    public function index()
    {
        $user = $this->session->userdata();
        if (empty($user) || !in_array($user['role_id'], ['1', '2'])) {
            show_error("Akses ditolak");
            return;
        }


        $data['title'] = "Dashboard";

        // === Filter Bulan & Tahun ===
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $bulan = sprintf('%02d', $bulan);

        // === Ambil data absensi ===
        $all_absensi = $this->AbsensiHarian_model->get_by_bulan_tahun($bulan, $tahun);

        // === Inisialisasi statistik ===
        $statistik = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Libur' => 0
        ];

        $kalender = [];

        foreach ($all_absensi as $row) {
            $hari_num = date('N', strtotime($row['tanggal']));
            $status = '';
            $color = '#007bff';

            // Deteksi libur (Sabtu/Minggu)
            if ($hari_num == 6 || $hari_num == 7) {
                $statistik['Libur']++;
                $status = 'Libur';
                $color = '#17a2b8';
            } elseif (empty($row['jam_in']) || empty($row['jam_out']) || trim($row['jam_in']) === trim($row['jam_out'])) {
                $statistik['Tidak Finger']++;
                $status = 'Tidak Finger';
                $color = '#6c757d';
            } else {
                $jam_normal = strtotime('07:30');
                $jam_in = strtotime($row['jam_in']);
                $selisih = max(0, round(($jam_in - $jam_normal) / 60));

                if ($selisih === 0) {
                    $statistik['Tepat Waktu']++;
                    $status = 'Tepat Waktu';
                    $color = '#28a745';
                } elseif ($selisih < 30) {
                    $statistik['Telat < 30 Menit']++;
                    $status = 'Telat < 30 Menit';
                    $color = '#ffc107';
                } elseif ($selisih <= 90) {
                    $statistik['Telat 30–90 Menit']++;
                    $status = 'Telat 30–90 Menit';
                    $color = '#fd7e14';
                } else {
                    $statistik['Telat > 90 Menit']++;
                    $status = 'Telat > 90 Menit';
                    $color = '#dc3545';
                }
            }

            $kalender[] = [
                'title' => $status,
                'start' => $row['tanggal'],
                'color' => $color
            ];
        }

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

        $data['statistik'] = $statistik;
        $data['kalender'] = $kalender;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer', $data);
    }
}
