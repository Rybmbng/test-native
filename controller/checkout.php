<?php
session_start();
require_once('controller/config.php');

function generateNoTransaksi($conn) {
    $tahun_bulan = date('Ym');
    $query = "SELECT no_transaksi FROM penjualan_header WHERE no_transaksi LIKE '$tahun_bulan%' ORDER BY no_transaksi DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $last_no_transaksi = $row['no_transaksi'];
        $last_urut = intval(substr($last_no_transaksi, -3)); 
        $new_urut = str_pad($last_urut + 1, 3, '0', STR_PAD_LEFT); 
    } else {
        $new_urut = '001';
    }

    return $tahun_bulan . '-' . $new_urut;
}

function applyPromo($conn, $kode_promo, $cart) {
    $query = "SELECT * FROM promo WHERE kode_promo = '$kode_promo'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $promo = mysqli_fetch_assoc($result);
        $total_discount = 0;
        if ($promo['kode_promo'] == 'promo-001') {
            $qty_facial_care = $cart['003']['qty'] ?? 0; 
            if ($qty_facial_care >= 2) {
                $total_discount = 3000; 
            }
        }

        return $total_discount; 
    }

    return 0;   
}

if (isset($_POST['checkout'])) {
    $no_transaksi = generateNoTransaksi($conn);
    $tgl_transaksi = date('Y-m-d');
    $customer = $_POST['customer'];  
    $kode_promo = $_POST['kode_promo'];  
    $total_bayar = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total_bayar += $item['subtotal'];
    }

    $promo_discount = applyPromo($conn, $kode_promo, $_SESSION['cart']);
    $total_bayar -= $promo_discount; 

    $ppn = $total_bayar * 0.1;
    $grand_total = $total_bayar + $ppn;

    $query = "INSERT INTO penjualan_header (no_transaksi, tgl_transaksi, customer, kode_promo, total_bayar, ppn, grand_total) 
              VALUES ('$no_transaksi', '$tgl_transaksi', '$customer', '$kode_promo', '$total_bayar', '$ppn', '$grand_total')";
    mysqli_query($conn, $query);

    foreach ($_SESSION['cart'] as $kode_barang => $item) {
        $harga = $item['harga'];
        $qty = $item['qty'];
        $discount = ($kode_barang === '003') ? $promo_discount : 0; 
        $subtotal = $item['subtotal'] - $discount;

        $query = "INSERT INTO penjualan_header_detail (no_transaksi, kode_barang, qty, harga, discount, subtotal) 
                  VALUES ('$no_transaksi', '$kode_barang', '$qty', '$harga', '$discount', '$subtotal')";
        mysqli_query($conn, $query);
    }

    unset($_SESSION['cart']);
    echo "<script>window.open('success_checkout.php?no_transaksi=$no_transaksi', '_blank')</script>";

}
?>

