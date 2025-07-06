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
                        <li class="nav-item active">
                            <a href="<?= base_url($sm['url']) ?>" aria-expanded="false">
                                <i class="<?= $sm['icon']; ?>"></i>
                                <p><?= $sm['title']; ?></p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <hr>

                <!-- Master Data -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Base</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li><a href="components/avatars.html"><span class="sub-item">Avatars</span></a></li>
                            <li><a href="components/buttons.html"><span class="sub-item">Buttons</span></a></li>
                            <li><a href="components/gridsystem.html"><span class="sub-item">Grid System</span></a></li>
                            <li><a href="components/panels.html"><span class="sub-item">Panels</span></a></li>
                            <li><a href="components/notifications.html"><span class="sub-item">Notifications</span></a></li>
                            <li><a href="components/sweetalert.html"><span class="sub-item">Sweet Alert</span></a></li>
                            <li><a href="components/font-awesome-icons.html"><span class="sub-item">Font Awesome Icons</span></a></li>
                            <li><a href="components/simple-line-icons.html"><span class="sub-item">Simple Line Icons</span></a></li>
                            <li><a href="components/flaticons.html"><span class="sub-item">Flaticons</span></a></li>
                            <li><a href="components/typography.html"><span class="sub-item">Typography</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Sidebar Layouts -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-th-list"></i>
                        <p>Sidebar Layouts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li><a href="sidebar-style-1.html"><span class="sub-item">Sidebar Style 1</span></a></li>
                            <li><a href="overlay-sidebar.html"><span class="sub-item">Overlay Sidebar</span></a></li>
                            <li><a href="compact-sidebar.html"><span class="sub-item">Compact Sidebar</span></a></li>
                            <li><a href="static-sidebar.html"><span class="sub-item">Static Sidebar</span></a></li>
                            <li><a href="icon-menu.html"><span class="sub-item">Icon Menu</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Forms -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#forms">
                        <i class="fas fa-pen-square"></i>
                        <p>Forms</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="nav nav-collapse">
                            <li><a href="forms/forms.html"><span class="sub-item">Basic Form</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Tables -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Tables</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li><a href="tables/tables.html"><span class="sub-item">Basic Table</span></a></li>
                            <li><a href="tables/datatables.html"><span class="sub-item">Datatables</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Maps -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#maps">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Maps</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse">
                            <li><a href="maps/jqvmap.html"><span class="sub-item">JQVMap</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Charts -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#charts">
                        <i class="far fa-chart-bar"></i>
                        <p>Charts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse">
                            <li><a href="charts/charts.html"><span class="sub-item">Chart Js</span></a></li>
                            <li><a href="charts/sparkline.html"><span class="sub-item">Sparkline</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Widgets -->
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li>

                <!-- Menu Levels -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#submenu">
                        <i class="fas fa-bars"></i>
                        <p>Menu Levels</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li><a href="#"><span class="sub-item">Level 2</span></a></li>
                                        <li><a href="#"><span class="sub-item">Level 2</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Level 1</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li><a href="#"><span class="sub-item">Level 2</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="#"><span class="sub-item">Level 1</span></a></li>
                        </ul>
                    </div>
                </li>

                <!-- Buy Pro -->
                <li class="mx-4 mt-2">
                    <a href="http://themekita.com/atlantis-bootstrap-dashboard.html" class="btn btn-primary btn-block">
                        <span class="btn-label mr-2"><i class="fa fa-heart"></i></span>Buy Pro
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->