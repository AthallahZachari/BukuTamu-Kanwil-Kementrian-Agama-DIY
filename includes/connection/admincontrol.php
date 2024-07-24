<?php
include 'connection.php';

//  === QUERY ===
//
// 
// [ SET ] jumlah halaman
$limit = 10;

// [ REQ ] params URL
$searchbox = isset($_GET['searchbox']) ? $_GET['searchbox'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filterLayanan = isset($_POST['filterLayanan']) ? $_POST['filterLayanan'] : '';


// [ SET ] current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;


// [ GET ] list layanan
$layanan = "SELECT * FROM layanan";
$queryLayanan = $pdo->prepare($layanan);
$queryLayanan->execute();
$listLayanan = $queryLayanan->fetchAll(PDO::FETCH_ASSOC);


// [ GET ] list bidang
$bidang = "SELECT * FROM bidang";
$queryBidang = $pdo->prepare($bidang);
$queryBidang->execute();
$listBidang = $queryBidang->fetchAll(PDO::FETCH_ASSOC);


// [ QUERY ] base query
$sql =
    " SELECT pengunjung.*, layanan.layanan, bidang.bidang FROM pengunjung 
    JOIN layanan ON pengunjung.layanan = layanan.id_layanan 
    JOIN bidang ON pengunjung.bidang = bidang.id_bidang WHERE pengunjung.nama LIKE :searchbox";

// [ FILTER ] Filter hasil pencarian berdasarkan HARI/BULAN/TAHUN saat ini
switch ($filter) {
    case 'today':
        $sql .= " AND DATE(tanggal) = CURDATE()";
        break;
    case 'month':
        $sql .= " AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
        break;
    case 'year':
        $sql .= " AND YEAR(tanggal) = YEAR(CURDATE())";
        break;
    case 'all': //menampilkan semua data
    default:
        // Tidak ada tambahan filter
        break;
}

// [ FILTER ] Filter bidang jika ada
if (!empty($filterLayanan)) {
    $sql .= " AND pengunjung.layanan = :filterLayanan";
}

// [ CONCAT ] concatenation untuk pencarian berdasarkan query dengan order 
$sql .= " ORDER BY id_pengunjung DESC LIMIT :start, :limit";

// [ EXECUTE ] query execute menggunakan PDO (PHP Data Object)
$query = $pdo->prepare($sql);
$query->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
$query->bindValue(':start', $start, PDO::PARAM_INT);
$query->bindValue(':limit', $limit, PDO::PARAM_INT);
if (!empty($filterLayanan)) {
    $query->bindValue(':filterLayanan', $filterLayanan, PDO::PARAM_STR);
}
$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

// [ COUNT ] total baris data untuk pagination
$total_sql = "SELECT COUNT(*) FROM pengunjung WHERE nama LIKE :searchbox";
switch ($filter) {
    case 'today':
        $total_sql .= " AND DATE(tanggal) = CURDATE()";
        break;
    case 'month':
        $total_sql .= " AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
        break;
    case 'year':
        $total_sql .= " AND YEAR(tanggal) = YEAR(CURDATE())";
        break;
    case 'all':
    default:
        // Tidak ada tambahan filter
        break;
}

if (!empty($filterLayanan)) {
    $total_sql .= " AND pengunjung.layanan = :filterLayanan";
}

$total_stmt = $pdo->prepare($total_sql);
$total_stmt->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
if (!empty($filterLayanan)) {
    $total_stmt->bindValue(':filterLayanan', $filterLayanan, PDO::PARAM_STR);
}
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

// [ UPDATE ] update value kolom bidang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_pengunjung']) && isset($_POST['selectedOption'])) {
        $id_pengunjung = $_POST['id_pengunjung'];
        $selectedOption = $_POST['selectedOption'];

        $sql = "UPDATE pengunjung SET bidang = :selectedOption, progres = 'assigned' WHERE id_pengunjung = :id_pengunjung";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':selectedOption' => $selectedOption,
            ':id_pengunjung' => $id_pengunjung,
        ]);

        // Check if update was successful
        if ($stmt->rowCount() > 0) {
            header('Location: ../../pages/admin/dashboard.php');
            exit;
        } else {
            echo "Update failed.";
        }
    } else {
        echo "Required POST data is missing.";
    }
}



