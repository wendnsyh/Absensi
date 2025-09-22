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
                <div class="col-md-12">

                    <?php if ($this->session->flashdata('success')): ?>
                        <?= $this->session->flashdata('success'); ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <?= $this->session->flashdata('error'); ?>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Profil</div>
                        </div>
                        <form action="<?= base_url('user/update'); ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">

                                    <!-- FOTO PROFIL -->
                                    <div class="col-md-4">
                                        <div class="text-center mb-3">
                                            <div class="avatar avatar-xxl">
                                                <img src="<?= base_url('assets/img/profile/' . $user['image']); ?>"
                                                    alt="Foto Profil"
                                                    class="avatar-img rounded-circle"
                                                    style="width:150px;height:150px;object-fit:cover;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                        </div>
                                    </div>

                                    <!-- DATA PROFIL -->
                                    <div class="col-md-8">
                                        <div class="row">

                                            <!-- NAMA -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Nama Lengkap</label>
                                                    <input type="text"
                                                        class="form-control <?= ($user['role_id'] == 1) ? 'bg-dark text-white font-weight-bold' : '' ?>"
                                                        name="name"
                                                        value="<?= $user['name']; ?>"
                                                        <?= ($user['role_id'] == 1) ? 'readonly' : '' ?>>
                                                </div>
                                            </div>

                                            <!-- EMAIL -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email"
                                                        class="form-control <?= ($user['role_id'] == 1) ? 'bg-dark text-white font-weight-bold' : '' ?>"
                                                        name="email"
                                                        value="<?= $user['email']; ?>"
                                                        <?= ($user['role_id'] == 1) ? 'readonly' : '' ?>>
                                                </div>
                                            </div>

                                            <!-- PASSWORD BARU -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_baru">Password Baru</label>
                                                    <input type="password" class="form-control" name="password_baru">
                                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                                </div>
                                            </div>

                                            <!-- KONFIRMASI PASSWORD -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                                                    <input type="password" class="form-control" name="konfirmasi_password">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- BUTTON -->
                            <div class="card-action text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>