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
                $field = ['Invoice', 'Nama', 'Tgl', 'Jen iskelamin', 'Saldo'];
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
            $sales[]['penjualan'] = ['penjualan' => $data,]; 
            
        }
        // $response = array(  
        //     'message' => 'Success', 
        //     'page' => $pagenum,  
        //     'records' => $records,   
        //     'data' => $sales
        // );
        
        $json = json_encode($sales);
        $bytes = file_put_contents("./reports/demo.json", $json);

        return $sales;
    }
    // var_dump('test');
    // die;
    require "reports/stireport_config.inc"; 
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Penjualan Report</title>
        <link rel="stylesheet" type="text/css" href="stimulsoft-report\2021.03.06\css\stimulsoft.viewer.office2013.whiteblue.css"/>
        <link rel="stylesheet" type="text/css" href="stimulsoft-report\2021.03.06\css\stimulsoft.designer.office2013.whiteblue.css"/>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.reports.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.viewer.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.dashboards.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.designer.js"></script>
        
        <script>
            
            function Start()
            {
                Stimulsoft.Base.StiLicense.loadFromFile("./<?= $stireport_path ?>stimulsoft/license.php");
                var viewer = new Stimulsoft.Viewer.StiViewer(null, "StiViewer", false)
                var report = new Stimulsoft.Report.StiReport()
                
                var options = new Stimulsoft.Designer.StiDesignerOptions()
                var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
                var dataSet = new Stimulsoft.System.Data.DataSet("Data")
                //alert('test')
                viewer.renderHtml('content')
                report.loadFile('./reports/penjualan.mrt')

                report.dictionary.dataSources.clear()
                
                dataSet.readJson(<?php echo json_encode(Report($connect, $pagenum, $pagesize, $sortorder, $sortfield)) ?>)

                report.regData(dataSet.dataSetName, '', dataSet)
                report.dictionary.synchronize()

                viewer.report = report
                designer.renderHtml("content")
                designer.report = report
                
            }

            function afterPrint()
            {
                if (confirm('Tutup halaman ?'))
                {
                    window.close()
                }
            }
        </script>
        <style type="text/css">
            .stiJsViewerPage 
            {
                word-break: break-all
            }
        </style>
    </head>
    <body onLoad="Start()" onafterprint="afterPrint()">
        <div id="content"></div>
    </body>
</html>