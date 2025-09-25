<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
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
                        <a href="#">Rekap</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <form action="<?= base_url('absensi/laporan_rekap'); ?>" method="post" class="form-inline">
                        <label class="mr-2">Dari Tanggal:</label>
                        <input type="date" name="start_date" class="form-control mr-2" value="<?= isset($start_date) ? $start_date : ''; ?>" required>
                        <label class="mr-2">Sampai Tanggal:</label>
                        <input type="date" name="end_date" class="form-control mr-4" value="<?= isset($end_date) ? $end_date : ''; ?>" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Tampilkan Laporan
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <?php if (!empty($rekap_data)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Total Hadir</th>
                                        <th>Total Tidak Hadir</th>
                                        <th>Total Telat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($rekap_data as $rekap): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $rekap['nama']; ?></td>
                                            <td><?= $rekap['nip']; ?></td>
                                            <td><?= $rekap['total_hadir'] ?: 0; ?></td>
                                            <td>
                                                <?php
                                                $total_tidak_hadir = ($rekap['total_sakit'] ?: 0) + ($rekap['total_izin'] ?: 0) + ($rekap['total_alfa'] ?: 0) + ($rekap['total_cuti'] ?: 0);
                                                echo $total_tidak_hadir;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $total_telat = ($rekap['total_telat_kurang_30'] ?: 0) + ($rekap['total_telat_30_90'] ?: 0) + ($rekap['total_telat_lebih_90'] ?: 0);
                                                echo $total_telat;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center">Silakan pilih periode tanggal untuk menampilkan laporan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>