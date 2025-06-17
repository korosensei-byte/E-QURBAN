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
        <div class="col-lg-12">
            <a href="<?= base_url('distribution/add'); ?>" class="btn btn-primary mb-3">Tambah Catatan Pembagian</a>
            <a href="<?= base_url('distribution/scan'); ?>" class="btn btn-info mb-3">Scan QR Code</a>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penerima</th>
                            <th>Tipe Distribusi</th>
                            <th>Berat (Kg)</th>
                            <th>Tanggal Distribusi</th>
                            <th>Status</th>
                            <th>QR Code</th>
                            <th>Diambil Oleh</th>
                            <th>Tanggal Pengambilan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($distributions as $dist) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $dist['username']; ?> (<?= $dist['email']; ?>)</td>
                                <td><?= ucfirst($dist['distribution_type']); ?></td>
                                <td><?= $dist['meat_weight_kg']; ?></td>
                                <td><?= date('d M Y H:i', strtotime($dist['distribution_date'])); ?></td>
                                <td>
                                    <span class="badge badge-<?= $dist['status'] === 'distributed' ? 'success' : 'warning'; ?>">
                                        <?= ucfirst($dist['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($dist['qr_code']) : ?>
                                        <img src="<?= base_url('distribution/generateqrcode/' . $dist['qr_code']); ?>" alt="QR Code" width="50">
                                    <?php else : ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($dist['collected_by_user_id']) : ?>
                                        <?php
                                            $userModel = new \Myth\Auth\Models\UserModel();
                                            $collector = $userModel->find($dist['collected_by_user_id']);
                                            echo $collector ? $collector->username : 'N/A';
                                        ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= $dist['collected_at'] ? date('d M Y H:i', strtotime($dist['collected_at'])) : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>