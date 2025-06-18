<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Panitia Qurban</h1>
    <p class="mb-4">Selamat datang! Silakan pilih menu manajemen di bawah ini untuk memulai.</p>

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Manajemen Peserta</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Data Peserta Qurban</div>
                            <p class="card-text mt-2 small">Lihat, tambah, dan kelola semua peserta qurban.</p>
                            <a href="<?= base_url('qurban'); ?>" class="btn btn-primary btn-sm mt-2">
                                <span class="text">Buka Menu</span> <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Manajemen Keuangan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Data Barang & Keuangan</div>
                             <p class="card-text mt-2 small">Catat semua pengeluaran untuk kebutuhan qurban.</p>
                            <a href="<?= base_url('financial'); ?>" class="btn btn-warning btn-sm mt-2">
                                <span class="text">Buka Menu</span> <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Manajemen Distribusi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Pembagian Daging</div>
                             <p class="card-text mt-2 small">Alokasikan dan kelola pembagian daging qurban.</p>
                            <a href="<?= base_url('distribution'); ?>" class="btn btn-success btn-sm mt-2">
                                <span class="text">Buka Menu</span> <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>