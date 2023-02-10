<?php
    include '../db.php';
    $Invoice = $_POST['Invoice'];
    $sql = mysqli_query($connect,"DELETE FROM penjualan WHERE Invoice='$Invoice'");
    $sqli = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$Invoice'");
    header("location:index.php");
?>