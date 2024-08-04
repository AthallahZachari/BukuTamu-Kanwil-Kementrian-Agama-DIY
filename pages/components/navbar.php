<?php
include 'includes/header.php';
?>
<div class="bg-slate-100 w-full px-4 py-3 flex flex-col md:flex-row items-center justify-between relative">
    <div class="flex items-center mb-3 md:mb-0">
        <a href="index.php" class="flex items-center">
            <div class="w-[40px] h-[40px] mr-2 bg-cover bg-center">
                <img src="https://gunungkidul.kemenag.go.id/asset/file_info/LOGO_KEMENAG.png" alt="logo" class="w-full h-full object-cover">
            </div>
            <h1 class="font-bold text-slate-700 text-base md:text-lg">KANTOR WILAYAH KEMENTRIAN D.I.YOGYAKARTA</h1>
        </a>
    </div>
    <div class="relative md:hidden">
        <button id="menu-button" class="text-slate-600 hover:text-black focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <nav class="hidden md:flex">
        <ul class="flex space-x-4 items-center">
            <li><a href="#aboutus" class="text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Tentang Kami</a></li>
            <li><a href="#kontakkami" class="text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Kontak Kami</a></li>
            <li><a href="#media" class="text-sm px-3 text-slate-600 hover:text-black hover:font-semibold">Link Kami</a></li>
            <li><a href="./pages/admin/login.php" class="bg-slate-100 hover:bg-slate-200 text-green-800 font-semibold border border-slate-400 px-5 py-2 rounded-md transition-all duration-300"><i class="fa-solid fa-user-tie pr-2"></i>Login</a></li>
        </ul>
    </nav>

    <!-- [ RESPONSIVE ] -->
    <!--  -->
    <nav id="menu" class="absolute top-[100%] w-full mt-2 bg-slate-100 shadow-lg hidden md:hidden">
        <ul class="flex flex-col items-center w-[50%] py-3 mx-auto ">
            <li><a href="#aboutus" class="block px-4 py-2 text-slate-600 hover:bg-gray-100">Tentang Kami</a></li>
            <li><a href="#kontakkami" class="block px-4 py-2 text-slate-600 hover:bg-gray-100">Kontak Kami</a></li>
            <li><a href="#media" class="block px-4 py-2 text-slate-600 hover:bg-gray-100">Link Kami</a></li>
            <!-- <li><a href="./pages/admin/login.php" class="block m-2 px-6 py-2 bg-slate-100 hover:bg-slate-200 text-green-800 font-semibold border border-slate-400 rounded-md transition-all duration-300"><i class="fa-solid fa-user-tie pr-2"></i>Login</a></li> -->
        </ul>
    </nav>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('menu-button');
        const menu = document.getElementById('menu');

        menuButton.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });

        // Optional: Close the menu if clicking outside of it
        document.addEventListener('click', function(event) {
            if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    });
</script>