<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saw_model');
        $this->load->model('Pegawai_model');
        $this->load->model('AbsensiHarian_model');
        $this->load->library(['session', 'form_validation']);
    }

    // HALAMAN HASIL SAW
    public function index()
    {
        $latitude = -6.3452;
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
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $divisi = $this->input->get('divisi') ?: null;

        $data['title'] = 'Hasil SAW';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['divisi'] = $divisi;
        $data['list_divisi'] = $this->Pegawai_model->get_divisi_list();

        $penilaian = $this->Saw_model->get_penilaian($bulan, $tahun, $divisi);
        $bobot = $this->Saw_model->get_bobot();

        $hasil = [];
        if (!empty($penilaian)) {
            $max_hari = max(array_column($penilaian, 'hari_kerja')) ?: 1;
            $max_skills = max(array_column($penilaian, 'skills')) ?: 1;
            $max_attitude = max(array_column($penilaian, 'attitude')) ?: 1;

            foreach ($penilaian as $p) {
                $normal_hari = ($max_hari > 0) ? $p['hari_kerja'] / $max_hari : 0;
                $normal_skills = ($max_skills > 0) ? $p['skills'] / $max_skills : 0;
                $normal_attitude = ($max_attitude > 0) ? $p['attitude'] / $max_attitude : 0;

                // bobot disimpan sebagai persen (100) → ubah ke fraction
                $w_hari = ($bobot['hari_kerja'] ?? 0) / 100;
                $w_skills = ($bobot['skills'] ?? 0) / 100;
                $w_attitude = ($bobot['attitude'] ?? 0) / 100;

                $nilai_akhir = ($normal_hari * $w_hari) + ($normal_skills * $w_skills) + ($normal_attitude * $w_attitude);

                $hasil[] = [
                    'nama' => $p['nama'],
                    'nip' => $p['nip'],
                    'divisi' => $p['divisi'],
                    'hari_kerja' => (int)$p['hari_kerja'],
                    'skills' => (float)$p['skills'],
                    'attitude' => (float)$p['attitude'],
                    'nilai_akhir' => round($nilai_akhir * 100, 4) // tampilkan sebagai persen
                ];
            }

            usort($hasil, function ($a, $b) {
                return $b['nilai_akhir'] <=> $a['nilai_akhir'];
            });
        }

        $data['hasil'] = $hasil;
        $data['bobot'] = $bobot;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);
        $this->load->view('template/footer',$data);
    }
    public function input_penilaian()
    {
        $latitude = -6.3452;
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
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $data['title'] = 'Input Penilaian Karyawan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // ambil daftar pegawai master
        $data['pegawai'] = $this->Pegawai_model->get_all();

        // ambil penilaian untuk periode ini (dipakai di tabel bawah)
        $data['penilaian'] = $this->Saw_model->get_all_penilaian($bulan, $tahun);

        // jika tidak ada POST -> tampilkan view
        if (!$this->input->post()) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('saw/penilaian', $data);
            $this->load->view('template/footer',$data);
            return;
        }

        // === Proses POST single input (form yang pakai name="nip") ===
        $nip = $this->input->post('nip');
        $skills = (float)$this->input->post('skills');
        $attitude = (float)$this->input->post('attitude');

        // cari pegawai by nip, jika belum ada buat otomatis (agar consistent)
        $peg = $this->Pegawai_model->get_by_nip($nip);
        if (!$peg) {
            // minimal simpan nama kosong, user nanti lengkapi di menu pegawai
            $insert = [
                'nip' => $nip,
                'nama_pegawai' => $this->input->post('nama') ?? $nip,
                'divisi' => null,
                'jabatan' => null,
                'status_aktif' => 'aktif'
            ];
            $this->Pegawai_model->insert($insert);
            $peg = $this->db->get_where('pegawai', ['nip' => $nip])->row_array();
        }

        $id_pegawai = $peg['id_pegawai'];

        // hitung hari kerja (berdasarkan absensi_harian.nip)
        $hari_kerja = $this->Saw_model->get_total_hadir_by_nip($nip, $bulan, $tahun);

        // simpan penilaian
        $this->Saw_model->simpan_penilaian($id_pegawai, $hari_kerja, $skills, $attitude, $bulan, $tahun);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Penilaian berhasil disimpan!</div>');
        redirect("saw/input_penilaian?bulan={$bulan}&tahun={$tahun}");
    }
    public function simpan_semua_penilaian()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $nips = $this->input->post('nip') ?: [];
        $skills = $this->input->post('skills') ?: [];
        $attitudes = $this->input->post('attitude') ?: [];

        foreach ($nips as $i => $nip) {
            $s = isset($skills[$i]) ? (float)$skills[$i] : 0;
            $a = isset($attitudes[$i]) ? (float)$attitudes[$i] : 0;

            $peg = $this->Pegawai_model->get_by_nip($nip);
            if (!$peg) {
                $this->Pegawai_model->insert(['nip' => $nip, 'nama_pegawai' => $nip, 'status_aktif' => 'aktif']);
                $peg = $this->Pegawai_model->get_by_nip($nip);
            }
            $id_pegawai = $peg['id_pegawai'];

            $hari_kerja = $this->Saw_model->get_total_hadir_by_nip($nip, $bulan, $tahun);
            $this->Saw_model->simpan_penilaian($id_pegawai, $hari_kerja, $s, $a, $bulan, $tahun);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">Semua penilaian berhasil disimpan!</div>');
        redirect("saw/input_penilaian?bulan={$bulan}&tahun={$tahun}");
    }
    public function bobot()
    {
        $latitude = -6.3452;
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

        $data['title'] = 'Bobot Kriteria';
        $data['bobot'] = $this->Saw_model->get_bobot();
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer',$data);
    }

    public function update_bobot()
    {
        $hari = (float)$this->input->post('hari_kerja');
        $skills = (float)$this->input->post('skills');
        $attitude = (float)$this->input->post('attitude');

        if (round($hari + $skills + $attitude) != 100) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Total bobot harus 100%.</div>');
        } else {
            $this->Saw_model->update_bobot([
                'hari_kerja' => $hari,
                'skills' => $skills,
                'attitude' => $attitude
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Bobot berhasil diperbarui.</div>');
        }
        redirect('saw/bobot');
    }
}
