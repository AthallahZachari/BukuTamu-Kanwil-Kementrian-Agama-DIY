<?php
include 'connection.php';

//  === QUERY ===
//
// 
// [ SET ] jumlah halaman
$limit = 8;


// [ REQ ] params URL
$searchbox = isset($_GET['searchbox']) ? $_GET['searchbox'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$kepentingan = isset($_POST['kepentingan']) ? $_POST['kepentingan'] : '';

// [ SET ] current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// [ QUERY ] base query
$sql = "SELECT * FROM pengunjung WHERE nama LIKE :searchbox";

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
    case 'all':
    default:
        // Tidak ada tambahan filter
        break;
}

// [ FILTER ] Filter bidang jika ada
if (!empty($kepentingan)) {
    $sql .= " AND kepentingan = :kepentingan";
}

// [ CONCAT ] contatenation untuk pencarian berdasarkan query dengan order 
$sql .= " ORDER BY id DESC LIMIT :start, :limit";

// [ EXECUTE ] query execute menggunakan PDO (PHP Data Object)
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
if (!empty($kepentingan)) {
    $stmt->bindValue(':kepentingan', $kepentingan, PDO::PARAM_STR);
}
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

if (!empty($kepentingan)) {
    $total_sql .= " AND kepentingan = :kepentingan";
}

$total_stmt = $pdo->prepare($total_sql);
$total_stmt->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
if (!empty($kepentingan)) {
    $total_stmt->bindValue(':kepentingan', $kepentingan, PDO::PARAM_STR);
}
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);



// === VARIABLES AND UTILS ===
// 
// 
// [ SET ] warna untuk kolom data KEPENTINGAN/BIDANG 
function getBgColor($kepentingan)
{
    switch ($kepentingan) {
        case 'Permohonan Rekomendasi':
            return 'red-400';
        case 'Permohonan Rohaniwan':
            return 'violet-400';
        case 'Permohonan Audiensi':
            return 'emerald-400';
        case 'Permohonan Penelitian':
            return 'amber-400';
        case 'Permohonan Magang':
            return 'orange-400';
        case 'Konsultasi Haji':
            return 'yellow-500';
        case 'Konsultasi Halal':
            return 'emerald-300';
        default:
            # code...
            break;
    }
}

// [ DROPDOWN ] Menu filter dropdown
$options = [
    ["id" => "1", "text" => "Permohonan Rekomendasi"],
    ["id" => "2", "text" => "Permohonan Rohaniwan"],
    ["id" => "3", "text" => "Permohonan Audiensi"],
    ["id" => "4", "text" => "Permohonan Penelitian"],
    ["id" => "5", "text" => "Permohonan Magang"],
    ["id" => "6", "text" => "Konsultasi Haji"],
    ["id" => "7", "text" => "Konsultasi Halal"]
];

