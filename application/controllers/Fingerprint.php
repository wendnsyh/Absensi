<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Fingerprint extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->model('Pegawai_model');
    }

    public function import_finger()
    {
        $file = $_FILES['file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        $data_insert = [];

        for ($row = 5; $row <= $highestRow; $row++) {

            $nama = trim($sheet->getCell("B" . $row)->getValue());
            if ($nama == "") continue;

            // Ambil pegawai
            $pegawai = $this->Pegawai_model->get_by_nip_or_nama(null, $nama);
            if ($pegawai) {
                $nip = $pegawai->nip;
                $nama_pegawai = $pegawai->nama_pegawai;
            } else {
                if ($pegawai) {
                    $nip = $pegawai->nip;
                    $nama_pegawai = $pegawai->nama_pegawai;
                } else {
                    $nip = "-";  
                    $nama_pegawai = $nama;
                }
                $nama_pegawai = $nama;
                $this->Pegawai_model->insert([
                    'nip' => $nip,
                    'nama_pegawai' => $nama_pegawai
                ]);
            }

            // Loop tanggal pada kolom 1 - 31
            for ($colIndex = 4; $colIndex <= 34; $colIndex++) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

                $raw = trim($sheet->getCell($col . $row)->getValue());
                if ($raw == "") continue;

                $raw = str_replace("\r", "", $raw);
                $lines = array_filter(array_map('trim', explode("\n", $raw)));
                $jumlah = count($lines);

                if ($jumlah == 0) {
                    $jam_in = null;
                    $jam_out = null;
                } elseif ($jumlah == 1) {
                    $jam_in = $lines[0];
                    $jam_out = null;
                } else {
                    $jam_in = $lines[0];
                    $jam_out = $lines[$jumlah - 1];
                }

                // Tanggal real
                $tanggal_ke = $colIndex - 3;
                $tahun = date('Y');
                $bulan = date('m');
                $tanggal = "{$tahun}-{$bulan}-{$tanggal_ke}";

                $data_insert[] = [
                    'nip' => $nip,
                    'nama' => $nama_pegawai,
                    'tanggal' => $tanggal,
                    'hari' => date('l', strtotime($tanggal)),
                    'jam_in' => $jam_in,
                    'jam_out' => $jam_out,
                    'keterangan' => 'HADIR'
                ];
            }
        }

        if (!empty($data_insert)) {
            $this->AbsensiHarian_model->insert_batch($data_insert);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Import Berhasil!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Tidak ada data berhasil dibaca!</div>');
        }

        redirect('absensi/absen_harian');
    }



    public function edit($id)
    {
        $data['absensi'] = $this->AbsensiHarian_model->get_by_id($id);

        if (!$data['absensi']) {
            show_404();
        }

        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('template/sidebar');
        $this->load->view('absensi/harian/edit_finger', $data);
        $this->load->view('template/footer');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $jam_in = $this->input->post('jam_in');
        $jam_out = $this->input->post('jam_out');

        $data = [
            'status' => $status,
            'jam_in' => $jam_in,
            'jam_out' => $jam_out
        ];

        $this->AbsensiHarian_model->update($id, $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diperbarui!</div>');
        redirect('absensi/absen_harian');
    }
}
