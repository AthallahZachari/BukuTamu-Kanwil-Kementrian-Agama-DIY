<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (isset($_POST['submit'])) {
    $currentDate = date('Y-m-d');

    $query = $pdo->prepare("INSERT INTO pengunjung (tanggal, nama, jenis_kelamin, umur, instansi, alamat, nomor_hp, layanan, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->execute([$currentDate, $_POST['nama'], $_POST['gender'], $_POST['umur'], $_POST['instansi'], $_POST['alamat'], $_POST['telepon'], $_POST['layanan'], $_POST['deskripsi']]);

    // Redirect to homepage
    header("Location: ../../index.php");
    exit();
}

// [ QUERY ] list layanan
$layanan = "SELECT * FROM layanan";
$queryLayanan = $pdo->prepare($layanan);
$queryLayanan->execute();
$listLayanan = $queryLayanan->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="" method="POST" id="myForm" class="flex flex-col">
    <!-- [ BIODATA ] -->
    <section class="w-full flex justify-start mt-3">
        <div class="w-full">
            <label for="nama" class="block text-slate-800 font-semibold px-1 pb-2">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" placeholder="Nama lengkap..." class="w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
    </section>

    <section class="w-full flex justify-start">
        <div class="w-[70%] mr-3 pr-5">
            <label for="umur" class="block text-slate-800 font-semibold px-1 pb-2">Umur</label>
            <input type="number" name="umur" id="umur" min="1" max="100" placeholder="Umur..." class="w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
        <div class="w-[30%]">
            <label for="gender" class="block text-slate-800 font-semibold px-1 pb-2">Jenis Kelamin</label>
            <input type="radio" name="gender" id="pria" value="pria">
            <label for="pria">Pria</label>
            <input type="radio" name="gender" id="wanita" value="wanita">
            <label for="wanita">Wanita</label>
        </div>
    </section>

    <section class="w-full flex justify-start items-start">
        <div class="w-[70%] mr-3 pr-5">
            <label for="alamat" class="block text-slate-800 font-semibold px-1 pb-2">Alamat Instansi/Pribadi</label>
            <input type="text" name="alamat" id="alamat" placeholder="Alamat..." class="w-full rounded-md px-4 py-1 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>
        <div class="w-[30%]">
            <label for="Instansi/pribadi" class="block text-slate-800 font-semibold px-1 pb-3">Instansi/Pribadi</label>
            <input type="radio" name="instansi" value="instansi" id="instansi">
            <label for="instansi">Instansi</label>
            <input type="radio" name="instansi" value="pribadi" id="pribadi">
            <label for="pribadi">Pribadi</label>
        </div>
    </section>

    <section class="w-full mb-3 flex justify-between">
        <div class="mr-3 pr-5 min-w-[60%]">
            <label for="telepon" class="block text-slate-800 font-semibold px-1 pb-2">Nomor HP/Telephone</label>
            <input type="text" name="telepon" id="telepon" placeholder="No. Aktif..." onkeypress="validateNumberInput(event)" class="w-[80%] rounded-md px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
        </div>

        <div class="text-sm font-semibold pt-9 min-w-[30%]">
            <a id="dropdownButton" onclick="togglePopup()" class="w-full px-3 py-2 mb-10 rounded-md border border-gray-300 hover:cursor-pointer focus:outline-none focus:ring-1 focus:ring-emerald-400">
                Input Layanan <i class="fa-solid fa-chevron-down ml-2"></i>
            </a>
            <div id="dropdownMenu" class="hidden absolute mt-3 z-10 bg-white min-w-[150px] border border-gray-300 rounded-md shadow-lg">
                <ul>
                    <?php foreach ($listLayanan as $list) { ?>
                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-value="<?= $list['id_layanan']; ?>"><?= $list['layanan']; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <input type="hidden" name="layanan" id="kepentinganID" required />
        </div>
    </section>

    <label for="keperluan" class="block text-slate-800 font-semibold px-1 pb-2">Deskripsi</label>
    <textarea name="deskripsi" id="keperluan" placeholder="Masukkan teks..." rows="10" class="resize-none rounded-md px-4 py-1 mb-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400"></textarea>

    <div id="error-message" class="hidden text-red-500 mb-3 text-center"></div>

    <section class="flex justify-between">
        <a href="../../index.php" class="hover:bg-slate-100 text-green-800 font-semibold border border-slate-400 px-4 py-2 rounded-md transition-all duration-300"><i class="fa-solid fa-chevron-left mr-3"></i>Kembali</a>
        <button type="submit" name="submit" class="text-slate-100 text-center font-semibold bg-green-800 hover:bg-green-950 px-4 py-2 rounded-md transition-all duration-300">Submit<i class="fa-solid fa-chevron-right ml-3"></i></button>
    </section>
</form>
<script>
    function togglePopup() {
        var dropdownMenu = document.getElementById("dropdownMenu");
        dropdownMenu.classList.toggle("hidden");
    }

    document.querySelectorAll('#dropdownMenu li').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value');
            document.getElementById('kepentinganID').value = selectedValue;
            document.getElementById('dropdownButton').textContent = this.textContent;
            document.getElementById('dropdownMenu').classList.add('hidden');
        });
    });

    document.getElementById('myForm').addEventListener('submit', function(event) {
        // Clear any previous error messages
        const errorMessage = document.getElementById('error-message');
        errorMessage.classList.add('hidden');
        errorMessage.textContent = '';

        // Get form inputs
        const nama = document.getElementById('nama').value.trim();
        const umur = document.getElementById('umur').value.trim();
        const gender = document.querySelector('input[name="gender"]:checked');
        const alamat = document.getElementById('alamat').value.trim();
        const instansi = document.querySelector('input[name="instansi"]:checked');
        const telepon = document.getElementById('telepon').value.trim();
        const layanan = document.getElementById('kepentinganID').value.trim();
        const deskripsi = document.getElementById('keperluan').value.trim();

        // Validate inputs
        if (!nama || !umur || !gender || !alamat || !instansi || !telepon || !layanan || !deskripsi) {
            event.preventDefault(); // Prevent form submission
            errorMessage.textContent = 'Pastikan semua kolom input terisi !!';
            errorMessage.classList.remove('hidden');
            return;
        }
    });

    function validateNumberInput(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
        }
    }
</script>