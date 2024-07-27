<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // [ POST ] list bidang
    if (isset($_POST['submitBidang'])) {
        $insertBidang = $pdo->prepare("INSERT INTO bidang (bidang, deskripsi) VALUES (?, ?)");
        $insertBidang->execute([$_POST['bidang'], $_POST['deskripsiBidang']]);

        if ($insertBidang->rowCount() > 0) {
            // Redirect ke halaman yang sama
            header('Location: ./admin_edit.php');
            exit();
        }
    }

    // [ DELETE ] list bidang
    if (isset($_POST['id_bidang'])) {
        $idBidang = $_POST['id_bidang'];
        $deleteBidang = $pdo->prepare("DELETE FROM bidang WHERE id_bidang = ?");
        $deleteBidang->execute([$idBidang]);

        // header('Location: ./dashboard.php?filter=all&searchbox=');
        header('Location: ./admin_edit.php');
        exit();
    }

    // [ POST ] list layanan
    if (isset($_POST['submitLayanan'])) {
        $insertLayanan = $pdo->prepare("INSERT INTO layanan (layanan) VALUES (?)");
        $insertLayanan->execute([$_POST['newLayanan']]);

        if ($insertLayanan->rowCount() > 0) {
            // Redirect ke halaman yang sama
            header('Location: ./admin_edit.php');
            exit();
        }
    }

    // [ DELETE ] list bidang
    if (isset($_POST['id_layanan'])) {
        $idLayanan = $_POST['id_layanan'];
        $deleteLayanan = $pdo->prepare("DELETE FROM layanan WHERE id_layanan = ?");
        $deleteLayanan->execute([$idLayanan]);

        // header('Location: ./dashboard.php?filter=all&searchbox=');
        header('Location: ./admin_edit.php');
        exit();
    }
}

$layanan = "SELECT * FROM layanan";
$queryLayanan = $pdo->prepare($layanan);
$queryLayanan->execute();
$listLayanan = $queryLayanan->fetchAll(PDO::FETCH_ASSOC);


$query = $pdo->query("SELECT * FROM bidang");
$listBidang = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<body class=" w-full min-h-[100vh]">
    <!-- TABLE BIDANG -->
    <?php include 'navbar_admin.php' ?>
    <div class="flex justify-between items-start px-10 py-6">
        <div>
            <p class="text-slate-500"><?php echo date('l, F j, Y'); ?></p>
            <h1 class="text-5xl font-bold">Edit Menu</h1>
        </div>
        <div class="flex items-center">
            <h1 class="text-xl font-semibold">Hi, <?php echo $sessionAdmin ?>!</h1>
            <div class="bg-slate-100 rounded-[50%] min-h-[30px] min-w-[30px] items-center ml-3">
                <i class="fa-solid fa-user text-center p-3"></i>
            </div>
        </div>
    </div>
    <section class=" w-full px-10 pb-10 my-5 flex">
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
                    <?php if ($queryBidang->rowCount() > 1) : ?>
                        <?php foreach ($listBidang as $index => $list) : ?>
                            <?= $index == 0 ? '' :
                                '<tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                    <td class=" ">' . $list['bidang'] . '</td>
                                    <td class=" px-5"> ' . $list['deskripsi'] . ' </td>
                                    <td class=" px-3 py-1 text-slate-800 text-xs">
                                        <form action="" method="POST" class=" flex">
                                            <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <input type="hidden" name="id_bidang" value="' . $list['id_bidang'] . '">
                                            <button type="submit" class=" px-2 py-1 border border-slate-400 rounded-md bg-red-500 hover:bg-red-700 transition-all duration-300">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>'; ?>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="py-2 px-4 text-center text-gray-700">Daftar bidang masih kosong, mohon isi terlebih dahulu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr class=" mt-3 h-[0.5px] bg-slate-400 border-none">
        </div>
        <div id="formAddBidang" class=" w-[40%] rounded-md hidden">
            <div class=" w-full px-5 pb-5 shadow-xl rounded-md ">
                <h1 class=" py-5 text-2xl text-slate-700 font-semibold">Form Tambah Bidang</h1>
                <form action="" method="POST" class="flex flex-col">
                    <label for="bidang" class=" text-slate-800 font-semibold px-2 pb-2">Bidang</label>
                    <input required type="text" name="bidang" placeholder="Nama bidang baru..." class=" rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

                    <label for="deskripsiBidang" class=" text-slate-800 font-semibold px-2 pb-2">Deskripsi</label>
                    <input type="text" name="deskripsiBidang" placeholder="Deskripsi..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <section class=" flex justify-between">
                        <a id="btnCancelBidang" class=" w-[45%] border border-slate-400 hover:bg-slate-100 hover:cursor-pointer text-center text-slate-600 text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                            Cancel
                        </a>
                        <button type="" name="submitBidang" class="w-[45%] bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                            Tambahkan
                        </button>
                    </section>
                </form>
            </div>
        </div>
    </section>

    <!-- TABLE LAYANAN -->
    <section class=" w-full px-10 pb-10 flex">
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
                    <?php if ($queryLayanan->rowCount() > 1) : ?>
                        <?php foreach ($listLayanan as $index => $list) : ?>
                            <?= $index == 0 ? '' :
                                '<tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                    <td class=" ">' . $list['layanan'] . '</td>
                                    <td class=" px-5"></td>
                                    <td class=" pl-2 pr-5 py-1 text-slate-800 text-xs">
                                        <form action="" method="POST">
                                            <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <input type="hidden" name="id_layanan" value="' . $list['id_layanan'] . '">
                                            <button type="submit" class=" px-2 py-1 border border-slate-400 rounded-md bg-red-500 hover:bg-red-700 transition-all duration-300">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>'; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="py-2 px-4 text-center text-gray-700">Daftar layanan masih kosong, mohon isi terlebih dahulu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr class=" align-bottom mt-3 h-[0.5px] bg-slate-400 border-none">
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

                    <section class=" flex justify-between">
                        <a id="btnCancelLayanan" class=" w-[45%] border border-slate-400 hover:bg-slate-100 hover:cursor-pointer text-center text-slate-600 text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                            Cancel
                        </a>
                        <button type="" name="submitLayanan" class="w-[45%] bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                            Tambahkan
                        </button>
                    </section>
                </form>
            </div>
        </div>
    </section>
</body>
<div class="w-full bg-violet-300">
    <?php include '../../includes/footer.php'; ?>
</div>

<script>
    document.getElementById('btnTambahBidang').addEventListener('click', function() {
        document.getElementById('formAddBidang').classList.toggle('hidden');
    });

    document.getElementById('btnCancelBidang').addEventListener('click', function() {
        document.getElementById('formAddBidang').classList.toggle('hidden');
    });

    document.getElementById('btnTambahLayanan').addEventListener('click', function() {
        document.getElementById('formAddLayanan').classList.toggle('hidden');
    });


    document.getElementById('btnCancelLayanan').addEventListener('click', function() {
        document.getElementById('formAddLayanan').classList.toggle('hidden');
    });
</script>