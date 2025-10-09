<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Absensi Pegawai</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="<?= base_url('absensi/absen_harian') ?>">Absensi Harian</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Detail</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <?= $pegawai['nama'] ?? 'Tidak diketahui' ?>
                        (<?= $pegawai['nip'] ?? '' ?>) <br>
                        Bulan: <?= date("F Y", mktime(0, 0, 0, $bulan, 1, $tahun)) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam In</th>
                                    <th>Jam Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($detail)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1;
                                    foreach ($detail as $d): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($d['tanggal'])) ?></td>
                                            <td><?= $d['jam_in'] ?? '-' ?></td>
                                            <td><?= $d['jam_out'] ?? '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('absensi/absen_harian?bulan=' . $bulan . '&tahun=' . $tahun) ?>"
                        class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
