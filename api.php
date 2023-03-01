<?php
    include 'db.php'; 
    $pagenum = $_GET['page']; 
    $pagesize = $_GET['rows']; 
    $sortfield = $_GET['sidx']; 
    $sortorder = $_GET['sord']; 
    $start = ($pagenum - 1) * $pagesize; 

    $query = "SELECT * FROM penjualan"; 
    $pages = "SELECT SQL_CALC_FOUND_ROWS * FROM penjualan";
    
    $filters = [];
    if(isset($_GET['filters'])) 
    {
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

    $globalsearch = [];
    if(isset($_GET['global_search']))
    {   
        $globalsearch = $_GET['global_search']; 
        if (isset($globalsearch))
        {
            $field = ['Invoice', 'Nama', 'Tgl', 'Jeniskelamin', 'Saldo'];
            for ($i=0; $i<count($field); $i++)
            {
                if ($i == 0)
                {
                    $query .= " WHERE $field[$i] LIKE '%$globalsearch%'";
                    $pages .= " WHERE $field[$i] LIKE '%$globalsearch%'";
                }
                else if ($i > 0)
                {
                    $query .= " OR $field[$i] LIKE '%$globalsearch%'";
                    $pages .= " OR $field[$i] LIKE '%$globalsearch%'";
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
    $sql = "SELECT FOUND_ROWS() AS 'found_rows';";
    $rows =  mysqli_query($connect, $sql);
    $rows = mysqli_fetch_assoc($rows);
    $records = $rows['found_rows']; 
    $totalpages = ceil((int)$records/(int)$pagesize); 

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
	    'data' => $sales
	);
    header('Content-Type: application/json');
	echo json_encode($response);
?>