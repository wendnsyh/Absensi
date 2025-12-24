<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Saw_model');
        $this->load->model('Divisi_model');
        $this->load->model('Pegawai_model');
        $this->load->library(['session', 'form_validation']);
    }


    private function set_weather_data(&$data)
    {
        $latitude = -6.3452;
        $longitude = 106.6725;
        $api_url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&daily=sunrise,sunset&timezone=Asia%2FJakarta";

        $weather_data = @json_decode(@file_get_contents($api_url), true);

        if ($weather_data && isset($weather_data['current'])) {
            $data['temperature']  = $weather_data['current']['temperature_2m'];
            $data['wind_speed']   = $weather_data['current']['wind_speed_10m'];
            $data['humidity']     = $weather_data['current']['relative_humidity_2m'];
            $data['weather_code'] = $weather_data['current']['weather_code'];
            $data['update_time']  = date('d M Y H:i', strtotime($weather_data['current']['time']));
            $data['sunrise']      = date('H:i', strtotime($weather_data['daily']['sunrise'][0]));
            $data['sunset']       = date('H:i', strtotime($weather_data['daily']['sunset'][0]));
        } else {
            $data['temperature'] = '-';
            $data['wind_speed']  = '-';
            $data['humidity']    = '-';
            $data['weather_code'] = '-';
            $data['sunrise']     = '-';
            $data['sunset']      = '-';
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
    public function index()
    {
        $data['title'] = "Hasil Penilaian SAW";
        $this->set_weather_data($data);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // pilihan filter dari query string
        $periode_type = $this->input->get('periode_type') ?: null;
        $periode_key  = $this->input->get('periode_key') ?: null;
        $divisi       = $this->input->get('divisi') ?: null;

        $data['periode_type'] = $periode_type;
        $data['periode_key']  = $periode_key;
        $data['divisi']       = $divisi;

        // list periode (otomatis dari absensi) -- pastikan model punya get_periode_list()
        $periode_list = $this->Saw_model->get_periode_list();
        $data['periode_list'] = $periode_list;

        // list divisi (object/array) -> make array of arrays to view expects
        $divisi_raw = $this->Divisi_model->get_all(); // model Anda mengembalikan objek
        $divisi_arr = [];
        foreach ($divisi_raw as $d) {
            // support both object and array
            if (is_object($d)) {
                $divisi_arr[] = ['id_divisi' => $d->id_divisi, 'nama_divisi' => $d->nama_divisi];
            } else {
                $divisi_arr[] = $d;
            }
        }
        $data['divisi_list'] = $divisi_arr;

        // jika periode tidak diisi -> kosongkan hasil
        if (empty($periode_type) || empty($periode_key)) {
            $data['ranking'] = [];
            $data['hasil_raw'] = [];
        } else {
            // ambil penilaian dari model
            $penilaian = $this->Saw_model->get_penilaian($periode_type, $periode_key, $divisi);

            // jika tidak ada penilaian -> kosong
            if (empty($penilaian)) {
                $data['ranking'] = [];
                $data['hasil_raw'] = [];
            } else {
                // Dapatkan bobot dari DB (kolom: coba fleksibel)
                $bobot_row = $this->Saw_model->get_bobot();
                // fallback ke bobot default jika DB kosong
                $bobot = [
                    'hari_kerja' => $bobot_row['hari_kerja'] ?? ($bobot_row['kehadiran'] ?? 0.4),
                    'skills'     => $bobot_row['skills'] ?? ($bobot_row['skill'] ?? 0.3),
                    'attitude'   => $bobot_row['attitude'] ?? ($bobot_row['attitude'] ?? 0.3)
                ];

                // pastikan bobot total => 1.0 (jika tersimpan dalam 100 gunakan /100)
                $sum = array_sum($bobot);
                if ($sum > 1.01 && $sum <= 300) {
                    // mungkin tersimpan 100 scale -> convert to unit scale
                    $bobot = array_map(fn($v) => $v / 100, $bobot);
                } elseif ($sum == 0) {
                    // beri bobot default
                    $bobot = ['hari_kerja' => 0.4, 'skills' => 0.3, 'attitude' => 0.3];
                }

                // ambil max tiap kriteria (toleran jika nama kolom beda)
                $hari_field = isset($penilaian[0]['hari_kerja']) ? 'hari_kerja' : (isset($penilaian[0]['kehadiran']) ? 'kehadiran' : null);
                $skills_field = isset($penilaian[0]['skills']) ? 'skills' : (isset($penilaian[0]['skill']) ? 'skill' : null);
                $att_field = isset($penilaian[0]['attitude']) ? 'attitude' : (isset($penilaian[0]['att']) ? 'att' : null);

                // build columns list safely
                $hari_vals = $skills_vals = $att_vals = [0];
                foreach ($penilaian as $p) {
                    if ($hari_field) $hari_vals[] = floatval($p[$hari_field] ?? 0);
                    if ($skills_field) $skills_vals[] = floatval($p[$skills_field] ?? 0);
                    if ($att_field) $att_vals[] = floatval($p[$att_field] ?? 0);
                }

                $max_hari = max($hari_vals) ?: 1;
                $max_skills = max($skills_vals) ?: 1;
                $max_att = max($att_vals) ?: 1;

                $ranking = [];
                foreach ($penilaian as $p) {
                    $n_hari = $hari_field ? (floatval($p[$hari_field] ?? 0) / $max_hari) : 0;
                    $n_skills = $skills_field ? (floatval($p[$skills_field] ?? 0) / $max_skills) : 0;
                    $n_att = $att_field ? (floatval($p[$att_field] ?? 0) / $max_att) : 0;

                    $score = ($n_hari * $bobot['hari_kerja']) + ($n_skills * $bobot['skills']) + ($n_att * $bobot['attitude']);

                    $ranking[] = [
                        'nama' => $p['nama_pegawai'] ?? ($p['nama'] ?? ($p['nama_from_absen'] ?? '-')),
                        'nip'  => $p['nip'] ?? ($p['pegawai_nip'] ?? '-'),
                        'id_divisi' => $p['id_divisi'] ?? null,
                        'score' => round($score, 4),
                        'raw' => $p
                    ];
                }

                usort($ranking, fn($a, $b) => $b['score'] <=> $a['score']);

                $data['ranking'] = $ranking;
                $data['hasil_raw'] = $penilaian;
            }
        }

        // load views
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/index', $data);   // view hasil
        $this->load->view('template/footer');
    }

    public function input_penilaian()
    {
        $data['title'] = "Input Penilaian SAW";
        $this->set_weather_data($data);

        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['periode_list'] = $this->Saw_model->get_periode_list();
        $data['divisi_list']  = $this->Divisi_model->get_all();


        $periode_type = $this->input->get('periode_type');
        $periode_key  = $this->input->get('periode_key');
        $divisi       = $this->input->get('divisi');

        $data['periode_type'] = $periode_type;
        $data['periode_key']  = $periode_key;
        $data['divisi']       = $divisi;

        if ($periode_type && $periode_key) {
            $data['pegawai_list'] = $this->Saw_model->get_pegawai_by_periode($periode_type, $periode_key, $divisi);
            $data['existing_penilaian'] = $this->Saw_model->get_existing_penilaian($periode_type, $periode_key);
        } else {
            $data['pegawai_list'] = [];
            $data['existing_penilaian'] = [];
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/penilaian', $data);
        $this->load->view('template/footer');
    }

    public function simpan_penilaian()
    {
        $periode_type = $this->input->post('periode_type');
        $periode_key  = $this->input->post('periode_key');

        // ambil array
        $id_pegawai = $this->input->post('id_pegawai');
        $nip        = $this->input->post('nip');
        $hari       = $this->input->post('hari_kerja');
        $skills     = $this->input->post('skills');
        $attitude   = $this->input->post('attitude');

        if (!$periode_type || !$periode_key) {
            $this->session->set_flashdata("message", "<div class='alert alert-danger'>Periode tidak valid!</div>");
            redirect('saw/input_penilaian');
        }

        // LOOP sesuai jumlah pegawai
        for ($i = 0; $i < count($nip); $i++) {

            $data = [
                "id_pegawai"   => !empty($id_pegawai[$i]) ? $id_pegawai[$i] : NULL,
                "nip"          => $nip[$i],
                "skills"       => $skills[$i],
                "attitude"     => $attitude[$i],
                "hari_kerja"   => $hari[$i],
                "periode_type" => $periode_type,
                "periode_key"  => $periode_key
            ];

            // panggil upsert
            $this->Saw_model->insert_penilaian_upsert($data);
        }

        $this->session->set_flashdata("message", "<div class='alert alert-success'>Penilaian berhasil disimpan.</div>");
        redirect('saw/input_penilaian?periode_type=' . $periode_type . '&periode_key=' . $periode_key);
    }


    public function bobot()
    {
        $data['title'] = "Bobot Penilaian SAW";
        $this->set_weather_data($data);

        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['bobot'] = $this->Saw_model->get_bobot(); // simpan DESIMAL

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/bobot', $data);
        $this->load->view('template/footer');
    }

    public function update_bobot()
    {
        // INPUT DALAM PERSEN
        $skill     = (float)$this->input->post('skill');
        $attitude  = (float)$this->input->post('attitude');
        $kehadiran = (float)$this->input->post('kehadiran');

        $total = $skill + $attitude + $kehadiran;

        if ($total != 100) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">Total bobot wajib 100%</div>'
            );
            redirect('saw/bobot');
        }

        // SIMPAN DALAM DESIMAL
        $this->Saw_model->update_bobot([
            'skills'     => $skill / 100,
            'attitude'   => $attitude / 100,
            'hari_kerja' => $kehadiran / 100
        ]);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Bobot berhasil diperbarui.</div>'
        );

        redirect('saw/bobot');
    }

    public function detail_pegawai()
    {
        $id_penilaian = $this->input->get('id');

        if (!$id_penilaian) {
            redirect('saw');
        }

        $data['title'] = "Detail Perhitungan SAW";
        $this->set_weather_data($data);

        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $penilaian = $this->db
            ->select("pk.*, p.nama_pegawai, p.nip, p.id_divisi, d.nama_divisi")
            ->from("penilaian_karyawan pk")
            ->join("pegawai p", "p.id_pegawai = pk.id_pegawai", "left")
            ->join("divisi d", "d.id_divisi = p.id_divisi", "left")
            ->where("pk.id_penilaian", $id_penilaian)
            ->get()
            ->row_array();

        if (!$penilaian) {
            redirect('saw');
        }

        // ambil semua penilaian di periode yg sama (UNTUK MAX)
        $all = $this->Saw_model->get_penilaian(
            $penilaian['periode_type'],
            $penilaian['periode_key'],
            $penilaian['id_divisi']
        );

        // max
        $max_hari   = max(array_column($all, 'hari_kerja')) ?: 1;
        $max_skill  = max(array_column($all, 'skills')) ?: 1;
        $max_att    = max(array_column($all, 'attitude')) ?: 1;

        // normalisasi
        $penilaian['n_hari']  = $penilaian['hari_kerja'] / $max_hari;
        $penilaian['n_skill'] = $penilaian['skills'] / $max_skill;
        $penilaian['n_att']   = $penilaian['attitude'] / $max_att;

        // bobot
        $bobot = $this->Saw_model->get_bobot();

        // nilai akhir
        $penilaian['nilai_akhir'] =
            ($penilaian['n_hari'] * $bobot['hari_kerja']) +
            ($penilaian['n_skill'] * $bobot['skills']) +
            ($penilaian['n_att'] * $bobot['attitude']);

        $data['p'] = $penilaian;
        $data['bobot'] = $bobot;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('saw/detail_pegawai', $data);
        $this->load->view('template/footer');
    }
}
