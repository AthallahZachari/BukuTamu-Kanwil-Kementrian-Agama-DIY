<?php
include '../../includes/header.php';

$message = " ";

session_start();
if (isset($_POST['login'])) {
    include '../../includes/connection/connection.php';
    $query = $pdo->prepare("SELECT * FROM pegawai WHERE username = ? AND nip = ? AND password = ?");
    $query->execute([$_POST['username'], $_POST['nip'], $_POST['password']]);
    if ($query->rowCount() > 0) {
        $_SESSION['pegawai'] = $_POST['username'];
        header("Location: ./dashboard.php");
    } else {
        $message = "Username, NIP, atau Password salah !";
    }
}
?>

<body class="min-h-screen w-full flex flex-col items-center justify-center relative bg-fixed bg-center bg-repeat" style="background-image: url('../../assets/belakang.avif');">
    <div class=" w-[50%] bg-white px-10 py-8 m-10 rounded-md shadow-xl">
        <section class=" flex flex-col justify-center items-center mb-5">
            <a href="../../index.php" class="flex justify-center">
                <div class="w-[100px] h-[100px] mr-2 bg-cover bg-center ">
                    <img src="https://gunungkidul.kemenag.go.id/asset/file_info/LOGO_KEMENAG.png" alt="logo" class=" w-full h-full object-cover ">
                </div>
            </a>
            <h1 class=" text-3xl text-slate-900 font-bold mt-2">Login</h1>
            <p class=" text-sm text-slate-500 text-center ">Login to your account below</p>
        </section>
        <form action="login.php" method="POST" class=" flex flex-col rounded-b-lg px-4 py-4">

            <label for="username" class=" text-slate-800 font-semibold px-2 pb-2">Username</label>
            <input type="text" name="username" placeholder="Username..." class=" rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

            <label for="nip" class=" text-slate-800 font-semibold px-2 pb-2">NIP</label>
            <input type="text" name="nip" placeholder="NIP..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

            <label for="password" class=" text-slate-800 font-semibold px-2 pb-2">Password</label>
            <input type="password" name="password" placeholder="Password..." class=" rounded-md px-4 py-2 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <div class=" block px-3 py-3 text-sm text-red-600">
                <p><?= $message ?></p>
            </div>
            <button type="submit" name="login" class="bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                Login
            </button>
            <a href="#" onclick="togglePopup()" class=" block font-semibold text-xs underline text-end mt-2 text-green-950">Forgot Password?</a>
        </form>
    </div>

    <!-- Popup Form -->
    <div id="popup-form" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class=" bg-gradient-to-b from-yellow-100 border to-white border-slate-200 px-7 py-3 rounded-lg shadow-xl w-[70%] md:w-[40%]">
            <a href="#" onclick="togglePopup()" class="block text-end text-slate-700">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <h2 class="text-2xl font-bold">Forgot Password</h2>
            <p class=" py-3 text-sm text-slate-500">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nec nibh molestie, efficitur arcu et, tristique tortor. Quisque id metus vel mi pellentesque ullamcorper eget imperdiet leo. </p>
        </div>
    </div>
</body>
<div class="w-full">
    <?php include '../../includes/footer.php' ?>
</div>
<script>
    function togglePopup() {
        var popup = document.getElementById("popup-form");
        popup.classList.toggle("hidden");
        popup.classList.toggle("flex");
    }
</script>