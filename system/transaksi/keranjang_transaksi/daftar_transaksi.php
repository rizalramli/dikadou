<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
                        </div>
                        <div class="card-body">
                            <a href="?halaman=transaksi" class="btn btn-primary mb-3">Tambah</a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nomor</th>
                                            <th class="text-center">Tanggal Pesan</th>
                                            <th class="text-center">Tanggal Selesai</th>
                                            <th class="text-center">Nama Customer</th>
                                            <th class="text-center">No hp</th>
                                            <th class="text-center">Total Biaya</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $no = 1;
                                    $query2 = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tgl_transaksi ASC");
                                    foreach ($query2 as $data2) :
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++ ?></td>
                                            <td><?php echo date('d-m-Y',strtotime($data2['tgl_transaksi'])) ?></td>
                                            <td><?php echo date('d-m-Y',strtotime($data2['tgl_deadline'])) ?></td>
                                            <td><?php echo $data2['nama_customer'] ?></td>
                                            <td><?php echo $data2['no_hp'] ?></td>
                                            <td class="text-right"><?php echo rupiah($data2['total_harga']) ?></td>
                                            <td class="text-center">
                                                <a style="cursor:pointer" class="btn btn-sm btn-warning text-white"
                                                    data-toggle="modal"
                                                    data-target="#modal-edit-user<?= $data2['id_transaksi'] ?>">Detail</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php foreach($query2 as $data2):  ?>
<div id="modal-edit-user<?=$data2['id_transaksi'];?>" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Nama Customer</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $id_transaksi = $data2['id_transaksi'];
                                    $no = 1;
                                    $query3 = mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE
                                    id_transaksi='$id_transaksi' GROUP BY id_transaksi");
                                    foreach ($query3 as $data3) :
                                        $explode = explode(",",$data3['nama_barang_detail']);
                                        $nama_customer = $explode[0];
                                        $nama_barang = $explode[2];
                                        ?>
                            <tr>
                                <td class="text-center"><?php echo $no++ ?></td>
                                <td><?php echo $nama_customer ?></td>
                                <td><?php echo substr($nama_barang,0,-10) ?></td>
                                <td><?php echo $data3['status_pengerjaan'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>