<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Master Pegawai</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="<?= base_url('dashboard') ?>"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Pegawai</li>
                </ul>
            </div>

            <?= $this->session->flashdata('message') ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Pegawai</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahPegawai">
                        <i class="fa fa-plus"></i> Tambah Pegawai
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Divisi</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pegawai as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($p->nip) ?></td>
                                        <td><?= htmlspecialchars($p->nama_pegawai) ?></td>

                                        <td>
                                            <?= $p->nama_divisi
                                                ? htmlspecialchars($p->nama_divisi)
                                                : '<span class="badge badge-danger">Belum diatur</span>' ?>
                                        </td>

                                        <td><?= htmlspecialchars($p->jabatan ?: '-') ?></td>

                                        <td>
                                            <?php if (($p->status_aktif ?? 'aktif') == "aktif"): ?>
                                                <span class="badge badge-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Nonaktif</span>
                                            <?php endif ?>
                                        </td>

                                        <td>
                                            <!-- Edit -->
                                            <button class="btn btn-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#modalEditPegawai<?= $p->id_pegawai ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Delete -->
                                            <a href="<?= base_url('pegawai/delete/' . $p->id_pegawai) ?>"
                                                onclick="return confirm('Hapus pegawai ini?')"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEditPegawai<?= $p->id_pegawai ?>">
                                        <div class="modal-dialog">
                                            <form method="post" action="<?= base_url('pegawai/edit/' . $p->id_pegawai) ?>">

                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h4 class="modal-title text-white">Edit Pegawai</h4>
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <label>NIP</label>
                                                        <input type="text" name="nip" class="form-control"
                                                            value="<?= $p->nip ?>" required>

                                                        <label class="mt-2">Nama Pegawai</label>
                                                        <input type="text" name="nama_pegawai" class="form-control"
                                                            value="<?= $p->nama_pegawai ?>" required>

                                                        <label class="mt-2">Divisi</label>
                                                        <select name="id_divisi" class="form-control">
                                                            <option value="">-- Pilih Divisi --</option>
                                                            <?php foreach ($divisi_list as $d): ?>
                                                                <option value="<?= $d->id_divisi ?>"
                                                                    <?= ($p->id_divisi == $d->id_divisi ? "selected" : "") ?>>
                                                                    <?= $d->nama_divisi ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>

                                                        <label class="mt-2">Jabatan</label>
                                                        <input type="text" name="jabatan" class="form-control"
                                                            value="<?= $p->jabatan ?>">

                                                        <label class="mt-2">Status</label>
                                                        <select name="status_aktif" class="form-control">
                                                            <option value="aktif" <?= ($p->status_aktif == "aktif" ? "selected" : "") ?>>Aktif</option>
                                                            <option value="nonaktif" <?= ($p->status_aktif == "nonaktif" ? "selected" : "") ?>>Nonaktif</option>
                                                        </select>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button class="btn btn-warning">Update</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Pegawai -->
<div class="modal fade" id="modalTambahPegawai">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('pegawai/add') ?>">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Tambah Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" required>

                    <label class="mt-2">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" class="form-control" required>

                    <label class="mt-2">Divisi</label>
                    <select name="id_divisi" class="form-control">
                        <option value="">-- Pilih Divisi --</option>
                        <?php foreach ($divisi_list as $d): ?>
                            <option value="<?= $d->id_divisi ?>"><?= $d->nama_divisi ?></option>
                        <?php endforeach ?>
                    </select>

                    <label class="mt-2">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>