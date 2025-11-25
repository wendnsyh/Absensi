<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Input Penilaian SAW</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Penilaian SAW</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Filter Penilaian</h4>
                </div>

                <div class="card-body">

                    <form method="get" action="<?= base_url('saw/input_penilaian') ?>" class="row">

                        <!-- Divisi -->
                        <div class="form-group col-md-4">
                            <label>Divisi</label>
                            <select name="divisi" class="form-control">
                                <option value="">Semua Divisi</option>
                                <?php foreach ($divisi_list as $d): ?>
                                    <option value="<?= $d->id_divisi ?>"
                                        <?= ($divisi == $d->id_divisi) ? 'selected' : '' ?>>
                                        <?= $d->nama_divisi ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <!-- Periode Type -->
                        <div class="form-group col-md-3">
                            <label>Jenis Periode</label>
                            <select name="periode_type" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="monthly"     <?= $periode_type == 'monthly'     ? 'selected' : '' ?>>Bulanan</option>
                                <option value="quarterly"   <?= $periode_type == 'quarterly'   ? 'selected' : '' ?>>3 Bulanan</option>
                                <option value="semester"    <?= $periode_type == 'semester'    ? 'selected' : '' ?>>6 Bulanan</option>
                                <option value="yearly"      <?= $periode_type == 'yearly'      ? 'selected' : '' ?>>Tahunan</option>
                            </select>
                        </div>

                        <!-- Periode Key -->
                        <div class="form-group col-md-3">
                            <label>Periode</label>
                            <input type="month" name="periode_key" class="form-control" value="<?= $periode_key ?>">
                        </div>

                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary btn-block">Filter</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">

                    <?php if (empty($pegawai_list)): ?>
                        <div class="alert alert-warning text-center">
                            Tidak ada pegawai untuk periode ini.
                        </div>
                    <?php else: ?>

                        <form method="post" action="<?= base_url('saw/simpan_penilaian') ?>">

                            <input type="hidden" name="periode_type" value="<?= $periode_type ?>">
                            <input type="hidden" name="periode_key" value="<?= $periode_key ?>">

                            <table class="table table-bordered table-dark">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>NIP</th>
                                        <th>Divisi</th>
                                        <th>Kehadiran</th>
                                        <th>Skill</th>
                                        <th>Attitude</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php $no = 1; foreach ($pegawai_list as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $p->nama_pegawai ?></td>
                                        <td><?= $p->nip ?></td>
                                        <td><?= $p->nama_divisi ?></td>
                                        <td><?= $p->hari_kerja ?> hari</td>

                                        <input type="hidden" name="id_pegawai[]" value="<?= $p->id_pegawai ?>">
                                        <input type="hidden" name="kehadiran[]" value="<?= $p->hari_kerja ?>">

                                        <td><input type="number" name="skill[]" class="form-control" min="0" max="100" required></td>
                                        <td><input type="number" name="attitude[]" class="form-control" min="0" max="100" required></td>
                                    </tr>
                                <?php endforeach ?>

                                </tbody>
                            </table>

                            <button class="btn btn-success btn-block">Simpan Semua Penilaian</button>
                        </form>

                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>
</div>
