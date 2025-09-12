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
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Detail Profil</div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td><?= $user['name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $user['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?= $user['role_id']; ?></td>
                                </tr>
                                <tr>
                                    <th>Date Created</th>
                                    <td><?= date('d M Y', $user['date_created']); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profil
                            </a>
                            <a href="<?= base_url('auth/ubahpassword'); ?>" class="btn btn-primary">
                                <i class="fas fa-unlock-alt mr-2"></i> Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>