<?php 
    $query = mysqli_query($koneksi, "SELECT * FROM detail_transaksi JOIN transaksi USING(id_transaksi) JOIN kriteria USING (id_kriteria) JOIN barang USING(id_barang) WHERE status_pengerjaan='Belum Selesai'");
    $jumlah_batas = mysqli_num_rows($query);
    $data      = [];
    $kriterias = [];
    $bobot     = [];
    $atribut     = [];
    $nilai_kuadrat = [];
    $tanggal_deadline = "";
    if ($query) {
        foreach($query as $row)
        {
            if(!isset($data[$row['nama_barang_detail']])){
                $data[$row['nama_barang_detail']]=[];
            }
            if(!isset($data[$row['nama_barang_detail']][$row['nama_kriteria']])){
                $data[$row['nama_barang_detail']][$row['nama_kriteria']]=[];
            }

            if(!isset($nilai_kuadrat[$row['nama_kriteria']])){
                $nilai_kuadrat[$row['nama_kriteria']]=0;
            }

            
            if($row['nama_kriteria'] == "Sisa Hari")
            {
                date_default_timezone_set("Asia/Jakarta");
                $tanggal_deadline = date("Y-m-d",strtotime($row['value_kriteria']));
                $sekarang = date("Y-m-d");
                $selisih = ((strtotime ($tanggal_deadline) - strtotime ($sekarang))/(60*60*24));
                $row['value_kriteria'] = (int) $selisih;
                if($row['value_kriteria'] < 0)
                {
                    $row['value_kriteria'] = 0.001;
                }
            }
            $bobot[$row['nama_kriteria']]=$row['bobot'];
            $atribut[$row['nama_kriteria']]=$row['atribut'];
            $data[$row['nama_barang_detail']][$row['nama_kriteria']] = $row['value_kriteria'];
            $nilai_kuadrat[$row['nama_kriteria']]+=pow($row['value_kriteria'],2);
            $kriterias[]=$row['nama_kriteria'];
        }
        
    }
    $kriteria     =array_unique($kriterias);
    $jml_kriteria =count($kriteria);

    $i=0;
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k){
            round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3);
        }
    }

    $i=0;
    $y=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3)*$bobot[$k];
        }
    }

    $yplus=[];
    foreach($kriteria as $k){
        if($atribut[$k] == "Benefit")
        {
            $yplus[$k]=([$k]?max($y[$k]):min($y[$k]));
        }
        else 
        {
            $yplus[$k]=([$k]?min($y[$k]):max($y[$k]));

        }
    }

    $ymin=[];
    foreach($kriteria as $k){
        if($atribut[$k] == "Cost")
        {
            $ymin[$k]=[$k]?max($y[$k]):min($y[$k]);
        }
        else 
        {
            $ymin[$k]=[$k]?min($y[$k]):max($y[$k]);
        }
    }

    $i=0;
    $dplus=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            if(!isset($dplus[$i-1])) 
                $dplus[$i-1]=0;
                $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
        }
    }
    $i=0;
    $dmin=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
            $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
        }
    }
    $count_data = 0;

?>
<div class="container-fluid mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Urutan Prioritas</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable8" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Barang</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Nilai Prefensi</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                <?php
                    $i=0;
                    $V=[];
                    $nama_customer = NULL;
                    $no_hp = NULL;
                    $nama_barang = NULL;
        
                    foreach($data as $nama => $krit)
                    {
                        ++$i;
                    ?>
                        <?php 
                        foreach($kriteria as $k)
                        {
                            $V[$i-1]=sqrt($dmin[$i-1])/(sqrt($dmin[$i-1])+sqrt($dplus[$i-1]));
                        }
                        $preferensi = round($V[$i-1],3);
                        $tampung_array[] = ["nama_barang" => $nama,"nilai" => $preferensi];
                        
                        ?>
                    <?php
                    }

                    // Mengurutkan array dari kecil ke besar
                    function cmp($a, $b)
                    {
                        return strcmp($a["nilai"], $b["nilai"]);
                    }
                    usort($tampung_array, "cmp");
                    // Di balik
                    $tampung_array = array_reverse($tampung_array);
                ?>
                    <?php
                        $no = 1; 
                        foreach($tampung_array as $tampil)
                        {
                            $nama = $tampil['nama_barang'];
                            $explode = explode(",",$tampil['nama_barang']);
                            $nama_customer = $explode[0];
                            $no_hp = $explode[1];
                            $nama_barang = $explode[2];
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $no++."." ?></td>
                            <td><?php echo substr($nama_barang,0,-10) ?></td>
                            <td><?php echo stripcslashes($nama_customer) ?></td>
                            <td><?php echo $tampil['nilai'] ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-success btn_proses" data-proses="<?php echo $nama ?>">Kerjakan Barang</a>
                            </td>
                        </tr>
                    <?php 
                        }
                    ?>
                </tbody>
                </table>
            </div>
                <?php } else { ?>
                    <h2 class="text-center">Minimal 2 Data Barang Pesanan</h2>
                <?php } ?>
        </div>
    </div>
</div>
<script src="assets/template/sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script>
	    $('.btn_proses').click(function() {
			var id = $(this).data("proses");
            if (confirm('Yakin ingin mengerjakan barang ini ?')) {
                $.ajax({
                    url: "system/transaksi/prioritas_order/proses_update.php",
                    method: "POST",
                    data: {
                        id : id
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
		});
</script>