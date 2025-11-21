<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Pengaturan Bobot SAW</h4>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $this->session->flashdata('message') ?>
                    <form action="<?= base_url('saw/update_bobot') ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Hari Kerja (%)</label>
                                    <input type="number" name="hari_kerja" class="form-control" required value="<?= $bobot['hari_kerja'] ?? 0 ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Skills (%)</label>
                                    <input type="number" name="skills" class="form-control" required value="<?= $bobot['skills'] ?? 0 ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Attitude (%)</label>
                                    <input type="number" name="attitude" class="form-control" required value="<?= $bobot['attitude'] ?? 0 ?>">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-2">Total bobot harus <strong>100%</strong>.</div>
                        <button class="btn btn-primary mt-2">Simpan Bobot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>