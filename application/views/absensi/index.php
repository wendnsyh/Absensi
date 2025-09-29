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
                        <a href="#">Absensi</a>
                    </li>
                </ul>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between mb-3">
                        <form action="<?= base_url('absensi/index'); ?>" method="get" class="form-inline">
                            <label class="mr-2">Tampilkan:</label>
                            <select name="bulan" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="">Semua Bulan</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i; ?>" <?= (isset($bulan_terpilih) && $bulan_terpilih == $i) ? 'selected' : ''; ?>>
                                        <?= date('F', mktime(0, 0, 0, $i, 10)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="tahun" class="form-control mr-4" onchange="this.form.submit()">
                                <option value="">Semua Tahun</option>
                                <?php for ($i = date('Y'); $i >= (date('Y') - 5); $i--): ?>
                                    <option value="<?= $i; ?>" <?= (isset($tahun_terpilih) && $tahun_terpilih == $i) ? 'selected' : ''; ?>>
                                        <?= $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>

                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari Nama atau NIP..." name="keyword" value="<?= html_escape($this->input->get('keyword')) ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary mr-1" type="submit">
                                        <i class="flaticon-search-1"></i> Cari
                                    </button>
                                    <a href="<?= base_url('absensi'); ?>" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div>
                            <button class="btn btn-success" data-toggle="modal" data-target="#importExcelModal">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahAbsensiModal">
                                <i class="fas fa-plus"></i> Tambah Absensi
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>ID Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Total Tidak Masuk</th>
                                    <th>Total Telat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($absensi)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = $start + 1;
                                    foreach ($absensi as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['nip']; ?></td>
                                            <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                            <td>
                                                <?php
                                                $total_tidak_hadir = $row['sakit'] + $row['izin'] + $row['alfa'] + $row['cuti'];
                                                if ($total_tidak_hadir > 0) {
                                                    echo $total_tidak_hadir . ' hari';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $total_telat = $row['terlambat_kurang_30'] + $row['terlambat_30_90'] + $row['terlambat_lebih_90'];
                                                $total_tidak_finger = $row['tidak_finger_masuk'] + $row['tidak_finger_pulang'];

                                                if ($total_telat > 0) {
                                                    echo 'Total Telat: ' . $total_telat . 'x';
                                                    if ($total_tidak_finger > 0) echo ', Tidak Finger: ' . $total_tidak_finger . 'x';
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

            <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('absensi/import'); ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importExcelModalLabel">Import Data Absensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Pilih Bulan</label>
                                    <select name="bulan_impor" class="form-control" required>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i; ?>" <?= (date('n') == $i) ? 'selected' : ''; ?>>
                                                <?= date('F', mktime(0, 0, 0, $i, 10)); ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Tahun</label>
                                    <select name="tahun_impor" class="form-control" required>
                                        <?php for ($i = date('Y'); $i >= (date('Y') - 5); $i--): ?>
                                            <option value="<?= $i; ?>" <?= (date('Y') == $i) ? 'selected' : ''; ?>>
                                                <?= $i; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih File Excel (.xlsx/.xls)</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <p class="text-danger">Pastikan format Excel sesuai dengan template. Data absensi untuk bulan dan tahun yang sama akan diganti.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>