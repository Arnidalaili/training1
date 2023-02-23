<?php
    include ('../db.php');
    $pagenum = $_GET['page']; 
    $pagesize = $_GET['rows']; 
    $sortfield = $_GET['sidx']; 
    $sortorder = $_GET['sord']; 
    
    Report($connect, $pagenum, $pagesize, $sortorder, $sortfield);

    function Report($connect, $pagenum, $pagesize, $sortorder, $sortfield)
    {
        $query = "SELECT * FROM penjualan";
        $pages = "SELECT SQL_CALC_FOUND_ROWS * FROM penjualan";
        $start = $_GET['start'] - 1;
        $limit = $_GET['limit'] - $start;

        $globalsearch = [];
        if (isset($_GET['global_search']))
        {
            $globalsearch = $_GET['global_search'];
            if(isset($globalsearch))
            {
                $field = ['Invoice', 'Nama', 'Tgl', 'Jeniskelamin', 'Saldo'];
                for ($i=0; $i<count($field); $i++)
                {
                    if ($i == 0)
                    {
                        $query .= " WHERE $field[$i] LIKE '%$globalsearch%'";
                        $pages .= " WHERE $field[$i] LIKE '%$globalsearch%'";
                    }
                    else if($i >= 0)
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

        if (isset($pagenum)) 
        {
            $query .= " LIMIT $start, $limit";  
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
            'data' => $sales
        );
        $json = json_encode($sales);
        $bytes = file_put_contents("./reports/demo.json", $json);
        
        header('Content-Type: application/json');
        echo json_encode($response);

        
    }
?>
