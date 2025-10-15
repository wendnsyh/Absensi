<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Absensi Harian</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="<?= base_url('dashboard') ?>"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="<?= base_url('absensi/absen_harian') ?>">Absensi Harian</a></li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Data Pegawai: <strong><?= $pegawai ? htmlspecialchars($pegawai['nama']) : '-' ?></strong></h5>
                        <small>NIP: <?= $pegawai ? htmlspecialchars($pegawai['nip']) : '-' ?> — Periode: <?= date("F Y", strtotime("{$tahun}-{$bulan}-01")) ?></small>
                    </div>
                    <div>
                        <a href="<?= base_url('absensi/absen_harian?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card p-2 text-center">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="icon-big text-primary"><i class="flaticon-check"></i></div>
                                    </div>
                                    <h6 class="text-muted">Total Hari Hadir</h6>
                                    <h4 class="font-weight-bold text-success"><?= $summary['total_hadir'] ?> Hari</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-2 text-center">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="icon-big text-warning"><i class="flaticon-time"></i></div>
                                    </div>
                                    <h6 class="text-muted">Total Menit Terlambat</h6>
                                    <h4 class="font-weight-bold text-warning"><?= $summary['total_menit_telat'] ?> Menit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-2 text-center">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="icon-big text-danger"><i class="flaticon-error"></i></div>
                                    </div>
                                    <h6 class="text-muted">Total Tidak Finger</h6>
                                    <h4 class="font-weight-bold text-danger"><?= $summary['total_tidak_finger'] ?> Kali</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-2 text-center">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="icon-big text-info"><i class="flaticon-folder"></i></div>
                                    </div>
                                    <h6 class="text-muted">Kategori Terlambat</h6>
                                    <ul class="list-unstyled text-left mt-2" style="font-size: 0.8rem;">
                                        <li>Tepat Waktu: <?= $summary['kategori']['Tepat Waktu'] ?></li>
                                        <li>Telat &lt;30m: <?= $summary['kategori']['Telat < 30 Menit'] ?></li>
                                        <li>Telat 30-90m: <?= $summary['kategori']['Telat 30–90 Menit'] ?></li>
                                        <li>Telat &gt;90m: <?= $summary['kategori']['Telat > 90 Menit'] ?></li>
                                        <li>Tidak Finger: <?= $summary['kategori']['Tidak Finger'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam In</th>
                                    <th>Jam Out</th>
                                    <th>Kategori Keterlambatan</th>
                                    <th>Menit Terlambat</th>
                                    <th>Status Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($absensi)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                                    </tr>
                                <?php else: $no = 1; ?>
                                    <?php foreach ($absensi as $a): ?>
                                        <?php
                                        // badge color based on kategori
                                        $badge = 'secondary';
                                        switch ($a['kategori_telat']) {
                                            case 'Tepat Waktu':
                                                $badge = 'success';
                                                break;
                                            case 'Telat < 30 Menit':
                                                $badge = 'warning';
                                                break;
                                            case 'Telat 30–90 Menit':
                                                $badge = 'danger';
                                                break;
                                            case 'Telat > 90 Menit':
                                                $badge = 'dark';
                                                break;
                                            case 'Tidak Finger':
                                                $badge = 'secondary';
                                                break;
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d M Y', strtotime($a['tanggal'])) ?></td>
                                            <td><?= $a['jam_in'] ?: '-' ?></td>
                                            <td><?= $a['jam_out'] ?: '-' ?></td>
                                            <td><span class="badge badge-<?= $badge ?>"><?= $a['kategori_telat'] ?></span></td>
                                            <td><?= $a['menit_telat'] ?> menit</td>
                                            <td><?= $a['status_pulang'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>