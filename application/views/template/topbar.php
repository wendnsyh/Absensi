<body data-background-color="dark">
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark2">
                <a class="sidebar-brand d-flex align-items-center justift-content-center">
                    <div class="sidebar-brand-icon">
                        <img src="<?= base_url('assets/img/logo/logo_tangsel.png'); ?>" alt="Logo Tangsel" style="width: 35px; height: 35px;">
                    </div>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark">

                <div class="d-flex align-items-center ml-auto mr-4" style="gap: 15px; white-space: nowrap;">
                    <!-- Waktu -->
                    <div class="text-gray-400">
                        <p id="currentDateTime" style="margin-bottom: 0; font-size: 14px;"></p>
                    </div>
                    <div style="width: 1px; height: 25px; background-color: #888;"></div>
                    <!-- Cuaca Tangsel  -->
                    <div class="text-light d-flex align-items-center" style="gap: 5px;">
                        <span>🌤</span>
                        <span><strong>Tangerang selatan</strong></span>
                        <span><strong><?= $temperature; ?>°C</strong></span>
                        <span>| 💨 <?= $wind_speed; ?> km/jam</span>
                    </div>
                </div> 
                <script>
                    function updateDateTime() {
                        var currentDate = new Date();
                        var formattedDateTime = currentDate.toLocaleString('en-US', {
                            weekday: 'long',
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        });
                        document.getElementById('currentDateTime').innerHTML = formattedDateTime;
                    }
                    updateDateTime();
                    setInterval(updateDateTime, 1000);
                </script>

                <!-- Profil dan menu lainnya -->
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                        alt="image profile" class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>"
                                                    alt="image profile" class="avatar-img rounded">
                                            </div>
                                            <div class="u-text">
                                                <h4><?= $user['name']; ?></h4>
                                                <p class="text-muted"><?= $user['email']; ?></p>
                                                <a href="<?= base_url('user') ?>" class="btn btn-xs btn-secondary btn-sm">
                                                    View Profile
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"
                                            onclick="return confirm('Yakin logout?')">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>