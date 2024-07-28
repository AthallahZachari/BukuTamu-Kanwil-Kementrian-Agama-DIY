<?php
session_start();
include '../../includes/connection/connection.php';
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    header("Location: ../../index.php");
    exit();
}
$sessionAdmin = $_SESSION['pegawai'];

?>

</head>

<body class="w-full min-h-[100vh]">
    <div>
        <?php include 'navbar_admin.php' ?>
        <section class="min-h-[20vh] flex justify-between items-start px-10 pt-6">
            <div>
                <p class="text-slate-500"><?php echo date('l, F j, Y'); ?></p>
                <h1 class="text-5xl font-bold">Dashboard</h1>
            </div>
            <div class="flex items-center">
                <h1 class="text-xl font-semibold">Hi, <?php echo $sessionAdmin ?>!</h1>
                <div class="bg-slate-100 rounded-[50%] min-h-[30px] min-w-[30px] items-center ml-3">
                    <i class="fa-solid fa-user text-center p-3"></i>
                </div>
            </div>
        </section>
        <section class="w-full flex px-10 pb-6 hidden">
            <div class="grid grid-cols-4 gap-3 w-[80%]">
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
                        <p class="text-xl text-slate-800 font-bold "><?= $totalVisitors ?> orang</p>
                        <p class="text-sm text-slate-400">Jumlah total pengunjung</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-10">
            <?php include './graph.php';?>
        </section>
        <section class=" px-10">
            <?php include './table.php'; ?>
        </section>
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