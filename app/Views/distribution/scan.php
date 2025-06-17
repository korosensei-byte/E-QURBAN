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
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Scan QR Code</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('distribution/verifyqrcode'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="qr_code_input">Masukkan Kode QR</label>
                            <input type="text" class="form-control" id="qr_code_input" name="qr_code_input" placeholder="Scan atau masukkan kode QR">
                        </div>
                        <button type="submit" class="btn btn-primary">Verifikasi QR Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>