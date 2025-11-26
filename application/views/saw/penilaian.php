<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Input Penilaian SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">

                    <?= $this->session->flashdata('message') ?>

                    <form method="get" action="<?= base_url('saw/input_penilaian') ?>" class="mb-3">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Jenis Periode</label>
                                <select name="periode_type" id="periode_type" class="form-control" required onchange="this.form.submit()">
                                    <option value="">-- Pilih Tipe Periode --</option>
                                    <option value="monthly" <?= ($periode_type == 'monthly')  ? 'selected' : '' ?>>Bulanan</option>
                                    <option value="quarter" <?= ($periode_type == 'quarter')  ? 'selected' : '' ?>>Triwulan</option>
                                    <option value="semester" <?= ($periode_type == 'semester') ? 'selected' : '' ?>>Semester</option>
                                    <option value="yearly" <?= ($periode_type == 'yearly')   ? 'selected' : '' ?>>Tahunan</option>
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label>Pilih Periode</label>
                                <select name="periode_key" class="form-control" required>
                                    <option value="">-- Pilih Periode --</option>

                                    <?php
                                    if (
                                        !empty($periode_type)
                                        && isset($periode_list[$periode_type])
                                        && is_array($periode_list[$periode_type])
                                    ):
                                    ?>

                                        <?php foreach ($periode_list[$periode_type] as $opt): ?>
                                            <option value="<?= $opt['key'] ?>"
                                                <?= (!empty($periode_key) && $periode_key == $opt['key']) ? 'selected' : '' ?>>
                                                <?= $opt['label'] ?>
                                            </option>
                                        <?php endforeach; ?>

                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Divisi</label>
                                <select name="divisi" class="form-control">
                                    <option value="">Semua Divisi</option>

                                    <?php foreach ($divisi_list as $d): ?>
                                        <option value="<?= $d['id_divisi'] ?>" <?= ($divisi == $d['id_divisi']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($d['nama_divisi']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                        </div>

                        <button class="btn btn-primary mt-3">Tampilkan Pegawai</button>
                    </form>


                    <!-- ============================
                        TABEL INPUT NILAI SAW
                    ============================== -->
                    <form method="post" action="<?= base_url('saw/simpan_penilaian') ?>">

                        <input type="hidden" name="periode_type" value="<?= $periode_type ?>">
                        <input type="hidden" name="periode_key" value="<?= $periode_key ?>">

                        <!-- TABLE -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Divisi</th>
                                        <th>Hari Kerja</th>
                                        <th>Skills</th>
                                        <th>Attitude</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($pegawai_list)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data pegawai</td>
                                        </tr>

                                    <?php else: $no = 1; ?>
                                        <?php foreach ($pegawai_list as $p): ?>

                                            <?php
                                            $pref = null;
                                            foreach ($existing_penilaian as $ep) {
                                                if ($ep['nip'] == $p['nip']) {
                                                    $pref = $ep;
                                                    break;
                                                }
                                            }
                                            ?>

                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($p['nama']) ?></td>
                                                <td><?= htmlspecialchars($p['nip']) ?></td>

                                                <td>
                                                    <?= isset($p['id_divisi']) && isset($p['nama_divisi'])
                                                        ? htmlspecialchars($p['nama_divisi'])
                                                        : '-' ?>
                                                </td>

                                                <td class="text-center">
                                                    <input type="number" min="0" name="hari_kerja[]" class="form-control"
                                                        value="<?= $pref['hari_kerja'] ?? $p['hari_kerja'] ?>">
                                                </td>

                                                <td>
                                                    <input type="hidden" name="id_pegawai[]" value="<?= $p['id_pegawai'] ?>">
                                                    <input type="hidden" name="nip[]" value="<?= $p['nip'] ?>">

                                                    <input type="number" min="0" max="100" name="skills[]"
                                                        class="form-control text-center"
                                                        value="<?= $pref['skills'] ?? 0 ?>">
                                                </td>

                                                <td>
                                                    <input type="number" min="0" max="100" name="attitude[]"
                                                        class="form-control text-center"
                                                        value="<?= $pref['attitude'] ?? 0 ?>">
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <button class="btn btn-success mt-2">Simpan Semua</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>