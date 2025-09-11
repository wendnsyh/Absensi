<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Profil Administrator</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('administrator') ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Profil</a>
                    </li>
                </ul>

            </div>

            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Detail Profil</div>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('administrator/profile/update'); ?>" method="post">
                                <div class="form-group">
                                    <label for="nama_admin">Nama:</label>
                                    <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= $user['name'] ?>">
                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $user['email'] ?>">
                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-success btn-round mt-3">Ubah Profil</button>
                                    <a href="<?php echo base_url('administrator/profile/ubah-password'); ?>" class="btn btn-primary btn-round">
                                        <i class="fas fa-unlock-alt mr-2"></i> Ubah Password
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>