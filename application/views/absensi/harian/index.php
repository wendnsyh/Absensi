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
                    <div>

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
                                                <a href="<?= base_url(
                                                                'absensi/detail_harian/' . $r['nip']
                                                                    . '?periode_type=' . $periode_type
                                                                    . '&periode_key=' . $periode_key
                                                                    . '&divisi_id=' . $divisi_id
                                                            ) ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url(
                                                                'fingerprint/edit_kehadiran/' . $r['nip']
                                                                    . '?periode_type=' . $periode_type
                                                                    . '&periode_key=' . $periode_key
                                                            ) ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= base_url(
                                                                'absensi/hapus_rekap/' . $r['nip']
                                                                    . '?periode_type=' . $periode_type
                                                                    . '&periode_key=' . $periode_key
                                                            ) ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus semua absensi pegawai pada periode ini?')">
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

                                <div class="alert alert-info">
                                    <b>Periode Otomatis</b><br>
                                    Sistem akan membaca periode langsung dari file Excel.<br>
                                    Contoh: <code>Periode: 01/10/2025 - 31/10/2025</code>
                                </div>

                                <div class="form-group">
                                    <label>File Fingerprint</label>
                                    <input type="file" name="file" class="form-control" required>
                                    <small class="text-muted">
                                        Format: Nama | Tanggal | Jam<br>
                                        Jam paling awal = IN, paling akhir = OUT
                                    </small>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>