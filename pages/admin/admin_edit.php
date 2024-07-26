<?php
include '../../includes/connection/connection.php';
include '../../includes/header.php';


// [ POST ] list bidang
if (isset($_POST['submitBidang'])) {
    $insertBidang = $pdo->prepare("INSERT INTO bidang (bidang, deskripsi) VALUES (?, ?)");
    $insertBidang->execute([$_POST['bidang'], $_POST['deskripsiBidang']]);
}

// [ POST ] list layanan
if (isset($_POST['submitLayanan'])) {
    $insertBidang = $pdo->prepare("INSERT INTO layanan (layanan) VALUES (?)");
    $insertBidang->execute([$_POST['newLayanan']]);
}

$layanan = "SELECT * FROM layanan";
$queryLayanan = $pdo->prepare($layanan);
$queryLayanan->execute();
$listLayanan = $queryLayanan->fetchAll(PDO::FETCH_ASSOC);


$query = $pdo->query("SELECT * FROM bidang");
$listBidang = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <!-- TABLE BIDANG -->
    <section class=" w-full pb-10 flex">
        <div class=" w-[57%] mr-10 px-5 pb-6 rounded-lg shadow-xl">
            <section class=" py-5 flex justify-between items-center">
                <h1 class=" text-2xl text-slate-700 font-semibold">Daftar Bidang</h1>
                <button id="btnTambahBidang" class=" bg-green-700 hover:bg-green-900 px-3 py-2 rounded-md text-slate-100 transition-all duration-300">
                    <i class="fa-solid fa-plus mr-2"></i>Bidang Baru
                </button>
            </section>
            <table class=" text-sm overflow-x-auto table-auto w-full">
                <thead>
                    <tr>
                        <th class="py-4 pl-5 pr-2 text-left font-medium border-y border-slate-400 text-slate-500">Bidang</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryBidang->rowCount() > 0) : ?>
                        <?php foreach ($listBidang as $index => $list) : ?>
                            <?= $index == 0 ? '' :
                                '<tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                    <td class=" ">' . $list['bidang'] . '</td>
                                    <td class=" px-5"> ' . $list['deskripsi'] . ' </td>
                                    <td class=" pl-2 pr-5 py-1 text-slate-800 text-xs">
                                        <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md bg-red-500 hover:bg-red-700 transition-all duration-300"><i class="fa-solid fa-ban"></i></button>
                                    </td>
                                </tr>'; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Daftar Bidang Masih Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="formAddBidang" class=" w-[40%] rounded-md hidden">
            <div class=" w-full px-5 pb-5 shadow-xl rounded-md ">
                <h1 class=" py-5 text-2xl text-slate-700 font-semibold">Form Tambah Bidang</h1>
                <form action="" method="POST" class="flex flex-col">
                    <label for="bidang" class=" text-slate-800 font-semibold px-2 pb-2">Bidang</label>
                    <input type="text" name="bidang" placeholder="Nama bidang baru..." class=" rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

                    <label for="deskripsiBidang" class=" text-slate-800 font-semibold px-2 pb-2">Deskripsi</label>
                    <input type="text" name="deskripsiBidang" placeholder="Deskripsi..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <button type="" name="submitBidang" class="bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                        Tambahkan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- TABLE LAYANAN -->
    <section class=" w-full pb-10 flex">
        <div class=" w-[57%] mr-10 px-5 pb-6 rounded-lg shadow-xl">
            <section class=" py-5 flex justify-between items-center">
                <h1 class=" text-2xl text-slate-700 font-semibold">Daftar Layanan</h1>
                <button id="btnTambahLayanan" class=" bg-green-700 hover:bg-green-900 px-3 py-2 rounded-md text-slate-100 transition-all duration-300">
                    <i class="fa-solid fa-plus mr-2"></i>Layanan Baru
                </button>
            </section>
            <table class=" text-sm overflow-x-auto table-auto w-full">
                <thead>
                    <tr>
                        <th class="py-4 pl-5 pr-2 text-left font-medium border-y border-slate-400 text-slate-500">Layanan</th>
                        <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryLayanan->rowCount() > 0) : ?>
                        <?php foreach ($listLayanan as $index => $list) : ?>
                            <?= $index == 0 ? '' :
                                '<tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                    <td class=" ">' . $list['layanan'] . '</td>
                                    <td class=" px-2 "></td>
                                    <td class=" pl-2 py-1 text-slate-800 text-xs ">
                                        <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md bg-red-500 hover:bg-red-700 transition-all duration-300"><i class="fa-solid fa-ban"></i></button>
                                    </td>
                                </tr>'; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Daftar Layanan Masih Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- [ FORM ] TAMBAH DAFTAR LAYANAN -->
        <div id="formAddLayanan" class=" w-[40%] rounded-md hidden">
            <div class=" w-full px-5 pb-5 shadow-xl rounded-md ">
                <h1 class=" py-5 text-2xl text-slate-700 font-semibold">Form Tambah Layanan</h1>
                <form action="" method="post" class="flex flex-col">

                    <label for="username" class=" text-slate-800 font-semibold px-2 pb-2">Layanan</label>
                    <input type="text" name="newLayanan" placeholder="Nama bidang baru..." class=" rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

                    <label for="nip" class=" text-slate-800 font-semibold px-2 pb-2">Deskripsi</label>
                    <input type="text" name="nip" placeholder="Deskripsi..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

                    <button type="" name="submitLayanan" class="bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                        Tambahkan
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>


<script>
    document.getElementById('btnTambahBidang').addEventListener('click', function() {
        document.getElementById('formAddBidang').classList.toggle('hidden');
    });

    document.getElementById('btnTambahLayanan').addEventListener('click', function() {
        document.getElementById('formAddLayanan').classList.toggle('hidden');
    });
</script>