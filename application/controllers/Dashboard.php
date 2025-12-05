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

            // akses object pakai -> bukan ['']
            $hari_num = date('N', strtotime($row->tanggal));
            $status = '';
            $color = '#007bff';

            // Libur Sabtu Minggu
            if ($hari_num == 6 || $hari_num == 7) {
                $statistik['Libur']++;
                $status = 'Libur';
                $color = '#17a2b8';

                // Tidak finger
            } elseif (empty($row->jam_in) || empty($row->jam_out) || trim($row->jam_in) === trim($row->jam_out)) {
                $statistik['Tidak Finger']++;
                $status = 'Tidak Finger';
                $color = '#6c757d';
            } else {
                $jam_normal = strtotime('07:30');
                $jam_in = strtotime($row->jam_in);

                $selisih = max(0, round(($jam_in - $jam_normal) / 60)); // menit terlambat

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
                'start' => $row->tanggal,
                'color' => $color
            ];
        }

        // Ambil data cuaca dari API Open-Meteo
        $latitude = -6.3452; // Koordinat Kecamatan Setu, Tangerang Selatan
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";

        $weather_data = json_decode(file_get_contents($api_url), true);
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
            $data['last_update'] = '-';
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


        $data['statistik'] = $statistik;
        $data['kalender'] = $kalender;

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_kehadiran_bulanan()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $data = $this->AbsensiHarian_model->get_tren_kehadiran($bulan, $tahun);
        echo json_encode($data);
    }

    public function get_rata_jam()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $data = $this->AbsensiHarian_model->get_rata_jam_masuk_pulang($bulan, $tahun);
        echo json_encode($data);
    }
}
