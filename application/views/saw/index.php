<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Hasil Perhitungan SAW</h4>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $this->session->flashdata('message') ?>

                    <form method="get" class="form-inline mb-3">
                        <div class="form-group mr-2">
                            <label class="mr-2">Bulan</label>
                            <select name="bulan" class="form-control">
                                <?php for ($m = 1; $m <= 12; $m++): $mm = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                                    <option value="<?= $mm ?>" <?= ($bulan == $mm ? 'selected' : '') ?>><?= $mm ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="form-group mr-2">
                            <label class="mr-2">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>">
                        </div>

                        <div class="form-group mr-2">
                            <label class="mr-2">Divisi</label>
                            <select name="divisi" class="form-control">
                                <option value="">Semua</option>
                                <?php foreach ($list_divisi as $d): ?>
                                    <option value="<?= $d->divisi ?>" <?= ($divisi == $d->divisi ? 'selected' : '') ?>><?= $d->divisi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button class="btn btn-primary">Filter</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Divisi</th>
                                    <th>Hari Kerja</th>
                                    <th>Skills</th>
                                    <th>Attitude</th>
                                    <th>Nilai Akhir (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($hasil)): $no = 1;
                                    foreach ($hasil as $r): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $r['nip'] ?></td>
                                            <td><?= $r['nama'] ?></td>
                                            <td><?= $r['divisi'] ?: '-' ?></td>
                                            <td class="text-center"><?= $r['hari_kerja'] ?></td>
                                            <td class="text-center"><?= $r['skills'] ?></td>
                                            <td class="text-center"><?= $r['attitude'] ?></td>
                                            <td class="text-center font-weight-bold"><?= $r['nilai_akhir'] ?></td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada hasil penilaian.</td>
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