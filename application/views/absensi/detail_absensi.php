<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Detail Absensi</h4>
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
                        <a href="<?= base_url('absensi') ?>">Absensi</a>
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
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title text-white mb-0">Detail Absensi: <?= $absensi['nama'] ?></h4>
                                <div class="ml-auto">
                                    <a href="<?= base_url('absensi'); ?>" class="btn btn-sm btn-light">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary"><i class="fas fa-user-circle"></i> Data Pegawai</h5>
                                    <table class="table table-sm table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td style="width: 150px;">Nama</td>
                                                <td>: <strong><?= $absensi['nama']; ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>NIP</td>
                                                <td>: <strong><?= $absensi['nip']; ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal</td>
                                                <td>: <strong><?= date('d M Y', strtotime($absensi['tanggal'])); ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-primary"><i class="fas fa-info-circle"></i> Status Ringkasan</h5>
                                    <div class="card bg-light mt-3">
                                        <div class="card-body py-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Status Kehadiran:</span>
                                                <h5>
                                                    <?php
                                                    $total_tidak_hadir = $absensi['sakit'] + $absensi['izin'] + $absensi['alfa'] + $absensi['cuti'];
                                                    if ($absensi['hadir'] > 0) {
                                                        echo '<span class="badge badge-success">Hadir (' . $absensi['hadir'] . ' hari)</span>';
                                                    } else if ($total_tidak_hadir > 0) {
                                                        echo '<span class="badge badge-danger">Tidak Hadir (' . $total_tidak_hadir . ' hari)</span>';
                                                    } else {
                                                        echo '<span class="badge badge-secondary">Tidak Ada Data</span>';
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Total Keterlambatan:</span>
                                                <h5>
                                                    <?php
                                                    $total_telat = $absensi['terlambat_kurang_30'] + $absensi['terlambat_30_90'] + $absensi['terlambat_lebih_90'];
                                                    if ($total_telat > 0) {
                                                        echo '<span class="badge badge-warning">' . $total_telat . ' kali</span>';
                                                    } else {
                                                        echo '<span class="badge badge-success">0 kali</span>';
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="text-primary"><i class="fas fa-list-alt"></i> Detail Rincian</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Status Ketidakhadiran</h6>
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <td style="width: 200px;">Sakit</td>
                                                <td>: <strong><?= $absensi['sakit'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Izin</td>
                                                <td>: <strong><?= $absensi['izin'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Alfa</td>
                                                <td>: <strong><?= $absensi['alfa'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Cuti</td>
                                                <td>: <strong><?= $absensi['cuti'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Dinas Luar</td>
                                                <td>: <strong><?= $absensi['dinas_luar'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Keterlambatan & Fingerprint</h6>
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <td style="width: 200px;">Terlambat < 30 menit</td>
                                                <td>: <strong><?= $absensi['terlambat_kurang_30'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Terlambat 30-90 menit</td>
                                                <td>: <strong><?= $absensi['terlambat_30_90'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Terlambat > 90 menit</td>
                                                <td>: <strong><?= $absensi['terlambat_lebih_90'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Tidak Finger Masuk</td>
                                                <td>: <strong><?= $absensi['tidak_finger_masuk'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                            <tr>
                                                <td>Tidak Finger Pulang</td>
                                                <td>: <strong><?= $absensi['tidak_finger_pulang'] ?: 0; ?></strong> kali</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>