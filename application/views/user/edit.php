<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title; ?></h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('user') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url("user") ?>">Profil</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Profil</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-lg-8">

                    <?= form_open_multipart('user/edit'); ?>

                    <!-- Nama -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text"
                                class="form-control text-primary font-weight-bold <?= form_error('name') ? 'is-invalid' : '' ?>"
                                id="name"
                                name="name"
                                value="<?= set_value('name', $user['name']); ?>"
                                readonly>
                            <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text"
                                class="form-control text-primary font-weight-bold <?= form_error('email') ? 'is-invalid' : '' ?>"
                                id="email"
                                name="email"
                                value="<?= set_value('email', $user['email']); ?>" readonly>
                        </div>
                    </div>

                    <!-- Foto -->
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <div class="mb-2">
                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                    class="img-thumbnail" width="100">
                            </div>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>