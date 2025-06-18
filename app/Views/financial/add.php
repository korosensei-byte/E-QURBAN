<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <form action="<?= base_url('financial/save'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="amount">Jumlah Pengeluaran</label>
                    <input type="number" class="form-control <?= session('errors.amount') ? 'is-invalid' : ''; ?>" id="amount" name="amount" value="<?= old('amount'); ?>" placeholder="Contoh: 150000">
                    <div class="invalid-feedback">
                        <?= session('errors.amount'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Pengeluaran</label>
                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3" placeholder="Contoh: Beli kantong plastik & tali rafia"><?= old('description'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('errors.description'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Pengeluaran</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>