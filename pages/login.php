<?php include '../includes/header.php' ?>

<body class="min-h-[100vh] w-full flex flex-col justify-center items-center">
    <div class=" w-[50%] bg-white px-10 py-8 m-10 rounded-md shadow-xl">
        <section class=" flex flex-col justify-center items-center">
            <a href="../index.php" class="flex justify-center">
                <div class="w-[100px] h-[100px] mr-2 bg-cover bg-center ">
                    <img src="https://gunungkidul.kemenag.go.id/asset/file_info/LOGO_KEMENAG.png" alt="logo" class=" w-full h-full object-cover ">
                </div>
            </a>
            <h1 class=" text-3xl text-slate-900 font-bold py-2">Selamat Datang Kembali</h1>
            <p class=" text-sm text-slate-500 text-center ">Glad to see you again<br> Login to your account below</p>
        </section>
        <form action="login.php" method="POST" class=" flex flex-col rounded-b-lg px-4 py-4">

            <label for="username" class=" text-slate-800 font-semibold px-2 pb-2">Username</label>
            <input type="text" name="username" placeholder="Username..." class=" rounded-md px-4 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

            <label for="nip" class=" text-slate-800 font-semibold px-2 pb-2">NIP</label>
            <input type="text" name="nip" placeholder="NIP..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

            <label for="password" class=" text-slate-800 font-semibold px-2 pb-2">Password</label>
            <input type="password" name="password" placeholder="Password..." class=" rounded-md px-4 py-2 mb-6 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">

            <button type="submit" name="login" class="bg-green-700 hover:bg-green-900 text-white text-lg font-semibold px-8 py-3 rounded-md transition-all duration-300">
                Login
            </button>
        </form>
        <p class=" px-6 text-sm text-end text-slate-500 font-semibold">Don't have any account? <a href="#" class=" font-bold text-green-800">Sign up</a> for free</p>
    </div>
    <?php
    session_start();
    if (isset($_POST['login'])) {
        include '../includes/connection/connection.php';
        $query = $pdo->prepare("SELECT * FROM pegawai WHERE username = ? AND nip = ? AND password = ?");
        $query->execute([$_POST['username'], $_POST['nip'], $_POST['password']]);
        if ($query->rowCount() > 0) {
            $_SESSION['pegawai'] = $_POST['username'];
            // echo '<script>
            //       var snackbar = document.getElementById("snackbar");
            //       snackbar.className = "show";
            //       setTimeout(function() {
            //           snackbar.className = snackbar.className.replace("show", "");
            //           window.location.href = "pegawai.php";
            //       }, 3000);
            //   </script>';
            header("Location: ./admin/dashboard.php");
        } else {
            echo "Username, NIP, atau Password salah.";
        }
    }
    ?>

</body>
<div class="w-full">
    <?php include '../includes/footer.php' ?>
</div>