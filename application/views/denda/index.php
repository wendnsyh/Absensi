<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">

                <h4 class="page-title">Master Denda Keterlambatan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard') ?>"><i class="flaticon-home"></i></a>
                    </li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Master Denda</li>
                </ul>
                <button class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Denda
                </button>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Rentang Menit</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($denda as $d): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $d->jenis_denda ?></td>
                                    <td><?= $d->menit_min ?> - <?= $d->menit_max ?> menit</td>
                                    <td>Rp <?= number_format($d->jumlah) ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm"
                                            data-toggle="modal"
                                            data-target="#modalEdit<?= $d->id_denda ?>">
                                            <i class="fas fa-edit">Edit</i>
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#modalEdit<?= $d->id_denda ?>">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('denda/simpan') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Denda</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input class="form-control mb-2" name="jenis_denda" placeholder="Jenis" required>
                    <input class="form-control mb-2" name="menit_min" type="number" placeholder="Menit Min" required>
                    <input class="form-control mb-2" name="menit_max" type="number" placeholder="Menit Max" required>
                    <input class="form-control mb-2" name="jumlah" type="number" placeholder="Jumlah" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php foreach ($denda as $d): ?>
    <div class="modal fade" id="modalEdit<?= $d->id_denda ?>">
        <div class="modal-dialog">
            <form method="post" action="<?= base_url('denda/update') ?>">
                <input type="hidden" name="id_denda" value="<?= $d->id_denda ?>">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Denda</h5>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <input class="form-control mb-2" name="jenis_denda"
                            value="<?= $d->jenis_denda ?>" required>
                        <input class="form-control mb-2" name="menit_min"
                            value="<?= $d->menit_min ?>" required>
                        <input class="form-control mb-2" name="menit_max"
                            value="<?= $d->menit_max ?>" required>
                        <input class="form-control mb-2" name="jumlah"
                            value="<?= $d->jumlah ?>" required>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach ?>