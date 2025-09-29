<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title; ?></h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('menu'); ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Menu</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#"><?= $title; ?></a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Form Edit Menu</div>
                        </div>
                        <div class="card-body">
                            <?= form_open('menu/edit_menu/' . $menu['id']); ?>
                            <div class="form-group">
                                <label for="menu">Nama Menu</label>
                                <input type="text" class="form-control" id="menu" name="menu"
                                    value="<?= set_value('menu', $menu['menu']); ?>">
                                <?= form_error('menu', '<small class="text-danger pl-2">', '</small>'); ?>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('menu'); ?>" class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>