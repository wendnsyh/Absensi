<?php
defined('BASEPATH') or exit('No direct script access allowed');

$periode_type = $periode_type ?? '';
$periode_key  = $periode_key ?? '';
$periode_list = $periode_list ?? [];
$divisi_list  = $divisi_list ?? [];
$ranking      = $ranking ?? [];
$divisi       = $divisi ?? '';

// helper compatibility array/object
function val($item, $key, $default = null)
{
    if (is_array($item) && array_key_exists($key, $item)) return $item[$key];
    if (is_object($item) && isset($item->{$key})) return $item->{$key};
    return $default;
}

// buat map divisi
$divisi_map = [];
foreach ($divisi_list as $d) {
    $id = val($d, 'id_divisi');
    $nama = val($d, 'nama_divisi');
    $divisi_map[$id] = $nama;
}
?>

<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Hasil Penilaian SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">

                    <!-- FORM FILTER -->
                    <form method="get" action="<?= base_url('saw') ?>" class="mb-4">

                        <div class="row">

                            <!-- Jenis Periode -->
                            <div class="col-md-4">
                                <label>Jenis Periode</label>
                                <select name="periode_type" id="periode_type" class="form-control" required onchange="this.form.submit()">
                                    <option value="">-- Pilih Tipe Periode --</option>
                                    <option value="monthly" <?= ($periode_type === 'monthly') ? 'selected' : '' ?>>Bulanan</option>
                                    <option value="quarter" <?= ($periode_type === 'quarter') ? 'selected' : '' ?>>Triwulan</option>
                                    <option value="semester" <?= ($periode_type === 'semester') ? 'selected' : '' ?>>Semester</option>
                                    <option value="yearly" <?= ($periode_type === 'yearly') ? 'selected' : '' ?>>Tahunan</option>
                                </select>
                            </div>

                            <!-- Periode -->
                            <div class="col-md-5">
                                <label>Pilih Periode</label>
                                <select name="periode_key" class="form-control" required>
                                    <option value="">-- Pilih Periode --</option>

                                    <?php if (!empty($periode_type) && isset($periode_list[$periode_type])): ?>
                                        <?php foreach ($periode_list[$periode_type] as $opt): ?>
                                            <option value="<?= $opt['key'] ?>"
                                                <?= ($periode_key === $opt['key']) ? 'selected' : '' ?>>
                                                <?= $opt['label'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Divisi -->
                            <div class="col-md-3">
                                <label>Divisi</label>
                                <select name="divisi" class="form-control">
                                    <option value="">Semua Divisi</option>

                                    <?php foreach ($divisi_list as $d): ?>
                                        <option value="<?= val($d, 'id_divisi') ?>"
                                            <?= ($divisi == val($d, 'id_divisi')) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars(val($d, 'nama_divisi')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <button class="btn btn-primary mt-3">Tampilkan</button>
                    </form>


                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th style="width:80px;">Rank</th>
                                    <th>Nama</th>
                                    <th style="width:150px">NIP</th>
                                    <th>Divisi</th>
                                    <th style="width:150px">Nilai Akhir</th>
                                    <th style="width:150px">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (empty($ranking)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada hasil.</td>
                                    </tr>
                                <?php else: $rank = 1; ?>

                                    <?php foreach ($ranking as $r): ?>
                                        <?php
                                        $raw = val($r, 'raw', []);
                                        $nama = val($raw, 'nama_pegawai', val($raw, 'nama', '-'));
                                        $nip  = val($raw, 'nip', '-');
                                        $id_div = val($raw, 'id_divisi');
                                        $div_name = $divisi_map[$id_div] ?? '-';
                                        ?>
                                        <tr>
                                            <td class="text-center"><b><?= $rank++ ?></b></td>
                                            <td><?= htmlspecialchars($nama) ?></td>
                                            <td><?= htmlspecialchars($nip) ?></td>
                                            <td><?= htmlspecialchars($div_name) ?></td>
                                            <td class="text-center">
                                                <b><?= number_format($r['score'] * 100, 2) ?></b>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('saw/detail_pegawai?id=' . $r['raw']['id_penilaian']) ?>"
                                                    class="btn btn-info btn-sm">
                                                    Detail SAW
                                                </a>
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