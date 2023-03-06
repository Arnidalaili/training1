<?php
    include 'db.php'; 

    //if 
    //$invoice = $_GET['Invoice'];
    // var_dump($invoice);
    // die;
    $query = mysqli_query($connect, "SELECT * FROM detailpenjualan");
    $sales = [];
    while($data=mysqli_fetch_array($query))
    {
        $sales[] = $data;
    }
    $response = array(
        'message' => 'Success',
    );
    echo json_encode($response);
?>