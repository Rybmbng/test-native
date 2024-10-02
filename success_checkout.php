<?php
session_start();
require_once('controller/config.php');

if (isset($_GET['no_transaksi'])) {
    $no_transaksi = $_GET['no_transaksi'];

    $header_query = "SELECT * FROM penjualan_header WHERE no_transaksi = '$no_transaksi'";
    $header_result = mysqli_query($conn, $header_query);
    $header = mysqli_fetch_assoc($header_result);

    $detail_query = "SELECT * FROM penjualan_header_detail WHERE no_transaksi = '$no_transaksi'";
    $detail_result = mysqli_query($conn, $detail_query);
}

$promo_keterangan = '';
if (!empty($header['kode_promo'])) {
    $promo_query = "SELECT keterangan FROM promo WHERE kode_promo = '{$header['kode_promo']}'";
    $promo_result = mysqli_query($conn, $promo_query);
    if ($promo_row = mysqli_fetch_assoc($promo_result)) {
        $promo_keterangan = $promo_row['keterangan'];
    } else {
        $promo_keterangan = 'Kode promo tidak valid.';
    }
} else {
    $promo_keterangan = 'Tidak ada promo yang digunakan.';
}
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Struk Checkout</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 20px;
                border: 1px solid #ddd;
                width: 400px;
            }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Struk Transaksi</h2>
    <p>No. Transaksi: <strong><?php echo $header['no_transaksi']; ?></strong></p>
    <p>Tanggal Transaksi: <strong><?php echo $header['tgl_transaksi']; ?></strong></p>
    <p>Customer: <strong><?php echo $header['customer']; ?></strong></p>
    
    <h3>Kode Promo:</h3>
    <p><strong><?php echo $header['kode_promo'] ? $header['kode_promo'] : 'Tidak ada promo yang digunakan.'; ?></strong></p>
    <p>Keterangan Promo: <strong><?php echo $promo_keterangan; ?></strong></p>
    
    <h3>Detail Item:</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = mysqli_fetch_assoc($detail_result)): ?>
                <tr>
                    <td><?php echo $detail['kode_barang']; ?></td>
                    <td><?php echo $detail['qty']; ?></td>
                    <td><?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($detail['discount'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Total Pembayaran:</h3>
    <p>Total Bayar: <strong><?php echo number_format($header['total_bayar'], 0, ',', '.'); ?></strong></p>
    <p>PPN: <strong><?php echo number_format($header['ppn'], 0, ',', '.'); ?></strong></p>
    <p>Grand Total: <strong><?php echo number_format($header['grand_total'], 0, ',', '.'); ?></strong></p>

    <p style="text-align: center;">Terima kasih atas pembelian Anda!</p>
</body>
</html>
