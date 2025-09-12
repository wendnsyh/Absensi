<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title; ?></h4>

            </div>

            <div class="row">
                <div class="col-lg-8">

                    <form action="<?= base_url('admin/editRole/' . $role['id']); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $role['id']; ?>">

                        <div class="form-group mb-3">
                            <label for="role">Nama Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="<?= $role['role']; ?>">
                            <?= form_error('role', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        <a href="<?= base_url('admin/role'); ?>" class="btn btn-danger btn-sm">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>