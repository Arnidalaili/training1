<?php
    include 'db.php';  
    $pagenum = $_GET['page']; //page
    $pagesize = $_GET['rows']; //row per page
    $sortfield = $_GET['sidx']; //kiriman sorting
    $sortorder = $_GET['sord']; //asc/desc
    $start = ($pagenum - 1) * $pagesize; //mulai halaman

    $query = "SELECT * FROM penjualan";
    $pages = "SELECT COUNT(*) as total FROM penjualan"; 
    
    $filters = [];
    if(isset($_GET['filters'])) {
        $filters = json_decode($_GET['filters'], true);
        $totalfilters = count($filters['rules']);
        if (isset($filters))
        {
            for ($i=0; $i<$totalfilters; $i++)
            { 
                $filterdata = $filters['rules'][$i]["data"];
                $filterfield = $filters['rules'][$i]["field"];

                if ($filterfield == 'Tgl')
                {
                    $filterdata = date("Y-m-d", strtotime($filterdata));
                }

                if ($i == 0)
                {
                    $query .= " WHERE $filterfield LIKE '%$filterdata%'";
                    $pages .= " WHERE $filterfield LIKE '%$filterdata%'";
                }
                else if ($i > 0)
                {
                    $query .= " AND $filterfield LIKE '%$filterdata%'";
                    $pages .= " AND $filterfield LIKE '%$filterdata%'";
                }
            }
        }
    }

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
    $row = mysqli_fetch_assoc($pagesquery);
    $records = $row; //records
    $totalpages = ceil($row['total']/$pagesize); //total data

    if (isset($pagenum))
    {
        $query .= " LIMIT $start, $pagesize"; 
    }
    
    $sales = []; 
    $totalquery = mysqli_query($connect, $query);
    while ($data=mysqli_fetch_assoc($totalquery)) 
    {
        $sales[] = $data;
	}
    $response = array(
        'message' => 'Success',
        'page' => $pagenum,
        'records' => $records,
        'total' => $totalpages,
	    'data' => $sales,
	);
    header('Content-Type: application/json');
	echo json_encode($response);
?>