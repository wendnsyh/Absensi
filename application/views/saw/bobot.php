<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Atur Bobot SAW (%)</h4>
            </div>

            <div class="card">
                <div class="card-body">

                    <?= $this->session->flashdata('message') ?>

                    <form method="post" action="<?= base_url('saw/update_bobot') ?>">

                        <div class="form-group">
                            <label>Bobot Skill (%)</label>
                            <input type="number" step="1" min="0" max="100"
                                name="skill" class="form-control"
                                value="<?= $bobot['skills'] * 100 ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Bobot Attitude (%)</label>
                            <input type="number" step="1" min="0" max="100"
                                name="attitude" class="form-control"
                                value="<?= $bobot['attitude'] * 100 ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Bobot Kehadiran (%)</label>
                            <input type="number" step="1" min="0" max="100"
                                name="kehadiran" class="form-control"
                                value="<?= $bobot['hari_kerja'] * 100 ?>" required>
                        </div>

                        <button class="btn btn-success">
                            <i class="fas fa-save"></i> Update Bobot
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>