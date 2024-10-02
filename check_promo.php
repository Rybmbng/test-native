<?php
require_once('controller/config.php');

if (isset($_POST['kode_promo'])) {
    $kode_promo = $_POST['kode_promo'];

    $query = "SELECT * FROM promo WHERE kode_promo = '$kode_promo'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $promo = mysqli_fetch_assoc($result);
        echo "Kode Promo Valid: " . $promo['nama_promo'] . " - " . $promo['keterangan'];
    } else {
        echo "Kode promo tidak valid.";
    }
}
?>
