<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h4 class="page-title"><?=$title ?></h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#"><?=$title ?></a>
                    </li>
                </ul>
            </div>

            <!-- FILTER CARD -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form method="get">
                        <div class="row">

                            <!-- JENIS PERIODE -->
                            <div class="col-md-4">
                                <label>Jenis Periode</label>
                                <select name="periode_type" id="periode_type"
                                    class="form-control"
                                    onchange="this.form.submit()" required>
                                    <option value="">-- Pilih Tipe Periode --</option>
                                    <option value="monthly" <?= ($periode_type == 'monthly') ? 'selected' : '' ?>>Bulanan</option>
                                    <option value="quarter" <?= ($periode_type == 'quarter') ? 'selected' : '' ?>>Triwulan</option>
                                    <option value="semester" <?= ($periode_type == 'semester') ? 'selected' : '' ?>>Semester</option>
                                    <option value="yearly" <?= ($periode_type == 'yearly') ? 'selected' : '' ?>>Tahunan</option>
                                </select>
                            </div>

                            <!-- PERIODE -->
                            <div class="col-md-4">
                                <label>Pilih Periode</label>
                                <select name="periode_key" class="form-control" required>
                                    <option value="">-- Pilih Periode --</option>
                                    <?php
                                    if (
                                        !empty($periode_type)
                                        && isset($periode_list[$periode_type])
                                    ):
                                        foreach ($periode_list[$periode_type] as $p):
                                    ?>
                                            <option value="<?= $p['key'] ?>"
                                                <?= ($periode_key == $p['key']) ? 'selected' : '' ?>>
                                                <?= $p['label'] ?>
                                            </option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>

                            <!-- DIVISI -->
                            <div class="col-md-4">
                                <label>Divisi</label>
                                <select name="divisi_id" class="form-control">
                                    <option value="">Semua Divisi</option>
                                    <?php foreach ($divisi as $d): ?>
                                        <option value="<?= $d->id ?>"
                                            <?= ($divisi_id == $d->id) ? 'selected' : '' ?>>
                                            <?= $d->nama_divisi ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>

                            <?php if (!empty($laporan)): ?>
                                <a target="_blank"
                                    href="<?= base_url('laporanabsensi/export_pdf?periode_type=' . $periode_type . '&periode_key=' . $periode_key . '&divisi_id=' . $divisi_id) ?>"
                                    class="btn btn-danger ml-2">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Tanggal</th>
                                <th>Jam In</th>
                                <th>Jam Out</th>
                                <th>Status Pulang</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Silakan pilih periode untuk menampilkan laporan
                                    </td>
                                </tr>
                                <?php else: $no = 1;
                                foreach ($laporan as $r): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $r['nama_pegawai'] ?></td>
                                        <td><?= $r['nip'] ?></td>
                                        <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
                                        <td><?= $r['jam_in'] ?: '-' ?></td>
                                        <td><?= $r['jam_out'] ?: '-' ?></td>
                                        <td><?= $r['status_pulang'] ?: '-' ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($r['bukti'])): ?>
                                                <img src="<?= base_url($r['bukti']) ?>"
                                                    style="max-width:60px;border-radius:5px;cursor:pointer"
                                                    onclick="window.open('<?= base_url($r['bukti']) ?>','_blank')">
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
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