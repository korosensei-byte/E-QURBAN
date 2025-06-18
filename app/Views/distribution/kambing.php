<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Distribusi Daging Kambing</h1>
    <a href="<?= base_url('distribution'); ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success" role="alert"><?= session()->getFlashdata('message'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <!-- FORM UNTUK DISTRIBUSI DAGING KAMBING -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Input Total Daging Kambing</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('distribution/kambing/distribute'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="total_meat_weight_kambing">Total Berat Daging Kambing (Kg)</label>
                    <input type="number" step="0.01" class="form-control" name="total_meat_weight_kambing" placeholder="Contoh: 85.50" required>
                    <small class="form-text text-muted">Masukkan total berat semua daging kambing yang tersedia untuk didistribusikan hari ini.</small>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Anda yakin ingin mendistribusikan total daging kambing ini?')">
                    <i class="fas fa-divide"></i> Alokasikan Daging Kambing
                </button>
            </form>
        </div>
    </div>

    <hr>
            
    <h4 class="mt-4 mb-3">Riwayat Alokasi Daging Kambing</h4>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
             <thead>
                <tr>
                    <th>#</th>
                    <th>Penerima</th>
                    <th>Tipe Jatah</th>
                    <th>Berat (kg)</th>
                    <th>QR Code</th>
                    <th>Tanggal Alokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php if(!empty($distributions)): ?>
                    <?php foreach ($distributions as $dist) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= esc($dist['username'] ?? 'User Dihapus'); ?></td>
                            <td>
                                <?php
                                    // Menentukan warna badge berdasarkan tipe distribusi
                                    $badgeClass = 'badge-light';
                                    if ($dist['distribution_type'] === 'berqurban') $badgeClass = 'badge-success';
                                    elseif ($dist['distribution_type'] === 'panitia') $badgeClass = 'badge-primary';
                                    elseif ($dist['distribution_type'] === 'warga') $badgeClass = 'badge-info';
                                ?>
                                <span class="badge <?= $badgeClass; ?>"><?= esc($dist['distribution_type'] === 'berqurban' ? 'Pekurban' : ucfirst($dist['distribution_type'])); ?></span>
                            </td>
                            <td><?= esc($dist['meat_weight']); ?></td>
                            <td>
                                <?php if (!empty($dist['qr_code'])) : ?>
                                    <img src="<?= base_url('distribution/qrimage/' . urlencode($dist['qr_code'])) ?>" alt="QR Code" width="80">
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($dist['distribution_date'])); ?></td>
                            <td>
                                <span class="badge badge-<?= $dist['status'] === 'distributed' ? 'success' : 'warning'; ?>"><?= ucfirst(esc($dist['status'])); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
