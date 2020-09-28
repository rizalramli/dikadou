<?php 
include "koneksi/koneksi.php";
    if(isset($_POST['simpan']))
    {
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = mysqli_query($koneksi,"SELECT * FROM user WHERE username='$username'");
        $cek = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);
        if($cek > 0)
        {
            if(password_verify($_POST['password'],$data['password']))
            {

                $_SESSION['kode_user'] = $data['kode_user'];
                $_SESSION['username_user'] = $data['username'];
                $_SESSION['nama_user'] = $data['nama_user'];

                header("location:admin.php?halaman=prioritas_order");
            }
            else
            {
            echo "<script>alert('username atau password anda salah');</script>";
            }
        }
        else{
            echo "<script>alert('username atau password anda salah');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>DIKADOU</title>

<!-- Custom fonts for this template-->
<link href="assets/template/sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="assets/template/sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
<script src="assets/js/sweetalert.js"></script>


</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

    <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">PERCETAKAN DIKADOU</h1>
                    <h2 class="h4 text-gray-900 mb-4">LOGIN</h2>
                </div>
                <form class="user" method="post" action="">
                    <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Username">
                    </div>
                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary btn-user btn-block">Login</button>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>

    </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="assets/template/sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="assets/template/sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assets/template/sb_admin_2/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
