<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title; ?></h4>

            </div>

            <?= $this->session->flashdata('message'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title"><?= $title; ?></h4>
                    <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#addUserModal">
                        <i class="fa fa-plus"></i> Tambah Admin
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($users as $u): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $u['name']; ?></td>
                                        <td><?= $u['email']; ?></td>
                                        <td><?= $u['role_id'] == 1 ? 'Super Admin' : 'Admin'; ?></td>
                                        <td>
                                            <?php if ($u['is_active'] == 1): ?>
                                                <span class="badge badge-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($u['role_id'] != 1): ?>
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/deleteUser/' . $u['id']); ?>"
                                                    onclick="return confirm('Yakin ingin menghapus?');"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Fixed</span>
                                            <?php endif; ?>
                                            </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('admin/addUser'); ?>" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Admin Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" required>
                                <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required>
                                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>