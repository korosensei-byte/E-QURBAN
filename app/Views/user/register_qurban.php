<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('message'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <?php if ($isBerqurban && !empty($user_qurbans)) : ?>
                <div class="alert alert-info">
                    Anda sudah terdaftar sebagai peserta qurban. Silakan lihat detailnya di bawah.
                    Jika Anda ingin menambah bagian sapi, silakan pilih 'Sapi' lagi di form.
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Qurban Anda</h6>
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

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran Qurban</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('user/saveregisterqurban'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="animal_type">Jenis Hewan Qurban</label>
                            <select name="animal_type" id="animal_type" class="form-control <?= session('errors.animal_type') ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Jenis Hewan --</option>
                                <option value="kambing" <?= old('animal_type') == 'kambing' ? 'selected' : ''; ?>>Kambing (Rp 2.700.000 + Rp 50.000 admin)</option>
                                <option value="sapi" <?= old('animal_type') == 'sapi' ? 'selected' : ''; ?>>Sapi (Rp 3.000.000 / bagian + Rp 100.000 admin per sapi)</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.animal_type'); ?>
                            </div>
                        </div>
                        <div class="form-group" id="share_number_group" style="display: <?= old('animal_type') == 'sapi' ? 'block' : 'none'; ?>;">
                            <label for="share_number">Jumlah Bagian Sapi (1-7)</label>
                            <input type="number" class="form-control <?= session('errors.share_number') ? 'is-invalid' : ''; ?>" id="share_number" name="share_number" value="<?= old('share_number'); ?>" min="1" max="7">
                            <small class="form-text text-muted">Untuk qurban sapi, satu sapi bisa untuk 7 orang. Masukkan jumlah bagian yang ingin Anda ambil.</small>
                            <div class="invalid-feedback">
                                <?= session('errors.share_number'); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar Qurban</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('animal_type').addEventListener('change', function() {
        var shareNumberGroup = document.getElementById('share_number_group');
        if (this.value === 'sapi') {
            shareNumberGroup.style.display = 'block';
        } else {
            shareNumberGroup.style.display = 'none';
            document.getElementById('share_number').value = ''; // Clear value if hidden
        }
    });
</script>
<?= $this->endSection(); ?>