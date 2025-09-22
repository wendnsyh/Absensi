<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('Karyawan_model');
    }

    public function index()
    {
        $data['title'] = 'Data Absensi';
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['absensi'] = $this->Absensi_model->getAll();
        $data['karyawan'] = $this->Karyawan_model->getAll();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('absensi/index', $data);
        $this->load->view('template/footer');
    }

    public function add()
    {
        $data = [
            'id_karyawan' => $this->input->post('id_karyawan', true),
            'tanggal' => $this->input->post('tanggal', true),
            'status' => $this->input->post('status', true),
            'keterangan' => $this->input->post('keterangan', true),
        ];
        $this->Absensi_model->insert($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Absensi berhasil ditambahkan!</div>');
        redirect('absensi');
    }

    public function import()
    {
        require FCPATH . 'vendor/autoload.php';

        $file_mimes = array(
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'application/vnd.ms-excel.sheet.macroenabled.12',
            'application/vnd.ms-excel.addin.macroenabled.12',
            'application/vnd.ms-excel.sheet.binary.macroenabled.12',
            'text/csv',
            'application/csv'
        );

        if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new Csv();
            } else {
                $reader = new Xlsx();
            }

            try {
                $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                // Looping dimulai dari baris kedua (indeks 2) untuk melewati header
                for ($i = 2; $i <= count($sheetData); $i++) {
                    // Periksa apakah baris kosong
                    if (empty(array_filter($sheetData[$i]))) {
                        continue;
                    }

                    // Mengambil data dari kolom A, B, C, D
                    $nip = (int)trim($sheetData[$i]['A']);
                    $tanggal = trim($sheetData[$i]['B']);
                    $status = trim($sheetData[$i]['C']);
                    $keterangan = trim($sheetData[$i]['D']);

                    // Mencari karyawan berdasarkan NIP
                    $karyawan = $this->db->get_where('karyawan', ['nip' => $nip])->row_array();

                    if ($karyawan) {
                        // Memproses format tanggal dari file
                        $tanggal_formatted = null;
                        if (strpos($tanggal, '/') !== false) {
                            $tanggal_parts = explode('/', $tanggal);
                            if (count($tanggal_parts) == 3) {
                                $tanggal_formatted = $tanggal_parts[2] . '-' . $tanggal_parts[1] . '-' . $tanggal_parts[0];
                            }
                        } else {
                            $tanggal_formatted = date('Y-m-d', strtotime($tanggal));
                        }

                        if ($tanggal_formatted) {
                            $data = [
                                'id_karyawan' => $karyawan['id_karyawan'],
                                'tanggal' => $tanggal_formatted,
                                'status' => $status,
                                'keterangan' => $keterangan
                            ];
                            $this->db->insert('absensi', $data);
                        }
                    }
                }

                $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi berhasil diimpor!</div>');
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Terjadi kesalahan saat membaca file: ' . $e->getMessage() . '</div>');
            } catch (Exception $e) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Terjadi kesalahan: ' . $e->getMessage() . '</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Format file salah!</div>');
        }
        redirect('absensi');
    }

    public function delete($id)
    {
        $this->Absensi_model->delete($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Data absensi berhasil dihapus!</div>');
        redirect('absensi');
    }
}
