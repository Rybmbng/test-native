<?php

if(isset($_POST['tambah']))  {
  $namabarang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $query = "SELECT MAX(kode_barang) as kode_terakhir FROM master_barang";
    $hasil = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($hasil);
    $kode_terakhir = $data['kode_terakhir'];

    if ($kode_terakhir) {
        $urutan = (int)substr($kode_terakhir, -3) + 1; 
        $kodeBaru = str_pad($urutan, 3, '0', STR_PAD_LEFT); 
    } else {
        $kodeBaru = '001'; 
    }

    $sql = "INSERT INTO master_barang (kode_barang, nama_barang, harga, stok) VALUES ('$kodeBaru', '$namabarang', '$harga', '$stok')";
    $sqld = mysqli_query($conn, $sql);

    if ($sqld) {
      echo "<script>alert('Data berhasil ditambah'); window.location.href='?admin=barang';</script>";
    } else {
      echo "<script>alert('Data gagal ditambah'); window.location.href='?admin=barang';</script>";
    }
}

if(isset($_POST['edit']))  {
  $kodebarangs = $_POST['kode_barang'];
  $namabarang = $_POST['nama_barang'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];

  $esql = "UPDATE master_barang SET nama_barang='$namabarang', harga='$harga', stok='$stok' WHERE kode_barang='$kodebarangs'";
  $esqld = mysqli_query($conn, $esql);

  if ($esqld) {
    echo "<script>alert('Data berhasil diubah'); window.location.href='?admin=barang';</script>";
  } else {
    echo "<script>alert('Data gagal diubah'); window.location.href='?admin=barang';</script>";
  }
}




if (isset($_GET['delete_id'])) {
  $kode_barang = $_GET['delete_id'];
  $sql_delete = "DELETE FROM master_barang WHERE kode_barang='$kode_barang'";
  $result_delete = mysqli_query($conn, $sql_delete);
  
  if ($result_delete) {
      echo "<script>alert('Data berhasil dihapus'); window.location.href='?admin=barang';</script>";
  } else {
      echo "<script>alert('Gagal menghapus data'); window.location.href='?admin=barang';</script>";
  }
}

?>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Master Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="?admin=">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active">Barang</li>
        </ol>
      </nav>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> Tambah Barang <i class="bi bi-plus"></i></button>
            </div>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Master Barang</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Kode Barang</th>
                  <th scope="col" class="text-center">Nama Barang</th>
                  <th scope="col" class="text-center">Harga</th>
                  <th scope="col" class="text-center">Edit</th>
                  <th scope="col" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $fetchdata = mysqli_query($conn, "SELECT * FROM master_barang");
              while ($data = mysqli_fetch_array($fetchdata)) {
              ?>
                <tr>
                  <th scope="row" class="text-center"><?php echo $data['kode_barang'] ?></th>
                  <td class="text-center"><?php echo $data['nama_barang'] ?></td>
                  <td class="text-center">Rp.<?php echo $data['harga'] ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['kode_barang'] ?>">Edit</button>
                  </td> 
                  <td class="text-center">
                  <button type="button" class="btn btn-danger">
                    <a style="text-decoration:none;color:white" href="?admin=barang&delete_id=<?php echo $data['kode_barang'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </button>
                  </td>  
                </tr>

                <!-- Modal Edit Barang -->
                <div class="modal fade" id="editModal<?php echo $data['kode_barang'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Barang</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" class="row g-4">
                          <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="kode_barang" value="<?php echo $data['kode_barang'] ?>" hidden>
                            <input type="text" class="form-control" name="kode_barangs" value="<?php echo $data['kode_barang'] ?>" disabled>
                          </div>
                          <div class="col-md-6">
                            <label for="validationDefault04" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" value="<?php echo $data['nama_barang'] ?>" required>
                          </div>  
                          <div class="col-md-6">
                            <label for="validationDefault03" class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" value="<?php echo $data['harga'] ?>" required>
                          </div>
                          <div class="col-md-6">
                            <label for="validationDefault03" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" value="<?php echo $data['stok'] ?>" required>
                          </div>
                          <div class="col-12">
                            <button type="submit" name="edit" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?')" class="btn btn-primary">Edit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </section>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" class="row g-4">
              <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Kode Barang</label>
                <input type="text" class="form-control" placeholder="Sudah Terisi Otomatis" readonly>
              </div>
              <div class="col-md-6">
                <label for="validationDefault04" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" name="nama_barang" required>
              </div>  
              <div class="col-md-6">
                <label for="validationDefault03" class="form-label">Harga</label>
                <input type="number" class="form-control" name="harga" required>
              </div>
              <div class="col-md-6">
                <label for="validationDefault03" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" required>
              </div>
              <div class="col-12">
              <button type="submit" name="tambah" value="tambah" onclick="return confirm('Apakah Anda yakin ingin menambah data ini?')" class="btn btn-primary" >Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

</main>

