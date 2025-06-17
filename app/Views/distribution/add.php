<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <form action="<?= base_url('distribution/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="recipient_user_id">Penerima</label>
                    <select name="recipient_user_id" id="recipient_user_id" class="form-control <?= session('errors.recipient_user_id') ? 'is-invalid' : ''; ?>">
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->id; ?>" <?= old('recipient_user_id') == $user->id ? 'selected' : ''; ?>><?= $user->username; ?> (<?= $user->email; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('errors.recipient_user_id'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_type">Tipe Distribusi</label>
                    <select name="distribution_type" id="distribution_type" class="form-control <?= session('errors.distribution_type') ? 'is-invalid' : ''; ?>">
                        <option value="warga" <?= old('distribution_type') == 'warga' ? 'selected' : ''; ?>>Warga Umum</option>
                        <option value="berqurban" <?= old('distribution_type') == 'berqurban' ? 'selected' : ''; ?>>Peserta Qurban</option>
                        <option value="panitia" <?= old('distribution_type') == 'panitia' ? 'selected' : ''; ?>>Panitia</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('errors.distribution_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="meat_weight_kg">Berat Daging (Kg)</label>
                    <input type="text" class="form-control <?= session('errors.meat_weight_kg') ? 'is-invalid' : ''; ?>" id="meat_weight_kg" name="meat_weight_kg" value="<?= old('meat_weight_kg'); ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.meat_weight_kg'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="distribution_date">Tanggal Distribusi</label>
                    <input type="datetime-local" class="form-control <?= session('errors.distribution_date') ? 'is-invalid' : ''; ?>" id="distribution_date" name="distribution_date" value="<?= old('distribution_date') ?: date('Y-m-d\TH:i'); ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.distribution_date'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Catatan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>