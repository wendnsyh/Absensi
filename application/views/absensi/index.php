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
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($absensi as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['nip']; ?></td>
                                        <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= $row['keterangan']; ?></td>
                                        <td>
                                            <a href="<?= base_url('absensi/delete/'.$row['id_absensi']); ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Yakin hapus data ini?');">
                                               <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Absensi -->
            <div class="modal fade" id="tambahAbsensi" tabindex="-1" role="dialog" aria-labelledby="tambahAbsensiLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('absensi/add'); ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Absensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Karyawan</label>
                                    <select name="id_karyawan" class="form-control" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        <?php foreach ($karyawan as $k): ?>
                                            <option value="<?= $k['id_karyawan']; ?>"><?= $k['nama'].' - '.$k['nip']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" required>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Alpha">Alpha</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

        </div>
    </div>
</div>
