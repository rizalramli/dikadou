<?php 
// Mencari Jarak Positif Manual
$a = sqrt(pow((3.7139-3.7139),2) + pow((2.98144-1.19256),2) + pow((1.29776-3.24444),2) + pow((1.8741-1.40556),2) + pow((0.78448-0.78448),2));
$b = sqrt(pow((3.7139-1.85695),2) + pow((2.98144-2.98144),2) + pow((1.29776-1.29776),2) + pow((1.8741-1.8741),2) + pow((0.78448-3.13784),2));
$c = sqrt(pow((3.7139-2.78545),2) + pow((2.98144-2.38512),2) + pow((1.29776-1.94664),2) + pow((1.8741-1.8741),2) + pow((0.78448-2.3534),2));
// Mencari Jarak Negatif Manual
$d = sqrt(pow((3.7139-1.85695),2) + pow((1.19256-1.19256),2) + pow((3.24444-3.24444),2) + pow((1.40556-1.40556),2) + pow((0.78448-3.13784),2));
$e = sqrt(pow((1.85695-1.85695),2) + pow((2.98144-1.19256),2) + pow((1.29776-3.24444),2) + pow((1.8741-1.40556),2) + pow((3.13784-3.13784),2));
$f = sqrt(pow((2.78545-1.85695),2) + pow((2.38512-1.19256),2) + pow((1.94664-3.24444),2) + pow((1.8741-1.40556),2) + pow((2.3534-3.13784),2));

