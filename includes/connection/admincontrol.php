<?php
include 'connection.php';

// Jumlah data per halaman
$limit = 8;

// Ambil kata kunci pencarian dan filter dari URL
$searchbox = isset($_GET['searchbox']) ? $_GET['searchbox'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Set halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Query dasar
$sql = "SELECT * FROM pengunjung WHERE nama LIKE :searchbox";

// Tambahkan filter berdasarkan nilai dropdown
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

// Tambahkan order dan limit
$sql .= " ORDER BY id DESC LIMIT :start, :limit";

// Eksekusi query
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total baris data untuk pagination
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
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->bindValue(':searchbox', '%' . $searchbox . '%', PDO::PARAM_STR);
$total_stmt->execute();
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

function getBgColor($instansi)
{
    switch ($instansi) {
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
