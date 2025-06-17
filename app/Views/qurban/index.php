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
            <a href="<?= base_url('qurban/add'); ?>" class="btn btn-primary mb-3">Tambah Peserta Qurban</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Jenis Hewan</th>
                            <th>Jumlah Bagian (Sapi)</th>
                            <th>Grup Qurban</th>
                            <th>Status Pembayaran</th>
                            <th>Jumlah Dibayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($participants as $participant) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $participant['username']; ?></td>
                                <td><?= $participant['email']; ?></td>
                                <td><?= ucfirst($participant['animal_type']); ?></td>
                                <td><?= $participant['share_number'] ?: '-'; ?></td>
                                <td><?= $participant['qurban_group'] ?: '-'; ?></td>
                                <td>
                                    <span class="badge badge-<?= $participant['payment_status'] === 'paid' ? 'success' : 'warning'; ?>">
                                        <?= ucfirst($participant['payment_status']); ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($participant['amount_paid'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($participant['payment_status'] === 'unpaid') : ?>
                                        <a href="<?= base_url('qurban/markaspaid/' . $participant['id']); ?>" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengubah status pembayaran ini menjadi LUNAS?');">Mark as Paid</a>
                                    <?php else : ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Paid</button>
                                    <?php endif; ?>
                                    <a href="#" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>