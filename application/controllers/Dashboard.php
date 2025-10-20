<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Pagination $pagination
 * @property Absensi_model $Absensi_model
 * @property Rekap_model $Rekap_model
 * @property CI_Input  $input
 * @property CI_URI  $uri
 */

use PhpOffice\PhpSpreadsheet\IOFactory;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //is_logged_in(); // helper login
        $this->load->model('Absensi_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->library('session');
    }
    public function index()
    {
        // Cek hak akses: hanya Admin / Super Admin
        $user = $this->session->userdata();
        if (empty($user) || !in_array($user['role_id'], ['1', '2'])) {
            show_error("Akses ditolak");
            return;
        }

        $data['user'] = $user;
        $data['title'] = "Dashboard Absensi";

        // Ambil data parameter bulan & tahun (bisa dari GET)
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // Data absensi untuk semua pegawai bulan ini
        $all_absensi = $this->AbsensiHarian_model->get_all_by_bulan_tahun($bulan, $tahun);

        // Konversi ke event kalender
        $events = [];
        foreach ($all_absensi as $a) {
            $status = 'Hadir';
            if (empty($a['jam_in']) || empty($a['jam_out']) || trim($a['jam_in']) === trim($a['jam_out'])) {
                $status = 'Tidak Finger';
            }
            $color = ($status === 'Tidak Finger') ? '#dc3545' : '#28a745';

            $events[] = [
                'title' => $status,
                'start' => $a['tanggal'],
                'color' => $color
            ];
        }
        $data['events'] = json_encode($events);

        // Statistik kategori
        $summary = [
            'Tepat Waktu' => 0,
            'Telat < 30 Menit' => 0,
            'Telat 30–90 Menit' => 0,
            'Telat > 90 Menit' => 0,
            'Tidak Finger' => 0,
            'Libur' => 0,
        ];
        foreach ($all_absensi as $row) {
            $hari_num = date('N', strtotime($row['tanggal']));
            // Jika Sabtu atau Minggu
            if ($hari_num == 6 || $hari_num == 7) {
                $summary['Libur']++;
                continue;
            }
            if (empty($row['jam_in']) || empty($row['jam_out']) || trim($row['jam_in']) === trim($row['jam_out'])) {
                $summary['Tidak Finger']++;
                continue;
            }
            $jam_normal = strtotime('07:30');
            $jam_in = strtotime($row['jam_in']);
            $selisih = max(0, round(($jam_in - $jam_normal) / 60));

            if ($selisih === 0) {
                $summary['Tepat Waktu']++;
            } elseif ($selisih < 30) {
                $summary['Telat < 30 Menit']++;
            } elseif ($selisih <= 90) {
                $summary['Telat 30–90 Menit']++;
            } else {
                $summary['Telat > 90 Menit']++;
            }
        }
        $data['summary'] = $summary;

        // URL API
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";

        // Ambil data dari API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);


        $data_api = json_decode($response, true);

        // Ambil data cuaca
        $cuaca = $data_api['current_weather'];

       
        $data['temperature'] = $cuaca['temperature'];
        $data['windspeed']   = $cuaca['windspeed'];
        $data['time']        = $cuaca['time'];
        $data['rekap'] = $this->AbsensiHarian_model->get_rekap_bulanan($bulan, $tahun);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Dashboard";

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer', $data);
    }
}
