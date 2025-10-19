<!-- dashboard/index.php -->
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
            </div>
            <!-- Filter Bulan & Tahun -->
            <form method="get" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <select name="bulan" class="form-control">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= sprintf('%02d', $i) ?>" <?= ($bulan == sprintf('%02d', $i)) ? 'selected' : '' ?>>
                                    <?= date("F", mktime(0, 0, 0, $i, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun" class="form-control">
                            <?php for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>

            <div class="row">
                <?php
                $colors = [
                    'Tepat Waktu' => 'info',
                    'Telat < 30 Menit' => 'warning',
                    'Telat 30–90 Menit' => 'danger',
                    'Telat > 90 Menit' => 'dark',
                    'Tidak Finger' => 'secondary',
                    'Libur' => 'primary',
                ];
                foreach ($summary as $label => $value): ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-stats card-round <?= $colors[$label] ?>">
                            <div class="card-body ">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-light"><?= $label ?></h6>
                                        <h3 class="text-light"><?= $value ?></h3>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-light text-<?= $colors[$label] ?> rounded-circle shadow">
                                            <i class="fa fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Kalender Kehadiran
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Grafik Kehadiran
                        </div>
                        <div class="card-body">
                            <canvas id="chartAbsensi"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Rekap Pegawai Bulan <?= date("F", mktime(0, 0, 0, $bulan, 1)) . " " . $tahun ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Total Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap as $r): ?>
                                    <tr>
                                        <td><?= $r['nip'] ?></td>
                                        <td><?= $r['nama'] ?></td>
                                        <td><?= $r['total_hari'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- FullCalendar & Chart.js -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kalender
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?= $events ?>,
            locale: 'id'
        });
        calendar.render();

        // Grafik
        const summary = <?= json_encode($summary) ?>;
        var ctx = document.getElementById('chartAbsensi').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(summary),
                datasets: [{
                    data: Object.values(summary),
                    backgroundColor: [
                        '#17a2b8', '#ffc107', '#fd7e14', '#dc3545', '#6c757d', '#007bff'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    });
</script>