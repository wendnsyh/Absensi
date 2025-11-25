<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title"><?= $title ?></h4>
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="<?= base_url('dashboard') ?>"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">SAW</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Hasil Penilaian</li>
                </ul>
            </div>

            <!-- FILTER -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">Filter Penilaian</h5>
                </div>
                <div class="card-body">

                    <form method="GET" action="<?= base_url('saw') ?>">
                        <div class="row">

                            <!-- Periode -->
                            <div class="col-md-3">
                                <label>Jenis Periode</label>
                                <select name="periode_type" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="monthly" <?= $periode_type == 'monthly' ? 'selected' : '' ?>>Bulanan</option>
                                    <option value="quarter" <?= $periode_type == 'quarter' ? 'selected' : '' ?>>3 Bulan</option>
                                    <option value="semester" <?= $periode_type == 'semester' ? 'selected' : '' ?>>6 Bulan</option>
                                    <option value="yearly" <?= $periode_type == 'yearly' ? 'selected' : '' ?>>Tahunan</option>
                                </select>
                            </div>

                            <!-- Key -->
                            <div class="col-md-3">
                                <label>Periode</label>
                                <input type="text" name="periode_key" class="form-control" placeholder="2025-01 / 2025-Q1 / 2025-H1 / 2025"
                                    value="<?= $periode_key ?>" required>
                            </div>

                            <!-- Divisi -->
                            <div class="col-md-3">
                                <label>Divisi</label>
                                <select name="divisi" class="form-control">
                                    <option value="">Semua Divisi</option>
                                    <?php foreach ($divisi_list as $d): ?>
                                        <option value="<?= $d['id_divisi'] ?>" <?= $divisi == $d['id_divisi'] ? 'selected' : '' ?>>
                                            <?= $d['nama_divisi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary btn-block">Terapkan Filter</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            <!-- TABEL PENILAIAN -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Penilaian</h4>
                </div>
                <div class="card-body table-responsive">

                    <?php if (!$penilaian): ?>
                        <p class="text-center text-muted">Belum ada data untuk periode ini.</p>
                    <?php else: ?>

                        <table class="table table-bordered table-hover">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Skill</th>
                                    <th>Attitude</th>
                                    <th>Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($penilaian as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $p['nama_pegawai'] ?></td>
                                        <td><?= $p['skill'] ?></td>
                                        <td><?= $p['attitude'] ?></td>
                                        <td><?= $p['kehadiran'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php endif; ?>
                </div>
            </div>

            <!-- RANKING -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title">Ranking SAW</h4>
                </div>
                <div class="card-body table-responsive">

                    <?php if (!$ranking): ?>
                        <p class="text-center text-muted">Belum ada ranking.</p>
                    <?php else: ?>

                        <table class="table table-bordered table-striped">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama Pegawai</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $r = 1;
                                foreach ($ranking as $rk): ?>
                                    <tr>
                                        <td><strong>#<?= $r++ ?></strong></td>
                                        <td><?= $rk['nama_pegawai'] ?></td>
                                        <td><?= number_format($rk['nilai_akhir'], 4) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>