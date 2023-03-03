<?php
    include('../db.php');

    $field = get_structure($connect);

    function get_structure($connect)
    {
        $data = mysqli_query($connect, "DESCRIBE penjualan");
        $field = [];
        while ($struct=mysqli_fetch_assoc($data))
        {
            $field[] = $struct;
        }
        return $field;
    }
    $response = ['structure' => $field];
    echo json_encode($response); 
?>