<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Bobot Kriteria</h4>
            </div>

            <?= $this->session->flashdata('message') ?? '' ?>

            <div class="card">
                <div class="card-body">
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Hari Kerja (%)</label>
                                <input type="number" name="hari_kerja" class="form-control" min="0" max="100" value="<?= $bobot['hari_kerja'] ?? 0 ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Skills (%)</label>
                                <input type="number" name="skills" class="form-control" min="0" max="100" value="<?= $bobot['skills'] ?? 0 ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Attitude (%)</label>
                                <input type="number" name="attitude" class="form-control" min="0" max="100" value="<?= $bobot['attitude'] ?? 0 ?>">
                            </div>
                        </div>
                        <button class="btn btn-success">Update Bobot</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>