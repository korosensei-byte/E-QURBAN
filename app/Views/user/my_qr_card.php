<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?php if (!empty($user_distributions)) : ?>
                <?php foreach ($user_distributions as $dist) : ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kartu Daging - <?= ucfirst($dist['animal_type']); ?> (<?= $dist['meat_weight']; ?> kg)</h6>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($dist['qr_code']) : ?>
                            <img src="<?= base_url('user/generateqrcard/' . $dist['qr_code']); ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                            <p class="mt-3">Tunjukkan QR Code ini kepada panitia saat pengambilan daging.</p>
                            <p>Status:
                                <span class="badge badge-<?= $dist['status'] === 'distributed' ? 'success' : 'warning'; ?>">
                                    <?= ucfirst($dist['status']); ?>
                                </span>
                            </p>
                            <?php if ($dist['status'] === 'distributed') : ?>
                                <p class="text-success">Daging sudah berhasil diambil pada: <?= date('d M Y H:i', strtotime($dist['collected_at'])); ?></p>
                            <?php endif; ?>
                            <a href="<?= base_url('user/generateqrcard/' . $dist['qr_code']); ?>" download="qr_daging_<?= $dist['id']; ?>.png" class="btn btn-sm btn-info mt-2">Unduh QR Code</a>
                        <?php else : ?>
                            <p>QR Code belum tersedia untuk bagian ini. Silakan hubungi panitia.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="alert alert-info">Anda belum terdaftar untuk mendapatkan bagian daging qurban.</div>
            <?php endif; ?>
            <a href="<?= base_url('user'); ?>" class="btn btn-secondary mt-3">&laquo; Kembali ke Profil Saya</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>