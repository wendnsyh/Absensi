<?php $penilaian = $penilaian ?? []; ?>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Input Penilaian Karyawan</h4>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Form Penilaian</h5>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('saw/input_penilaian?bulan=' . $bulan . '&tahun=' . $tahun) ?>" method="post" class="form-inline">
                        <div class="form-group mr-2">
                            <label class="mr-2">Pegawai</label>
                            <select name="nip" class="form-control" required>
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= $p->nip ?>"><?= $p->nama_pegawai ?> (<?= $p->nip ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mr-2">
                            <label class="mr-2">Skills</label>
                            <input type="number" name="skills" class="form-control" min="0" max="100" required>
                        </div>

                        <div class="form-group mr-2">
                            <label class="mr-2">Attitude</label>
                            <input type="number" name="attitude" class="form-control" min="0" max="100" required>
                        </div>

                        <button class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Penilaian (Periode <?= $bulan ?>/<?= $tahun ?>)</h5>
                    <form action="<?= base_url('saw/simpan_semua_penilaian?bulan=' . $bulan . '&tahun=' . $tahun) ?>" method="post" class="mb-0">
                        <button class="btn btn-light btn-sm">Simpan Semua Nilai</button>
                    </form>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Hari Kerja</th>
                                    <th>Skills</th>
                                    <th>Attitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($penilaian)): $no = 1;
                                    foreach ($penilaian as $r): ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $r['nip'] ?></td>
                                            <td class="text-left"><?= $r['nama'] ?></td>
                                            <td><?= $r['hari_kerja'] ?></td>
                                            <td>
                                                <input type="hidden" name="nip[]" value="<?= $r['nip'] ?>">
                                                <input type="number" name="skills[]" class="form-control text-center" value="<?= $r['skills'] ?>" min="0" max="100">
                                            </td>
                                            <td>
                                                <input type="number" name="attitude[]" class="form-control text-center" value="<?= $r['attitude'] ?>" min="0" max="100">
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data penilaian untuk periode ini.</td>
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