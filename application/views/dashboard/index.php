<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
            </div>

            <!-- Filter Bulan & Tahun -->
            <form action="<?= base_url('dashboard'); ?>" method="get" class="form-inline mb-3">
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
                <?php foreach ($statistik as $label => $jumlah): ?>
                    <div class="col-md-4 col-lg-4">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center bubble-shadow-small bg-primary">
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

            <!-- Grafik Kehadiran -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title">Grafik Kehadiran Bulan <?= date("F", mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h4>
                </div>
                <div class="card-body">
                    <canvas id="chartKehadiran" height="120"></canvas>
                </div>
            </div>

            <!-- Kalender Kehadiran -->
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Kalender Kehadiran Pegawai</h4>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>

                    <!-- Legend Warna -->
                    <div class="mt-4">
                        <h5><i class="fas fa-info-circle text-primary"></i> Keterangan Warna</h5>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-success mr-2">&nbsp;&nbsp;</span> Tepat Waktu
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-warning mr-2">&nbsp;&nbsp;</span> Telat &lt; 30 Menit
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge" style="background-color:#fd7e14;">&nbsp;&nbsp;</span> Telat 30–90 Menit
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-danger mr-2">&nbsp;&nbsp;</span> Telat &gt; 90 Menit
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-secondary mr-2">&nbsp;&nbsp;</span> Tidak Finger
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-info mr-2">&nbsp;&nbsp;</span> Libur
                                </div>
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
    // ====== Grafik ======
    const ctx = document.getElementById('chartKehadiran').getContext('2d');
    const chartKehadiran = new Chart(ctx, {
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

    // ====== Kalender ======
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '<?= $tahun . "-" . sprintf("%02d", $bulan) . "-01" ?>',
            height: 600,
            themeSystem: 'bootstrap',
            events: <?= json_encode($kalender) ?>,
        });
        calendar.render();
    });
</script>