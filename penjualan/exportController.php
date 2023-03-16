<?php

    include ('../db.php');
    require '../vendor/autoload.php';
    $pagenum = $_GET['page']; 
    $pagesize = $_GET['rows']; 
    $sortfield = $_GET['sidx']; 
    $sortorder = $_GET['sord']; 
    
    
    Export($connect, $pagenum, $pagesize, $sortorder, $sortfield);
    

    function Export($connect, $pagenum, $pagesize, $sortorder, $sortfield)
    {
        $query = "SELECT * FROM penjualan";
        $pages = "SELECT SQL_CALC_FOUND_ROWS * FROM penjualan";
        $start = $_GET['start'] - 1;
        $limit = $_GET['limit'] - $start;
        
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
        $salesDetail = [];
        $dataDetail = [];
        $totalquery = mysqli_query($connect, $query); 
        while ($data=mysqli_fetch_assoc($totalquery)) 
        {
            $data['Tgl'] = date('d-m-Y', strtotime($data['Tgl']));
            $sales[] = $data;
        }
        $tempData = [];
        foreach($sales as $index => $dataSales) 
        {
            $queryDetail = "SELECT * FROM detailpenjualan WHERE Invoice = '".$dataSales['Invoice']."'";
            $totalDetail = mysqli_query($connect, $queryDetail);
            while ($dataDetail=mysqli_fetch_assoc($totalDetail))
            {
                $salesDetail[] = $dataDetail;
            }
            $mrtData[] = array_merge($dataSales,$salesDetail);
            $tempData['sales'] = $mrtData;
        }
        $dataTotal = json_encode($tempData);
        // var_dump($dataTotal);
        // die;

        $arr_az = range('A','Z');
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();
        foreach ($sales as $index => $sale)
        {
            $invoicedata = $sale["Invoice"];
            $namadata = $sale["Nama"];
            $tgldata = $sale["Tgl"];
            $jeniskelamindata = $sale["Jeniskelamin"];
            $saldodata = $sale["Saldo"];

            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
            $sheet->getStyle('A1')->applyFromArray($styleArray);
            $sheet->getStyle('B1')->applyFromArray($styleArray);
            $sheet->getStyle('C1')->applyFromArray($styleArray);
            $sheet->getStyle('D1')->applyFromArray($styleArray);
            $sheet->getStyle('E1')->applyFromArray($styleArray);

            $sheet->setCellValue('A1','No.Invoice');
            $sheet->setCellValue('B1','Nama Customer');
            $sheet->setCellValue('C1','Tanggal Pembelian');
            $sheet->setCellValue('D1','Jenis Kelamin');
            $sheet->setCellValue('E1','Saldo');

            $styleArray2 = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                ],
            ];

            $sheet->setCellValue($arr_az[0].$index + 2,$invoicedata);
            $sheet->setCellValue($arr_az[1].$index + 2,$namadata);
            $sheet->setCellValue($arr_az[2].$index + 2,$tgldata);
            $sheet->setCellValue($arr_az[3].$index + 2,$jeniskelamindata);
            $sheet->setCellValue($arr_az[4].$index + 2,$saldodata); 

            $sheet->getStyle($arr_az[0].$index + 2,$invoicedata)->applyFromArray($styleArray2);;
            $sheet->getStyle($arr_az[4].$index + 2,$saldodata)->getNumberFormat()->setFormatCode("Rp #,##0.00");
        }
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="filename_' . time() . '.xlsx"');
        header('Cache-Control: max-age=0');

        $xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
        $xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
        $xlsxWriter->save('php://output');
    }
    require "reports/stireport_config.inc"; 
?>