<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <!-- HEADER -->
            <div class="page-header">
                <h4 class="page-title">Detail Laporan Absensi</h4>
            </div>

            <!-- INFO PEGAWAI -->
            <div class="card mb-3">
                <div class="card-body">
                    <strong><?= htmlspecialchars($pegawai->nama_pegawai) ?></strong><br>
                    NIP: <?= $pegawai->nip ?><br>
                    Periode: <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
                </div>
            </div>

            <!-- EXPORT -->
            <a class="btn btn-danger btn-sm mb-3"
                href="<?= base_url(
                            "laporanabsensi/export_pdf_detail/{$pegawai->nip}"
                                . "?bulan={$bulan}&tahun={$tahun}"
                        ) ?>">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>

            <!-- TABLE -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Jam In</th>
                                    <th>Jam Out</th>
                                    <th>Kategori</th>
                                    <th>Status Pulang</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($detail)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($detail as $d): ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
                                            <td><?= $d['hari'] ?></td>
                                            <td><?= $d['jam_in'] ?: '-' ?></td>
                                            <td><?= $d['jam_out'] ?: '-' ?></td>
                                            <td><?= $d['kategori'] ?></td>
                                            <td><?= $d['status_pulang'] ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($d['bukti'])): ?>
                                                    <img src="<?= base_url($d['bukti']) ?>"
                                                        style="max-width:70px;border-radius:6px;cursor:pointer"
                                                        onclick="window.open('<?= base_url($d['bukti']) ?>','_blank')">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <a href="<?= base_url("laporanabsensi?bulan=$bulan&tahun=$tahun") ?>"
                class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

        </div>
    </div>
</div>