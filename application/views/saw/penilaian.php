<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Input Penilaian Karyawan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard'); ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Penilaian</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4 class="card-title">Form Penilaian Karyawan</h4>
                        </div>

                        <div class="card-body">
                            <form method="post" action="<?= base_url('saw/input_penilaian'); ?>">
                                <div class="form-group">
                                    <label for="nip">Pilih Karyawan</label>
                                    <select name="nip" id="nip" class="form-control select2" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        <?php foreach ($pegawai as $peg): ?>
                                            <option value="<?= $peg['nip']; ?>">
                                                <?= $peg['nip']; ?> - <?= $peg['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('nip', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="skills">Skill</label>
                                    <input type="number" class="form-control" id="skills" name="skills" min="0" max="100"
                                        placeholder="Nilai skill (0-100)" required>
                                    <?= form_error('skills', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="attitude">Attitude</label>
                                    <input type="number" class="form-control" id="attitude" name="attitude" min="0" max="100"
                                        placeholder="Nilai attitude (0-100)" required>
                                    <?= form_error('attitude', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Penilaian
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Data Penilaian Karyawan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Hari Kerja</th>
                                            <th>Skill</th>
                                            <th>Attitude</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($penilaian)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($penilaian as $p): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $p['nip']; ?></td>
                                                    <td><?= $p['nama']; ?></td>
                                                    <td><?= $p['hari_kerja']; ?></td>
                                                    <td><?= $p['skills']; ?></td>
                                                    <td><?= $p['attitude']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-muted">Belum ada data penilaian.</td>
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
    </div>
</div>