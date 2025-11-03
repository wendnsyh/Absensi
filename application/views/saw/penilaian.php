<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Input Penilaian Karyawan</h4>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nilai Attitude & Skills</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('saw/simpan_penilaian'); ?>">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Attitude</th>
                                        <th>Skills</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pegawai as $p): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $p['nip']; ?></td>
                                            <td><?= $p['nama']; ?></td>
                                            <td>
                                                <input type="number" name="attitude[<?= $p['nip']; ?>]" class="form-control" value="<?= $p['attitude']; ?>" min="0" max="100" required>
                                            </td>
                                            <td>
                                                <input type="number" name="skills[<?= $p['nip']; ?>]" class="form-control" value="<?= $p['skills']; ?>" min="0" max="100" required>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Penilaian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>