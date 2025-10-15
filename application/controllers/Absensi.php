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

        if (!$file) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">File tidak ditemukan!</div>');
            redirect('absensi/absen_harian');
        }

        // Load Excel
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil bulan & tahun dari form
        $bulan = $this->input->post('bulan_impor');
        $tahun = $this->input->post('tahun_impor');

        // Kolom D = tanggal 1, dst
        $kolom_awal = 'D';
        $kolom_akhir = $sheet->getHighestColumn();
        $baris_terakhir = $sheet->getHighestRow();

        $data_absensi_harian = [];

        // Loop tiap pegawai (setiap 3 baris)
        for ($row = 9; $row <= $baris_terakhir; $row += 3) {
            $nama = $sheet->getCell("B$row")->getFormattedValue();
            $nip  = $sheet->getCell("C$row")->getFormattedValue();

            // Jika cell nama kosong karena merge, ambil dari baris sebelumnya
            if (!$nama) {
                $nama = $sheet->getCell("B" . ($row - 1))->getFormattedValue();
            }

            if (!$nip) {
                $nip = $sheet->getCell("C" . ($row - 1))->getFormattedValue();
            }

            // Lewati baris kosong
            if (empty($nama) && empty($nip)) {
                continue;
            }

            $baris_in = $row + 1;
            $baris_out = $row + 2;

            // Loop kolom tanggal
            $kolom_index_awal = Coordinate::columnIndexFromString($kolom_awal);
            $kolom_index_akhir = Coordinate::columnIndexFromString($kolom_akhir);

            $tanggal = 1;

            for ($col = $kolom_index_awal; $col <= $kolom_index_akhir; $col++) {
                $colLetter = Coordinate::stringFromColumnIndex($col);

                $jam_in = trim($sheet->getCell($colLetter . $baris_in)->getFormattedValue());
                $jam_out = trim($sheet->getCell($colLetter . $baris_out)->getFormattedValue());

                if (!empty($jam_in) || !empty($jam_out)) {
                    $data_absensi_harian[] = [
                        'nip' => $nip,
                        'nama' => $nama,
                        'tanggal' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal),
                        'jam_in' => $jam_in ?: null,
                        'jam_out' => $jam_out ?: null
                    ];
                }

                $tanggal++;
            }
        }

        // Simpan ke DB
        if (!empty($data_absensi_harian)) {
            $this->AbsensiHarian_model->insert_batch($data_absensi_harian);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi harian berhasil diimpor!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Tidak ada data valid yang ditemukan di file.</div>');
        }

        redirect('absensi/absen_harian?bulan=' . $bulan . '&tahun=' . $tahun);
    }
    public function detail_harian($nip)
    {
        $bulan = (int) ($this->input->get('bulan') ?: date('n'));
        $tahun = (int) ($this->input->get('tahun') ?: date('Y'));

        $absensi = $this->AbsensiHarian_model->get_by_nip_bulan_tahun($nip, $bulan, $tahun);

        // Jam standar
        $jam_standar_in = strtotime('07:30:00');
        $jam_standar_out = strtotime('16:00:00');
        $menit_per_hari = 8.5 * 60; // 510 menit

        $summary = [
            'total_hadir' => 0,
            'total_tidak_finger' => 0,
            'total_menit_telat' => 0,
            'kategori' => [
                'Tepat Waktu' => 0,
                'Telat < 30 Menit' => 0,
                'Telat 30–90 Menit' => 0,
                'Telat > 90 Menit' => 0,
                'Tidak Finger' => 0
            ]
        ];

        foreach ($absensi as &$a) {
            $a['jam_in'] = isset($a['jam_in']) && $a['jam_in'] !== '' ? $a['jam_in'] : null;
            $a['jam_out'] = isset($a['jam_out']) && $a['jam_out'] !== '' ? $a['jam_out'] : null;

            $a['kategori_telat'] = '-';
            $a['status_pulang'] = '-';
            $a['menit_telat'] = 0;

            if (empty($a['jam_in']) && empty($a['jam_out'])) {
                continue;
            }

            $summary['total_hadir']++;

            if ($a['jam_in'] !== null && $a['jam_out'] !== null && trim($a['jam_in']) === trim($a['jam_out'])) {
                $a['kategori_telat'] = 'Tidak Finger';
                $a['status_pulang'] = 'Tidak Finger';
                $a['menit_telat'] = 0;
                $summary['kategori']['Tidak Finger']++;
                $summary['total_tidak_finger']++;
                continue;
            }

            if (!empty($a['jam_in'])) {
                $jam_in_time = @strtotime($a['jam_in']);
                if ($jam_in_time !== false) {
                    $selisih_menit = round(($jam_in_time - $jam_standar_in) / 60);
                    $a['menit_telat'] = $selisih_menit > 0 ? $selisih_menit : 0;

                    if ($a['menit_telat'] === 0) {
                        $a['kategori_telat'] = 'Tepat Waktu';
                        $summary['kategori']['Tepat Waktu']++;
                    } elseif ($a['menit_telat'] > 0 && $a['menit_telat'] <= 30) {
                        $a['kategori_telat'] = 'Telat < 30 Menit';
                        $summary['kategori']['Telat < 30 Menit']++;
                    } elseif ($a['menit_telat'] > 30 && $a['menit_telat'] <= 90) {
                        $a['kategori_telat'] = 'Telat 30–90 Menit';
                        $summary['kategori']['Telat 30–90 Menit']++;
                    } else {
                        $a['kategori_telat'] = 'Telat > 90 Menit';
                        $summary['kategori']['Telat > 90 Menit']++;
                    }

                    $summary['total_menit_telat'] += $a['menit_telat'];
                }
            }

            if (!empty($a['jam_out'])) {
                $jam_out_time = @strtotime($a['jam_out']);
                if ($jam_out_time !== false) {
                    $a['status_pulang'] = ($jam_out_time < $jam_standar_out) ? 'Pulang Cepat' : 'Normal';
                }
            }
        }
        unset($a);

        usort($absensi, function ($x, $y) {
            return strtotime($x['tanggal']) <=> strtotime($y['tanggal']);
        });

        // 🔹 Konversi total menit terlambat ke hari, jam, menit kerja
        $total_menit = $summary['total_menit_telat'];
        $hari = floor($total_menit / $menit_per_hari);
        $sisa_menit = $total_menit % $menit_per_hari;
        $jam = floor($sisa_menit / 60);
        $menit = $sisa_menit % 60;

        $summary['konversi_telat'] = [
            'hari' => $hari,
            'jam' => $jam,
            'menit' => $menit
        ];

        $data = [
            'absensi' => $absensi,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pegawai' => !empty($absensi) ? $absensi[0] : null,
            'summary' => $summary
        ];

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Detail Absensi Harian";
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/detail', $data);
        $this->load->view('template/footer', $data);
    }
}
