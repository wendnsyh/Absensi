<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="dark2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <!--Query Menu--->
                <?php
                $role_id = $this->session->userdata('role_id');

                // Perhatikan penulisan tabel dan kolom tanpa tanda kutip tunggal, gunakan backtick (`) jika diperlukan
                $queryMenu = "SELECT user_menu.id, user_menu.menu
              FROM user_menu 
              JOIN user_access_menu ON user_menu.id = user_access_menu.menu_id
              WHERE user_access_menu.role_id = $role_id
              ORDER BY user_access_menu.menu_id ASC";

                $menu = $this->db->query($queryMenu)->result_array();
                ?>


                <!--Looping menu-->
                <?php foreach ($menu as $m) : ?>

                    <!-- Bagian Judul Menu -->
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h class="text-section"><?= $m['menu']; ?></h>
                    </li>
                    <!-- SUb Menu-->
                    <?php
                    $menuId = $m['id'];
                    $querySubMenu = "SELECT *
                                    FROM user_sub_menu JOIN user_menu
                                    ON   user_sub_menu.menu_id= user_menu.id
                                    WHERE user_sub_menu.menu_id = $menuId
                                    AND    user_sub_menu.is_active = 1";

                    $subMenu = $this->db->query($querySubMenu)->result_array();
                    ?>
                    <?php foreach ($subMenu as $sm) : ?>
                        <li class="nav-item <?= ($title == $sm['title']) ? 'active' : '' ?>">
                            <a href="<?= base_url($sm['url']) ?>" aria-expanded="false">
                                <i class="<?= $sm['icon']; ?>"></i>
                                <p><?= $sm['title']; ?></p>
                                <hr>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <hr>
               
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->