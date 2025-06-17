<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-QURBAN</div>
    </a>

    <?php if(in_groups('admin')) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Admin Menu
        </div>
        <li class="nav-item <?= (current_url() == base_url('admin')) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fas fa-users"></i>
                <span>Manajemen User</span></a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Manajemen Qurban
        </div>
        <li class="nav-item <?= (current_url() == base_url('financial')) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('financial'); ?>">
                <i class="fas fa-money-bill-wave"></i>
                <span>Rekapan Keuangan</span></a>
        </li>
        <li class="nav-item <?= (current_url() == base_url('qurban')) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('qurban'); ?>">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Pendataan Peserta Qurban</span></a>
        </li>
        <li class="nav-item <?= (current_url() == base_url('distribution')) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('distribution'); ?>">
                <i class="fas fa-truck-loading"></i>
                <span>Pembagian Daging</span></a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        User Profile
    </div>
    <li class="nav-item <?= (current_url() == base_url('user')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fas fa-user"></i>
            <span>My Profile</span></a>
    </li>
    <?php if (in_groups('berqurban') || in_groups('user')) : // Asumsi role 'user' dan 'berqurban' berhak melihat QR card ?>
    <li class="nav-item <?= (current_url() == base_url('user/myqrcard')) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/myqrcard'); ?>">
            <i class="fas fa-qrcode"></i>
            <span>Kartu Pengambilan Daging</span></a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user-edit"></i>
            <span>Edit Profile</span></a>
    </li>

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