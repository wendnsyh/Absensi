<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Hasil Perhitungan SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">

                    <form method="get" action="<?= base_url('saw') ?>" class="form-inline mb-3">

                        <select name="periode_type" class="form-control mr-2" required>
                            <option value="">-- Tipe Periode --</option>
                            <option value="monthly" <?= ($periode_type == 'monthly')  ? 'selected' : '' ?>>Bulanan</option>
                            <option value="quarter" <?= ($periode_type == 'quarter')  ? 'selected' : '' ?>>Triwulan</option>
                            <option value="semester" <?= ($periode_type == 'semester') ? 'selected' : '' ?>>Semester</option>
                            <option value="yearly" <?= ($periode_type == 'yearly')   ? 'selected' : '' ?>>Tahunan</option>
                        </select>

                        <select name="periode_key" class="form-control mr-2" required>
                            <option value="">-- Pilih Periode --</option>

                            <?php if (!empty($periode_list[$periode_type])): ?>
                                <?php foreach ($periode_list[$periode_type] as $opt): ?>
                                    <option value="<?= $opt['key'] ?>" <?= ($periode_key == $opt['key']) ? 'selected' : '' ?>>
                                        <?= $opt['label'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <select name="divisi" class="form-control mr-2">
                            <option value="">Semua Divisi</option>
                            <?php foreach ($divisi_list as $d): ?>
                                <option value="<?= $d->id_divisi ?>" <?= ($d->id_divisi == $divisi) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($d->nama_divisi) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button class="btn btn-primary">Tampilkan</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Divisi</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (empty($ranking)): ?>
                                    <tr>
                                        <td class="text-center" colspan="5">
                                            <em>Belum ada hasil</em>
                                        </td>
                                    </tr>

                                <?php else: $rank = 1; ?>
                                    <?php foreach ($ranking as $r): ?>
                                        <tr>
                                            <td class="text-center"><?= $rank++ ?></td>
                                            <td><?= htmlspecialchars($r['nama']) ?></td>
                                            <td><?= htmlspecialchars($r['raw']['nip']) ?></td>

                                            <td>
                                                <?= htmlspecialchars($r['raw']['nama_divisi'] ?? '-') ?>
                                            </td>

                                            <td class="text-center">
                                                <?= number_format($r['score'], 4) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>