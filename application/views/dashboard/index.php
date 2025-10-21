<!-- dashboard/index.php -->
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
            </div>
            <form action="<?= base_url('dashboard'); ?>" method="get" class="form-inline mb-3">
                <select name="bulan" class="form-control mr-2">
                    <?php
                    $bulan_arr = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December'
                    ];
                    foreach ($bulan_arr as $num => $nama_bulan): ?>
                        <option value="<?= $num ?>" <?= $bulan == $num ? 'selected' : '' ?>><?= $nama_bulan ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="tahun" class="form-control mr-2">
                    <?php for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++): ?>
                        <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </form>
            <!-- Statistik Kehadiran -->
            <div class="row">
                <?php
                $cards = [
                    ['label' => 'Tepat Waktu', 'icon' => 'far fa-calendar-check', 'color' => 'primary'],
                    ['label' => 'Telat < 30 Menit', 'icon' => 'far fa-clock', 'color' => 'warning'],
                    ['label' => 'Telat 30–90 Menit', 'icon' => 'fas fa-hourglass-half', 'color' => 'danger'],
                    ['label' => 'Telat > 90 Menit', 'icon' => 'fas fa-hourglass-end', 'color' => 'dark'],
                    ['label' => 'Tidak Finger', 'icon' => 'fas fa-user-slash', 'color' => 'secondary'],
                    ['label' => 'Libur', 'icon' => 'fas fa-bed', 'color' => 'info']
                ];
                foreach ($cards as $card):
                    $label = $card['label'];
                    $icon = $card['icon'];
                    $color = $card['color'];
                    $count = isset($statistik[$label]) ? $statistik[$label] : 0;
                ?>
                    <div class="col-md-4 col-lg-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center bubble-shadow-small bg-<?= $color ?>">
                                            <i class="<?= $icon ?> text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category"><?= $label ?></p>
                                            <h4 class="card-title"><?= $count ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Grafik Kehadiran Bulanan -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Statistik Kehadiran Bulan <?= date("F", mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKehadiran" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kalender Kehadiran -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kalender Kehadiran Pegawai</h4>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
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
            // ===== Grafik Statistik =====
            const ctx = document.getElementById('chartKehadiran').getContext('2d');
            const chartKehadiran = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_keys($statistik)) ?>,
                    datasets: [{
                        label: 'Jumlah Hari',
                        data: <?= json_encode(array_values($statistik)) ?>,
                        backgroundColor: [
                            '#007bff', '#ffc107', '#dc3545', '#6c757d', '#adb5bd', '#17a2b8'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            // ===== Kalender Kehadiran =====
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: <?= json_encode($kalender) ?>,
                    height: 600,
                    themeSystem: 'bootstrap'
                });
                calendar.render();
            });
        </script>