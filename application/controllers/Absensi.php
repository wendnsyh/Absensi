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

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil bulan & tahun dari form
        $bulan = $this->input->post('bulan_impor');
        $tahun = $this->input->post('tahun_impor');

        // Kolom D = tanggal 1, E = tanggal 2, dst
        $kolom_awal = 'D';
        $kolom_akhir = $sheet->getHighestColumn();
        $baris_terakhir = $sheet->getHighestRow();

        $data_absensi_harian = [];

        // Struktur: 
        // Baris nama = 9, 12, 15, ...
        // IN = baris+1
        // OUT = baris+2
        for ($row = 9; $row <= $baris_terakhir; $row++) {
            $nama = $sheet->getCell("B$row")->getValue();
            $nip = $sheet->getCell("C$row")->getValue();

            // Jika ada nama & nip, berarti baris ini pegawai
            if ($nama && $nip) {
                $baris_in = $row + 1;  // baris IN
                $baris_out = $row + 2; // baris OUT

                $tanggal = 1;
                $col = $kolom_awal;

                // Loop semua tanggal
                while (Coordinate::columnIndexFromString($col) <= Coordinate::columnIndexFromString($kolom_akhir)) {
                    $jam_in = $sheet->getCell($col . $baris_in)->getValue();
                    $jam_out = $sheet->getCell($col . $baris_out)->getValue();

                    if (!empty($jam_in) || !empty($jam_out)) {
                        $data_absensi_harian[] = [
                            'nip' => $nip,
                            'tanggal' => "$tahun-$bulan-" . str_pad($tanggal, 2, '0', STR_PAD_LEFT),
                            'jam_in' => $jam_in ?: null,
                            'jam_out' => $jam_out ?: null
                        ];
                    }

                    // Geser ke kolom berikutnya
                    $tanggal++;
                    $col = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($col) + 1);
                }

                // Lompat ke pegawai berikutnya (3 baris berikutnya)
                $row += 2;
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
        $bulan = $this->input->get('bulan') ?: date('n');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Detail Absensi Pegawai";

        // Ambil data detail absensi pegawai dalam bulan & tahun tertentu
        $data['detail'] = $this->AbsensiHarian_model->get_detail_pegawai($nip, $bulan, $tahun);

        // Ambil info pegawai (nama, nip)
        $data['pegawai'] = !empty($data['detail']) ? $data['detail'][0] : null;

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // Load view
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/harian/detail', $data);
        $this->load->view('template/footer', $data);
    }
}
