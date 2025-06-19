<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

<?php if (session()->getFlashdata('message')) : ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Dana Administrasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($totalAdminFee, 0, ',', '.'); ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-arrow-down fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pengeluaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($totalExpense, 0, ',', '.'); ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-arrow-up fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sisa Dana Administrasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($balance, 0, ',', '.'); ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-wallet fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Pengeluaran</h6>
            <a href="<?= base_url('financial/add'); ?>" class="btn btn-primary btn-sm">Tambah Pengeluaran</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Dicatat Oleh</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
<?php foreach ($transactions as $transaction): ?>
    <tr>
        <td><?= $i++; ?></td>
        <td>Rp <?= number_format($transaction['amount'], 0, ',', '.'); ?></td>
        <td><?= esc($transaction['description']); ?></td>
        <td>
            <?php
                $userModel = new \Myth\Auth\Models\UserModel();
                $user = $userModel->find($transaction['related_user_id']);
                echo $user ? esc($user->username) : 'N/A';
            ?>
        </td>
        <td><?= date('d M Y H:i', strtotime($transaction['created_at'])); ?></td>
        <td>
            <a href="<?= base_url('financial/delete/' . $transaction['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                <i class="fas fa-trash"></i> Hapus
            </a>
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