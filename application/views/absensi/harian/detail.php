<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Absensi Harian</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('absensi/absen_harian') ?>">Absensi Harian</a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5>
                            Data Pegawai:
                            <strong><?= $pegawai ? htmlspecialchars($pegawai->nama_pegawai) : '-' ?></strong>
                        </h5>
                        <small>
                            NIP: <?= $pegawai ? htmlspecialchars($pegawai->nip) : '-' ?>
                            —
                            Periode: <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
                        </small>
                    </div>
                    <div>
                        <a href="<?= base_url("absensi/absen_harian?bulan=$bulan&tahun=$tahun") ?>"
                            class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card card-stats card-primary">
                                <div class="card-body">
                                    <div class="numbers">
                                        <p class="card-category">Total Kehadiran</p>
                                        <h4 class="card-title">
                                            <?= $summary['total_hadir'] ?> Hari
                                        </h4>
                                        <small class="text-white">
                                            Disiplin Kehadiran
                                        </small>
                                    </div>
                                    <div class="icon-big text-center">
                                        <i class="flaticon-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card card-stats card-warning">
                                <div class="card-body">
                                    <div class="numbers">
                                        <p class="card-category">Total Keterlambatan</p>
                                        <h4 class="card-title">
                                            <?= $summary['total_menit_telat'] ?> Menit
                                        </h4>
                                        <small class="text-white">
                                            ≈ <?= $summary['konversi_telat']['jam'] ?> Jam
                                            <?= $summary['konversi_telat']['menit'] ?> Menit
                                        </small>
                                    </div>
                                    <div class="icon-big text-center">
                                        <i class="flaticon-time"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card card-stats card-danger">
                                <div class="card-body">
                                    <div class="numbers">
                                        <p class="card-category">Akumulasi Denda</p>
                                        <h4 class="card-title">
                                            Rp <?= number_format($summary['total_denda'] ?? 0, 0, ',', '.') ?>
                                        </h4>
                                        <small class="text-white">
                                            Akibat Keterlambatan
                                        </small>
                                    </div>
                                    <div class="icon-big text-center">
                                        <i class="flaticon-price-tag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card card-stats card-danger">
                                <div class="card-body">
                                    <div class="numbers">
                                        <p class="card-category">Pelanggaran Absensi</p>
                                        <h4 class="card-title">
                                            <?= $summary['total_tidak_finger'] ?> Kali
                                        </h4>
                                        <small class="text-white">
                                            Tidak Finger
                                        </small>
                                    </div>
                                    <div class="icon-big text-center">
                                        <i class="flaticon-error"></i>
                                    </div>
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
                                    <th>Hari</th>
                                    <th>Jam In</th>
                                    <th>Jam Out</th>
                                    <th>Kategori</th>
                                    <th>Status Pulang</th>
                                    <th>Bukti</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($absensi)) : ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data.</td>
                                    </tr>
                                <?php else : $no = 1; ?>
                                    <?php foreach ($absensi as $a) : ?>

                                        <?php
                                        $keterangan = $a['keterangan'] ?? '';
                                        $bukti      = $a['bukti'] ?? null;
                                        $hasBukti   = !empty($bukti);
                                        $isLibur    = ($a['kategori_telat'] ?? '') === 'Libur';

                                        $badge = 'secondary';

                                        switch ($a['kategori_telat'] ?? '') {
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

                                            case 'Libur':
                                                $badge = 'info';
                                                break;
                                        }
                                        ?>
                                        <tr <?= $isLibur ? 'style="background:#f5f5f5;font-style:italic"' : '' ?>>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d M Y', strtotime($a['tanggal'])) ?></td>
                                            <td><?= $a['hari'] ?? '-' ?></td>
                                            <td><?= $a['jam_in'] ?? '-' ?></td>
                                            <td><?= $a['jam_out'] ?? '-' ?></td>
                                            <td>
                                                <span class="badge badge-<?= $badge ?>">
                                                    <?= $a['kategori_telat'] ?? '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                // Default badge
                                                $status = $a['status_pulang'] ?? '-';
                                                $badgeStatus = 'secondary';

                                                // Keterangan khusus → selalu "-"
                                                if (in_array($keterangan, ['Sakit', 'Izin', 'Cuti', 'Dinas Luar', 'WFH'])) {
                                                    $status = '-';
                                                    $badgeStatus = 'secondary';
                                                } elseif ($status === 'Lembur') {
                                                    $badgeStatus = 'success';
                                                } elseif ($status === 'Terlambat Tidak Menambah Jam Kerja') {
                                                    $badgeStatus = 'warning';
                                                } elseif ($status === 'Pulang Normal') {
                                                    $badgeStatus = 'info';
                                                } elseif ($status === 'Tidak Lengkap') {
                                                    $badgeStatus = 'danger';
                                                }
                                                ?>

                                                <span class="badge badge-<?= $badgeStatus ?>">
                                                    <?= $status ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <?php if ($hasBukti) : ?>
                                                    <img src="<?= base_url($bukti) ?>"
                                                        style="max-width:80px;max-height:80px;border-radius:6px;cursor:pointer"
                                                        onclick="window.open('<?= base_url($bukti) ?>','_blank')">
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right">
                                                <?php if (!empty($a['nominal_denda'])) : ?>
                                                    <span class="badge badge-danger">
                                                        Rp <?= number_format($a['nominal_denda'], 0, ',', '.') ?>
                                                    </span>
                                                    <br>
                                                    <small class="text-muted"><?= $a['jenis_denda'] ?></small>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
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