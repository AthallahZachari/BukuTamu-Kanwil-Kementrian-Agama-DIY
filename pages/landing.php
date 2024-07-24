<?php
// Include your database connection file
include './includes/connection/connection.php';
include './includes/header.php';

// Tanggal yang ingin Anda hitung jumlah respondennya
$tanggal = date('Y-m-d');

// Query untuk menghitung jumlah responden berdasarkan tanggal
$stmt = $pdo->prepare("SELECT COUNT(*) AS visitors FROM pengunjung WHERE tanggal = ?");
$stmt->execute([$tanggal]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Mengambil jumlah responden dari hasil query
$visitorCount = $result['visitors'];
?>

<div class="relative h-screen bg-fixed bg-center bg-no-repeat bg-cover" style="background-image: url('assets/samantari.jpg');">
  <div class="absolute inset-0 bg-black opacity-70"></div>
  <div class="relative h-full px-10 ">
    <?php include 'components/navbar.php'; ?>
    <div class="w-[80%] min-h-[90vh] m-auto flex flex-col items-center justify-evenly">
      <section class="w-[70%] flex flex-col justify-center items-center">
        <h1 class="font-bold text-4xl text-slate-200 text-center w-full">
          Selamat Datang di Buku Tamu Kanwil Kemenag D.I.Yogyakarta
        </h1>
        <div class="pt-5 flex justify-center">
          <!-- ./pages/pengunjung/pengunjung.php -->
          <a href="./pages/pengunjung/pengunjung.php" class="text-slate-300 text-xl font-bold bg-green-800 hover:bg-green-950 px-8 py-5 rounded-md transition-all duration-300">
            <i class="fa-regular fa-user mr-3"></i>Klik Disini
          </a>
        </div>
      </section>
      <section class="w-[25%] px-5 py-2 bg-white bg-opacity-10 backdrop-blur-sm rounded-md shadow-xl grid grid-rows-4">
        <div class=" text-sm text-slate-300 text-end">
          <p class="text-slate-200"><?php echo date('l, F j, Y'); ?></p>
        </div>
        <div class=" row-span-2 mt-5 text-center">
          <p class="text-6xl text-slate-300 font-bold"><?php echo $visitorCount; ?></p>
          <p class="text-slate-400 mt-2">Pengunjung Hari Ini</p>
        </div>
      </section>
    </div>
  </div>
</div>
