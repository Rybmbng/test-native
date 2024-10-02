  <?php 
  ob_start();
  include 'controller/config.php';  
  ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
    <?php include_once 'template/style.php' ?>
    </head>
    <body>
      <div class="container-scroller"> 
        <?php include_once 'template/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
              <li class="nav-item nav-profile">
                <a href="" class="nav-link">
                  <div class="nav-profile-image">
                    <img src="assets/profile/profile.png" alt="profile">
                    <span class="login-status online"></span>
                  </div>
                  <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Admin</span>
                    <span class="text-secondary text-small">Kasir</span>
                  </div>
                  <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?admin=">
                  <span class="menu-title">Dashboard</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?admin=barang">
                  <span class="menu-title">Master</span>
                  <i class="mdi mdi-cards menu-icon"></i>
                </a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#user-pages" aria-expanded="false" aria-controls="general-pages">
                  <span class="menu-title">Transaksi</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
                <div class="collapse" id="user-pages">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="?admin=selesai"> Selesai </a></li>
                  </ul>
                </div>
              </li>
            
            </ul>
          </nav>
          <div class="main-panel">
            <div class="content-wrapper">
            <?php include './controller/page.php'; ?>
            </div>
            
          </div>
        </div>
      </div>


      <script src="assets/vendors/js/vendor.bundle.base.js"></script>
      <script src="assets/vendors/chart.js/Chart.min.js"></script>
      <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
      <script src="assets/js/off-canvas.js"></script>
      <script src="assets/js/hoverable-collapse.js"></script>
      <script src="assets/js/misc.js"></script>
      <script src="assets/js/dashboard.js"></script>
      <script src="assets/js/todolist.js"></script>
  </body>
  </html>
  <?php
  ob_end_flush();
  ?>
