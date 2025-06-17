<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <form action="<?= base_url('financial/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="transaction_type">Tipe Transaksi</label>
                    <select name="transaction_type" id="transaction_type" class="form-control <?= session('errors.transaction_type') ? 'is-invalid' : ''; ?>">
                        <option value="in" <?= old('transaction_type') == 'in' ? 'selected' : ''; ?>>Pemasukan</option>
                        <option value="out" <?= old('transaction_type') == 'out' ? 'selected' : ''; ?>>Pengeluaran</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('errors.transaction_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="amount">Jumlah</label>
                    <input type="text" class="form-control <?= session('errors.amount') ? 'is-invalid' : ''; ?>" id="amount" name="amount" value="<?= old('amount'); ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.amount'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3"><?= old('description'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('errors.description'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="related_user_id">User Terkait (Opsional)</label>
                    <select name="related_user_id" id="related_user_id" class="form-control">
                        <option value="">-- Pilih User --</option>
                        <?php
                            // Fetch all users from UserModel to populate the dropdown
                            $userModel = new \Myth\Auth\Models\UserModel();
                            $allUsers = $userModel->findAll();
                            foreach ($allUsers as $user) :
                        ?>
                        <option value="<?= $user->id; ?>" <?= old('related_user_id') == $user->id ? 'selected' : ''; ?>><?= $user->username; ?> (<?= $user->email; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>