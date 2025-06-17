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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Keuangan</h6>
                </div>
                <div class="card-body">
                    <p>Total Pemasukan: **Rp <?= number_format($totalIncome, 0, ',', '.'); ?>**</p>
                    <p>Total Pengeluaran: **Rp <?= number_format($totalExpense, 0, ',', '.'); ?>**</p>
                    <p>Saldo Kas: **Rp <?= number_format($balance, 0, ',', '.'); ?>**</p>
                    <a href="<?= base_url('financial/add'); ?>" class="btn btn-primary btn-sm">Tambah Transaksi Baru</a>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Deskripsi</th>
                                    <th>User Terkait</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td>
                                            <span class="badge badge-<?= $transaction['transaction_type'] === 'in' ? 'success' : 'danger'; ?>">
                                                <?= ucfirst($transaction['transaction_type']); ?>
                                            </span>
                                        </td>
                                        <td>Rp <?= number_format($transaction['amount'], 0, ',', '.'); ?></td>
                                        <td><?= $transaction['description']; ?></td>
                                        <td>
                                            <?php if ($transaction['related_user_id']) : ?>
                                                <?php
                                                    $userModel = new \Myth\Auth\Models\UserModel();
                                                    $user = $userModel->find($transaction['related_user_id']);
                                                    echo $user ? $user->username : 'N/A';
                                                ?>
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($transaction['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>