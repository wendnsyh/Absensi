<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Pagination $pagination
 * @property Absensi_model $Absensi_model
 * @property Rekap_model $Rekap_model
 * @property CI_Input  $input
 * @property CI_URI  $uri
 */

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //is_logged_in(); // helper login
        $this->load->model('Absensi_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $bulan_param = $this->input->get('bulan') ?? date('n');
        $tahun_param = $this->input->get('tahun') ?? date('Y');

        $data['bulan'] = $bulan_param;
        $data['tahun'] = $tahun_param;

        $data['summary'] = $this->Absensi_model->get_monthly_summary($bulan_param, $tahun_param);
        $data['total_pegawai'] = $this->Absensi_model->get_total_pegawai();
        $data['recent_absensi'] = $this->Absensi_model->get_all_absensi(5, 0, $bulan_param, $tahun_param, null); // Ambil 5 data terbaru bulan ini

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }
}
