<main id="main" class="main">
    <div class="pagetitle">
      <h1>Transaksi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="?admin=">Home</a></li>
          <li class="breadcrumb-item">Transaksi</li>
        </ol>
      </nav>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Riwayat Transaksi</h4>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success" onclick="exportToPdf()">Export to PDF</button>
                <button type="button" class="btn btn-info" onclick="exportToXls()">Export to XLS</button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Customer</th>
                            <th>Kode Promo</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM penjualan_header";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['no_transaksi']; ?></td>
                                <td><?php echo $row['tgl_transaksi']; ?></td>
                                <td><?php echo $row['customer']; ?></td>
                                <td><?php echo !empty($row['kode_promo']) ? $row['kode_promo'] : '-'; ?></td>
                                <td><?php echo number_format($row['grand_total'], 0, ',', '.'); ?></td>
                                <td>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#detailModal" data-no-transaksi="<?php echo $row['no_transaksi']; ?>">Lihat Detail</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-content">
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#detailModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var noTransaksi = button.data('no-transaksi'); 

                $.ajax({
                    url: 'controller/detail.php',
                    type: 'POST',
                    data: {no_transaksi: noTransaksi},
                    success: function(data) {
                        $('#modal-body-content').html(data);
                    }
                });
            });

            function exportToPdf() {
                window.open('controller/pdf.php', '_blank');
            }

            function exportToXls() {
                window.open('controller/xls.php', '_blank');
            }
        </script>
    </div>
</main>

