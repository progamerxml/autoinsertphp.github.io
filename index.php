<?php
date_default_timezone_set("Asia/Jakarta");
    // class koneksi{

    //     var $host = "localhost";
    //     var $username = "admin";
    //     var $password = "101112";
    //     var $nama_db = "xml_test";

    //     function __construct()
    //     {
    //         $koneksi = mysqli_connect($this->host, $this->username, $this->password);
    //         mysqli_select_db($koneksi,$this->nama_db);

    //         if($koneksi){
    //             return $sukses = true;
    //         }else{
    //             return $sukses =  false;
    //         }
    //     }
    // }

    // $konek = new koneksi();
    // $status = $konek->__construct();

    $host = "localhost";
    $username = "admin";
    $password = "101112";
    $nama_db = "xml_test";

    $konek = new mysqli($host,$username,$password,$nama_db);
    if($konek->connect_error) {
        die('Maaf koneksi gagal: '. $konek->connect_error);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <title>xml_test</title>
</head>
<body>
    <div style="width : 80%; margin:auto;">
        <?php
            $tanggal = date("Y-m-d", strtotime("yesterday")); echo "kemaren tanggal : ".$tanggal; echo " sekarang jam : ".date("H:i:s")."<br><br>";
            $jam = date("H:i",strtotime("13:51")); //var_dump($jam);
            $sek = date("H:i");
            if ($jam == $sek)
            {
                var_dump($sek);
                $tgl_data = "2022-06-26"; //date("Y-m-d", strtotime("yesterday"));
                $sttsok = 4;
                $sttsno = 2;
                $ssql = "select distinct (vtype) as kode from xml_test.log_purchase where status = 4 and tanggal like '%$tgl_data%'"; //var_dump($ssql);
                $esql = mysqli_query($konek, $ssql);
                $jsql = mysqli_num_rows($esql); //var_dump($jsql);
                for ($i = 1; $i < $jsql; $i++){
                    $kode = mysqli_fetch_object($esql);
                    $strxok = "select count(status) as jml from xml_test.log_purchase where vtype like '%$kode->kode%' and status = $sttsok and tanggal like '%$tgl_data%'"; //var_dump($strxok);
                    $trxok = mysqli_fetch_object(mysqli_query($konek, $strxok)); var_dump($trxok->jml);
                    $strxno = "select count(status) as jml from xml_test.log_purchase where vtype like '%$kode->kode%' and status = $sttsno and tanggal like '%$tgl_data%'"; //var_dump($strxno);
                    $trxno = mysqli_fetch_object(mysqli_query($konek, $strxno)); var_dump($trxno->jml);
                    // echo $kode->kode."<br>";
                    $sisql = "insert into xml_test.test_xml (shift, trx, status, kode) VALUES ('07.00-14.30', $trxok->jml, $sttsok, '$kode->kode')";
                    mysqli_query($konek, $sisql);
                     //echo "sekarang jam : ".date("H:i:s");
                }
            }
        ?>
        <table border="1" style="width:100%" id="myTable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Shift</th>
                    <th>Transaksi</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tsql = "Select * from xml_test.test_xml";
                    $etsql = mysqli_query($konek, $tsql);
                    $nmr = 1;
                    while ($baris = mysqli_fetch_object($etsql)) { ?>
                <tr>
                    <td><?php echo $nmr; ?></td>
                    <td><?php echo $baris->kode; ?></td>
                    <td><?php echo $baris->shift; ?></td>
                    <td><?php echo $baris->trx; ?></td>
                    <td><?php echo $baris->status; ?></td>
                    <td><?php echo $baris->waktu; ?></td>
                    <td><?php echo $baris->opr; ?></td>
                </tr>
                <?php $nmr++; } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</body>
</html>