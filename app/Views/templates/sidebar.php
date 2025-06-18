<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-mosque"></i> </div>
        <div class="sidebar-brand-text mx-3">E-QURBAN</div>
    </a>

    <?php if(in_groups('admin')) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            ADMINISTRATOR
        </div>
        <li class="nav-item <?= (uri_string() == 'admin') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fas fa-users-cog"></i>
                <span>Manajemen User</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if(in_groups('admin') || in_groups('panitia')) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            MANAJEMEN QURBAN
        </div>
    <?php endif; ?>
    <?php if(in_groups('panitia')) : ?>

        <li class="nav-item <?= (uri_string() == 'panitia') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('panitia'); ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if(in_groups('admin')) : ?>

        <li class="nav-item <?= (uri_string() == 'qurban') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('qurban'); ?>">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Data Peserta Qurban</span></a>
        </li>
        <li class="nav-item <?= (uri_string() == 'financial') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('financial'); ?>">
                <i class="fas fa-cash-register"></i>
                <span>Keuangan & Barang</span></a>
        </li>
        <li class="nav-item <?= (uri_string() == 'distribution') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('distribution'); ?>">
                <i class="fas fa-truck-loading"></i>
                <span>Pembagian Daging</span></a>
        </li>
    <?php endif; ?>
    

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        USER PROFILE
    </div>
    <li class="nav-item <?= (uri_string() == 'user') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fas fa-user"></i>
            <span>My Profile</span></a>
    </li>
    <?php if(in_groups('user')) : ?>

    <li class="nav-item <?= (strpos(uri_string(), 'user/myqrcard') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/myqrcard'); ?>">
            <i class="fas fa-qrcode"></i>
            <span>Kartu Pengambilan Daging</span></a>
    </li>
    <?php endif; ?>
    

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>