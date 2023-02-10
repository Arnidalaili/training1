<?php
    include '../db.php';
    $operation = $_POST['oper'];
    
    if ($operation !== 'del') {
        $invoice = Strtoupper($_POST['Invoice']);
        $nama = Strtoupper($_POST['Nama']);
        $tgl = $_POST['Tgl'];
        $newDate = date("Y-m-d", strtotime($tgl)); //ubah format tanggal
        $jeniskelamin = Strtoupper($_POST['Jeniskelamin']);
        $saldo = $_POST['Saldo'];
        $saldoTanpaTitik = str_replace('.', '', $saldo);
        $saldoTanpaKoma = str_replace(',', '.', $saldoTanpaTitik);
    }
    
    if ($operation === 'add') 
    {
        $sql= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newDate','$jeniskelamin','$saldoTanpaKoma')");
    } 
    else if ($operation === 'edit') 
    {
        $sql = mysqli_query($connect,"UPDATE penjualan SET Invoice='$invoice', Nama='$nama', Tgl='$newDate', Jeniskelamin='$jeniskelamin', Saldo=$saldoTanpaKoma WHERE Invoice='$invoice'");
    }
    else if ($operation === 'del')
    {
        $id = $_POST['id'];
        $sql = mysqli_query($connect,"DELETE FROM penjualan WHERE id='$id'");
    }
?>  

