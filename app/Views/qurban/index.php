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


        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Dana Qurban (Lunas)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($totalAmountPaid, 0, ',', '.'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="<?= base_url('qurban/add'); ?>" class="btn btn-primary btn-sm">Tambah Peserta Qurban</a>
                    <div>
                        <button id="edit-btn" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Daftar
                        </button>
                        <button id="cancel-btn" class="btn btn-secondary btn-sm" style="display: none;">
                            <i class="fas fa-times"></i> Batalkan Edit
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Jenis Hewan</th>
                                    <th>Bagian (Sapi) / Tag (Kambing)</th>
                                    <th>Grup Qurban (Sapi)</th>
                                    <th>Status Pembayaran</th>
                                    <th>Jumlah Dibayar</th>
                                    <th class="kolom-aksi" style="display: none;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($participants as $participant): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $participant['username']; ?></td>
                                        <td><?= $participant['email']; ?></td>
                                        <td><?= ucfirst($participant['animal_type']); ?></td>
                                        <td><?= $participant['animal_type'] === 'sapi' ? $participant['share_number'] : esc($participant['animal_tag']); ?>
                                        </td>
                                        <td><?= $participant['qurban_group'] ?: '-'; ?></td>
                                        <td>
                                            <span
                                                class="badge badge-<?= $participant['payment_status'] === 'paid' ? 'success' : 'warning'; ?>">
                                                <?= ucfirst($participant['payment_status']); ?>
                                            </span>
                                        </td>
                                        <td>Rp <?= number_format($participant['amount_paid'], 0, ',', '.'); ?></td>
                                        <td class="kolom-aksi" style="display: none;">
                                            <?php if ($participant['payment_status'] === 'unpaid'): ?>
                                                <a href="<?= base_url('qurban/markaspaid/' . $participant['id']); ?>"
                                                    class="btn btn-success btn-sm mb-1"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status pembayaran ini menjadi LUNAS?');">Bayar</a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm mb-1" disabled>Lunas</button>
                                            <?php endif; ?>
                                            <a href="<?= base_url('qurban/delete/' . $participant['id']); ?>"
                                                class="btn btn-danger btn-sm mb-1"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data peserta qurban ini?');">Hapus</a>
                                        </td>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Ambil elemen tombol dan kolom aksi dari halaman
        const editBtn = document.getElementById('edit-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const kolomAksi = document.querySelectorAll('.kolom-aksi');

        // 2. Tambahkan event listener untuk tombol 'Edit Daftar'
        editBtn.addEventListener('click', function () {
            // Sembunyikan tombol 'Edit'
            editBtn.style.display = 'none';
            // Tampilkan tombol 'Batalkan Edit'
            cancelBtn.style.display = 'inline-block';

            // Tampilkan semua kolom aksi
            kolomAksi.forEach(function (kolom) {
                kolom.style.display = 'table-cell';
            });
        });

        // 3. Tambahkan event listener untuk tombol 'Batalkan Edit'
        cancelBtn.addEventListener('click', function () {
            // Tampilkan kembali tombol 'Edit'
            editBtn.style.display = 'inline-block';
            // Sembunyikan tombol 'Batalkan'
            cancelBtn.style.display = 'none';

            // Sembunyikan kembali semua kolom aksi
            kolomAksi.forEach(function (kolom) {
                kolom.style.display = 'none';
            });
        });
    });
</script>

<?= $this->endSection(); ?>