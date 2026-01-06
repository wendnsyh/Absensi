<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h4 class="page-title">Laporan Absensi</h4>
            </div>

            <!-- FILTER -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="get" class="form-inline">

                        <label class="mr-2">Bulan:</label>
                        <select name="bulan"
                            class="form-control mr-3"
                            onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>>
                                    <?= date("F", mktime(0, 0, 0, $i, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <label class="mr-2">Tahun:</label>
                        <select name="tahun"
                            class="form-control mr-3"
                            onchange="this.form.submit()">
                            <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <label class="mr-2">Divisi:</label>
                        <select name="divisi_id"
                            class="form-control"
                            onchange="this.form.submit()">
                            <option value="">Semua Divisi</option>
                            <?php foreach ($divisi as $d): ?>
                                <option value="<?= $d->id_divisi ?>"
                                    <?= ($divisi_id == $d->id_divisi) ? 'selected' : '' ?>>
                                    <?= $d->nama_divisi ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </form>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Pegawai</th>
                                    <th width="150">NIP</th>
                                    <th class="text-center" width="150">
                                        Total Hari Kerja
                                    </th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (empty($laporan)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                    <?php else: $no = 1;
                                    foreach ($laporan as $l): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($l->nama_pegawai) ?></td>
                                            <td><?= $l->nip ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">
                                                    <?= $l->total_hari_kerja ?> Hari
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url(
                                                                'LaporanAbsensi/detail/' . $l->nip
                                                                    . '?bulan=' . $bulan
                                                                    . '&tahun=' . $tahun
                                                            ) ?>" class="btn btn-info btn-sm">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>