<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Hasil Penilaian SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">
                    <?php if (empty($hasil)): ?>
                        <div class="alert alert-warning text-center">
                            <strong>Belum ada data penilaian karyawan.</strong>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Hari Kerja</th>
                                        <th>Skill</th>
                                        <th>Attitude</th>
                                        <th>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rank = 1; ?>
                                    <?php foreach ($hasil as $h): ?>
                                        <tr>
                                            <td class="text-center"><b><?= $rank++; ?></b></td>
                                            <td><?= htmlspecialchars($h['nip'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($h['nama'] ?? '-'); ?></td>
                                            <td class="text-center"><?= $h['hari_kerja'] ?? 0; ?></td>
                                            <td class="text-center"><?= $h['skills'] ?? 0; ?></td>
                                            <td class="text-center"><?= $h['attitude'] ?? 0; ?></td>
                                            <td class="text-center">
                                                <b><?= isset($h['nilai_akhir']) ? number_format($h['nilai_akhir'], 3) : '-'; ?></b>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>