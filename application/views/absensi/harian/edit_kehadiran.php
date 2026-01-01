<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Edit Kehadiran</h4>
            </div>

            <form method="post"
                action="<?= base_url('Fingerprint/simpan_kehadiran') ?>"
                enctype="multipart/form-data">
                <input type="hidden" name="nip" value="<?= $pegawai->nip ?>">
                <input type="hidden" name="bulan" value="<?= $bulan ?>">
                <input type="hidden" name="tahun" value="<?= $tahun ?>">

                <div class="card">
                    <div class="card-header">
                        <strong><?= $pegawai->nama_pegawai ?></strong><br>
                        Periode: <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:120px">Tanggal</th>
                                        <th style="width:110px">Hari</th>
                                        <th style="width:90px">Jam In</th>
                                        <th style="width:90px">Jam Out</th>
                                        <th>Status Kehadiran</th>
                                        <th style="width:220px">Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $i => $r): ?>
                                        <?php
                                        $hasFinger = ($r['jam_in'] || $r['jam_out']);
                                        $ket = $r['keterangan'] ?? '';
                                        ?>
                                        <tr>
                                            <td>
                                                <?= date('d M Y', strtotime($r['tanggal'])) ?>
                                                <input type="hidden" name="tanggal[]" value="<?= $r['tanggal'] ?>">
                                            </td>
                                            <td><?= $r['hari'] ?></td>
                                            <td><?= $r['jam_in'] ?: '-' ?></td>
                                            <td><?= $r['jam_out'] ?: '-' ?></td>

                                            <!-- STATUS -->
                                            <td>
                                                <?php if ($hasFinger): ?>

                                                    <!-- 🔒 NILAI TETAP TERKIRIM -->
                                                    <input type="hidden" name="keterangan[]" value="<?= $ket ?>">

                                                    <!-- 🔒 SELECT HANYA TAMPILAN -->
                                                    <select class="form-control" disabled>
                                                        <option><?= $ket ?: 'Hadir' ?></option>
                                                    </select>

                                                    <small class="text-muted">Sudah ada data fingerprint</small>

                                                <?php else: ?>

                                                    <select name="keterangan[]"
                                                        class="form-control"
                                                        data-index="<?= $i ?>"
                                                        onchange="toggleBukti(this)">

                                                        <option value="">-- Pilih --</option>
                                                        <?php foreach (['Sakit', 'Izin', 'Cuti', 'Alpa', 'Dinas Luar', 'WFH', 'Libur'] as $o): ?>
                                                            <option value="<?= $o ?>" <?= ($ket == $o) ? 'selected' : '' ?>>
                                                                <?= $o ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                <?php endif; ?>
                                            </td>

                                            <!-- BUKTI -->
                                            <td>
                                                <?php if (!$hasFinger): ?>
                                                    <input type="file"
                                                        name="bukti[<?= $i ?>]"
                                                        id="bukti_<?= $i ?>"
                                                        class="form-control"
                                                        accept="image/*,.pdf"
                                                        <?= ($ket === 'Libur') ? 'disabled' : '' ?>>

                                                    <?php if (!empty($r['bukti'])): ?>
                                                        <small class="text-success">File sebelumnya ada</small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="<?= base_url("absensi/detail_harian/{$pegawai->nip}/$bulan/$tahun") ?>"
                            class="btn btn-secondary">
                            Kembali
                        </a>
                        <button class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function toggleBukti(select) {
        const idx = select.dataset.index;
        const file = document.getElementById('bukti_' + idx);
        if (!file) return;

        if (select.value === 'Libur') {
            file.value = '';
            file.disabled = true;
        } else {
            file.disabled = false;
        }
    }
</script>