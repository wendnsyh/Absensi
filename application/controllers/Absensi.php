<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('Rekap_model');
        $this->load->library('session');
        $this->load->library('pagination');
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Absensi";
        $keyword = $this->input->get('keyword');

        // Konfigurasi Pagination
        $config['base_url'] = base_url('absensi/index');
        $config['total_rows'] = $this->Absensi_model->count_all_absensi($keyword);
        $config['per_page'] = 20; // 20 baris per halaman

        // Konfigurasi Tampilan Pagination
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

        // Menambahkan keyword ke URL pagination
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config['base_url'] . $config['suffix'];

        $this->pagination->initialize($config);

        // Mengambil data absensi dengan pagination dan keyword
        $data['start'] = $this->uri->segment(3) ?: 0;
        $data['absensi'] = $this->Absensi_model->get_all_absensi($config['per_page'], $data['start'], $keyword);

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function import()
    {
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

        $data_absensi = [];
        // Asumsi baris 1 adalah header, mulai dari baris 2
        for ($i = 2; $i <= count($sheetData); $i++) {
            $baris = $sheetData[$i];

            // Cek jika kolom NIP (Kolom C) tidak kosong
            if (!empty($baris['C'])) {
                $nama = $baris['B'];
                $nip = $baris['C'];
                $tanggal_awal_bulan = strtotime($baris['D']); // Asumsi kolom D adalah tanggal 1
                $bulan = date('n', $tanggal_awal_bulan);
                $tahun = date('Y', $tanggal_awal_bulan);

                // Kolom Status (Sakit, Izin, Alfa, Cuti, Dinas Luar)
                $sakit = $baris['AO'] ?: 0;
                $izin = $baris['AP'] ?: 0;
                $alfa = $baris['AQ'] ?: 0;
                $cuti = $baris['AR'] ?: 0;
                $dinas_luar = $baris['AS'] ?: 0;

                // Kolom Terlambat
                $telat_kurang_30 = $baris['AJ'] ?: 0;
                $telat_30_90 = $baris['AK'] ?: 0;
                $telat_lebih_90 = $baris['AL'] ?: 0;
                $tidak_finger = $baris['AN'] ?: 0;

                // Masukkan data ke array
                $data_absensi[] = [
                    'nama'                => $nama,
                    'nip'                 => $nip,
                    'tanggal'             => date('Y-m-d', $tanggal_awal_bulan),
                    'sakit'               => $sakit,
                    'izin'                => $izin,
                    'alfa'                => $alfa,
                    'cuti'                => $cuti,
                    'dinas_luar'          => $dinas_luar,
                    'terlambat_kurang_30' => $telat_kurang_30,
                    'terlambat_30_90'     => $telat_30_90,
                    'terlambat_lebih_90'  => $telat_lebih_90,
                    'tidak_finger_masuk'  => $tidak_finger,
                    'tidak_finger_pulang' => 0, // Anda perlu menyesuaikan logika ini
                    'hadir'               => ($sakit || $izin || $alfa || $cuti || $dinas_luar) ? 0 : 1
                ];
            }
        }

        if (!empty($data_absensi)) {
            $this->Absensi_model->insert_batch($data_absensi);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data absensi berhasil diimpor!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tidak ada data valid yang ditemukan di file.</div>');
        }

        redirect('absensi');
    }

    public function add()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $pegawai = $this->Absensi_model->get_pegawai_by_id($id_pegawai);

        $status = $this->input->post('status');

        $data = [
            'nama' => $pegawai['nama'],
            'nip' => $pegawai['nip'],
            'tanggal' => $this->input->post('tanggal'),
            'hadir' => ($status == 'Hadir') ? 1 : 0,
            'sakit' => ($status == 'Sakit') ? 1 : 0,
            'izin' => ($status == 'Izin') ? 1 : 0,
            'alfa' => ($status == 'Alfa') ? 1 : 0,
            'dinas_luar' => ($status == 'Dinas Luar') ? 1 : 0,
            'cuti' => ($status == 'Cuti') ? 1 : 0,
            'terlambat_kurang_30' => $this->input->post('terlambat_kurang_30') ?: 0,
            'terlambat_30_90' => $this->input->post('terlambat_30_90') ?: 0,
            'terlambat_lebih_90' => $this->input->post('terlambat_lebih_90') ?: 0,
            'tidak_finger_masuk' => $this->input->post('tidak_finger_masuk') ?: 0,
            'tidak_finger_pulang' => $this->input->post('tidak_finger_pulang') ?: 0,
        ];

        $this->Absensi_model->add_absensi($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data absensi berhasil ditambahkan.</div>');
        redirect('absensi');
    }
    // ... di dalam class Absensi extends CI_Controller
    public function detail($id)
    {
        // Cek apakah ID ada
        if (!$id) {
            show_404();
        }

        // Ambil data detail absensi dari model
        $data['absensi'] = $this->Absensi_model->get_absensi_by_id($id);

        // Jika data tidak ditemukan, tampilkan error 404
        if (empty($data['absensi'])) {
            show_404();
        }

        // Data user, title, dsb.
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Detail Absensi";

        // Muat view detail dengan data yang sudah disiapkan
        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('absensi/detail_absensi', $data); // Mengarahkan ke view baru 'absensi/detail.php'
        $this->load->view('template/footer', $data);
    }

    public function delete($id)
    {
        $this->Absensi_model->delete_absensi($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data absensi berhasil dihapus.</div>');
        redirect('absensi');
    }
}
