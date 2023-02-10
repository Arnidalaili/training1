<?php
    include '../db.php';
    $invoice = $_POST['Invoice'];
    $nama = $_POST['Nama'];
    $tgl = $_POST['Tgl'];
    $sql= mysqli_query($connect, "INSERT INTO penjualan (Invoice, Nama, Tgl) VALUES ('$invoice','$nama','$tgl')");
 
    $totalDetail = count($_POST['NamaBarang']);
    for ($i=0; $i<$totalDetail; $i++)
    {
        $namabarang = $_POST['NamaBarang'][$i];
        $qty = $_POST['Qty'][$i];
        $harga = $_POST['Harga'][$i];
        $sql= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$harga,'$invoice')");
    }
    header("location:index.php");
?>

