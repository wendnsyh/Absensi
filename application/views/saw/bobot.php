<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Atur Bobot Kriteria SAW</h4>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('saw/update_bobot'); ?>" method="post">
                        <div class="form-group">
                            <label>Total Hari Kerja (%)</label>
                            <input type="number" name="hari_kerja" class="form-control" value="<?= $bobot['hari_kerja'] * 100; ?>" min="0" max="100" required>
                        </div>

                        <div class="form-group">
                            <label>Skills (%)</label>
                            <input type="number" name="skills" class="form-control" value="<?= $bobot['skills'] * 100; ?>" min="0" max="100" required>
                        </div>

                        <div class="form-group">
                            <label>Attitude (%)</label>
                            <input type="number" name="attitude" class="form-control" value="<?= $bobot['attitude'] * 100; ?>" min="0" max="100" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">Simpan Bobot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>