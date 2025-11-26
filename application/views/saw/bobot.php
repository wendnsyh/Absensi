<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Atur Bobot SAW</h4>
            </div>

            <div class="card">
                <div class="card-body">

                    <?= $this->session->flashdata('message') ?>

                    <form method="post" action="<?= base_url('saw/update_bobot') ?>">

                        <div class="form-group">
                            <label>Bobot Skill</label>
                            <input type="number" step="0.01" name="skill" class="form-control"
                                value="<?= $bobot['skill'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Bobot Attitude</label>
                            <input type="number" step="0.01" name="attitude" class="form-control"
                                value="<?= $bobot['attitude'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Bobot Kehadiran</label>
                            <input type="number" step="0.01" name="kehadiran" class="form-control"
                                value="<?= $bobot['kehadiran'] ?>" required>
                        </div>

                        <button class="btn btn-success">Update Bobot</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>