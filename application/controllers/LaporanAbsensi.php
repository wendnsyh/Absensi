<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanAbsensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LaporanAbsensi_model');
        $this->load->model('Pegawai_model');
        $this->load->model('AbsensiHarian_model');
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
        $bulan     = (int) ($this->input->get('bulan') ?? date('n'));
        $tahun     = (int) ($this->input->get('tahun') ?? date('Y'));
        $divisi_id = $this->input->get('divisi_id');

        $data = [
            'title'     => 'Laporan Absensi',
            'bulan'     => $bulan,
            'tahun'     => $tahun,
            'divisi_id' => $divisi_id,
            'divisi'    => $this->db->get('divisi')->result(),
            'laporan'   => $this->LaporanAbsensi_model
                ->get_index($bulan, $tahun, $divisi_id),
        ];

        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('template/footer');
    }


    public function detail($nip)
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if (!$bulan || !$tahun) {
            redirect('laporanabsensi');
        }

        $this->load->model([
            'Pegawai_model',
            'LaporanAbsensi_model'
        ]);

        $pegawai = $this->Pegawai_model->get_by_nip($nip);
        if (!$pegawai) show_404();

        $rows = $this->LaporanAbsensi_model->get_detail($nip, $bulan, $tahun);

        $detail = [];

        foreach ($rows as $r) {

            // =====================
            // KATEGORI (READ RESULT)
            // =====================
            if ($r->keterangan && $r->keterangan !== 'HADIR') {
                $kategori = $r->keterangan;
            } elseif (!$r->jam_in || !$r->jam_out) {
                $kategori = 'Tidak Finger';
            } elseif ($r->menit_telat > 90) {
                $kategori = 'Telat > 90 Menit';
            } elseif ($r->menit_telat >= 30) {
                $kategori = 'Telat 30–90 Menit';
            } elseif ($r->menit_telat > 0) {
                $kategori = 'Telat < 30 Menit';
            } else {
                $kategori = 'Tepat Waktu';
            }

            // =====================
            // STATUS PULANG
            // =====================
            $hariNum = date('N', strtotime($r->tanggal));
            $jamPulang = ($hariNum == 5) ? '16:30:00' : '16:00:00';

            if (!$r->jam_out) {
                $status = 'Tidak Lengkap';
            } elseif ($r->jam_out > $jamPulang) {
                $status = 'Menambah Jam Kerja';
            } else {
                $status = 'Pulang Normal';
            }

            $detail[] = [
                'tanggal' => $r->tanggal,
                'hari' => $r->hari,
                'jam_in' => $r->jam_in,
                'jam_out' => $r->jam_out,
                'kategori' => $kategori,
                'status_pulang' => $status,
                'bukti' => $r->bukti
            ];
        }

        $data = [
            'title'   => 'Detail Laporan Absensi',
            'pegawai' => $pegawai,
            'detail'  => $detail,
            'bulan'   => $bulan,
            'tahun'   => $tahun
        ];

        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('laporan/detail', $data);
        $this->load->view('template/footer');
    }


    public function export_pdf_detail($nip)
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if (!$bulan || !$tahun) {
            redirect('laporanabsensi');
        }

        $pegawai = $this->db->get_where('pegawai', ['nip' => $nip])->row();
        $detail  = $this->LaporanAbsensi_model
            ->get_detail($nip, $bulan, $tahun);

        $data['pegawai'] = $pegawai;
        $data['detail']  = $detail;
        $data['bulan']   = $bulan;
        $data['tahun']   = $tahun;

        // ===== TCPDF =====
        $this->load->library('pdf');
        $pdf = new Pdf('P', 'mm', 'A4');
        $pdf->AddPage();

        $html = $this->load->view('laporan/pdf_detail', $data, true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output(
            "Detail-Absensi-{$nip}-{$bulan}-{$tahun}.pdf",
            'I'
        );
    }




    /* =========================
       HELPER RANGE PERIODE
    ========================= */
    private function _getRangeTanggal($type, $key)
    {
        switch ($type) {
            case 'monthly':
                return [
                    'start' => "$key-01",
                    'end'   => date('Y-m-t', strtotime("$key-01"))
                ];
            case 'quarter':
                [$y, $q] = explode('-Q', $key);
                $map = [
                    1 => ['01-01', '03-31'],
                    2 => ['04-01', '06-30'],
                    3 => ['07-01', '09-30'],
                    4 => ['10-01', '12-31']
                ];
                return [
                    'start' => "$y-{$map[$q][0]}",
                    'end'   => "$y-{$map[$q][1]}"
                ];
            case 'semester':
                [$y, $s] = explode('-S', $key);
                return $s == 1
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
