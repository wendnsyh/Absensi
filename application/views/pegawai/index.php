<!-- Atlantis Template Views for Pegawai Module -->

<!-- index.php -->
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Pegawai</h4>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <form class="form-inline" method="get" action="">
                        <div class="form-group mr-2">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama/NIP" value="<?= $keyword ?>">
                        </div>
                        <div class="form-group mr-2">
                            <select name="divisi" class="form-control">
                                <option value="">Semua Divisi</option>
                                <?php foreach ($divisi_list as $d): ?>
                                    <option value="<?= $d->divisi ?>" <?= ($filter_divisi == $d->divisi ? 'selected' : '') ?>>
                                        <?= $d->divisi ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button class="btn btn-primary">Filter</button>
                    </form>

                    <button class="btn btn-success" data-toggle="modal" data-target="#modalAddPegawai">Tambah Pegawai</button>
                </div>

                <div class="card-body">
                    <?= $this->session->flashdata('message') ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Divisi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $start + 1; foreach($pegawai as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $p->nip ?></td>
                                    <td><?= $p->nama_pegawai ?></td>
                                    <td><?= $p->divisi ?: '-' ?></td>
                                    <td><?= $p->tanggal_masuk ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditPegawai<?= $p->id_pegawai ?>">Edit</button>
                                        <a href="<?= base_url('pegawai/delete/' . $p->id_pegawai) ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?= $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pegawai -->
<div class="modal fade" id="modalAddPegawai">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?= base_url('pegawai/add') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Divisi</label>
                        <select name="divisi" class="form-control">
                            <option value="">Pilih Divisi</option>
                            <?php foreach ($divisi_list as $d): ?>
                                <option value="<?= $d->divisi ?>"><?= $d->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pegawai -->
<?php foreach ($pegawai as $p): ?>
<div class="modal fade" id="modalEditPegawai<?= $p->id_pegawai ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="<?= base_url('pegawai/edit/' . $p->id_pegawai) ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?= $p->nip ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama" class="form-control" value="<?= $p->nama_pegawai ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Divisi</label>
                        <select name="divisi" class="form-control">
                            <option value="">Pilih Divisi</option>
                            <?php foreach ($divisi_list as $d): ?>
                                <option value="<?= $d->divisi ?>" <?= ($p->divisi == $d->divisi) ? 'selected' : '' ?>>
                                    <?= $d->divisi ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="<?= $p->tanggal_masuk ?>" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
