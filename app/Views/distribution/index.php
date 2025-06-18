<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Pembagian Daging</h1>
    <p class="mb-4">Silakan pilih jenis hewan yang akan dikelola distribusinya.</p>

    <div class="row">
        <!-- Tombol Kelola Daging Kambing -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Distribusi Kambing</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Daging Kambing</div>
                            <p class="card-text mt-2">Masuk ke halaman untuk menginput total berat dan mengalokasikan semua daging kambing.</p>
                            <a href="<?= base_url('distribution/kambing'); ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
                                <span class="text">Mulai Kelola</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hat-cowboy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kelola Daging Sapi -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Distribusi Sapi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Daging Sapi</div>
                             <p class="card-text mt-2">Masuk ke halaman untuk menginput total berat dan mengalokasikan semua daging sapi.</p>
                            <a href="<?= base_url('distribution/sapi'); ?>" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
                                <span class="text">Mulai Kelola</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cow fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>