<?php
require '../../vendor/autoload.php';
include '../../includes/connection/admincontrol.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'Tanggal');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Gender');
$sheet->setCellValue('D1', 'Umur');
$sheet->setCellValue('E1', 'Instansi');
$sheet->setCellValue('F1', 'Alamat');
$sheet->setCellValue('G1', 'Nomor HP');
$sheet->setCellValue('H1', 'Layanan');
$sheet->setCellValue('I1', 'Bidang');
$sheet->setCellValue('J1', 'Deskripsi');

// Mengambil data dari database
$query = $pdo->query("SELECT * FROM bukutamu_db.pengunjung");
$rowNumber = 2; // Baris pertama setelah header

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('A' . $rowNumber, htmlspecialchars($row["tanggal"]));
    $sheet->setCellValue('B' . $rowNumber, htmlspecialchars($row["nama"]));
    $sheet->setCellValue('C' . $rowNumber, htmlspecialchars($row["jenis_kelamin"]));
    $sheet->setCellValue('D' . $rowNumber, htmlspecialchars($row["umur"]));
    $sheet->setCellValue('E' . $rowNumber, htmlspecialchars($row["instansi"]));
    $sheet->setCellValue('F' . $rowNumber, htmlspecialchars($row["alamat"]));
    $sheet->setCellValue('G' . $rowNumber, htmlspecialchars($row["nomor_hp"]));
    $sheet->setCellValue('H' . $rowNumber, htmlspecialchars($row["layanan"]));
    $sheet->setCellValue('I' . $rowNumber, htmlspecialchars($row["bidang"]));
    $sheet->setCellValue('J' . $rowNumber, htmlspecialchars($row["deskripsi"]));
    $rowNumber++;
}

// Menulis file ke output
$writer = new Xlsx($spreadsheet);   
$fileName = "Data-Pengunjung.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
$writer->save('php://output');
exit();
?>