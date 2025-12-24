<div class="main-panel">
    <div class="content">
        <div class="page-inner">


            <div class="page-inner">
                <h4 class="page-title">Detail Perhitungan SAW</h4>
                <a href="<?= base_url('saw') ?>" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali ke Hasil
                </a>

                <!-- INFO PEGAWAI -->
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">Nama</th>
                                <td><?= $p['nama_pegawai'] ?></td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td><?= $p['nip'] ?></td>
                            </tr>
                            <tr>
                                <th>Divisi</th>
                                <td><?= $p['nama_divisi'] ?></td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td><?= $p['periode_key'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- NILAI AWAL -->
                <div class="card mt-3">
                    <div class="card-header"><b>Nilai Awal</b></div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Hari Kerja</th>
                                <td><?= $p['hari_kerja'] ?></td>
                            </tr>
                            <tr>
                                <th>Skill</th>
                                <td><?= $p['skills'] ?></td>
                            </tr>
                            <tr>
                                <th>Attitude</th>
                                <td><?= $p['attitude'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- NORMALISASI -->
                <div class="card mt-3">
                    <div class="card-header"><b>Normalisasi</b></div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Hari Kerja</th>
                                <td><?= number_format($p['n_hari'], 4) ?></td>
                            </tr>
                            <tr>
                                <th>Skill</th>
                                <td><?= number_format($p['n_skill'], 4) ?></td>
                            </tr>
                            <tr>
                                <th>Attitude</th>
                                <td><?= number_format($p['n_att'], 4) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- PERHITUNGAN AKHIR -->
                <div class="card mt-3">
                    <div class="card-header"><b>Nilai Akhir</b></div>
                    <div class="card-body">
                        <p>
                            (<?= number_format($p['n_hari'], 4) ?> × <?= $bobot['hari_kerja'] ?>) +
                            (<?= number_format($p['n_skill'], 4) ?> × <?= $bobot['skills'] ?>) +
                            (<?= number_format($p['n_att'], 4) ?> × <?= $bobot['attitude'] ?>)
                        </p>
                        <h3 class="text-success">
                            <?= number_format($p['nilai_akhir'], 4) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>