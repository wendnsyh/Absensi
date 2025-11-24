<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="page-title">Master Divisi</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <a href="<?= base_url('dashboard') ?>"><i class="flaticon-home"></i></a>
                        </li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Master Divisi</li>
                    </ul>
                </div>
                <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#tambahModal">
                    <i class="fa fa-plus"></i> Tambah Divisi
                </button>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Divisi</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Divisi</th>
                                    <th>Dibuat Pada</th>
                                    <th width="18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($divisi)): $no = 1; ?>
                                    <?php foreach ($divisi as $d): ?>
                                        <?php if (!is_object($d)) continue; ?>

                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($d->nama_divisi); ?></td>
                                            <td class="text-center">
                                                <?= date('d M Y H:i', strtotime($d->created_at)); ?>
                                            </td>
                                            <td class="text-center">

                                                <!-- Tombol Edit -->
                                                <button class="btn btn-warning btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editModal<?= $d->id_divisi; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <a href="<?= base_url('divisi/delete/' . $d->id_divisi); ?>"
                                                    onclick="return confirm('Yakin ingin menghapus divisi ini?')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>

                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal<?= $d->id_divisi; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title text-white">Edit Divisi</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <form method="POST" action="<?= base_url('divisi/edit/' . $d->id_divisi); ?>">
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label>Nama Divisi</label>
                                                                <input type="text" name="nama_divisi"
                                                                    class="form-control"
                                                                    required
                                                                    value="<?= htmlspecialchars($d->nama_divisi); ?>">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-warning">Update</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal Edit -->

                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada data divisi
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Divisi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="<?= base_url('divisi/add'); ?>">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Divisi</label>
                        <input type="text" name="nama_divisi" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Modal Tambah -->