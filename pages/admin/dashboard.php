<?php
session_start();
include '../../includes/connection/connection.php';
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
        SUM(CASE WHEN jenis_kelamin = 'wanita' THEN 1 ELSE 0 END) AS females
    FROM pengunjung
");
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

// Mengambil jumlah responden dari hasil query
$totalVisitors = $result['total_visitors']; //jml total pengunjung
$weeklyCount = $result['weekly_visitor']; //jml total pengunjung
$monthlyCount = $result['monthly_visitor']; //pengunjung hari ini
$dailyCount = $result['daily_visitor']; //pengunjung hari ini
$maleCount = $result['males']; //pengunjung pria
$femaleCount = $result['females']; //pengunjung wanita
$sessionAdmin = $_SESSION['pegawai'];

?>

</head>

<body>
    <body class=" min-h-[100vh] w-full">
        <?php include 'navbar_admin.php' ?>
        <section class=" min-h-[20vh] flex justify-between items-start px-10 pt-6 ">
            <div>
                <h1 class=" text-5xl font-bold">Dashboard</h1>
                <p class=" text-slate-500"><?php echo date('l, F j, Y'); ?></p>
            </div>
            <div class=" flex items-center">
                <h1 class=" text-xl font-semibold">Hi, <?php echo $sessionAdmin ?>!</h1>
                <div class=" bg-slate-100 rounded-[50%] min-h-[30px] min-w-[30px] items-center ml-3">
                    <i class="fa-solid fa-user text-center p-3"></i>
                </div>
            </div>
        </section>
        <section class=" w-full flex px-10">

            <div class="grid grid-cols-2 gap-3 w-[50%] ">
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-user-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300 "></i>
                    <div class="flex flex-col">
                        <p class=" text-xl text-slate-800 font-semibold "><?= $dailyCount ?> orang</p>
                        <p class=" text-sm text-slate-400">Jumlah pengunjung hari ini</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300 "></i>
                    <div class="flex flex-col">
                        <p class=" text-xl text-slate-800 font-semibold "><?= $weeklyCount ?> orang</p>
                        <p class=" text-sm text-slate-400">Jumlah pengunjung minggu ini</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300 "></i>
                    <div class="flex flex-col">
                        <p class=" text-xl text-slate-800 font-semibold "><?= $monthlyCount ?> orang</p>
                        <p class=" text-sm text-slate-400">Jumlah pengunjung bulanan</p>
                    </div>
                </div>
                <div class="flex items-center p-4 rounded-md shadow-md">
                    <i class="fa-solid fa-layer-group text-xl mr-3 p-4 rounded-[50%] border border-slate-300 "></i>
                    <div class="flex flex-col">
                        <p class=" text-xl text-slate-800 font-semibold "><?= $totalVisitors ?> orang</p>
                        <p class=" text-sm text-slate-400">Jumlah total pengunjung</p>
                    </div>
                </div>
                <!-- <div class="bg-gray-400 p-4">Item 3</div>
                <div class="bg-gray-500 p-4">Item 4</div> -->
            </div>
        </section>
        <section class=" px-10">
            <?php include './table.php';?>
        </section>
    </body>
    <div class=" w-full bg-violet-300">
        <?php include '../../includes/footer.php'; ?>
    </div>