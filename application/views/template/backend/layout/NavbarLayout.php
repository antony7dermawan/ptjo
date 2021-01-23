<div class="">
<nav class="navbar header-navbar pcoded-header iscollapsed">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a href="javascript:void(0)">
                <img class="img-fluid" src="<?= base_url(); ?>assets/png/logo_acien.png" alt="Theme-Logo" />
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu icon-toggle-right"></i>
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <a href="#!" onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()" class="waves-effect waves-light" data-cf-modified-d8424a08d31b5b8b406fded2-="">
                        <i class="full-screen feather icon-maximize"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="header-notification"></li>
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img class="img-radius" alt="User-Profile-Image" src="<?= base_url('assets/images/login.jpg'); ?>">

                            <span><?php echo $this->session->userdata('name') ?></span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <a href="#">
                                    <a href="<?php echo base_url('c_change_password') ?>">
                                    <i class="feather icon-user"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('index.php/auth/logout'); ?>">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>

                            </li>
                        </ul>
                    </div>
                </li>
        </div>
    </div>
</nav>
</div>