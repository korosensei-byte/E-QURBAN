<?= $this->extend('templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Pembagian Daging</h1>
    <p class="mb-4">Silakan pilih jenis hewan yang akan dikelola distribusinya.</p>


    <div class="row">
        <!-- Tombol Kelola Daging Kambing -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Distribusi Kambing</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Daging Kambing</div>
                            <p class="card-text mt-2">Masuk ke halaman untuk menginput total berat dan mengalokasikan
                                semua daging kambing.</p>
                            <a href="<?= base_url('distribution/kambing'); ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
                                <span class="text">Mulai Kelola</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hat-cowboy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kelola Daging Sapi -->
        <div class="col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Distribusi Sapi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Daging Sapi</div>
                            <p class="card-text mt-2">Masuk ke halaman untuk menginput total berat dan mengalokasikan
                                semua daging sapi.</p>
                            <a href="<?= base_url('distribution/sapi'); ?>" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span>
                                <span class="text">Mulai Kelola</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cow fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Ayat Al-Qur'an tentang Qurban</h6>
                </div>
                <div class="card-body">
                    <p class="text-right" style="font-family: 'Scheherazade', serif; font-size: 1.5rem;">
                        لِيَشْهَدُوا مَنَافِعَ لَهُمْ وَيَذْكُرُوا اسْمَ اللَّهِ فِي أَيَّامٍمَّعْلُومَاتٍ عَلَى مَا
                        رَزَقَهُم مِّنْ بَهِيمَةِ الْأَنْعَامِ فَكُلُوا مِنْهَا وَأَطْعِمُوا الْبَائِسَ الْفَقِيرَ
                    </p>
                    <hr>
                    <p>
                        <strong>Artinya:</strong> "Supaya mereka menyaksikan berbagai manfaat bagi mereka dan supaya
                        mereka menyebut nama Allah pada hari yang telah ditentukan atas rezeki yang Allah telah berikan
                        kepada mereka berupa binatang ternak. Maka makanlah sebahagian daripadanya dan (sebahagian lagi)
                        berikanlah untuk dimakan orang-orang yang sengsara dan fakir."
                        <br>
                        <em>(QS. Al-Hajj: 28)</em>
                    </p>
                </div><br>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">Hadits tentang Pembagian Daging Qurban</h6>
                </div>
                <div class="card-body">
                    <p class="text-right" style="font-family: 'Scheherazade', serif; font-size: 1.5rem;"> عَنْ سَلَمَةَ
                        بْنِ الْأَكْوَعِ رضي الله عنه قَالَ:
                        قَالَ النَّبِيُّ ﷺ: «كُلُوا وَأَطْعِمُوا وَادَّخِرُوا»
                    </p>
                    <hr>
                    <p>
                        <strong>Artinya:</strong> "Makanlah (daging qurban itu), berilah makan kepada orang lain, dan
                        simpanlah (sebagian)."
                        <br>
                        <em>(HR. Bukhari no. 5569, Muslim no. 1971)</em>
                    </p>
                    <p>
                        <strong>Keterangan:</strong> Dari hadits ini, para ulama menganjurkan pembagian daging qurban
                        menjadi tiga bagian:
                    <ul>
                        <li>1/3 untuk dikonsumsi sendiri</li>
                        <li>1/3 untuk dihadiahkan kepada kerabat/tetangga</li>
                        <li>1/3 untuk disedekahkan kepada fakir miskin</li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection(); ?>