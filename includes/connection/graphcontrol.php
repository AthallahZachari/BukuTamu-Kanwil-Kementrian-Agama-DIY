<?php 
include 'admincontrol.php';
include 'connection.php';

// Menentukan bulan dan tahun berdasarkan pilihan
$month = isset($_GET['month']) ? $_GET['month'] : 'this_month';
if ($month == 'last_month') {
    $monthCondition = "MONTH(tanggal) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(tanggal) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
} else {
    $monthCondition = "MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
}

// Query untuk mengambil data pengunjung per hari dalam seminggu untuk bulan yang dipilih
$queryDaily = $pdo->prepare("
    SELECT
        DAYNAME(tanggal) AS day_name,
        COUNT(*) AS visitors_count
    FROM pengunjung
    WHERE $monthCondition
    GROUP BY DAYOFWEEK(tanggal)
    ORDER BY DAYOFWEEK(tanggal)
");
$queryDaily->execute();
$dataDaily = $queryDaily->fetchAll(PDO::FETCH_ASSOC);

// Query untuk menghitung jumlah hari unik dengan pengunjung dalam bulan yang dipilih
$queryUniqueDays = $pdo->prepare("
    SELECT COUNT(DISTINCT DATE(tanggal)) AS unique_days
    FROM pengunjung
");
$queryUniqueDays->execute();
$uniqueDays = $queryUniqueDays->fetch(PDO::FETCH_ASSOC)['unique_days'];

// Hitung rata-rata pengunjung harian
if ($uniqueDays > 0) {
    $averageDailyVisitors = $totalVisitors / $uniqueDays;
    $averageDailyVisitors = round($averageDailyVisitors);
} else {
    $averageDailyVisitors = 0;
}

// Query untuk mengambil data pengunjung per minggu untuk bulan yang dipilih
$queryWeekly = $pdo->prepare("
    SELECT
        WEEK(tanggal) AS week_number,
        COUNT(*) AS visitors_count
    FROM pengunjung
    WHERE $monthCondition
    GROUP BY WEEK(tanggal)
    ORDER BY WEEK(tanggal)
");
$queryWeekly->execute();
$dataWeekly = $queryWeekly->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mengambil data pengunjung per bulan untuk tahun ini
$queryMonthly = $pdo->prepare("
    SELECT
        MONTHNAME(tanggal) AS month_name,
        COUNT(*) AS visitors_count
    FROM pengunjung
    WHERE YEAR(tanggal) = YEAR(CURDATE())
    GROUP BY MONTH(tanggal)
    ORDER BY MONTH(tanggal)
");
$queryMonthly->execute();
$dataMonthly = $queryMonthly->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mengambil data pengunjung per tahun untuk beberapa tahun terakhir
$queryYearly = $pdo->prepare("
    SELECT
        YEAR(tanggal) AS year,
        COUNT(*) AS visitors_count
    FROM pengunjung
    WHERE YEAR(tanggal) BETWEEN YEAR(CURDATE()) - 5 AND YEAR(CURDATE())
    GROUP BY YEAR(tanggal)
    ORDER BY YEAR(tanggal)
");
$queryYearly->execute();
$dataYearly = $queryYearly->fetchAll(PDO::FETCH_ASSOC);

// Query to get the number of visitors by gender
$queryGender = $pdo->prepare("
    SELECT
        jenis_kelamin AS gender,
        COUNT(*) AS visitors_count
    FROM pengunjung
    GROUP BY jenis_kelamin
");
$queryGender->execute();
$dataGender = $queryGender->fetchAll(PDO::FETCH_ASSOC);

?>