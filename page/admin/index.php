<?php
include_once 'controller/config.php';
include_once 'controller/checkout.php';
$sql = mysqli_query($conn, "SELECT * FROM penjualan_header");
if (!$sql) {
    die("Query failed: " . mysqli_error($conn));
}
?>



<?php

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
    header("location: index.php?admin");

}


if (isset($_POST['add_to_cart'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = (int)$_POST['qty'];

    $query = "SELECT * FROM master_barang WHERE kode_barang = '$kode_barang'";
    $result = mysqli_query($conn, $query);
    $item = mysqli_fetch_assoc($result);
    if ($item) {
        if (isset($_SESSION['cart'][$kode_barang])) {
            $_SESSION['cart'][$kode_barang]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$kode_barang] = [
                'nama_barang' => $item['nama_barang'],
                'harga' => $item['harga'],
                'qty' => $qty,
                'subtotal' => $item['harga'] * $qty
            ];
        }
        $_SESSION['cart'][$kode_barang]['subtotal'] = $_SESSION['cart'][$kode_barang]['harga'] * $_SESSION['cart'][$kode_barang]['qty'];
       
    }
    header("location: index.php?admin");

}
?>

<div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
              <nav aria-label="breadcrumb">
           
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
</div>

            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Pendapatan <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <?php
                      $total = mysqli_query($conn,"SELECT SUM(grand_total) as grand_totals
                      FROM penjualan_header");
                      if (!$total) {
                          die("Query failed: " . mysqli_error($conn));
                      }
                      $sum = mysqli_fetch_array($total);
                      ?>
                      
                    <h2 class="mb-5">Rp. <?php echo $sum['grand_totals'] ?></h2>                 
                   </div>
                </div>
              </div>

              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Penjualan <i class="mdi mdi-cart mmdi-24px float-right"></i>
                    </h4>
                    <?php
                      $sql = mysqli_query($conn,"SELECT *FROM penjualan_header");
                      if (!$sql) {
                          die("Query failed: " . mysqli_error($conn));
                      }
                      $total = mysqli_num_rows($sql);
                      ?>
                    <h2 class="mb-5"><?php echo $total ?></h2>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Transaksi Hari Ini</h4>
                   
                  <?php
        require_once ('controller/config.php');

        // Query untuk mengambil data barang dari master_barang
        $query = "SELECT kode_barang, nama_barang, harga FROM master_barang";
        $result = mysqli_query($conn, $query);
        ?>

        <form method="POST" class="form-inline">
            <div class="form-group mb-2">
                <label for="kode_barang" class="mr-2">Pilih Barang:</label>
                <select name="kode_barang" id="kode_barang" class="custom-select">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?= $row['kode_barang']; ?>">
                            <?= $row['nama_barang']; ?> - Rp <?= number_format($row['harga'], 2); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="qty" class="mr-2">Jumlah:</label>
                <input type="number" name="qty" id="qty" value="1" min="1" class="form-control">
            </div>
            <button type="submit" name="add_to_cart" class="btn btn-primary mb-2">Tambah ke Keranjang</button>
        </form>
        <?php
          if (!empty($_SESSION['cart'])) {
              echo "<h3 class='text-primary'>Keranjang Belanja</h3>";
              echo "<table class='table table-bordered table-striped'>
                      <thead>
                          <tr>
                              <th>Nama Barang</th>
                              <th>Jumlah</th>
                              <th>Harga Satuan</th>
                              <th>Subtotal</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>";
              
              $total = 0;
              foreach ($_SESSION['cart'] as $kode_barang => $item) {
                  echo "<tr>
                          <td>{$item['nama_barang']}</td>
                          <td>{$item['qty']}</td>
                          <td class='text-right'>Rp " . number_format($item['harga'], 2) . "</td>
                          <td class='text-right'>Rp " . number_format($item['subtotal'], 2) . "</td>
                          <td class='text-center'>
                              <a href='cart.php?act=plus&kode_barang=$kode_barang'><i class='mdi mdi-plus-circle'></i></a> | 
                              <a href='cart.php?act=min&kode_barang=$kode_barang'><i class='mdi mdi-minus-circle'></i></a> | 
                              <a href='cart.php?act=del&kode_barang=$kode_barang'><i class='mdi mdi-delete'></i></a>
                          </td>
                      </tr>";
                  $total += $item['subtotal'];
              }

              echo "<tr>
                      <td colspan='3' class='text-right'><strong>Total</strong></td>
                      <td colspan='2' class='text-right'><strong>Rp " . number_format($total, 2) . "</strong></td>
                    </tr>";
              echo "</tbody>
                    </table>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#checkout-modal'>
                Checkout
            </button>
            ";
                    
          } else {
              echo "<p class='text-muted'>Keranjang belanja Anda kosong.</p>";
          }
          ?>
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Transaksi Hari Ini</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          <th scope="col">Kode Transaksi</th>
                          <th scope="col">Customer</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col">Grand Total</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $date = date('Y-m-d');
                        $result = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE tgl_transaksi = '$date'");
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        
                        if (mysqli_num_rows($result) > 0) {
                          while ($data = mysqli_fetch_assoc($result)){  
                        ?>
                          <tr>
                            <td> <a href="?admin=detail&id=<?php echo $data['no_transaksi'] ?>" style="text-decoration:none;"><?php echo $data['no_transaksi']?> </a> </td>
                            <td>
                              <label class="badge badge-gradient-success"><?php echo $data['customer']; ?></label>
                            </td>
                            <td><?php echo $data['tgl_transaksi']?></td>
                            <td><span class="badge bg-primary">Rp. <?php echo $data['grand_total'] ?></span></td>
                        
                         </tr>
                        <?php }
                        } else {
                          echo "<tr><td colspan='4' style='text-align:center'>Data tidak ditemukan</td></tr>";
                        }
                        ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="modal fade" id="checkout-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Checkout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="customer" class="form-label">Nama Customer:</label>
                                    <input type="text" class="form-control" id="customer" name="customer" required>
                                    <div class="invalid-feedback">
                                        Silakan isi nama customer.
                                    </div>
                                </div>

                                <div class="mb-3">
                                <label for="kode_promo">Kode Promo (jika ada):</label><br>        <input type="text" id="kode_promo" name="kode_promo" onkeyup="checkPromo()"><br><br>
                                <span id="promo_status"></span><br>


                                <br><br>
                                </div>

                                <?php if (!empty($_SESSION['cart'])): ?>
                                    <h3 class="mb-3">Keranjang Belanja</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nama Barang</th>
                                                    <th scope="col">Jumlah</th>
                                                    <th scope="col">Harga Satuan</th>
                                                    <th scope="col">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_bayar = 0;
                                                foreach ($_SESSION['cart'] as $kode_barang => $item) {
                                                    $subtotal = $item['qty'] * $item['harga'];
                                                    $total_bayar += $subtotal;
                                                ?>
                                                    <tr>
                                                        <td><?= $item['nama_barang'] ?></td>
                                                        <td><?= $item['qty'] ?></td>
                                                        <td>Rp <?= number_format($item['harga'], 2) ?></td>
                                                        <td>Rp <?= number_format($subtotal, 2) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3"><strong>Total Bayar</strong></td>
                                                    <td><strong>Rp <?= number_format($total_bayar, 2) ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>PPN 10%</strong></td>
                                                    <td><strong>Rp <?= number_format($total_bayar * 0.1, 2) ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Grand Total</strong></td>
                                                    <td><strong>Rp <?= number_format($total_bayar + ($total_bayar * 0.1), 2) ?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php $_SESSION['total_bayar'] = $total_bayar + ($total_bayar * 0.1); ?>
                                <?php else: ?>
                                    <p class="text-center">Keranjang Anda kosong.</p>
                                <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="checkout" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin checkout?')">Checkout</button>
                        </div>
                            </form>
                    </div>
                </div>
            </div>


            <script>
        function checkPromo() {
            var kodePromo = $('#kode_promo').val();
            if (kodePromo.length > 0) {
                $.ajax({
                    url: 'check_promo.php',
                    type: 'POST',
                    data: { kode_promo: kodePromo },
                    success: function(response) {
                        $('#promo_status').html(response);
                    }
                });
            } else {
                $('#promo_status').html('');
            }
        }
    </script>