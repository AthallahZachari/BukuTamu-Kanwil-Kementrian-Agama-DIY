<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    header("Location: ../../index.php");
    exit();
}

// Tanggal yang ingin Anda hitung jumlah respondennya
$tanggal = date('Y-m-d');

// Query untuk menghitung jumlah responden berdasarkan tanggal
$stmt = $pdo->prepare("SELECT COUNT(*) AS visitors FROM pengunjung WHERE tanggal = ?");
$stmt->execute([$tanggal]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Mengambil jumlah responden dari hasil query
$visitorCount = $result['visitors'];
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
        <section class=" w-[60%] min-h-[30vh] flex justify-between px-10">
            <div class=" min-w-[50%] flex flex-col rounded-md px-3 py-2 bg-white shadow-lg">
                <h1 class=" text-lg text-center font-semibold ">Tamu Hari Ini</h1>
                <h1><?php echo $visitorCount; ?></h1>
            </div>
        </section>
        <section>

        </section>
        <section class=" px-10">
            <?php include './table.php' ?>
        </section>
    </body>
    <div class=" w-full bg-violet-300">
        <?php include '../../includes/footer.php'; ?>
    </div>