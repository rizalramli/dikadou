<?php 
    include "../../../koneksi/koneksi.php";
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $selesai = "Selesai";
    $query_update = mysqli_query($koneksi, "UPDATE detail_transaksi SET status_pengerjaan='$selesai' WHERE nama_barang_detail='$id'");
    echo $query_update;
?>