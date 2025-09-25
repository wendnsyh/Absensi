<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Edit Data Karyawan</h4>
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
                        <a href="<?= base_url('karyawan') ?>">Karyawan</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit Karyawan</div>
                        </div>
                        <form action="<?= base_url('karyawan/update/' . $karyawan['id_karyawan']); ?>" method="post">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text"
                                        class="form-control"
                                        id="nama"
                                        name="nama"
                                        value="<?= $karyawan['nama']; ?>"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text"
                                        class="form-control"
                                        id="nip"
                                        name="nip"
                                        value="<?= $karyawan['nip']; ?>"
                                        pattern="[0-9]+"
                                        title="Hanya boleh angka"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_masuk">Tanggal Masuk</label>
                                    <input type="date"
                                        class="form-control"
                                        id="tanggal_masuk"
                                        name="tanggal_masuk"
                                        value="<?= $karyawan['tanggal_masuk']; ?>"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <select class="form-control" id="divisi" name="divisi" required>
                                        <option value="">-- Pilih Divisi --</option>
                                        <option value="Sekretariat" <?= ($karyawan['divisi'] == 'Sekretariat') ? 'selected' : '' ?>>Sekretariat</option>
                                        <option value="Rehabsos" <?= ($karyawan['divisi'] == 'Rehabsos') ? 'selected' : '' ?>>Rehabsos</option>
                                        <option value="Dayasos" <?= ($karyawan['divisi'] == 'Dayasos') ? 'selected' : '' ?>>Dayasos</option>
                                        <option value="Linjamsos" <?= ($karyawan['divisi'] == 'Linjamsos') ? 'selected' : '' ?>>Linjamsos</option>
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <a href="<?= base_url('karyawan'); ?>" class="btn btn-danger">
                                    <i class="fas fa-arrow-left mr-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>