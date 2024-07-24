<?php
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    session_start();
}

$sessionAdmin = $_SESSION['pegawai'];
?>
<div class=" sticky top-0 z-10 bg-glass-bg backdrop-blur-sm shadow-lg w-full m-auto px-10 py-4 flex justify-between items-center">
    <div class=" flex align-middle items-center">
        <div class="w-[40px] h-[40px] mr-2 bg-cover bg-center ">
            <img src="https://gunungkidul.kemenag.go.id/asset/file_info/LOGO_KEMENAG.png" alt="logo" class=" w-full h-full object-cover ">
        </div>
        <h1 class=" font-bold text-slate-700 text-lg">KANWIL KEMENAG DIY</h1>
    </div>
    <nav>
        <ul class="flex">
            <li><a href="#aboutus" class=" text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Tentang Kami</a></li>
            <li><a href="#kontakkami" class=" text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Kontak Kami</a></li>
            <li><a href="#media" class=" text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Link Kami</a></li>
            <li><a href="#" onclick="togglePopup()" class=" hover:bg-slate-100 text-green-800 font-semibold border hover:border-slate-400 px-4 py-2 ml-2 rounded-md transition-all duration-300"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
        </ul>
    </nav>
</div>
<div id="popup-form" class="fixed inset-0 items-center justify-center z-20 bg-black bg-opacity-50 hidden">
    <div class=" bg-white flex flex-col justify-center items-center px-7 py-7 rounded-lg shadow-xl w-[70%] md:w-[35%]">
        <div class=" min-h-48 w-[50%] bg-black bg-cover bg-center" style="background-image: url('../../assets/logout.avif')"></div>
        <h2 class=" text-slate-700 text-2xl font-bold mb-5">Anda yakin keluar?</h2>
        <div class=" w-full flex justify-around font-medium">
            <a href="#" onclick="togglePopup()" class=" hover:bg-slate-100 transition-all duration-300 border border-slate-300 rounded-md text-slate-500 text-center min-w-[45%] px-5 py-2">Batal</a>
            <a href="../../includes/connection/logout.php" class=" bg-red-500 hover:bg-red-600 transition-all duration-300 rounded-md text-slate-200 text-center min-w-[45%] px-5 py-2">Logout</a>
        </div>
    </div>
</div>
<script src="./script.js"></script>
<script>
    function togglePopup() {
        var popup = document.getElementById("popup-form");
        popup.classList.toggle("hidden");
        popup.classList.toggle("flex");
    }
</script>