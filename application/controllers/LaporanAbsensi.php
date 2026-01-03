<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanAbsensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LaporanAbsensi_model');
        //$this->load->library('Pdf');
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

    public function index()
    {
        $periode_type = $this->input->get('periode_type');
        $periode_key  = $this->input->get('periode_key');
        $divisi_id    = $this->input->get('divisi_id');

        $data = [
            'title'        => 'Laporan Absensi',
            'periode_type' => $periode_type,
            'periode_key'  => $periode_key,
            'periode_list' => $this->_getPeriodeList(),
            'divisi'       => $this->db->get('divisi')->result(),
            'divisi_id'    => $divisi_id,
            'laporan'      => []
        ];

        if ($periode_type && $periode_key) {
            $range = $this->_getRangeTanggal($periode_type, $periode_key);

            $data['laporan'] = $this->LaporanAbsensi_model
                ->get_laporan($range['start'], $range['end'], $divisi_id);

            $data['range'] = $range;
        }

        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $data['title'] = 'Laporan Absensi';
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('template/footer');
    }


    public function export_pdf()
    {
        $periode_type = $this->input->get('periode_type');
        $periode_key  = $this->input->get('periode_key');
        $divisi_id    = $this->input->get('divisi_id');

        $range = $this->_getRangeTanggal($periode_type, $periode_key);

        $data['laporan'] = $this->LaporanAbsensi_model
            ->get_laporan_pdf($range['start'], $range['end'], $divisi_id);

        $data['periode'] = $periode_key;

        $pdf = new Pdf('L', 'mm', 'A4');
        $pdf->SetTitle('Laporan Absensi');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        $html = $this->load->view('laporan/pdf_absensi', $data, true);
        $pdf->writeHTML($html);

        $pdf->Output('laporan-absensi.pdf', 'I');
    }

    // ================= HELPER =================
    private function _getPeriodeList()
    {
        $year = date('Y');
        return [
            'monthly' => array_map(fn($m) => [
                'key' => "$year-$m",
                'label' => date('F Y', strtotime("$year-$m-01"))
            ], range(1, 12)),

            'quarter' => [
                ['key' => "$year-Q1", 'label' => "Triwulan I $year"],
                ['key' => "$year-Q2", 'label' => "Triwulan II $year"],
                ['key' => "$year-Q3", 'label' => "Triwulan III $year"],
                ['key' => "$year-Q4", 'label' => "Triwulan IV $year"],
            ],

            'semester' => [
                ['key' => "$year-S1", 'label' => "Semester I $year"],
                ['key' => "$year-S2", 'label' => "Semester II $year"],
            ],

            'yearly' => [
                ['key' => "$year", 'label' => "Tahun $year"]
            ]
        ];
    }

    private function _getRangeTanggal($type, $key)
    {
        switch ($type) {
            case 'monthly':
                return [
                    'start' => "$key-01",
                    'end'   => date('Y-m-t', strtotime("$key-01"))
                ];

            case 'quarter':
                [$y, $q] = explode('-', $key);
                $map = [
                    'Q1' => ['01-01', '03-31'],
                    'Q2' => ['04-01', '06-30'],
                    'Q3' => ['07-01', '09-30'],
                    'Q4' => ['10-01', '12-31']
                ];
                return [
                    'start' => "$y-{$map[$q][0]}",
                    'end'   => "$y-{$map[$q][1]}"
                ];

            case 'semester':
                [$y, $s] = explode('-', $key);
                return $s == 'S1'
                    ? ['start' => "$y-01-01", 'end' => "$y-06-30"]
                    : ['start' => "$y-07-01", 'end' => "$y-12-31"];

            case 'yearly':
                return [
                    'start' => "$key-01-01",
                    'end'   => "$key-12-31"
                ];
        }
    }
}
