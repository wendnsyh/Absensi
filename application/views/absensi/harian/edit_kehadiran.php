<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Edit Kehadiran</h4>
            </div>

            <form method="post" action="<?= base_url('Fingerprint/simpan_kehadiran') ?>">
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
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Jam In</th>
                                        <th>Jam Out</th>
                                        <th>Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($rows as $i => $r): ?>
                                        <tr>
                                            <td>
                                                <?= date('d M Y', strtotime($r['tanggal'])) ?>
                                                <input type="hidden" name="tanggal[]" value="<?= $r['tanggal'] ?>">
                                            </td>
                                            <td><?= $r['hari'] ?></td>
                                            <td><?= $r['jam_in'] ?: '-' ?></td>
                                            <td><?= $r['jam_out'] ?: '-' ?></td>
                                            <td>
                                                <?php $hasFinger = ($r['jam_in'] || $r['jam_out']); ?>

                                                <select name="keterangan[]" class="form-control"
                                                    <?= $hasFinger ? 'disabled' : '' ?>>

                                                    <option value="">-- Pilih --</option>

                                                    <?php foreach (
                                                        [
                                                            'Sakit',
                                                            'Izin',
                                                            'Cuti',
                                                            'Alpa',
                                                            'Dinas Luar',
                                                            'WFH',
                                                            'Libur'
                                                        ] as $o
                                                    ): ?>

                                                        <option value="<?= $o ?>"
                                                            <?= ($r['keterangan'] == $o) ? 'selected' : '' ?>>
                                                            <?= $o ?>
                                                        </option>

                                                    <?php endforeach; ?>
                                                </select>

                                                <?php if ($hasFinger): ?>
                                                    <small class="text-muted">Sudah ada Data fingerprint</small>
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