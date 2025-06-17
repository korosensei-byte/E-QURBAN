<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('/img/' . user()->user_image) ?>" class="card-img" alt="<?php user()->username ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4><?= user()->username; ?></h4>
                                </li>
                                <?php if(user()->fullname) : ?>
                                 <li class="list-group-item"><?= user()->fullname; ?></li>
                                <?php endif; ?>

                                <li class="list-group-item"><?= user()->email; ?></li>
                            </ul>
                            <div class="mt-3">
                                <a href="<?= base_url('user/myqrcard'); ?>" class="btn btn-primary btn-sm">Lihat Kartu Pengambilan Daging</a>
                                <a href="<?= base_url('user/registerqurban'); ?>" class="btn btn-success btn-sm ml-2">Daftar Qurban</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($user_qurbans)) : ?>
                <div class="card shadow mb-4 mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Qurban Saya</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($user_qurbans as $qurban) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Hewan: <?= ucfirst($qurban['animal_type']); ?>
                                    <?php if ($qurban['animal_type'] === 'sapi') : ?>
                                        (Bagian: <?= $qurban['share_number']; ?> - Grup: <?= $qurban['qurban_group']; ?>)
                                    <?php endif; ?>
                                    <span class="badge badge-<?= $qurban['payment_status'] === 'paid' ? 'success' : 'warning'; ?> badge-pill">
                                        <?= ucfirst($qurban['payment_status']); ?> (Rp <?= number_format($qurban['amount_paid'], 0, ',', '.'); ?>)
                                    </span>
                                    <small class="text-muted">Terdaftar: <?= date('d M Y', strtotime($qurban['created_at'])); ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($user_distributions)) : ?>
                <div class="card shadow mb-4 mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengambilan Daging</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($user_distributions as $dist) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Daging <?= $dist['meat_weight_kg']; ?> kg (Tipe: <?= ucfirst($dist['distribution_type']); ?>)
                                    <span class="badge badge-<?= $dist['status'] === 'distributed' ? 'success' : 'warning'; ?> badge-pill">
                                        <?= ucfirst($dist['status']); ?>
                                    </span>
                                    <?php if ($dist['collected_at']) : ?>
                                        <small class="text-muted">Diambil: <?= date('d M Y H:i', strtotime($dist['collected_at'])); ?></small>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>