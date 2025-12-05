<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Rekap Absensi Bulanan</h4>
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
                </ul>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <!-- Filter Bulan & Tahun -->
                    <form method="get" class="form-inline">
                        <label class="mr-2">Bulan:</label>
                        <select name="bulan" class="form-control mr-2" onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>>
                                    <?= date("F", mktime(0, 0, 0, $i, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <label class="mr-2">Tahun:</label>
                        <select name="tahun" class="form-control mr-2" onchange="this.form.submit()">
                            <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </form>

                    <!-- Dua Tombol Import -->
                    <div>
                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#importHarianModal">
                            <i class="fas fa-file-excel"></i> Import Absensi Harian
                        </button>

                        <button class="btn btn-primary" data-toggle="modal" data-target="#importFingerModal">
                            <i class="fas fa-fingerprint"></i> Import Fingerprint
                        </button>
                    </div>
                </div>

                <!-- Tabel Pegawai -->
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (empty($rekap)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data absensi</td>
                                    </tr>
                                <?php else: ?>

                                    <?php $no = 1;
                                    foreach ($rekap as $r): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $r['nip'] ?></td>
                                            <td><?= $r['nama_pegawai'] ?></td>
                                            <td>
                                                <a href="<?= base_url('absensi/detail_harian/'
                                                                . $r['nip'] . '/'
                                                                . $bulan . '/'
                                                                . $tahun) ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url('absensi/edit_status/'
                                                                . $r['nip'] . '/'
                                                                . $bulan . '/'
                                                                . $tahun) ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Edit
                                                </a>
                                                <a href="<?= base_url('absensi/hapus_rekap/'
                                                                . $r['nip'] . '/'
                                                                . $bulan . '/'
                                                                . $tahun) ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus semua absensi pegawai ini pada bulan ini?')">
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
            </div>


            <div class="modal fade" id="importHarianModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form action="<?= base_url('absensi/import_harian') ?>"
                            method="post" enctype="multipart/form-data">

                            <div class="modal-header">
                                <h5 class="modal-title">Import Absensi Harian</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <input type="hidden" name="metode" value="1">

                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="bulan_impor" class="form-control" required>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i ?>"><?= date("F", mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun_impor" class="form-control" required>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>File Excel</label>
                                    <input type="file" name="file" class="form-control" required>
                                    <small class="text-danger">Gunakan template IN & OUT per pegawai.</small>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button class="btn btn-success" type="submit">Import</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="importFingerModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form action="<?= base_url('Fingerprint/import_finger') ?>"
                            method="post" enctype="multipart/form-data">

                            <div class="modal-header">
                                <h5 class="modal-title">Import Data Fingerprint</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <input type="hidden" name="metode" value="2">

                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="bulan_impor" class="form-control" required>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i ?>"><?= date("F", mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun_impor" class="form-control" required>
                                        <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>File Fingerprint</label>
                                    <input type="file" name="file" class="form-control" required>
                                    <small class="text-info">Gunakan format fingerprint timesheet (jam IN atas, OUT bawah).</small>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit">Import</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>