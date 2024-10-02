<?php
session_start();
require_once('config.php');

if (isset($_POST['no_transaksi'])) {
    $no_transaksi = $_POST['no_transaksi']; 

    $header_query = "SELECT * FROM penjualan_header WHERE no_transaksi = '$no_transaksi'";
    $header_result = mysqli_query($conn, $header_query);
    $header = mysqli_fetch_assoc($header_result);

    $detail_query = "SELECT * FROM penjualan_header_detail WHERE no_transaksi = '$no_transaksi'";
    $detail_result = mysqli_query($conn, $detail_query);

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

    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h2>Struk Transaksi</h2>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<p>No. Transaksi: <strong>' . $header['no_transaksi'] . '</strong></p>';
    echo '<p>Tanggal Transaksi: <strong>' . $header['tgl_transaksi'] . '</strong></p>';
    echo '<p>Customer: <strong>' . $header['customer'] . '</strong></p>';
    echo '</div>';
    echo '<div class="col-md-6">';
    echo '<h3>Kode Promo:</h3>';
    echo '<p><strong>' . ($header['kode_promo'] ? $header['kode_promo'] : 'Tidak ada promo yang digunakan.') . '</strong></p>';
    echo '<p>Keterangan Promo: <strong>' . $promo_keterangan . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h3>Detail Item:</h3>';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr><th>Kode Barang</th><th>Qty</th><th>Harga</th><th>Diskon</th><th>Subtotal</th></tr>';
    echo '</thead><tbody>';
    while ($detail = mysqli_fetch_assoc($detail_result)) {
        echo '<tr>';
        echo '<td>' . $detail['kode_barang'] . '</td>';
        echo '<td>' . $detail['qty'] . '</td>';
        echo '<td>' . number_format($detail['harga'], 0, ',', '.') . '</td>';
        echo '<td>' . number_format($detail['discount'], 0, ',', '.') . '</td>';
        echo '<td>' . number_format($detail['subtotal'], 0, ',', '.') . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-md-12"> <br/> <br/>'; 
    echo '<h3>Total Pembayaran:</h3>';
    echo '<p>Total Bayar: <strong>' . number_format($header['total_bayar'], 0, ',', '.') . '</strong></p>';
    echo '<p>PPN: <strong>' . number_format($header['ppn'], 0, ',', '.') . '</strong></p>';
    echo '<p>Grand Total: <strong>' . number_format($header['grand_total'], 0, ',', '.') . '</strong></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}



