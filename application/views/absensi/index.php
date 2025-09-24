<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Absensi</h4>
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
                        <a href="#">Absensi</a>
                    </li>
                </ul>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <form action="<?= base_url('absensi/import'); ?>" method="post" enctype="multipart/form-data" class="form-inline">
                        <input type="file" name="file" class="form-control mr-2" required>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>
                    </form>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahAbsensi">
                        <i class="fas fa-plus"></i> Tambah Absensi
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 ml-auto">
                            <form action="<?= base_url('absensi'); ?>" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari Nama atau NIP" name="keyword" value="<?= html_escape($this->input->get('keyword')) ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary mr-2" type="submit">
                                            <i class="flaticon-search-1"></i> Cari
                                        </button>
                                        <a href="<?= base_url('absensi'); ?>" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total Telat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($absensi)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = $start + 1; // Penomoran dimulai dari offset yang benar
                                    foreach ($absensi as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['nip']; ?></td>
                                            <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                            <td>
                                                <?php
                                                if ($row['hadir'] == 1) echo 'Hadir';
                                                else if ($row['sakit'] == 1) echo 'Sakit';
                                                else if ($row['izin'] == 1) echo 'Izin';
                                                else if ($row['alfa'] == 1) echo 'Alfa';
                                                else if ($row['cuti'] == 1) echo 'Cuti';
                                                else if ($row['dinas_luar'] == 1) echo 'Dinas Luar';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $total_telat = $row['terlambat_kurang_30'] + $row['terlambat_30_90'] + $row['terlambat_lebih_90'];
                                                $total_tidak_finger = $row['tidak_finger_masuk'] + $row['tidak_finger_pulang'];

                                                if ($total_telat > 0 && $total_tidak_finger > 0) {
                                                    echo 'Total Telat: ' . $total_telat . 'x, Tidak Finger: ' . $total_tidak_finger . 'x';
                                                } else if ($total_telat > 0) {
                                                    echo 'Total Telat: ' . $total_telat . 'x';
                                                } else if ($total_tidak_finger > 0) {
                                                    echo 'Tidak Finger: ' . $total_tidak_finger . 'x';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('absensi/detail/' . $row['id']); ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url('absensi/delete/' . $row['id']); ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin hapus data ini?');">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <?= $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>