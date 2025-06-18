<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <?php
    $pendingDistributions = array_filter($user_distributions, function ($dist) {
        return $dist['status'] === 'pending';
    });
    ?>
    <?php if (!empty($pendingDistributions)): ?>
        <div class="alert alert-info alert-dismissible fade show shadow" role="alert">
            <h4 class="alert-heading"><i class="fas fa-bell"></i> Pemberitahuan!</h4>
            <p>Anda mendapatkan alokasi daging qurban yang belum diambil. Silakan tunjukkan QR Code di bawah kepada panitia.
            </p>
            <hr>
            <ul class="mb-0">
                <?php foreach ($pendingDistributions as $dist): ?>
                    <li>Anda mendapatkan jatah <strong>daging <?= esc(ucfirst($dist['animal_type'])); ?></strong> seberat
                        <strong><?= esc($dist['meat_weight']); ?> kg</strong>.</li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-3">
                <a href="<?= base_url('user/myqrcard'); ?>" class="btn btn-primary btn-sm">Lihat Kartu Pengambilan Daging
                    (QR Code)</a>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="row">

        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="<?= base_url('/img/' . user()->user_image) ?>" class="img-fluid rounded-circle mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;" alt="<?= user()->username ?>">
                    <h4 class="card-title font-weight-bold text-primary mb-1"><?= user()->username; ?></h4>

                    <?php if (user()->fullname): ?>
                        <p class="card-text text-gray-800 mb-0"><?= user()->fullname; ?></p>
                    <?php endif; ?>

                    <p class="card-text text-muted mb-3"><?= user()->email; ?></p>

                    <hr>
                    
                    <?php if(in_groups('user')) : ?>

                    <a href="<?= base_url('user/myqrcard'); ?>" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="icon text-white-50"><i class="fas fa-qrcode"></i></span>
                        <span class="text">Kartu Daging</span>
                    </a>
                    <a href="<?= base_url('user/registerqurban'); ?>" class="btn btn-success btn-icon-split btn-sm">
                        <span class="icon text-white-50"><i class="fas fa-hand-holding-heart"></i></span>
                        <span class="text">Daftar Qurban</span>
                    </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="col-lg-7">

            <?php if (!empty($user_qurbans)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-2">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Qurban Saya</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($user_qurbans as $qurban): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-hand-holding-heart text-primary mr-2"></i>
                                        Hewan: <strong><?= ucfirst($qurban['animal_type']); ?></strong>
                                        <?php if ($qurban['animal_type'] === 'sapi'): ?>
                                            <small>(Bagian: <?= $qurban['share_number']; ?> - Grup:
                                                <?= $qurban['qurban_group']; ?>)</small>
                                        <?php endif; ?>
                                    </div>
                                    <span
                                        class="badge badge-<?= $qurban['payment_status'] === 'paid' ? 'success' : 'warning'; ?> badge-pill">
                                        <?= ucfirst($qurban['payment_status']); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
</div>
        <div class="col-lg-12">


            <?php if (!empty($user_distributions)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Riwayat Pengambilan Daging</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($user_distributions as $dist): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-box-open text-success mr-2"></i>
                                        Daging <strong><?= esc(ucfirst($dist['animal_type'])); ?>
                                            <?= esc($dist['meat_weight']); ?> kg</strong>
                                        <small class="d-block text-muted">(Tipe Jatah:
                                            <?= ucfirst($dist['distribution_type']); ?>)</small>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="badge badge-<?= $dist['status'] === 'distributed' ? 'success' : 'warning'; ?> badge-pill d-block mb-1">
                                            <?= ucfirst($dist['status']); ?>
                                        </span>
                                        <?php if ($dist['collected_at']): ?>
                                            <small class="text-muted" style="font-size: 0.75rem;">Diambil:
                                                <?= date('d M Y', strtotime($dist['collected_at'])); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

        <!-- </div> -->
    </div>
</div>
<?= $this->endSection(); ?>