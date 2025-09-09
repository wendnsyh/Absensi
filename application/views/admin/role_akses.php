<div class="main-panel" data-background-color="white">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"><?= $title; ?></h4>

            </div>
            <!-- Konten Utama -->
            <div class="row">
                <div class="col-lg-6">
                    <?= $this->session->flashdata('message'); ?>

                    <h5>Role : <?= $role['role']; ?></h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($menu as $m) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $m['menu']; ?></td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="menu<?= $m['id']; ?>"
                                                <?= check_access($role['id'], $m['id']); ?>
                                                data-role="<?= $role['id']; ?>"
                                                data-menu="<?= $m['id']; ?>">
                                            <label class="custom-control-label" for="menu<?= $m['id']; ?>"></label>
                                        </div>


                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Konten -->
        </div>
    </div>
</div>