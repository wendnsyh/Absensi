<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    // Fungsi untuk mendapatkan data absensi dengan pagination dan pencarian
    public function get_all_absensi($limit, $start, $keyword = null)
    {
        // Logika pencarian
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get('absensi', $limit, $start);
        return $query->result_array();
    }

    // Fungsi untuk menghitung total data
    public function count_all_absensi($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nip', $keyword);
        }
        return $this->db->get('absensi')->num_rows();
    }
    public function insert_batch($data)
    {
        return $this->db->insert_batch('absensi', $data);
    }

    public function get_absensi_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('absensi')->row_array();
    }
    
    public function add_absensi($data)
    {
        return $this->db->insert('absensi', $data);
    }

    public function delete_absensi($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('absensi');
    }

    public function get_all_pegawai()
    {
        return $this->db->get('pegawai')->result_array();
    }

    public function get_pegawai_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('pegawai')->row_array();
    }

    public function get_rekap_bulanan($bulan, $tahun)
    {
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('rekap_absensi');
        return $query->result();
    }
    // Tambahkan fungsi baru di Absensi.php
    public function get_detail_absensi()
    {
        // Cek apakah permintaan datang dari AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id');
        $data_absensi = $this->Absensi_model->get_absensi_by_id($id);

        // Kirim data dalam format JSON
        echo json_encode($data_absensi);
    }
}
