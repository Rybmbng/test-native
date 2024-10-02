<?php
session_start();

if (isset($_GET['act']) && isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];
    
    if ($_GET['act'] == 'plus') {
        $_SESSION['cart'][$kode_barang]['qty'] += 1;
        $_SESSION['cart'][$kode_barang]['subtotal'] = $_SESSION['cart'][$kode_barang]['qty'] * $_SESSION['cart'][$kode_barang]['harga'];
    } elseif ($_GET['act'] == 'min') {
        if ($_SESSION['cart'][$kode_barang]['qty'] > 1) {
            $_SESSION['cart'][$kode_barang]['qty'] -= 1;
            $_SESSION['cart'][$kode_barang]['subtotal'] = $_SESSION['cart'][$kode_barang]['qty'] * $_SESSION['cart'][$kode_barang]['harga'];
        }
    } elseif ($_GET['act'] == 'del') {
        unset($_SESSION['cart'][$kode_barang]);
    }
    
    header("Location: index.php?admin");
    exit();
}
?>
