<?php
    include '../db.php';
    $operation = $_POST['oper'];

    $invoice = strtoupper($_POST['Invoice']);
    if ($operation != 'del')
    {
        $nama = strtoupper($_POST['Nama']);
        $tgl = $_POST['Tgl'];
        $newtgl = date("Y-m-d", strtotime($tgl));
        $jeniskelamin = strtoupper($_POST['Jeniskelamin']);
        $saldo = $_POST['Saldo'];
        $saldotitik = str_replace('.', '', $saldo);
        $saldokoma = str_replace(',', '.', $saldotitik);

        
        //$totalDetail = count($_POST['Namabarang']);
        if ($operation == 'add') 
        {
            $dataheader = mysqli_autocommit($connect, false);
            //die;
            $sqlheader= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
            if ($sqlheader == true)
            {
                if(isset($_POST['Namabarang']))
                {
                    $totalDetail = count($_POST['Namabarang']);
                    for ($i=0; $i<$totalDetail; $i++)
                    {
                        $datadetail = $_POST['Namabarang'][$i];
                        if (isset($datadetail) && !empty($datadetail))
                        {
                            $namabarang = strtoupper($_POST['Namabarang'][$i]);
                            $qty = $_POST['Qty'][$i];
                            $harga = $_POST['Harga'][$i];
                            $hargatitik = str_replace('.', '', $harga);
                            $hargakoma = str_replace(',', '.', $hargatitik);

                            $data1 = mysqli_autocommit($connect, false);
                            $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$hargakoma,'$invoice')");
                            //die;
                            if ($sqldetail == true)
                            {
                                $data2 = mysqli_commit($connect);
                            }
                            else if ($sqldetail == false)
                            {
                                $data3 = mysqli_rollback($connect);
                            }
                        }
                        else if (isset($_POST['Namabarang']))
                        {
                            if (empty($datadetail))
                            {
                                $data1 = mysqli_autocommit($connect, false);
                                $sqlheader= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
                                $data = mysqli_commit($connect);
                            }
                            
                        }
                    }
                }
                else 
                {
                    $data1 = mysqli_autocommit($connect, false);
                    $sqlheader= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
                    $data = mysqli_commit($connect);
                }
            }
            else if ($sqlheader == false)
            {
                $dataheader = mysqli_rollback($connect);
            }
        } 
        else if ($operation == 'edit') 
        {
            $dataheader = mysqli_autocommit($connect, false);
            //die;
            $sqlheader = mysqli_query($connect,"UPDATE penjualan SET Invoice='$invoice', Nama='$nama', Tgl='$newtgl', Jeniskelamin='$jeniskelamin', Saldo=$saldokoma WHERE Invoice='$invoice'");
            if ($sqlheader == true)
            {
                if (isset($_POST['Namabarang']))
                {
                    $totalDetail = count($_POST['Namabarang']);
                    $sqldel = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$invoice'");
                    for ($i=0; $i<$totalDetail; $i++)
                    {
                        $datadetail = $_POST['Namabarang'][$i];
                        if (isset($datadetail) && !empty($datadetail))
                        {
                            $namabarang = strtoupper($_POST['Namabarang'][$i]);
                            $qty = $_POST['Qty'][$i];
                            $harga = $_POST['Harga'][$i];
                            $hargatitik = str_replace('.', '', $harga);
                            $hargakoma = str_replace(',', '.', $hargatitik);
    
                            $data1 = mysqli_autocommit($connect, false);
                            $sqldetail= mysqli_query($connect, "INSERT INTO detailpenjualan (NamaBarang, Qty, Harga, Invoice) VALUES ('$namabarang',$qty,$hargakoma,'$invoice')");
                            //die;
                            if ($sqldetail == true)
                            {
                                $data2 = mysqli_commit($connect);
                            }
                            else if ($sqldetail == false)
                            {
                                $data3 = mysqli_rollback($connect);
                            }
                        }
                        else if (isset($_POST['Namabarang']))
                        {
                            if(empty($datadetail))
                            {
                                $data1 = mysqli_autocommit($connect, false);
                                $sqlheader= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
                                $data = mysqli_commit($connect);
                            }
                            
                        }
                    }
                }
                else
                {
                    $data1 = mysqli_autocommit($connect, false);
                    $sqlheader= mysqli_query($connect,"INSERT INTO penjualan (Invoice, Nama, Tgl, Jeniskelamin, Saldo) VALUES ('$invoice','$nama','$newtgl','$jeniskelamin','$saldokoma')");
                    $sqldel = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$invoice'");
                    $data = mysqli_commit($connect);
                }
            }
            else if($sqlheader == false)
            {
                $dataheader = mysqli_rollback($connect);
            }
        }
    }
    else if ($operation == 'del')
    {
        $sql = mysqli_query($connect,"DELETE FROM penjualan WHERE Invoice='$invoice'");
        $sqldetail = mysqli_query($connect,"DELETE FROM detailpenjualan WHERE Invoice='$invoice'");
    }
    $response = array(
        'invoice' => $invoice,
        'status' => 'submitted'
    );
    echo json_encode($response);
?>  

