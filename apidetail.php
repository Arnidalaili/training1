<?php
    include 'db.php'; 
    $invoice = $_GET['Invoice'];
    $pagenum = $_GET['page'];
    $pagesize = $_GET['rows'];
    $sortfield = $_GET['sidx'];
    $sortorder = $_GET['sord'];
    $start = ($pagenum - 1) * $pagesize; 

    $query = "SELECT * FROM detailpenjualan WHERE Invoice='$invoice'";
    $pages = "SELECT SQL_CALC_FOUND_ROWS * FROM detailpenjualan WHERE Invoice='$invoice'";

    if (isset($sortfield) && $sortfield != NULL) 
    {   
        if ($sortorder == 'desc')  
        {
            $query  .= " ORDER BY $sortfield DESC"; 
        }
        else if ($sortorder == 'asc') 
        {
            $query .= " ORDER BY $sortfield ASC"; 
        }
    }
    $pagesquery = mysqli_query($connect, $pages);
    $sql = "SELECT FOUND_ROWS() AS 'found_rows'";
    $rows =  mysqli_query($connect, $sql);
    $rows = mysqli_fetch_assoc($rows);
    $records = $rows['found_rows']; 
    $totalpages = ceil((int)$records/(int)$pagesize);

    if (isset($pagenum)) 
    {
        $query .= " LIMIT $start, $pagesize";  
    }

    $totaldetail = mysqli_query($connect, $query);
    $sales = [];
    while($data=mysqli_fetch_assoc($totaldetail))
    {
        $sales [] = $data;
    }
    $response = array(
        'message' => 'Success',
        'page' => $pagenum,  
        'records' => $records, 
        'total' => $totalpages,
        'data' => $sales
    );
    echo json_encode($response);
?>

