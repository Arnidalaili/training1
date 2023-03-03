<?php
    include '../db.php';
    $operationadd = $_GET['operadd'];
    $operationedit = $_GET['operedit'];
    $operationdel = $_GET['operdel'];

    $invoice = $_GET['Invoice'];
    $nama = $_GET['Nama'];
    $tgl = $_GET['Tgl'];
    $jeniskelamin = $_GET['Jeniskelamin'];
    $saldo = $_GET['Saldo'];

    // if ($operationdel !== 0) {
    //     $invoice = Strtoupper($_POST['Invoice']);
    //     $nama = Strtoupper($_POST['Nama']);
    //     $tgl = $_POST['Tgl'];
    //     $newDate = date("Y-m-d", strtotime($tgl)); //ubah format tanggal
    //     $jeniskelamin = Strtoupper($_POST['Jeniskelamin']);
    //     $saldo = $_POST['Saldo'];
    //     $saldoTanpaTitik = str_replace('.', '', $saldo);
    //     $saldoTanpaKoma = str_replace(',', '.', $saldoTanpaTitik);
    // }
    $totalDetail = count($_POST['NamaBarang']);
    if ($operationadd) 
    {
        $sql= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newDate','$jeniskelamin','$saldoTanpaKoma')");
        for ($i=0; $i<$totalDetail; $i++)
        {
            $namabarang = $_POST['NamaBarang'][$i];
            $qty = $_POST['Qty'][$i];
            $harga = $_POST['Harga'][$i];
            $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$harga,'$invoice')");
        }
    } 
    else if ($operationedit) 
    {
        $sql = mysqli_query($connect,"UPDATE penjualan SET Invoice='$invoice', Nama='$nama', Tgl='$newDate', Jeniskelamin='$jeniskelamin', Saldo=$saldoTanpaKoma WHERE Invoice='$invoice'");

        $sqli = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$invoice'");
        for ($i=0; $i<$totalDetail; $i++)
        {
            $namabarang = $_POST['NamaBarang'][$i];
            $qty = $_POST['Qty'][$i];
            $harga = $_POST['Harga'][$i];
            $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$harga,'$Invoice')");
        }
    }
    else if ($operationdel)
    {
        $id = $_POST['id'];
        $sql = mysqli_query($connect,"DELETE FROM penjualan WHERE id='$id'");
        $sqldetail = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$Invoice'");
    }

    $response = array(
        'Invoice' => $invoice,
        'status' => 'submitted'
    );
    echo json_encode($response);
?>  

