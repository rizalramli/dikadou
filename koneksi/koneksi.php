<!-- koneksi -->
<?php

$koneksi = mysqli_connect("localhost", "root", "", "dikadou");
if (!$koneksi) {
	echo "koneksi database gagal = " . mysqli_connect_error();
}

?>