
<?php 
session_start();
include "koneksi/koneksi.php";
include "koneksi/function.php";
if (!isset($_SESSION['username_user'])) {
    header('location:index.php');
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dikadou</title>

  <!-- Bootstrap core CSS -->

  <!-- Custom styles for this template -->
  <link href="assets/css/simple-sidebar.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/template/sb_admin_2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="assets/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<script src="assets/js/sweetalert.js"></script>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Dikadou </div>
      <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "transaksi" || $_GET['halaman'] == "daftar_transaksi") {echo"active";} ?>"
                        href="?halaman=transaksi">Transaksi</a>
        <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "prioritas_order") {echo"active";} ?>"
            href="?halaman=prioritas_order">Prioritas Order</a>
    
        <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "topsis") {echo"active";} ?>"
            href="?halaman=topsis">Perhitungan Topsis</a>
    
        <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "barang") {echo"active";} ?>"
            href="?halaman=barang">Barang</a>
            <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "kriteria") {echo"active";} ?>"
            href="?halaman=kriteria">Kriteria</a>
    
        <a class="list-group-item list-group-item-action bg-light" <?php if($_GET['halaman'] == "user") {echo"active";} ?>"
            href="?halaman=user">User</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION['username_user'] ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" onclick="return confirm('Yakin ingin logout ?')" href="logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <?php 
                if(!isset($_GET['halaman'])) {
                        error_reporting(0);
                    }
                    if ($_GET['halaman'] == 'barang') {
                        include "system/master/barang/tampil.php";
                    }
                    if ($_GET['halaman'] == 'kriteria') {
                        include "system/master/kriteria/tampil.php";
                    }
                    if ($_GET['halaman'] == 'user') {
                        include "system/master/user/tampil.php";
                    }
                    if ($_GET['halaman'] == 'transaksi') {
                        include "system/transaksi/keranjang_transaksi/tampil.php";
                    }
                    if ($_GET['halaman'] == 'daftar_transaksi') {
                    include "system/transaksi/keranjang_transaksi/daftar_transaksi.php";
                    }
                    if ($_GET['halaman'] == 'topsis') {
                        include "system/transaksi/perhitungan_topsis/tampil.php";
                    }
                    if ($_GET['halaman'] == 'prioritas_order') {
                        include "system/transaksi/prioritas_order/tampil.php";
                    }
                ?>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="assets/template/sb_admin_2/vendor/jquery/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/template/sb_admin_2/vendor/datatables/jquery.dataTables.min.js"> </script>
    <script src="assets/template/sb_admin_2/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/template/sb_admin_2/js/demo/datatables-demo.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>

    <!-- Agar input tidak ada history -->
    <script>
        $("form :input").attr("autocomplete", "off");
    </script>
    <!-- Format Rupiah -->
    <script src="assets/js/jquery.mask.js"></script>


    <script>
        $('#dataTable').DataTable({
            ordering: false
        });
        $('#dataTable2').DataTable({
            ordering: false
        });
        $('#dataTable3').DataTable({
            ordering: false
        });
        $('#dataTable4').DataTable({
            ordering: false
        });
        $('#dataTable5').DataTable({
            ordering: false
        });
        $('#dataTable6').DataTable({
            ordering: false
        });
        $('#dataTable7').DataTable({
            ordering: false
        });
        $('#dataTable8').DataTable({
            ordering: false
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.rupiah').mask('000.000.000', {
                reverse: true
            });
		        $('.hp').mask('000000000000000');
        })
    </script>
    <script>
        var date = new Date();
        date.setDate(date.getDate() + 1);

        $('#datepicker').datepicker({
            startDate: date
        });
    </script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
