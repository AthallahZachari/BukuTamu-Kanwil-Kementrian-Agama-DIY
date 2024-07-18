<?php
include '../../includes/header.php';

if (isset($_POST['submit'])) {
    include '../../includes/connection/connection.php';
    $currentDate = date('Y-m-d');

    $query = $pdo->prepare("INSERT INTO pengunjung (tanggal, nama, jenis_kelamin, umur, instansi, alamat, nomor_hp, kepentingan, keperluan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->execute([$currentDate, $_POST['nama'], $_POST['gender'], $_POST['umur'], $_POST['instansi'], $_POST['alamat'], $_POST['telepon'], $_POST['kepentingan'], $_POST['keperluan']]);

    // // REDIRECT ke halaman utama
    header("Location: ../../index.php");
    exit();
}

$options = [
    ["id" => "1", "text" => "Permohonan Rekomendasi"],
    ["id" => "2", "text" => "Permohonan Rohaniwan"],
    ["id" => "3", "text" => "Permohonan Audiensi"],
    ["id" => "4", "text" => "Permohonan Penelitian"],
    ["id" => "5", "text" => "Permohonan Magang"],
    ["id" => "6", "text" => "Konsultasi Haji"],
    ["id" => "7", "text" => "Konsultasi Halal"]
];

?>

<form action="" method="POST" class=" flex flex-col">
    <!-- [ BIODATA ] -->
    <section class=" w-full flex justify-start mt-3">
        <!-- [ INPUT ] NAMA LENGKAP -->
        <div class=" w-full "> <!-- Adjust input width -->
            <label for="nama" class="block text-slate-800 font-semibold px-1 pb-2">Nama Lengkap</label>
            <input required type="text" name="nama" id="nama" placeholder="Nama lengkap..." class=" w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
    </section>

    <section class="w-full flex justify-start">
        <div class="w-[70%] mr-3 pr-5">
            <!-- umur -->
            <label for="umur" class="block text-slate-800 font-semibold px-1 pb-2">Umur</label>
            <input required type="number" name="umur" id="umur" min="1" max="100" placeholder="Umur..." class="w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
        <div class="w-[30%]">
            <!-- jenis kelamin -->
            <label for="gender" class="block text-slate-800 font-semibold px-1 pb-2">Gender </label>
            <input type="radio" name="gender" id="pria" value="pria">
            <label for="pria">Pria</label>
            <input type="radio" name="gender" id="wanita" value="wanita">
            <label for="wanita">Wanita</label>
        </div>
    </section>

    <!-- [ INSTANSI & ALAMAT ] -->
    <section class="w-full flex justify-start items-start ">
        <div class="w-[70%] mr-3 pr-5">
            <!-- alamat -->
            <label for="alamat" class="block text-slate-800 font-semibold px-1 pb-2">Alamat</label>
            <input required type="text" name="alamat" placeholder="Alamat..." class="w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
        <div class="w-[30%]">
            <!-- instansi/pribadi -->
            <label for="Instansi/pribadi" class="block text-slate-800 font-semibold px-1 pb-3">Instansi/Pribadi</label>
            <input type="radio" name="instansi" value="instansi" id="instansi">
            <label for="instansi">Instansi</label>
            <input type="radio" name="instansi" value="pribadi" id="pribadi">
            <label for="pribadi">Pribadi</label>
        </div>
    </section>

    <!-- telepon -->
    <section class="w-full mb-3 flex justify-between" >
        <div class=" mr-3 pr-5 min-w-[70%]">
            <label for="telephone" class="block text-slate-800 font-semibold px-1 pb-2">Nomor Telephone</label>
            <input required type="text" name="telepon" id="telepon" class="w-[70%] rounded-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>

        <div class=" text-sm font-semibold pt-9 text-center">
            <a id="dropdownButton" class="w-full px-3 py-2 mb-10 rounded-md border border-gray-300 hover:cursor-pointer focus:outline-none focus:ring-1 focus:ring-emerald-400">
                Layanan <i class="fa-solid fa-chevron-down ml-2"></i>
            </a>
            <div id="dropdownMenu" class="hidden absolute mt-3 z-10 bg-white border border-gray-300 rounded-md shadow-lg">
                <ul>
                    <?php foreach ($options as $option) { ?>
                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-value="<?= $option['text']; ?>"><?= $option['text']; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <input type="hidden" name="kepentingan" id="kepentinganID" />
        </div>

    </section>

    <!-- KEPERLUAN -->
    <!-- TEXT AREA -->
    <label for="keperluan" class="block text-slate-800 font-semibold px-1 pb-2">Keperluan</label>
    <textarea required name="keperluan" id="keperluan" placeholder="Masukkan teks..." rows="10" class=" resize-none rounded-md px-4 py-1 mb-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400"></textarea>

    <section class=" flex justify-between">
        <a href="../../index.php" class="  hover:bg-slate-100 text-green-800 font-semibold border border-slate-400 px-4 py-2 rounded-md transition-all duration-300"><i class="fa-solid fa-chevron-left mr-3"></i>Kembali</a>
        <!-- <a href="#" class=" text-slate-100 text-center font-semibold bg-green-800 hover:bg-green-950 px-4 py-2 rounded-md transition-all duration-300">Submit<i class="fa-solid fa-chevron-right ml-3"></i></a> -->
        <button type="" name="submit" class=" text-slate-100 text-center font-semibold bg-green-800 hover:bg-green-950 px-4 py-2 rounded-md transition-all duration-300">Submit<i class="fa-solid fa-chevron-right ml-3"></i></button>
    </section>
</form>
<script src="./script.js"></script>