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
                                    <th>username</th>
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
                                        <td><?= $u['username']; ?></td>
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
                                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUserModal<?= $u['id']; ?>"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/deleteUser/' . $u['id']); ?>"
                                                    onclick="return confirm('Yakin ingin menghapus?');"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                <?php else: ?>
                                                <span class="badge badge-secondary">Fixed</span>
                                            <?php endif; ?>
                                            </td>
                                    </tr>
                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="editUserModal<?= $u['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/editUser/' . $u['id']); ?>" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control" name="name" value="<?= $u['name']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>username</label>
                                                            <input type="username" class="form-control" name="username" value="<?= $u['username']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Role</label>
                                                            <select class="form-control" name="role_id">
                                                                <option value="1" <?= $u['role_id'] == 1 ? 'selected' : ''; ?>>Super Admin</option>
                                                                <option value="2" <?= $u['role_id'] == 2 ? 'selected' : ''; ?>>Admin</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="form-control" name="is_active">
                                                                <option value="1" <?= $u['is_active'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                                                                <option value="0" <?= $u['is_active'] == 0 ? 'selected' : ''; ?>>Nonaktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                                <label>username</label>
                                <input type="username" class="form-control" name="username" required>
                                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
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