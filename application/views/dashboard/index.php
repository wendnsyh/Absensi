<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-primary card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-users"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Pegawai</p>
                                        <h4 class="card-title"><?= $total_pegawai; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-check"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Kehadiran (Bulan Ini)</p>
                                        <h4 class="card-title"><?= $summary['total_hadir'] ?: 0; ?> Hari</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-warning card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-time-2"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Telat (Bulan Ini)</p>
                                        <h4 class="card-title"><?= $summary['total_telat'] ?: 0; ?>x</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-danger card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-close"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Alfa (Bulan Ini)</p>
                                        <h4 class="card-title"><?= $summary['total_alfa'] ?: 0; ?> Hari</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Aktivitas Absensi Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-head-bg-primary mt-4">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($recent_absensi as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['nip']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['hadir'] == 1) echo '<span class="badge badge-success">Hadir</span>';
                                                    else if ($row['sakit'] == 1) echo '<span class="badge badge-warning">Sakit</span>';
                                                    else if ($row['izin'] == 1) echo '<span class="badge badge-info">Izin</span>';
                                                    else if ($row['alfa'] == 1) echo '<span class="badge badge-danger">Alfa</span>';
                                                    else if ($row['cuti'] == 1) echo '<span class="badge badge-primary">Cuti</span>';
                                                    else if ($row['dinas_luar'] == 1) echo '<span class="badge badge-secondary">Dinas Luar</span>';
                                                    ?>
                                                </td>
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
    </div>
</div>