?> 
<div class="container-fluid mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Evaluation Matrix (x<sub>ij</sub>)</h6>
        </div>
        <div class="card-body">
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
                $count_data = 0;
                ?>
                <?php 
                    $count_data = count($data);
                    if($count_data > 1)
                    {
                ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="text-center" width="5%" rowspan="2">No</th>
                        <th class="text-center" rowspan="2">Barang</th>
                        <th class="text-center" rowspan="2">Customer</th>
                        <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                    </tr>
                    <tr>
                        <?php
                        foreach($kriteria as $k)
                        {;
                        ?>
                            <th class="text-center"><?php echo $k ?></th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $nama_customer = NULL;
                        $no_hp = NULL;
                        $nama_barang = NULL;
                        foreach($data as $nama => $krit)
                        {
                            $explode = explode(",",$nama);
                            $nama_customer = $explode[0];
                            $no_hp = $explode[1];
                            $nama_barang = $explode[2];
                        ?>
                            <tr>
                                <td class="text-center"><?php echo ++$i."." ?></td>
                                <td><?php echo substr($nama_barang,0,-10) ?></td>
                                <td><?php echo stripcslashes($nama_customer) ?></td>
                            <?php
                            foreach($kriteria as $k)
                            {
                            ?>
                                <?php 
                                if($k == 'Harga')
                                {
                                    echo "<td class='text-right'>".rupiah($krit[$k])."</td>";
                                }
                                else if($krit[$k] == 0.001)
                                {
                                    echo "<td class='text-right'>0</td>";
                                }
                                else
                                {
                                    echo "<td class='text-center'>$krit[$k]</td>";
                                }
                                ?>
                                
                            <?php
                            }
                            echo "</tr>";
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
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Ternormalisasi (r<sub>ij</sub>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="text-center" width="5%" rowspan="2">No</th>
                        <th class="text-center" rowspan="2">Barang</th>
                        <th class="text-center" rowspan="2">Customer</th>
                        <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                    </tr>
                    <tr>
                        <?php
                        foreach($kriteria as $k)
                        {
                            ?>
                            <th class="text-center"><?php echo $k ?></th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $nama_customer = NULL;
                        $no_hp = NULL;
                        $nama_barang = NULL;
                        foreach($data as $nama => $krit)
                        {
                            $explode = explode(",",$nama);
                            $nama_customer = $explode[0];
                            $no_hp = $explode[1];
                            $nama_barang = $explode[2];
                        ?>
                            <tr>
                                <td class="text-center"><?php echo ++$i."." ?></td>
                                <td><?php echo substr($nama_barang,0,-10) ?></td>
                                <td><?php echo stripcslashes($nama_customer) ?></td>
                            <?php
                            foreach($kriteria as $k){
                            ?>
                                <td class="text-center"><?php echo round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3) ?></td>
                            <?php
                            }
                            ?>
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

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Ternormalisasi Bobot (y<sub>ij</sub>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="text-center" width="5%" rowspan="2">No</th>
                        <th class="text-center" rowspan="2">Barang</th>
                        <th class="text-center" rowspan="2">Customer</th>
                        <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                    </tr>
                    <tr>
                        <?php
                        foreach($kriteria as $k)
                        {
                        ?>
                            <th class="text-center"><?php echo $k ?></th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $y=[];
                        $nama_customer = NULL;
                        $no_hp = NULL;
                        $nama_barang = NULL;
                        foreach($data as $nama => $krit)
                        {
                            $explode = explode(",",$nama);
                            $nama_customer = $explode[0];
                            $no_hp = $explode[1];
                            $nama_barang = $explode[2];
                        ?>
                            <tr>
                                <td class="text-center"><?php echo ++$i."." ?></td>
                                <td><?php echo substr($nama_barang,0,-10) ?></td>
                                <td><?php echo stripcslashes($nama_customer) ?></td>
                            <?php 
                            foreach($kriteria as $k)
                            {
                                $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3)*$bobot[$k];
                            ?>
                                <td class="text-center"><?php echo $y[$k][$i-1] ?></td>
                            <?php 
                            }
                            ?>
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

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Solusi Ideal positif (A<sup>+</sup>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center" colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                </tr>
                <tr>
                    <?php
                    foreach($kriteria as $k)
                    {
                    ?>
                        <th class="text-center"><?php echo $k ?></th>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                    {
                    ?>
                        <th>y<sub><?php echo $n ?></sub><sup>+</sup></th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
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
                    echo "<th>$yplus[$k]</th>";
                    }
                    ?>
                </tr>
                </tbody>
                </table>
            </div>
            <?php } else { ?>
                    <h2 class="text-center">Minimal 2 Data Barang Pesanan</h2>
                <?php } ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Solusi Ideal negatif (A<sup>-</sup>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable5" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                </tr>
                <tr>
                    <?php
                    foreach($kriteria as $k)
                    {
                    ?>
                        <th class="text-center"><?php echo $k ?></th>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                    {
                    ?>
                        <th>y<sub><?php echo $n ?></sub><sup>-</sup></th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
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
                    echo "<th>{$ymin[$k]}</th>";
                    }

                    ?>
                </tr>
                </tbody>
                </table>
            </div>
            <?php } else { ?>
                    <h2 class="text-center">Minimal 2 Data Barang Pesanan</h2>
                <?php } ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jarak positif (D<sub>i</sub><sup>+</sup>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable6" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Barang</th>
                    <th>Customer</th>
                    <th>D<suo>+</sup></th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $i=0;
                    $dplus=[];
                    $nama_customer = NULL;
                    $no_hp = NULL;
                    $nama_barang = NULL;
                    foreach($data as $nama => $krit)
                    {
                        $explode = explode(",",$nama);
                        $nama_customer = $explode[0];
                        $no_hp = $explode[1];
                        $nama_barang = $explode[2];
                    ?>
                        <tr>
                            <td class="text-center"><?php echo ++$i."." ?></td>
                            <td><?php echo substr($nama_barang,0,-10) ?></td>
                            <td><?php echo stripcslashes($nama_customer) ?></td>
                        <?php
                        foreach($kriteria as $k){
                        if(!isset($dplus[$i-1])) 
                            $dplus[$i-1]=0;
                            $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
                        }
                        ?>
                            <td><?php echo round(sqrt($dplus[$i-1]),3) ?></td>
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

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jarak negatif (D<sub>i</sub><sup>-</sup>)</h6>
        </div>
        <div class="card-body">
        <?php 
            $count_data = count($data);
            if($count_data > 1)
            {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Barang</th>
                    <th>Customer</th>
                    <th>D<suo>-</sup></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                $dmin=[];
                $nama_customer = NULL;
                $no_hp = NULL;
                $nama_barang = NULL;
                foreach($data as $nama => $krit)
                {
                    $explode = explode(",",$nama);
                    $nama_customer = $explode[0];
                    $no_hp = $explode[1];
                    $nama_barang = $explode[2];
                ?>
                    <tr>
                        <td class="text-center"><?php echo ++$i."." ?></td>
                        <td><?php echo substr($nama_barang,0,-10) ?></td>
                        <td><?php echo stripcslashes($nama_customer) ?></td>
                    <?php
                    foreach($kriteria as $k)
                    {
                    if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
                    $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
                    }
                    ?>
                        <td><?php echo round(sqrt($dmin[$i-1]),3) ?></td>
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
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nilai Preferensi(V<sub>i</sub>)</h6>
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
                    <th>Barang</th>
                    <th>Customer</th>
                    <th>V<sub>i</sub></th>
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
                        $explode = explode(",",$nama);
                        $nama_customer = $explode[0];
                        $no_hp = $explode[1];
                        $nama_barang = $explode[2];
                    ?>
                        <tr>
                            <td class="text-center"><?php echo ++$i."." ?></td>
                            <td><?php echo substr($nama_barang,0,-10) ?></td>
                            <td><?php echo stripcslashes($nama_customer) ?></td>
                        <?php 
                        foreach($kriteria as $k)
                        {
                        $V[$i-1]=sqrt($dmin[$i-1])/(sqrt($dmin[$i-1])+sqrt($dplus[$i-1]));
                        }
                        $preferensi = round($V[$i-1],3);
                        ?>
                            <td><?php echo $preferensi ?></td>
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
