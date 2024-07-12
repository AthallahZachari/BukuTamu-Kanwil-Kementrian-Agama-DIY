<?php
include '../../includes/header.php';

if (!isset($_SESSION['pegawai'])) {
    session_start();
}

$sessionAdmin = $_SESSION['pegawai'];
?>
<div class=" sticky top-0 z-50 bg-glass-bg backdrop-blur-sm shadow-lg w-full m-auto px-10 py-4 flex justify-between items-center">
    <div class=" flex align-middle items-center">
        <div class="w-[40px] h-[40px] mr-2 bg-cover bg-center ">
            <img src="https://gunungkidul.kemenag.go.id/asset/file_info/LOGO_KEMENAG.png" alt="logo" class=" w-full h-full object-cover ">
        </div>
        <h1 class=" font-bold text-slate-700 text-lg">KANWIL KEMENAG DIY</h1>
    </div>
    <nav>
        <ul class="flex">
            <li><a href="../login.php" class=" text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">About Us</a></li>
            <li><a href="#" class=" text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Contact Us</a></li>
            <li><a href="../../includes/connection/logout.php" class=" hover:bg-red-300 text-green-800 font-semibold border border-slate-400 px-4 py-2 ml-2 rounded-md transition-all duration-300"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Logout</a></li>
        </ul>
    </nav>
</div>