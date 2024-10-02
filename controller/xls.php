<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Riwayat_Transaksi.xls");

require('config.php');

$query = "SELECT * FROM penjualan_header";
$result = mysqli_query($conn, $query);

echo "<table border='1'>
<tr>
    <th>No. Transaksi</th>
    <th>Tanggal Transaksi</th>
    <th>Customer</th>
    <th>Kode Promo</th>
    <th>Total Bayar</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['no_transaksi']}</td>
        <td>{$row['tgl_transaksi']}</td>
        <td>{$row['customer']}</td>
        <td>" . (!empty($row['kode_promo']) ? $row['kode_promo'] : '-') . "</td>
        <td>" . number_format($row['grand_total'], 0, ',', '.') . "</td>
    </tr>";
}

echo "</table>";
mysqli_close($conn);
?>
