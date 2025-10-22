<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title">🌤️ Cuaca Kecamatan Setu, Tangerang Selatan</h4>
                    <p class="text-muted mb-0">
                        Informasi cuaca real-time berdasarkan data dari <strong>Open-Meteo API</strong>.
                        Menampilkan suhu, kecepatan angin, kelembapan, serta waktu terbit dan terbenam matahari di wilayah Setu.
                    </p>
                </div>

                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Terakhir diperbarui: <?= $update_time ?? '-' ?> WIB</h5>
                        <p class="mb-0">
                            <i class="fas fa-wind text-info"></i> <?= $wind_speed ?? '-' ?> km/jam &nbsp;&nbsp;
                            <i class="fas fa-tint text-primary"></i> <?= $humidity ?? '-' ?>% &nbsp;&nbsp;
                            <i class="fas fa-sun text-warning"></i> <?= $sunrise ?? '-' ?> &nbsp;&nbsp;
                            <i class="fas fa-moon text-purple"></i> <?= $sunset ?? '-' ?>
                        </p>
                    </div>

                    <div class="text-right">
                        <h3><?= $temperature ?? '-' ?>°C</h3>
                        <p class="mb-0"><?= $weather_desc ?? '-' ?></p>
                    </div>
                </div>
            </div>
            <!-- Filter Bulan & Tahun -->
            <form action="<?= base_url('dashboard'); ?>" method="get" class="form-inline mb-4">
                <select name="bulan" class="form-control mr-2">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <select name="tahun" class="form-control mr-2">
                    <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </form>

            <!-- Statistik Kehadiran -->
            <div class="row">
                <?php
                $warna = [
                    'Tepat Waktu' => 'success',
                    'Telat < 30 Menit' => 'warning',
                    'Telat 30–90 Menit' => 'orange',
                    'Telat > 90 Menit' => 'danger',
                    'Tidak Finger' => 'secondary',
                    'Libur' => 'info'
                ];
                foreach ($statistik as $label => $jumlah):
                    $color = $warna[$label] ?? 'primary';
                ?>
                    <div class="col-md-4 col-lg-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center bubble-shadow-small bg-<?= $color ?>">
                                            <i class="far fa-calendar-check text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category"><?= $label ?></p>
                                            <h4 class="card-title"><?= $jumlah ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Grafik & Rata-rata Jam -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">📊 Statistik Kehadiran Bulan <?= date("F", mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKehadiran" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">🕒 Rata-rata Jam Kehadiran</h4>
                        </div>
                        <div class="card-body">
                            <h5>Rata-rata Jam Masuk: <span class="text-primary"><?= $avgMasuk ?? '-' ?></span></h5>
                            <h5>Rata-rata Jam Pulang: <span class="text-success"><?= $avgPulang ?? '-' ?></span></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kalender Kehadiran -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">📅 Kalender Kehadiran Pegawai</h4>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>

                    <div class="mt-4">
                        <h5><i class="fas fa-info-circle text-primary"></i> Keterangan Warna</h5>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2"><span class="badge badge-success mr-2">&nbsp;&nbsp;</span> Tepat Waktu</div>
                                <div class="d-flex align-items-center mb-2"><span class="badge badge-warning mr-2">&nbsp;&nbsp;</span> Telat &lt; 30 Menit</div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2"><span class="badge" style="background-color:#fd7e14;">&nbsp;&nbsp;</span> Telat 30–90 Menit</div>
                                <div class="d-flex align-items-center mb-2"><span class="badge badge-danger mr-2">&nbsp;&nbsp;</span> Telat &gt; 90 Menit</div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2"><span class="badge badge-secondary mr-2">&nbsp;&nbsp;</span> Tidak Finger</div>
                                <div class="d-flex align-items-center mb-2"><span class="badge badge-info mr-2">&nbsp;&nbsp;</span> Libur</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<script>
    // ===== Grafik Kehadiran =====
    const ctx = document.getElementById('chartKehadiran').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($statistik)) ?>,
            datasets: [{
                label: 'Jumlah Hari',
                data: <?= json_encode(array_values($statistik)) ?>,
                backgroundColor: ['#28a745', '#ffc107', '#fd7e14', '#dc3545', '#6c757d', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Hari'
                    }
                }
            }
        }
    });

    // ===== Kalender Kehadiran =====
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const events = <?= json_encode($kalender ?? []) ?>;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '<?= $tahun . "-" . sprintf("%02d", $bulan) . "-01" ?>',
            height: 650,
            themeSystem: 'bootstrap',
            events: events,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            }
        });

        calendar.render();
    });
</script>