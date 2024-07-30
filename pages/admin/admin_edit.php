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
            header('Location: ./admin_edit.php');
            exit();
        }
    }

    // [ DELETE ] list bidang
    if (isset($_POST['delete_bidang'])) {
        $idBidang = $_POST['delete_bidang'];
        $deleteBidang = $pdo->prepare("DELETE FROM bidang WHERE id_bidang = ?");
        $deleteBidang->execute([$idBidang]);

        header('Location: ./admin_edit.php');
        exit();
    }

    // [ UPDATE ] list bidang
    if (isset($_POST['submitEditBidang'])) {
        $idEditBidang = $_POST['edit_id_bidang'];
        $namaBidang = $_POST['edit_bidang'];
        $deskripsiBidang = $_POST['edit_deskripsi'];
        $updateBidang = $pdo->prepare("UPDATE `bidang` SET `bidang` = ?, `deskripsi` = ? WHERE `id_bidang` = ?");
        $updateBidang->execute([$namaBidang, $deskripsiBidang, $idEditBidang]);

        header('Location: ./admin_edit.php');
        exit();
    }

    // [ POST ] list layanan
    if (isset($_POST['submitLayanan'])) {
        $insertLayanan = $pdo->prepare("INSERT INTO layanan (layanan, deskripsi) VALUES (?, ?)");
        $insertLayanan->execute([$_POST['newLayanan'], $_POST['newDeskripsi']]);

        if ($insertLayanan->rowCount() > 0) {
            header('Location: ./admin_edit.php');
            exit();
        }
    }

    // [ DELETE ] list layanan
    if (isset($_POST['delete_layanan'])) {
        $idLayanan = $_POST['delete_layanan'];
        $deleteLayanan = $pdo->prepare("DELETE FROM layanan WHERE id_layanan = ?");
        $deleteLayanan->execute([$idLayanan]);

        header('Location: ./admin_edit.php');
        exit();
    }

    // [ UPDATE ] list layanan
    if (isset($_POST['submitEditLayanan'])) {
        $idEditLayanan = $_POST['edit_id_layanan'];
        $namaLayanan = $_POST['edit_layanan'];
        $deskripsiLayanan = $_POST['edit_deskripsi_layanan'];
        $updateLayanan = $pdo->prepare("UPDATE `layanan` SET `layanan` = ?, `deskripsi` = ? WHERE `id_layanan` = ?");
        $updateLayanan->execute([$namaLayanan, $deskripsiLayanan, $idEditLayanan]);

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

<body class="w-full min-h-[100vh]">
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
    <section class="w-full px-10 pb-10 my-5 flex">
        <div class="w-[57%] mr-10 px-5 pb-6 rounded-lg shadow-xl">
            <section class="py-5 flex justify-between items-center">
                <h1 class="text-2xl text-slate-700 font-semibold">Daftar Bidang</h1>
                <button id="btnTambahBidang" class="bg-green-700 hover:bg-green-900 px-3 py-2 rounded-md text-slate-100 transition-all duration-300">
                    <i class="fa-solid fa-plus mr-2"></i>Bidang Baru
                </button>
            </section>
            <table class="text-sm overflow-x-auto table-auto w-full">
                <thead>
                    <tr>
                        <th class="py-4 pl-5 pr-2 text-left font-medium border-y border-slate-400 text-slate-500">Bidang</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($query->rowCount() > 1) : ?>
                        <?php foreach (array_slice($listBidang, 1) as $data) {
                            $idBidang = $data['id_bidang'];
                        ?>
                            <tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                <td class=""><?= htmlspecialchars($data['bidang']) ?></td>
                                <td class="px-5"><?= htmlspecialchars($data['deskripsi']) ?></td>
                                <td class=" flex px-3 py-1 text-slate-800 text-xs">

                                    <!-- TOMBOL EDIT BIDANG -->
                                    <button onclick="showEditFormBidang(<?= $idBidang ?>, '<?= htmlspecialchars($data['bidang']) ?>', '<?= htmlspecialchars($data['deskripsi']) ?>')" class="px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- TOMBOL DELETE BIDANG -->
                                    <button onClick="showWarningBidang(<?= $idBidang?>)" class=" px-2 py-1 ml-2 bg-red-500 hover:bg-red-700 border border-slate-400 rounded-md transition-all duration-300"><i class="fa-solid fa-ban"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="py-2 px-4 text-center text-gray-700">Daftar bidang masih kosong, mohon isi terlebih dahulu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr class="mt-3 h-[0.5px] bg-slate-400 border-none">
        </div>
        <div id="formAddBidang" class="w-[40%] rounded-md hidden">
            <div class="w-full px-5 pb-5 shadow-xl rounded-md ">
                <h1 class="py-5 text-2xl text-slate-700 font-semibold">Form Tambah Bidang</h1>
                <form action="" method="POST" class="flex flex-col">
                    <label for="bidang" class="text-slate-800 font-semibold px-2 pb-2">Bidang</label>
                    <input required type="text" name="bidang" placeholder="Nama bidang baru..." class="rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <label for="deskripsiBidang" class="text-slate-800 font-semibold px-2 pb-2">Deskripsi</label>
                    <input type="text" name="deskripsiBidang" placeholder="Deskripsi..." class="rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <section class="flex justify-between">
                        <a id="btnCancelBidang" class="w-[45%] border border-slate-400 hover:bg-slate-100 hover:cursor-pointer text-center text-slate-600 text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">Cancel</a>
                        <button type="submit" name="submitBidang" class="w-[45%] bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">Tambahkan</button>
                    </section>
                </form>
            </div>
        </div>
    </section>

    <!-- TABLE LAYANAN -->
    <section class="w-full px-10 pb-10 flex">
        <div class="w-[57%] mr-10 px-5 pb-6 rounded-lg shadow-xl">
            <section class="py-5 flex justify-between items-center">
                <h1 class="text-2xl text-slate-700 font-semibold">Daftar Layanan</h1>
                <button id="btnTambahLayanan" class="bg-green-700 hover:bg-green-900 px-3 py-2 rounded-md text-slate-100 transition-all duration-300">
                    <i class="fa-solid fa-plus mr-2"></i>Layanan Baru
                </button>
            </section>
            <table class="text-sm overflow-x-auto table-auto w-full">
                <thead>
                    <tr>
                        <th class="py-4 pl-5 pr-2 text-left font-medium border-y border-slate-400 text-slate-500">Layanan</th>
                        <th class="py-4 px-5 text-left font-medium border-y border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-5 text-end font-medium border-y border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryLayanan->rowCount() > 0) : ?>
                        <?php foreach (array_slice($listLayanan, 1) as $layanan) {
                            $idLayanan = $layanan['id_layanan'];
                        ?>

                            <tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                <td class=""><?= htmlspecialchars($layanan['layanan']) ?></td>
                                <td class=" px-5"><?= htmlspecialchars($layanan['deskripsi']) ?></td>
                                <td class=" flex justify-end px-3 py-1 text-slate-800 text-xs ">

                                    <!-- EDIT BUTTON -->
                                    <button onclick="showEditFormLayanan(<?= $layanan['id_layanan'] ?>, '<?= htmlspecialchars($layanan['layanan']) ?>', '<?= htmlspecialchars($layanan['deskripsi']) ?>')" class="px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- DELETE BUTTON -->
                                    <button onClick="showWarning(<?= $layanan['id_layanan'] ?>)" class=" px-2 py-1 ml-2 bg-red-500 hover:bg-red-700 border border-slate-400 rounded-md transition-all duration-300"><i class="fa-solid fa-ban"></i></button>

                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="py-2 px-4 text-center text-gray-700">Daftar layanan masih kosong, mohon isi terlebih dahulu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr class="mt-3 h-[0.5px] bg-slate-400 border-none">
        </div>
        <div id="formAddLayanan" class="w-[40%] rounded-md hidden">
            <div class="w-full px-5 pb-5 shadow-xl rounded-md ">
                <h1 class="py-5 text-2xl text-slate-700 font-semibold">Form Tambah Layanan</h1>
                <form action="" method="POST" class="flex flex-col">
                    <label for="newLayanan" class="text-slate-800 font-semibold px-2 pb-2">Layanan</label>
                    <input required type="text" name="newLayanan" placeholder="Nama layanan baru..." class="rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <label for="newDeskripsi" class="text-slate-800 font-semibold px-2 pb-2">Deskripsi</label>
                    <input required type="text" name="newDeskripsi" placeholder="Deskripsi..." class="rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <section class="flex justify-between">
                        <a id="btnCancelLayanan" class="w-[45%] border border-slate-400 hover:bg-slate-100 hover:cursor-pointer text-center text-slate-600 text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">Cancel</a>
                        <button type="submit" name="submitLayanan" class="w-[45%] bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">Tambahkan</button>
                    </section>
                </form>
            </div>
        </div>
    </section>
</body>

<!-- Form Editing Bidang -->
<div id="modalEditBidang" class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-5 min-w-[40%]">
        <h2 class="text-2xl text-slate-700 font-semibold py-5 mb-4">Edit Bidang</h2>
        <form action="" method="POST" id="formEditBidang" class=" ">
            <input type="hidden" name="edit_id_bidang" id="edit_id_bidang">
            <label for="edit_bidang" class=" mb-2 px-2 block text-sm font-medium text-gray-700">Bidang</label>
            <input type="text" name="edit_bidang" id="edit_bidang" class=" w-full rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <label for="edit_deskripsi" class=" mb-2 px-2 block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" name="edit_deskripsi" id="edit_deskripsi" class=" w-full rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <div class="grid grid-cols-2">
                <button type="button" class=" px-4 py-2 mr-3 border border-gray-300 rounded-md text-slate-600 hover:bg-gray-100" onclick="hideEditForm('modalEditBidang')">Cancel</button>
                <button type="submit" name="submitEditBidang" class=" px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-900">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Warning Sign on Delete Bidang -->
<div id="bidangDeleteWarning" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class=" bg-red-100 rounded-lg p-5 min-w-[35%]">
        <h2 class="text-2xl text-slate-800 font-bold mb-2"><i class="fa-solid fa-circle-exclamation text-red-500 mr-3"></i>Hapus Bidang</h2>
        <p class=" text-sm text-slate-600">Bidang akan dihapus dari daftar, dan formulir dengan bidang terkait akan ikut terhapus</p>
        <p class=" text-sm text-slate-600 mb-5">Anda yakin menghapus?</p>
        <section class="  w-[40%] grid grid-cols-2">
            <button onclick="hideEditForm('bidangDeleteWarning')" class="p-5 py-2 mr-2 text-slate-800 font-semibold rounded-md bg-white hover:bg-slate-200 transition-all duration-300">Batal</button>
            <form action="" method="POST" class="inline">
                <input type="hidden" name="delete_bidang" value="<?= $idBidang ?>">
                <button type="submit" class="p-3 text-slate-800 font-semibold rounded-md bg-red-500 hover:bg-red-700 w-full transition-all duration-300">
                    Hapus
                </button>
            </form>
        </section>

    </div>
</div>

<!-- Modal for Editing Layanan -->
<div id="modalEditLayanan" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-5 min-w-[40%]">
        <h2 class="text-xl font-semibold mb-4">Edit Layanan</h2>
        <form action="" method="POST" id="formEditLayanan">
            <input type="hidden" name="edit_id_layanan" id="edit_id_layanan">
            <label for="edit_layanan" class="px-2 mb-2 block text-sm font-medium text-gray-700">Layanan</label>
            <input type="text" name="edit_layanan" id="edit_layanan" class=" w-full rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <label for="edit_layanan" class="px-2 mb-2 block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" name="edit_deskripsi_layanan" id="edit_deskripsi_layanan" class=" w-full rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <div class="grid grid-cols-2">
                <button type="button" class=" px-4 py-2 mr-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100" onclick="hideEditForm('modalEditLayanan')">Cancel</button>
                <button type="submit" name="submitEditLayanan" class=" px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-900">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Warning Sign on Delete Layanan -->
<div id="layananDeleteWarning" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
    <div class=" bg-red-100 rounded-lg p-5 min-w-[35%]">
        <h2 class="text-2xl text-slate-800 font-bold mb-2"><i class="fa-solid fa-circle-exclamation text-red-500 mr-3"></i>Hapus Layanan</h2>
        <p class=" text-sm text-slate-600">Layanan akan terhapus dari daftar, dan formulir dengan layanan terkait akan ikut terhapus</p>
        <p class=" text-sm text-slate-600 mb-5">Anda yakin menghapus?</p>
        <section class="  w-[40%] grid grid-cols-2">
            <button onclick="hideEditForm('layananDeleteWarning')" class="p-2 mr-2 text-slate-800 font-semibold rounded-md border border-gray-300 bg-white hover:bg-slate-200 transition-all duration-300">Batal</button>
            <form action="" method="POST" class="inline">
                <input type="hidden" name="delete_layanan" value="<?= $idLayanan ?>">
                <button type="submit" class="p-2 text-slate-800 font-semibold rounded-md bg-red-500 hover:bg-red-700 w-full transition-all duration-300">
                    Hapus
                </button>
            </form>
        </section>

    </div>
</div>

<script>
    document.getElementById('btnTambahBidang').addEventListener('click', () => {
        document.getElementById('formAddBidang').classList.toggle('hidden');
    });

    document.getElementById('btnTambahLayanan').addEventListener('click', () => {
        document.getElementById('formAddLayanan').classList.toggle('hidden');
    });

    document.getElementById('btnCancelBidang').addEventListener('click', () => {
        document.getElementById('formAddBidang').classList.add('hidden');
    });

    document.getElementById('btnCancelLayanan').addEventListener('click', () => {
        document.getElementById('formAddLayanan').classList.add('hidden');
    });

    function showEditFormBidang(id, bidang, deskripsi) {
        document.getElementById('edit_id_bidang').value = id;
        document.getElementById('edit_bidang').value = bidang;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('modalEditBidang').classList.remove('hidden');
    }

    function showEditFormLayanan(id, layanan, deskripsi) {
        document.getElementById('edit_id_layanan').value = id;
        document.getElementById('edit_layanan').value = layanan;
        document.getElementById('edit_deskripsi_layanan').value = deskripsi;
        document.getElementById('modalEditLayanan').classList.remove('hidden');
    }

    function showWarningBidang(id) {
        document.getElementById('edit_id_bidang').value = id;
        document.getElementById('bidangDeleteWarning').classList.remove('hidden');
    }

    function showWarning(id) {
        document.getElementById('edit_id_layanan').value = id;
        document.getElementById('layananDeleteWarning').classList.remove('hidden');
    }

    function hideEditForm(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    document.querySelectorAll('#btnShowWarning').addEventListener('click', () => {
        document.getElementById('layananDeleteWarning').classList.remove('hidden');
    });
</script>