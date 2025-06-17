<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen User</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('message'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua User</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari user..."
                                aria-label="Search" name="keyword"
                                value="<?= esc(isset($_GET['keyword']) ? $_GET['keyword'] : ''); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url('admin'); ?>" class="btn btn-secondary btn-sm">Semua Role</a>
                    <a href="<?= base_url('admin?role=admin'); ?>" class="btn btn-secondary btn-sm">Admin</a>
                    <a href="<?= base_url('admin?role=panitia'); ?>" class="btn btn-secondary btn-sm">Panitia</a>
                    <a href="<?= base_url('admin?role=berqurban'); ?>" class="btn btn-secondary btn-sm">Berqurban</a>
                    <a href="<?= base_url('admin?role=user'); ?>" class="btn btn-secondary btn-sm">Warga</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 + (isset($_GET['page']) ? ($_GET['page'] - 1) * 20 : 0); ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $user->username; ?></td>
                                <td><?= $user->email; ?></td>
                                <td>
                                    <span class="badge badge-<?php
                                    if ($user->name == 'admin') {
                                        echo 'success';
                                    } elseif ($user->name == 'panitia') {
                                        echo 'dark'; // or 'primary', 'dark', etc.
                                    }
                                    elseif ($user->name == 'user') {
                                        echo 'warning'; // or 'primary', 'dark', etc.
                                    } else {
                                        echo 'primary';
                                    }
                                    ?>"><?= $user->name; ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= ($user->active == 1) ? 'success' : 'secondary'; ?>">
                                        <?= ($user->active == 1) ? 'Aktif' : 'Nonaktif'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/' . $user->userid); ?>"
                                        class="btn btn-info btn-sm">Detail</a>
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