<?php
    include 'db.php';  
    $pagenum = $_GET['page']; //page
    $pagesize = $_GET['rows']; //row per page
    $sortfield = $_GET['sidx']; //kiriman sorting
    $sortorder = $_GET['sord']; //asc/desc
    $start = ($pagenum - 1) * $pagesize; //mulai halaman

    $query = "SELECT * FROM penjualan"; //query select data
    $pages = "SELECT COUNT(*) as total FROM penjualan"; //query select total data
    
    $filters = [];
    if(isset($_GET['filters'])) {
        $filters = json_decode($_GET['filters'], true); //mengubah data array menjadi string 
        $totalfilters = count($filters['rules']); //variabel yang menampung jumlah rules
        if (isset($filters))
        {
            for ($i=0; $i<$totalfilters; $i++) //perulangan filter
            { 
                $filterdata = $filters['rules'][$i]["data"]; //variabel untuk parameter data di dalam rules
                $filterfield = $filters['rules'][$i]["field"]; //variabel untuk parameter field di dalam rules

                if ($filterfield == 'Tgl') //kondisi untuk tanggal, jika field = tanggal 
                {
                    $filterdata = date("Y-m-d", strtotime($filterdata)); //maka format tanggal diubah ke datedatabase
                }

                if ($i == 0) //kondisi jika filter cuma 1 field 
                {
                    $query .= " WHERE $filterfield LIKE '%$filterdata%'"; //sambungan query untuk select data filter
                    $pages .= " WHERE $filterfield LIKE '%$filterdata%'"; //sambungan query untuk total data 
                }
                else if ($i > 0) //kondisi jika filter lebih dari (>) 1
                {
                    $query .= " AND $filterfield LIKE '%$filterdata%'"; //sambungan query untuk select data filter
                    $pages .= " AND $filterfield LIKE '%$filterdata%'"; //sambungan query untuk total data 
                }
            }
        }
    }

    if (isset($sortfield) && $sortfield != NULL) //kondisi untuk sorting
    {   
        if ($sortorder == 'desc')  //jika sord nya = desc
        {
            $query  .= " ORDER BY $sortfield DESC"; //maka sambungan query select
        }
        else if ($sortorder == 'asc') //jika sord = asc
        {
            $query .= " ORDER BY $sortfield ASC"; //maka sambungan query select
        }
    }

    $pagesquery = mysqli_query($connect, $pages); //
    $row = mysqli_fetch_assoc($pagesquery);
    $records = $row; //records
    $totalpages = ceil($row['total']/$pagesize); //ceil -> membulatkan bilangan keatas , untuk total data/10

    if (isset($pagenum)) // kondisi jika paging
    {
        $query .= " LIMIT $start, $pagesize";  //maka sambungan query select
    }
    
    $sales = [];  //array yang menampung data
    $totalquery = mysqli_query($connect, $query); //variabel pengganti 
    while ($data=mysqli_fetch_assoc($totalquery)) //perulangban untuk mengambil data
    {
        $sales[] = $data; //data yang sudah diambil, dimasukkan ke dalam variabel data
	}
    $response = array( //response array 
        'message' => 'Success', //pesan singkat 
        'page' => $pagenum, //parameter page 
        'records' => $records, //parameter records
        'total' => $totalpages, //parameter total halaman
	    'data' => $sales, //parameter data yang tampil
	);
    header('Content-Type: application/json');
	echo json_encode($response);
?>