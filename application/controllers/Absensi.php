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
        $this->load->library('session');
        $this->load->library('pagination');
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

        // Ambil data cuaca
        $url = "https://api.open-meteo.com/v1/forecast?latitude=-6.25&longitude=106.75&current_weather=true";
        $response = file_get_contents($url);
        $cuaca = json_decode($response, true)['current_weather'] ?? [];

        $data['temperature'] = $cuaca['temperature'] ?? '-';
        $data['windspeed'] = $cuaca['windspeed'] ?? '-';
        $data['time'] = $cuaca['time'] ?? '-';

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

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Detail Absensi";

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

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/laporan_rekap', $data);
        $this->load->view('template/footer', $data);
    }


    public function absen_harian()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Absensi Harian";

        $bulan_param = $this->input->get('bulan') ?: date('n');
        $tahun_param = $this->input->get('tahun') ?: date('Y');
        $keyword = $this->input->get('keyword');

        $config['base_url'] = base_url('absensi/absen_harian');
        // get_rekap_bulanan may return an array of rows; ensure total_rows is an integer
        $all_rekap = $this->AbsensiHarian_model->get_rekap_bulanan($bulan_param, $tahun_param);
        $config['total_rows'] = is_array($all_rekap) ? count($all_rekap) : (int) $all_rekap;
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
        $data['absensi_harian'] = $this->AbsensiHarian_model->get_all($config['per_page'], $data['start'], $bulan_param, $tahun_param, $keyword); // Kirim keyword ke model
        $data['pegawai'] = $this->Absensi_model->get_all_pegawai();


        $data['bulan'] = $bulan_param;
        $data['tahun'] = $tahun_param;
        // reuse the previously fetched rekap data to avoid duplicate queries
        $data['rekap'] = $all_rekap;



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

                // Gabungan "07:12 16:24"
                if (!empty($gabung_row[$col])) {
                    $times = preg_split('/\s+/', trim($gabung_row[$col]));
                    if (count($times) === 2) {
                        $jam_in = $times[0];
                        $jam_out = $times[1];
                    }
                }

                if (empty($jam_in) && !empty($in_row[$col])) $jam_in = trim($in_row[$col]);
                if (empty($jam_out) && !empty($out_row[$col])) $jam_out = trim($out_row[$col]);

                // Format tanggal
                $tgl_fix = date('Y-m-d', strtotime("$tahun-$bulan-$tanggal"));

                $data_absensi_harian[] = [
                    'nip' => $nip,
                    'nama' => $nama,
                    'tanggal' => $tgl_fix,
                    'hari' => $hari,
                    'jam_in' => $jam_in ?: null,
                    'jam_out' => $jam_out ?: null
                ];
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

    public function detail_harian($nip, $bulan, $tahun)
    {
        $bulan = $bulan ?? date('m');
        $tahun = $tahun ?? date('Y');
        $this->load->model('AbsensiHarian_model');

        $pegawai = $this->AbsensiHarian_model->get_pegawai_by_nip($nip);
        $data_absen = $this->AbsensiHarian_model->get_by_nip_bulan_tahun($nip, $bulan, $tahun);

        $absensi = [];
        $summary = [
            'total_hadir' => 0,
            'total_menit_telat' => 0,
            'total_tidak_finger' => 0,
            'kategori' => [
                'Tepat Waktu' => 0,
                'Telat < 30 Menit' => 0,
                'Telat 30–90 Menit' => 0,
                'Telat > 90 Menit' => 0,
                'Tidak Finger' => 0,
                'Libur' => 0
            ]
        ];

        foreach ($data_absen as $row) {
            $tanggal = $row['tanggal'];
            $hari_db = $row['hari']; // dari database (hasil impor)
            $hari_num = date('N', strtotime($tanggal));

            // Jika kosong, fallback ke nama hari otomatis
            if (empty($hari_db)) {
                $hari = date('l', strtotime($tanggal));
            } else {
                $hari = $hari_db;
            }

            if ($hari_num == 6 || $hari_num == 7) {
                $absensi[] = [
                    'tanggal' => $tanggal,
                    'hari' => $hari,
                    'jam_in' => '-',
                    'jam_out' => '-',
                    'kategori_telat' => 'Libur',
                    'menit_telat' => 0,
                    'status_pulang' => 'Libur'
                ];
                $summary['kategori']['Libur']++;
                continue;
            }

            if ($row['jam_in'] == $row['jam_out']) {
                $kategori = 'Tidak Finger';
                $status_pulang = 'Tidak Finger';
                $menit_telat = 0;
                $summary['total_tidak_finger']++;
            } else {
                $jam_normal = strtotime("07:30");
                $jam_in = strtotime($row['jam_in']);
                $selisih = max(0, round(($jam_in - $jam_normal) / 60));

                if ($selisih == 0) {
                    $kategori = 'Tepat Waktu';
                } elseif ($selisih < 30) {
                    $kategori = 'Telat < 30 Menit';
                } elseif ($selisih <= 90) {
                    $kategori = 'Telat 30–90 Menit';
                } else {
                    $kategori = 'Telat > 90 Menit';
                }

                $status_pulang = 'Normal';
                $menit_telat = $selisih;

                $summary['total_menit_telat'] += $menit_telat;
                $summary['total_hadir']++;
            }

            $summary['kategori'][$kategori]++;

            $absensi[] = [
                'tanggal' => $tanggal,
                'hari' => $hari,
                'jam_in' => $row['jam_in'],
                'jam_out' => $row['jam_out'],
                'kategori_telat' => $kategori,
                'menit_telat' => $menit_telat,
                'status_pulang' => $status_pulang
            ];
        }

        $total = $summary['total_menit_telat'];
        $summary['konversi_telat'] = [
            'hari' => floor($total / (8 * 60)),
            'jam' => floor(($total % (8 * 60)) / 60),
            'menit' => $total % 60
        ];

        usort($absensi, function ($a, $b) {
            return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
        });

        $data = [
            'pegawai' => $pegawai,
            'absensi' => $absensi,
            'summary' => $summary,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'title' => 'Detail Absensi Harian',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/detail', $data);
        $this->load->view('template/footer', $data);
    }
}
