<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Absensi Harian</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Absensi</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Detail</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4 class="card-title">
                                <?= $pegawai['nama'] ?> (<?= $pegawai['nip'] ?>)
                                - <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
                            </h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display table table-striped table-hover">
                                    <thead class="bg-primary text-white text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Jam In</th>
                                            <th>Jam Out</th>
                                            <th>Keterangan</th>
                                            <th>Kategori</th>
                                            <th>Menit Telat</th>
                                            <th>Status Pulang</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php $no = 1;
                                        foreach ($absensi as $row): ?>
                                            <?php
                                            $kategori = $row['kategori_telat'];
                                            $badge_class = 'secondary';

                                            switch ($kategori) {
                                                case 'Tepat Waktu':
                                                    $badge_class = 'success';
                                                    break;
                                                case 'Telat < 30 Menit':
                                                    $badge_class = 'warning';
                                                    break;
                                                case 'Telat 30–90 Menit':
                                                    $badge_class = 'warning';
                                                    break;
                                                case 'Telat > 90 Menit':
                                                    $badge_class = 'danger';
                                                    break;
                                                case 'Tidak Finger':
                                                    $badge_class = 'info';
                                                    break;
                                                case 'Sakit':
                                                    $badge_class = 'primary';
                                                    break;
                                                case 'Izin':
                                                    $badge_class = 'primary';
                                                    break;
                                                case 'Cuti':
                                                    $badge_class = 'info';
                                                    break;
                                                case 'Dinas Luar':
                                                    $badge_class = 'dark';
                                                    break;
                                                case 'WFH':
                                                    $badge_class = 'secondary';
                                                    break;
                                                case 'Tanpa Keterangan':
                                                    $badge_class = 'danger';
                                                    break;
                                                case 'Libur':
                                                    $badge_class = 'light';
                                                    break;
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                                <td><?= $row['hari'] ?></td>
                                                <td><?= $row['jam_in'] ?: '-' ?></td>
                                                <td><?= $row['jam_out'] ?: '-' ?></td>
                                                <td>
                                                    <span class="badge badge-<?= $badge_class ?>">
                                                        <?= $row['keterangan'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?= $badge_class ?>">
                                                        <?= $row['kategori_telat'] ?>
                                                    </span>
                                                </td>
                                                <td><?= $row['menit_telat'] ?> menit</td>
                                                <td><?= $row['status_pulang'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <h6 class="font-weight-bold">Rekap Bulan Ini</h6>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <p>Total Hadir: <strong><?= $summary['total_hadir'] ?></strong></p>
                                </div>
                                <div class="col-md-3">
                                    <p>Total Menit Telat: <strong><?= $summary['total_menit_telat'] ?> menit</strong></p>
                                </div>
                                <div class="col-md-3">
                                    <p>Tidak Finger: <strong><?= $summary['total_tidak_finger'] ?></strong></p>
                                </div>
                                <div class="col-md-3">
                                    <p>Konversi Telat:
                                        <strong>
                                            <?= $summary['konversi_telat']['hari'] ?>h
                                            <?= $summary['konversi_telat']['jam'] ?>j
                                            <?= $summary['konversi_telat']['menit'] ?>m
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>