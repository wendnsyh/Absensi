<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Dompdf\Dompdf;

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Pagination $pagination
 * @property Absensi_model $Absensi_model
 * @property AbsensiHarian_model $AbsensiHarian_model
 * @property Rekap_model $Rekap_model
 * @property CI_Input  $input
 * @property CI_URI  $uri
 * @property CI_Loader $load
 * @property CI_Dompdf $Dompdf
 */

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->model('Rekap_model');
        $this->load->model('Pegawai_model');
        $this->load->library('session');
        $this->load->library('pagination');
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

    private function getPeriodeRange($periode_type, $periode_key)
    {
        switch ($periode_type) {
            case 'monthly':
                $start = $periode_key . '-01';
                $end   = date('Y-m-t', strtotime($start));
                $label = date('F Y', strtotime($start));
                break;

            case 'quarter':
                [$y, $q] = explode('-Q', $periode_key);
                $month = ($q - 1) * 3 + 1;
                $start = "$y-$month-01";
                $end   = date('Y-m-t', strtotime("+2 months", strtotime($start)));
                $label = "Triwulan $q $y";
                break;

            case 'semester':
                [$y, $s] = explode('-S', $periode_key);
                $start = ($s == 1) ? "$y-01-01" : "$y-07-01";
                $end   = ($s == 1) ? "$y-06-30" : "$y-12-31";
                $label = "Semester $s $y";
                break;

            case 'yearly':
                $start = "$periode_key-01-01";
                $end   = "$periode_key-12-31";
                $label = "Tahun $periode_key";
                break;

            default:
                $start = date('Y-m-01');
                $end   = date('Y-m-t');
                $label = date('F Y');
        }

        return [$start, $end, $label];
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Absensi";

        $bulan_param = $this->input->get('bulan');
        $tahun_param = $this->input->get('tahun');
        $keyword = $this->input->get('keyword');

        if ($bulan_param === null || $bulan_param == '') {
            $bulan_param = date('n'); // 0 = semua bulan
        }
        if ($tahun_param === null || $tahun_param == '') {
            $tahun_param = date('Y'); // 0 = semua tahun
        }

        $config['base_url'] = base_url('absensi/index');
        $config['total_rows'] = $this->Absensi_model->count_all_absensi($bulan_param, $tahun_param, $keyword);
        $config['per_page'] = 20;

        $config['reuse_query_string'] = TRUE;
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'Pertama';
        $config['last_link'] = 'Terakhir';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3) ?: 0;
        $data['absensi'] = $this->Absensi_model->get_all_absensi($config['per_page'], $data['start'], $bulan_param, $tahun_param, $keyword);
        $data['pegawai'] = $this->Absensi_model->get_all_pegawai();

        $data['bulan_terpilih'] = $bulan_param;
        $data['tahun_terpilih'] = $tahun_param;

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

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function import()
    {
        $bulan_impor = $this->input->post('bulan_impor');
        $tahun_impor = $this->input->post('tahun_impor');

        if (empty($_FILES['file']['name'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pilih file terlebih dahulu.</div>');
            redirect('absensi');
        }
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if ($extension !== 'xlsx' && $extension !== 'xls') {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Format file tidak valid. Gunakan .xlsx atau .xls.</div>');
            redirect('absensi');
        }

        $reader = new Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $data_absensi_to_insert = [];
        $data_absensi_to_update = [];

        $data_absensi = [];
        for ($i = 2; $i <= count($sheetData); $i++) {
            $baris = $sheetData[$i];

            if (!empty($baris['C'])) {
                $nama = $baris['B'];
                $nip = $baris['C'];
                $tanggal = date('Y-m-d', mktime(0, 0, 0, $bulan_impor, 1, $tahun_impor));

                // Ambil data ringkasan dari kolom yang benar
                $hadir = $baris['I'] ?? 0;
                $sakit = $baris['AO'] ?? 0;
                $izin = $baris['AP'] ?? 0;
                $alfa = $baris['AQ'] ?? 0;
                $cuti = $baris['AR'] ?? 0;
                $dinas_luar = $baris['AS'] ?? 0;
                $terlambat_kurang_30 = $baris['AJ'] ?? 0;
                $terlambat_30_90 = $baris['AK'] ?? 0;
                $terlambat_lebih_90 = $baris['AL'] ?? 0;
                $tidak_finger_masuk = $baris['AN'] ?? 0;
                $tidak_finger_pulang = $baris['AN'] ?? 0;

                $data_absensi[] = [
                    'no'                  => $baris['A'],
                    'nama'                => $nama,
                    'nip'                 => $nip,
                    'tanggal'             => $tanggal,
                    'hadir'               => $hadir,
                    'sakit'               => $sakit,
                    'izin'                => $izin,
                    'alfa'                => $alfa,
                    'cuti'                => $cuti,
                    'dinas_luar'          => $dinas_luar,
                    'terlambat_kurang_30' => $terlambat_kurang_30,
                    'terlambat_30_90'     => $terlambat_30_90,
                    'terlambat_lebih_90'  => $terlambat_lebih_90,
                    'tidak_finger_masuk'  => $tidak_finger_masuk,
                    'tidak_finger_pulang' => $tidak_finger_pulang,
                ];
            }
        }

        if (!empty($data_absensi)) {
            $this->Absensi_model->insert_batch($data_absensi);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data absensi berhasil diimpor untuk bulan ' . date('F Y', mktime(0, 0, 0, $bulan_impor, 1, $tahun_impor)) . '.
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada data valid yang ditemukan di file.</div>');
        }

        redirect('absensi?bulan=' . $bulan_impor . '&tahun=' . $tahun_impor);
    }

    public function detail($id)
    {
        if (!$id) {
            show_404();
        }

        $data['absensi'] = $this->Absensi_model->get_absensi_by_id($id);

        if (empty($data['absensi'])) {
            show_404();
        }

        // === API Cuaca Terkini ===
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = @file_get_contents($url);
        $cuaca = $response ? json_decode($response, true)['current_weather'] ?? [] : [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Detail Absensi";

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

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/detail_absensi', $data);
        $this->load->view('template/footer', $data);
    }

    public function delete($id)
    {
        $this->Absensi_model->delete_absensi($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data absensi berhasil dihapus.</div>');
        redirect('absensi');
    }

    public function laporan_detail_pdf($id)
    {

        if (!$id) {
            show_404();
        }

        $data['absensi'] = $this->Absensi_model->get_absensi_by_id($id);

        if (empty($data['absensi'])) {
            show_404();
        }

        $html = $this->load->view('absensi/laporan_detail_pdf', $data, true);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();


        $file_name = 'Detail_Absensi_' . $data['absensi']['nama'] . '.pdf';


        $dompdf->stream($file_name, array("Attachment" => false));
    }

    public function laporan_rekap()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Laporan Rekap Absensi";

        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');
        $data['rekap_data'] = [];

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $data['rekap_data'] = $this->Rekap_model->get_absensi_rekap_for_period($data['start_date'], $data['end_date']);
        }

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

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/laporan_rekap', $data);
        $this->load->view('template/footer', $data);
    }


    public function absen_harian()
    {
        $bulan = $this->input->get('bulan') ?? date('n');
        $tahun = $this->input->get('tahun') ?? date('Y');
        $divisi_id = $this->input->get('divisi_id');
        if ($divisi_id === null || $divisi_id === '') {
            $divisi_id = 'all'; // atau null / 0
        }


        // Sinkronkan ke sistem periode
        $periode_type = 'monthly';
        $periode_key  = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);

        [$start, $end, $label] = $this->getPeriodeRange($periode_type, $periode_key);

        $this->load->model('AbsensiHarian_model');

        $user = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data = [
            'title'         => 'Rekap Absensi',
            'rekap'         => $this->AbsensiHarian_model->get_rekap_range($start, $end),
            'periode_type'  => $periode_type,
            'periode_key'   => $periode_key,
            'label_periode' => $label,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'divisi_id'     => $divisi_id,
            'user'          => $user
        ];

        $this->set_weather_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function import_harian()
    {
        $file = $_FILES['file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $bulan = $this->input->post('bulan_impor');
        $tahun = $this->input->post('tahun_impor');

        $data_absensi_harian = [];

        // Baris ke-7: tanggal
        $tanggal_row = $rows[6];
        // Baris ke-8: hari
        $hari_row = $rows[7];

        // Data pegawai dimulai dari baris ke-9
        for ($i = 8; $i < count($rows); $i += 3) {
            $gabung_row = $rows[$i];
            $in_row = isset($rows[$i + 1]) ? $rows[$i + 1] : [];
            $out_row = isset($rows[$i + 2]) ? $rows[$i + 2] : [];

            $nama = trim($gabung_row[1]);
            $nip = trim($gabung_row[2]);

            if (empty($nip)) continue;

            for ($col = 4; $col < count($tanggal_row); $col++) {
                $tanggal = trim($tanggal_row[$col]);
                $hari = ucfirst(trim($hari_row[$col]));

                if (empty($tanggal)) continue;

                $jam_in = '';
                $jam_out = '';
                $keterangan = null;

                // Gabungan contoh: "07:12 16:24" atau "S"
                if (!empty($gabung_row[$col])) {
                    $cell_value = trim($gabung_row[$col]);

                    // Jika hanya huruf (S, I, C, DL, WFH, A)
                    if (preg_match('/^(S|I|C|DL|WFH|A)$/i', $cell_value)) {
                        $keterangan = strtoupper($cell_value);
                    } else {
                        $times = preg_split('/\s+/', $cell_value);
                        if (count($times) === 2) {
                            $jam_in = $times[0];
                            $jam_out = $times[1];
                        }
                    }
                }

                // Jika tidak ada gabungan, ambil dari baris in/out
                if (empty($jam_in) && !empty($in_row[$col])) {
                    $val = trim($in_row[$col]);
                    if (preg_match('/^(S|I|C|DL|WFH|A)$/i', $val)) {
                        $keterangan = strtoupper($val);
                    } else {
                        $jam_in = $val;
                    }
                }

                if (empty($jam_out) && !empty($out_row[$col])) {
                    $val = trim($out_row[$col]);
                    if (preg_match('/^(S|I|C|DL|WFH|A)$/i', $val)) {
                        $keterangan = strtoupper($val);
                    } else {
                        $jam_out = $val;
                    }
                }

                // Format tanggal
                $tgl_fix = date('Y-m-d', strtotime("$tahun-$bulan-$tanggal"));

                $data_absensi_harian[] = [
                    'nip' => $nip,
                    'nama' => $nama,
                    'tanggal' => $tgl_fix,
                    'hari' => $hari,
                    'jam_in' => $jam_in ?: null,
                    'jam_out' => $jam_out ?: null,
                    'keterangan' => $keterangan
                ];
            }
        }
        // Integrasi ke master data pegawai
        foreach ($data_absensi_harian as $row) {
            $nip = trim($row['nip']);
            $nama = trim($row['nama']);

            if (empty($nip)) continue;

            $pegawai = $this->Pegawai_model->get_by_nip($nip);

            // handle object atau array
            $is_obj = is_object($pegawai);

            $nama_db   = $is_obj ? $pegawai->nama_pegawai : ($pegawai['nama_pegawai'] ?? null);
            $id_db     = $is_obj ? $pegawai->id_pegawai   : ($pegawai['id_pegawai']   ?? null);

            if (!$pegawai) {
                // jika pegawai belum ada → insert baru
                $this->Pegawai_model->insert([
                    'nip' => $nip,
                    'nama_pegawai' => $nama,
                    'id_divisi' => null,
                    'jabatan' => null,
                    'status_aktif' => 'aktif'
                ]);
            } else {
                // jika nama berubah → update nama_pegawai
                if (!empty($nama) && $nama_db != $nama) {
                    $this->Pegawai_model->update($id_db, [
                        'nama_pegawai' => $nama
                    ]);
                }
            }
        }
        if (!empty($data_absensi_harian)) {
            $this->AbsensiHarian_model->insert_batch($data_absensi_harian);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi berhasil diimpor!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Tidak ada data valid ditemukan di file.</div>');
        }

        redirect('absensi/absen_harian?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    public function detail_harian($nip)
    {
        $periode_key = $this->input->get('periode_key');
        if (!$periode_key) {
            redirect('absensi/absen_harian');
        }

        [$tahun, $bulan] = explode('-', $periode_key);

        $this->load->model([
            'AbsensiHarian_model',
            'Pegawai_model',
            'Denda_model'
        ]);

        /* =========================
       DATA PEGAWAI
    ========================= */
        $pegawai = $this->Pegawai_model->get_by_nip($nip);
        if (!$pegawai) {
            $pegawai = (object)[
                'nip' => $nip,
                'nama_pegawai' => 'Tidak Dikenal'
            ];
        }

        /* =========================
       DATA ABSENSI
    ========================= */
        $rows = $this->AbsensiHarian_model
            ->get_by_nip_bulan_tahun($nip, $bulan, $tahun);

        $absensi = [];
        $summary = [
            'total_hadir' => 0,
            'total_menit_telat' => 0,
            'total_tidak_finger' => 0,
            'total_denda' => 0,
            'konversi_telat' => [
                'jam' => 0,
                'menit' => 0
            ]
        ];

        foreach ($rows as $r) {

            $tanggal = $r['tanggal'];
            $hariNum = date('N', strtotime($tanggal)); // 1=Senin
            $hariStr = date('l', strtotime($tanggal));

            $jam_in  = $r['jam_in'];
            $jam_out = $r['jam_out'];
            $keterangan = strtoupper(trim($r['keterangan'] ?? ''));

            $menit_telat = (int) ($r['menit_telat'] ?? 0);
            $id_denda    = $r['id_denda'];

            $kategori = '-';
            $status_pulang = '-';
            $jenis_denda = '-';
            $nominal_denda = 0;

            /* =========================
           JAM KERJA
        ========================= */
            if ($hariNum >= 6) {
                // Sabtu / Minggu
                $kategori = 'Libur';
            } else {
                $jam_masuk  = '07:30:00';
                $jam_pulang = ($hariNum == 5) ? '16:30:00' : '16:00:00';
            }

            /* =========================
           KETERANGAN MANUAL (PRIORITAS UTAMA)
        ========================= */
            if (in_array($keterangan, [
                'SAKIT',
                'IZIN',
                'CUTI',
                'DINAS LUAR',
                'WFH',
                'LIBUR',
                'ALPA'
            ])) {

                $kategori = ucfirst(strtolower($keterangan));
                $status_pulang = '-';
            }

            /* =========================
           TIDAK FINGER (HANYA JIKA HADIR & TANPA KETERANGAN)
        ========================= */ elseif (
                $kategori !== 'Libur' &&
                (
                    empty($jam_in) ||
                    empty($jam_out) ||
                    $jam_in === $jam_out
                )
            ) {

                $kategori = 'Tidak Finger';
                $status_pulang = 'Tidak Lengkap';
                $summary['total_tidak_finger']++;
            }

            /* =========================
           HADIR NORMAL
        ========================= */ elseif ($kategori !== 'Libur') {

                // KATEGORI TELAT (DARI IMPORT)
                if ($menit_telat == 0) {
                    $kategori = 'Tepat Waktu';
                } elseif ($menit_telat < 30) {
                    $kategori = 'Telat < 30 Menit';
                } elseif ($menit_telat <= 90) {
                    $kategori = 'Telat 30–90 Menit';
                } else {
                    $kategori = 'Telat > 90 Menit';
                }

                $summary['total_hadir']++;
                $summary['total_menit_telat'] += $menit_telat;

                /* =========================
               STATUS PULANG & DENDA
            ========================= */
                if ($jam_out && $jam_out > $jam_pulang) {

                    $status_pulang = 'Menambah Jam Kerja';

                    // TELAT + TAMBAH JAM → 50%
                    if ($menit_telat > 0 && $id_denda) {
                        $d = $this->Denda_model->get_denda_by_menit($menit_telat);
                        if ($d) {
                            $jenis_denda = $d->jenis_denda . ' (50%)';
                            $nominal_denda = $d->jumlah / 2;
                            $summary['total_denda'] += $nominal_denda;
                        }
                    }
                } else {

                    $status_pulang = 'Pulang Normal';

                    // TELAT TANPA TAMBAH JAM → FULL
                    if ($menit_telat > 0 && $id_denda) {
                        $d = $this->Denda_model->get_denda_by_menit($menit_telat);
                        if ($d) {
                            $jenis_denda = $d->jenis_denda;
                            $nominal_denda = $d->jumlah;
                            $summary['total_denda'] += $nominal_denda;
                        }
                    }
                }
            }

            $absensi[] = [
                'tanggal' => $tanggal,
                'hari' => $hariStr,
                'jam_in' => $jam_in ?: '-',
                'jam_out' => $jam_out ?: '-',
                'kategori_telat' => $kategori,
                'status_pulang' => $status_pulang,
                'nominal_denda' => $nominal_denda,
                'jenis_denda' => $jenis_denda,
                'bukti' => $r['bukti']
            ];
        }

        /* =========================
       KONVERSI MENIT TELAT
    ========================= */
        $summary['konversi_telat']['jam']   = floor($summary['total_menit_telat'] / 60);
        $summary['konversi_telat']['menit'] = $summary['total_menit_telat'] % 60;

        /* =========================
       VIEW
    ========================= */
        $data = [
            'pegawai' => $pegawai,
            'absensi' => $absensi,
            'summary' => $summary,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'title' => 'Detail Absensi Harian',
            'user' => $this->db->get_where('user', [
                'email' => $this->session->userdata('email')
            ])->row_array()
        ];

        $this->set_weather_data($data);
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/detail', $data);
        $this->load->view('template/footer');
    }



    public function hapus_rekap($nip, $bulan, $tahun)
    {
        if ($nip == "-" || empty($nip)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Tidak dapat menghapus data tanpa NIP.</div>');
            redirect('absensi/absen_harian');
        }

        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->delete('absensi_harian');

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi berhasil dihapus.</div>');
        redirect('absensi/absen_harian');
    }

    public function edit_status($nip, $bulan, $tahun)
    {
        $data['absen'] = $this->AbsensiHarian_model->get_by_nip_bulan_tahun($nip, $bulan, $tahun);
        $data['nip'] = $nip;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $this->load->view('absensi/harian/edit_status', $data);
    }

    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->AbsensiHarian_model->update($id, [
            'status' => $status
        ]);

        $this->session->set_flashdata('message', 'Status berhasil diperbarui!');
        redirect('absensi/absen_harian');
    }
}
