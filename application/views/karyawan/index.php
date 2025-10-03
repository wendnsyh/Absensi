<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-title">Data Karyawan</div>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahKaryawan">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableKaryawan" class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($karyawan as $k): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $k['nama']; ?></td>
                            <td><?= $k['nik']; ?></td>
                            <td><?= $k['jabatan']; ?></td>
                            <td><?= $k['divisi']; ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKaryawan<?= $k['id_karyawan']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <a href="<?= base_url('karyawan/hapus/' . $k['id_karyawan']); ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editKaryawan<?= $k['id_karyawan']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="<?= base_url('karyawan/edit/' . $k['id_karyawan']); ?>" method="post">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Edit Karyawan</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="nama" class="form-control" value="<?= $k['nama']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" name="nik" class="form-control" value="<?= $k['nik']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" value="<?= $k['jabatan']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Divisi</label>
                                                <input type="text" name="divisi" class="form-control" value="<?= $k['divisi']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('karyawan/tambah'); ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Divisi</label>
                        <input type="text" name="divisi" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>