<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    header("Location: ../../index.php");
    exit();
}

// Query untuk menghitung jumlah responden berdasarkan tanggal dan jumlah gender
$query = $pdo->prepare("
    SELECT
        COUNT(*) AS total_visitors,
        SUM(CASE WHEN tanggal = CURDATE() THEN 1 ELSE 0 END) AS daily_visitor,
        SUM(CASE WHEN YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS weekly_visitor,
        SUM(CASE WHEN MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS monthly_visitor,
        SUM(CASE WHEN jenis_kelamin = 'pria' THEN 1 ELSE 0 END) AS males,
        SUM(CASE WHEN jenis_kelamin = 'wanita' THEN 1 ELSE 0 END) AS females,
        SUM(CASE WHEN progres = 'unassigned' THEN 1 ELSE 0 END) AS new_entries
    FROM pengunjung
");
$query->execute();
$resultCountVisitor = $query->fetch(PDO::FETCH_ASSOC);

// Mengambil jumlah responden dari hasil query
$totalVisitors = $resultCountVisitor['total_visitors']; //jml total pengunjung
$weeklyCount = $resultCountVisitor['weekly_visitor']; //jml total pengunjung mingguan
$monthlyCount = $resultCountVisitor['monthly_visitor']; //jml total pengunjung bulanan
$dailyCount = $resultCountVisitor['daily_visitor']; //jml total pengunjung harian
$maleCount = $resultCountVisitor['males']; //pengunjung pria
$femaleCount = $resultCountVisitor['females']; //pengunjung wanita
$newEntriesCount = $resultCountVisitor['new_entries']; //formulir baru
$sessionAdmin = $_SESSION['pegawai'];

?>

</head>

<body class="w-full min-h-[100vh]">
    <div>
        <?php include 'navbar_admin.php' ?>
        <section class="min-h-[20vh] flex justify-between items-start px-10 pt-6">
            <div>
                <h1 class="text-5xl font-bold">Dashboard</h1>
                <p class="text-slate-500"><?php echo date('l, F j, Y'); ?></p>
            </div>
            <div class="flex items-center">
                <h1 class="text-xl font-semibold">Hi, <?php echo $sessionAdmin ?>!</h1>
                <div class="bg-slate-100 rounded-[50%] min-h-[30px] min-w-[30px] items-center ml-3">
                    <i class="fa-solid fa-user text-center p-3"></i>
                </div>
            </div>
        </section>
        <section class="w-full flex px-10">
            <div class="grid grid-cols-4 gap-3 w-[80%]">
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-user-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300"></i>
                    <div class="flex flex-col">
                        <p class="text-xl text-slate-800 font-bold "><?= $dailyCount ?> orang</p>
                        <p class="text-sm text-slate-400">Pengunjung hari ini</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300"></i>
                    <div class="flex flex-col">
                        <p class="text-xl text-slate-800 font-bold "><?= $newEntriesCount ?> form</p>
                        <p class="text-sm text-slate-400">Formulir tanpa bidang</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300"></i>
                    <div class="flex flex-col">
                        <p class="text-xl text-slate-800 font-bold "><?= $weeklyCount ?> orang</p>
                        <p class="text-sm text-slate-400">Jumlah pengunjung minggu ini</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300"></i>
                    <div class="flex flex-col">
                        <p class="text-xl text-slate-800 font-bold "><?= $totalVisitors ?> orang</p>
                        <p class="text-sm text-slate-400">Jumlah total pengunjung</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tombol pilihan -->
        <section class=" w-[30%] px-3 mt-3 flex justify-evenly shadow-md mx-10 rounded-md">
            <button id="tableBtn" class=" text-slate-800 px-4 py-3  border-b-2 border-green-500">Tampilkan Tabel</button>
            <button id="editBtn" class=" text-slate-800 px-4 py-3 ">Tampilkan Edit</button>
        </section>
        <div class="my-3">
            <section id="admin-table" class="px-10">
                <?php include './table.php'; ?>
            </section>
            <section id="show-edit" class=" px-10 hidden">
                <?php include './admin_edit.php'; ?>
            </section>
        </div>
    </div>
</body>

<div class="w-full bg-violet-300">
    <?php include '../../includes/footer.php'; ?>
</div>

<script>
    document.getElementById('tableBtn').addEventListener('click', function() {
        document.getElementById('admin-table').classList.remove('hidden');
        document.getElementById('show-edit').classList.add('hidden');
        document.getElementById('tableBtn').classList.add('border-b-2', 'border-green-500');
        document.getElementById('editBtn').classList.remove('border-b-2', 'border-green-500');
    });

    document.getElementById('editBtn').addEventListener('click', function() {
        document.getElementById('show-edit').classList.remove('hidden');
        document.getElementById('admin-table').classList.add('hidden');
        document.getElementById('editBtn').classList.add('border-b-2', 'border-green-500');
        document.getElementById('tableBtn').classList.remove('border-b-2', 'border-green-500');
    });
</script>