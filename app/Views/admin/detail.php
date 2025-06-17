<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Pengguna</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('/img/' . $user->user_image) ?>" class="card-img" alt="<?= $user->username ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4><?= $user->username; ?></h4>
                                </li>
                                <?php if ($user->fullname) : ?>
                                    <li class="list-group-item"><?= $user->fullname; ?></li>
                                <?php endif; ?>
                                <li class="list-group-item"><?= $user->email; ?></li>
                                <li class="list-group-item">
                                    Terdaftar sejak: <?= date('d F Y', strtotime($user->created_at)) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="mt-4">Roles Pengguna</h5>

            <?php if(session()->getFlashdata('message')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/updateUserRoles/' . $user->userid) ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="form-group">
        <?php 
        // Buat array sederhana yang hanya berisi ID dari role yang dimiliki pengguna
        $currentUserRoleIds = array_column($user_roles, 'id');
        
        // Loop semua role yang tersedia
        foreach ($all_roles as $role): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $role->id ?>" id="role-<?= $role->id ?>"
                    <?php if (in_array($role->id, $currentUserRoleIds)): ?>
                        checked
                    <?php endif; ?>
                >
                <label class="form-check-label" for="role-<?= $role->id ?>">
                    <?= ucfirst($role->name) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary">Update Roles</button>
    <a href="<?= base_url('admin') ?>" class="btn btn-secondary">Kembali</a>
</form>
             </div>
    </div>
</div>
<?= $this->endSection(); ?>