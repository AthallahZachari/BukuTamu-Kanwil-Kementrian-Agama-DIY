<?php
include '../includes/header.php';
$data = [
    ["judul" => "Permohonan Rekomendasi", "deskripsi" => "Perfect plan for Starters", "icon" => "fa-brands fa-gg-circle"],
    ["judul" => "Permohonan Rohaniwan", "deskripsi" => "For users who wants to do more", "icon" => "fa-brands fa-slack"],
    ["judul" => "Permohonan Audiensi", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-magnet"],
    ["judul" => "Permohonan Penelitian", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-paper-plane"],
    ["judul" => "Permohonan Magang", "deskripsi" => "Exploring your interest, broaden your vision", "icon" => "fa-solid fa-users"],
    ["judul" => "Konsultasi Haji", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-kaaba"],
    ["judul" => "Konsultasi Halal", "deskripsi" => "For users who wants to do more", "icon" => "fa-solid fa-shield-virus"],
];
?>

<body class="min-h-screen w-full flex flex-col items-center justify-center relative bg-fixed bg-center bg-repeat" style="background-image: url('../assets/belakang.avif');">
    <div class=" max-w-[85%] py-6 my-6 flex flex-wrap justify-evenly rounded-sm shadow-xl bg-slate-50">
        <?php foreach ($data as $row) { ?>
            <section class=" min-w-[325px] min-h-[200px] px-5 py-3 my-5 flex flex-col justify-between border border-slate-500 rounded-md bg-white">
                <div>
                    <span class=" block text-2xl">
                        <i class="<?= $row["icon"];?>"></i>
                    </span>
                    <h1 class=" text-lg text-slate-800 mt-2"><?= $row["judul"];?></h1>
                    <p class=" text-xs text-slate-500"><?= $row["deskripsi"];?></p>
                </div>
                <a href="./pages/mainmenu.php" class=" flex justify-between items-center text-slate-300 bg-green-700 hover:bg-green-800 font-semibold px-5 py-3 rounded-md transition-all duration-300">
                    Detail Info<i class="fa-solid fa-arrow-right"></i>
                </a>
            </section>
        <?php } ?>
    </div>
</body>
<?php include '../includes/footer.php' ?>