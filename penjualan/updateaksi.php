<?php
    include '../db.php';
        $Invoice=$_POST['Invoice'];
        $Nama=$_POST['Nama'];
        $Tgl=$_POST['Tgl'];
        $sql = mysqli_query($connect,"UPDATE penjualan SET Invoice='$Invoice', Nama='$Nama', Tgl='$Tgl' WHERE Invoice='$Invoice'");

        $sqli = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$Invoice'");
        
        $totalDetail = count($_POST['NamaBarang']);
        for ($i=0; $i<$totalDetail; $i++)
        {
            $namabarang = $_POST['NamaBarang'][$i];
            $qty = $_POST['Qty'][$i];
            $harga = $_POST['Harga'][$i];
            $sql= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$harga,'$Invoice')");
        }
    header("location:index.php");
?>