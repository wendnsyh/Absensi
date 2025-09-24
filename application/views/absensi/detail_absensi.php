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

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail Absensi <?= $absensi['nama'] ?></div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td><?= $absensi['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td><?= $absensi['nip']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><?= date('d M Y', strtotime($absensi['tanggal'])); ?></td>
                            </tr>
                            <tr>
                                <td>Status Kehadiran</td>
                                <td>
                                    <?php
                                    if ($absensi['hadir'] == 1) echo 'Hadir';
                                    else if ($absensi['sakit'] == 1) echo 'Sakit';
                                    else if ($absensi['izin'] == 1) echo 'Izin';
                                    else if ($absensi['alfa'] == 1) echo 'Alfa';
                                    else if ($absensi['cuti'] == 1) echo 'Cuti';
                                    else if ($absensi['dinas_luar'] == 1) echo 'Dinas Luar';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Terlambat < 30 menit</td>
                                <td><?= $absensi['terlambat_kurang_30'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Terlambat 30-90 menit</td>
                                <td><?= $absensi['terlambat_30_90'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Terlambat > 90 menit</td>
                                <td><?= $absensi['terlambat_lebih_90'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Tidak Finger Masuk</td>
                                <td><?= $absensi['tidak_finger_masuk'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Tidak Finger Pulang</td>
                                <td><?= $absensi['tidak_finger_pulang'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Sakit</td>
                                <td><?= $absensi['sakit'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Izin</td>
                                <td><?= $absensi['izin'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Alfa</td>
                                <td><?= $absensi['alfa'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Dinas Luar</td>
                                <td><?= $absensi['dinas_luar'] ?: 0; ?> kali</td>
                            </tr>
                            <tr>
                                <td>Cuti</td>
                                <td><?= $absensi['cuti'] ?: 0; ?> kali</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('absensi'); ?>" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>