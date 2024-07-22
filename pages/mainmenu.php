<?php
include '../includes/connection/connection.php';
include '../includes/header.php';

$sql = "SELECT * FROM  bidang";

$query = $pdo->prepare($sql);
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

// $data = [
//     ["judul" => "Bagian Tata Usaha", "deskripsi" => "Perfect plan for Starters", "icon" => "fa-brands fa-gg-circle"],
//     ["judul" => "Bagian Pendidikan Agama dan Keagamaan Islam", "deskripsi" => "For users who wants to do more", "icon" => "fa-brands fa-slack"],
//     ["judul" => "Bagian Penyelenggaraan Haji dan Umroh", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-magnet"],
//     ["judul" => "Bagian Urusan Agama Islam", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-paper-plane"],
//     ["judul" => "Bagian Penyiaran Agama Islam dan Zakat Wakaf", "deskripsi" => "Exploring your interest, broaden your vision", "icon" => "fa-solid fa-users"],
//     ["judul" => "Bagian Pendidikan Madrasah", "deskripsi" => "Exploring your interest, broaden your vision", "icon" => "fa-solid fa-users"],
//     ["judul" => "Bimas Kristen", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-kaaba"],
//     ["judul" => "Bimas Katolik", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-shield-virus"],
//     ["judul" => "Bimas Hindu", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-kaaba"],
//     ["judul" => "Bimas Buddha", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-kaaba"],
//     ["judul" => "Bimas Konghucu", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-kaaba"],
// ];
?>

<body class="min-h-screen w-full flex flex-col items-center justify-center relative bg-fixed bg-center bg-repeat" style="background-image: url('../assets/belakang.avif');">
    <div class=" max-w-[85%] py-6 my-6 flex flex-wrap justify-evenly rounded-sm shadow-xl bg-slate-50">
        <?php foreach ($rows as $row) { ?>
            <section class=" w-[300px] min-h-[200px] px-5 py-3 my-5 flex flex-col justify-between border border-slate-500 rounded-md bg-white">
                <div>
                    <h1 class=" text-xl font-bold text-slate-800 mt-2"><?= $row["bidang"];?></h1>
                    <p class=" text-xs text-slate-500"><?= $row["deskripsi"];?></p>
                </div>
                <a href="./pages/mainmenu.php" class=" flex justify-between items-center text-slate-300 bg-green-700 hover:bg-green-800 font-semibold px-5 py-3 rounded-md transition-all duration-300">
                    Detail Info<i class="fa-solid fa-arrow-right"></i>
                </a>
            </section>
        <?php } ?>
    </div>
</body>
<div class=" w-full">
    <?php include '../includes/footer.php' ?>
</div>