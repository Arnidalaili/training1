<?php
    include '../db.php';
    $operationadd = $_POST['operadd'];
    // $operationedit = $_POST['operedit'];
    // $operationdel = $_POST['operdel'];

    // if ($operationdel !== 0)
    // {
    $invoice = $_POST['Invoice'];
    $nama = $_POST['Nama'];
    $tgl = $_POST['Tgl'];
    $newtgl = date("Y-m-d", strtotime($tgl));
    $jeniskelamin = $_POST['Jeniskelamin'];
    $saldo = $_POST['Saldo'];
    $saldotitik = str_replace('.', '', $saldo);
    $saldokoma = str_replace(',', '.', $saldotitik);
    // }

    $totalDetail = count($_POST['Namabarang']);
    if ($operationadd) 
    {
        $sql= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
        for ($i=0; $i<$totalDetail; $i++)
        {
            $namabarang = $_POST['Namabarang'][$i];
            $qty = $_POST['Qty'][$i];
            $harga = $_POST['Harga'][$i];
            $hargatitik = str_replace('.', '', $harga);
            $hargakoma = str_replace(',', '.', $hargatitik);
            
            $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$hargakoma,'$invoice')");
        }
    } 
    // else if ($operationedit) 
    // {
    //     $sql = mysqli_query($connect,"UPDATE penjualan SET Invoice='$invoice', Nama='$nama', Tgl='$newDate', Jeniskelamin='$jeniskelamin', Saldo=$saldoTanpaKoma WHERE Invoice='$invoice'");

    //     $sqli = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$invoice'");
    //     for ($i=0; $i<$totalDetail; $i++)
    //     {
    //         $namabarang = $_POST['NamaBarang'][$i];
    //         $qty = $_POST['Qty'][$i];
    //         $harga = $_POST['Harga'][$i];
    //         $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$harga,'$Invoice')");
    //     }
    // }
    // else if ($operationdel)
    // {
    //     $id = $_POST['id'];
    //     $sql = mysqli_query($connect,"DELETE FROM penjualan WHERE id='$id'");
    //     $sqldetail = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$Invoice'");
    // }

    $response = array(
        'Invoice' => $invoice,
        'status' => 'submitted'
    );
    echo json_encode($response);
?>  

