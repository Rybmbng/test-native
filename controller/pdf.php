<?php
require('fpdf/fpdf.php');
require('config.php');

$query = "SELECT * FROM penjualan_header";
$result = mysqli_query($conn, $query);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 10, 'Laporan Riwayat Transaksi', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'No. Transaksi', 1);
$pdf->Cell(40, 10, 'Tanggal Transaksi', 1);
$pdf->Cell(50, 10, 'Customer', 1);
$pdf->Cell(40, 10, 'Kode Promo', 1);
$pdf->Cell(40, 10, 'Total Bayar', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(40, 10, $row['no_transaksi'], 1);
    $pdf->Cell(40, 10, $row['tgl_transaksi'], 1);
    $pdf->Cell(50, 10, $row['customer'], 1);
    $pdf->Cell(40, 10, !empty($row['kode_promo']) ? $row['kode_promo'] : '-', 1);
    $pdf->Cell(40, 10, number_format($row['grand_total'], 0, ',', '.'), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Laporan_Riwayat_Transaksi.pdf');
mysqli_close($conn);
?>

