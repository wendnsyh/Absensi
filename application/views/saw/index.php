<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Hasil Penilaian SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">
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
                                <?php $rank = 1;
                                foreach ($hasil as $h): ?>
                                    <tr>
                                        <td class="text-center"><b><?= $rank++; ?></b></td>
                                        <td><?= $h['nip']; ?></td>
                                        <td><?= $h['nama']; ?></td>
                                        <td class="text-center"><?= $h['hari_kerja']; ?></td>
                                        <td class="text-center"><?= $h['skills']; ?></td>
                                        <td class="text-center"><?= $h['attitude']; ?></td>
                                        <td class="text-center"><b><?= number_format($h['nilai_akhir'], 3); ?></b></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>