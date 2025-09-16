<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Karyawan</h4>
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
                        <a href="#">Karyawan</a>
                    </li>
                </ul>
            </div>

            <!-- Flash message -->
            <?= $this->session->flashdata('message'); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahKaryawan">
                                <i class="fas fa-plus"></i> Tambah Karyawan
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Divisi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($karyawan as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['nip']; ?></td>
                                                <td><?= date('d M Y', strtotime($row['tanggal_masuk'])); ?></td>
                                                <td><?= $row['divisi']; ?></td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKaryawan<?= $row['id_karyawan']; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <!-- Tombol Hapus -->
                                                    <a href="<?= base_url('karyawan/delete/' . $row['id_karyawan']); ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data ini?');">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editKaryawan<?= $row['id_karyawan']; ?>" tabindex="-1" role="dialog" aria-labelledby="editKaryawanLabel<?= $row['id_karyawan']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="<?= base_url('karyawan/edit/' . $row['id_karyawan']); ?>" method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editKaryawanLabel<?= $row['id_karyawan']; ?>">Edit Karyawan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group">
                                                                    <label for="nama">Nama</label>
                                                                    <input type="text" class="form-control" name="nama" value="<?= $row['nama']; ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="nip">NIP</label>
                                                                    <input type="number" class="form-control" name="nip" value="<?= $row['nip']; ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                                                    <input type="date" class="form-control" name="tanggal_masuk" value="<?= $row['tanggal_masuk']; ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="divisi">Divisi</label>
                                                                    <select name="divisi" class="form-control" required>
                                                                        <option value="Sekretariat" <?= $row['divisi'] == 'Sekretariat' ? 'selected' : ''; ?>>Sekretariat</option>
                                                                        <option value="Rehabsos" <?= $row['divisi'] == 'Rehabsos' ? 'selected' : ''; ?>>Rehabsos</option>
                                                                        <option value="Dayasos" <?= $row['divisi'] == 'Dayasos' ? 'selected' : ''; ?>>Dayasos</option>
                                                                        <option value="Linjamsos" <?= $row['divisi'] == 'Linjamsos' ? 'selected' : ''; ?>>Linjamsos</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                                    <i class="fas fa-times mr-2"></i>Batal
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save mr-2"></i>Update
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal Edit -->

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Karyawan -->
            <div class="modal fade" id="tambahKaryawan" tabindex="-1" role="dialog" aria-labelledby="tambahKaryawanLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('karyawan/add'); ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahKaryawanLabel">Tambah Karyawan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="number" class="form-control" name="nip" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_masuk" required>
                                </div>

                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <select name="divisi" class="form-control" required>
                                        <option value="">-- Pilih Divisi --</option>
                                        <option value="Sekretariat">Sekretariat</option>
                                        <option value="Rehabsos">Rehabsos</option>
                                        <option value="Dayasos">Dayasos</option>
                                        <option value="Linjamsos">Linjamsos</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Tambah -->

        </div>
    </div>
</div>