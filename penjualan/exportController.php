<?php

    include ('../db.php');
    require '../vendor/autoload.php';
    $pagenum = $_GET['page']; 
    $pagesize = $_GET['rows']; 
    $sortfield = $_GET['sidx']; 
    $sortorder = $_GET['sord']; 
    $invoice = $_GET['invoice'];
    
    
    Export($connect, $pagenum, $pagesize, $sortorder, $sortfield, $invoice);

    function Export($connect, $pagenum, $pagesize, $sortorder, $sortfield, $invoice)
    {
        $query = "SELECT * FROM penjualan WHERE Invoice='$invoice'";
        $sales = [];
        $salesDetail = [];
        $dataDetail = [];
        $totalquery = mysqli_query($connect, $query); 
        while ($data=mysqli_fetch_assoc($totalquery)) 
        {
            
            $data['Tgl'] = date('d-m-Y', strtotime($data['Tgl']));
            $sales[] = $data;

            $tempData = [];
            $queryDetail = "SELECT * FROM detailpenjualan WHERE Invoice = '".$data['Invoice']."'";
            
            $totalDetail = mysqli_query($connect, $queryDetail);
            $numRows = mysqli_num_rows($totalDetail);
            if($numRows != 0)
            {
                while ($dataDetail=mysqli_fetch_assoc($totalDetail))
                {
                    $salesDetail[] = $dataDetail;
                    $tempData['sales'] = array_merge($sales,$salesDetail);
                }
            }
            else if ($numRows == 0)
            {
                $tempData['sales'] = $sales;
            }
        }
        // echo json_encode($salesDetail);
        //  die;
        //$dataTotal = json_encode($tempData);
        
        $arr_az = range('A','Z');
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();;

        $noBarang = 8;
        $noQty = 8;
        $noHarga = 8;
        $noTotal = 8;
        $styleHarga = 8;
        $styleTotal = 8;

        foreach ($sales as $index => $sale)
        {
            // $for ($i='A', $i!=$$excel->getActiveSheet()->getHighestColumn(), $i++) 
            // {
            //     $excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            // }

            foreach (range('A', $excel->getActiveSheet()->getHighestDataColumn()) as $col) {
                $excel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            } 
            foreach (range('B', $excel->getActiveSheet()->getHighestDataColumn()) as $col) {
                $excel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            } 
            foreach (range('C', $excel->getActiveSheet()->getHighestDataColumn()) as $col) {
                $excel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            } 
            foreach (range('D', $excel->getActiveSheet()->getHighestDataColumn()) as $col) {
                $excel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
            } 

            $invoicedata = $sale["Invoice"];
            $namadata = $sale["Nama"];
            $tgldata = $sale["Tgl"];
            $jeniskelamindata = $sale["Jeniskelamin"];
            $saldodata = $sale["Saldo"];
            $datakosong = '';

            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ];
            $styleArray2 = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'font' => [
                    'bold' => true,
                ],
            ];
            $sheet->getStyle('A1')->applyFromArray($styleArray);
            $sheet->getStyle('A2')->applyFromArray($styleArray);
            $sheet->getStyle('A3')->applyFromArray($styleArray);
            $sheet->getStyle('A4')->applyFromArray($styleArray);
            $sheet->getStyle('A5')->applyFromArray($styleArray);
            $sheet->getStyle('A6')->applyFromArray($styleArray);
            $sheet->getStyle('A7')->applyFromArray($styleArray2);
            $sheet->getStyle('B7')->applyFromArray($styleArray2);
            $sheet->getStyle('C7')->applyFromArray($styleArray2);
            $sheet->getStyle('D7')->applyFromArray($styleArray2);
            
            $sheet->setCellValue('A1','No.Invoice');
            $sheet->setCellValue('A2','Customer Name');
            $sheet->setCellValue('A3','Date');
            $sheet->setCellValue('A4','Gender');
            $sheet->setCellValue('A5','Saldo');
            $sheet->setCellValue('A6','');
            $sheet->setCellValue('A7','Item Name');
            $sheet->setCellValue('B7','Quantity');
            $sheet->setCellValue('C7','Item Price');
            $sheet->setCellValue('D7','Total Price');


            $sheet->setCellValue('B1',':');
            $sheet->setCellValue('B2',':');
            $sheet->setCellValue('B3',':');
            $sheet->setCellValue('B4',':');
            $sheet->setCellValue('B5',':');
            $sheet->setCellValue('B6','');
            
            $sheet->setCellValue('C1',$invoicedata);
            $sheet->setCellValue('C2',$namadata);
            $sheet->setCellValue('C3',$tgldata);
            $sheet->setCellValue('C4',$jeniskelamindata);
            $sheet->setCellValue('C5',$saldodata);
            $sheet->setCellValue('C6',$datakosong);
            $sheet->getStyle('C5',$saldodata)->getNumberFormat()->setFormatCode("Rp #,##0.00");

            foreach($salesDetail as $index => $detail)
            {
                $brgdata = $detail["NamaBarang"];
                $qtydata = $detail["Qty"];
                $hargadata = $detail["Harga"];
                //$total = 
                $sheet->setCellValue($arr_az[0].$noBarang++,$brgdata);
                $qtyCell = $arr_az[1].$noQty++;
                $sheet->setCellValue($qtyCell,$qtydata);
                $hargaCell = $arr_az[2].$noHarga++;
                $sheet->setCellValue($hargaCell,$hargadata);
                $sheet->getStyle($arr_az[2].$styleHarga++,$saldodata)->getNumberFormat()->setFormatCode("Rp #,##0.00");
                //$sheet->setCellValue($arr_az[1].($noQty+2),'Sub Total');
                // var_dump($hargaCell);
                // die;
                //$sumrange = $qtydata * $hargadata; // 500000
                //{Sum(int.Parse(sales.Harga)*int.Parse(sales.Qty))}
                //$sumrange = ($arr_az[1].$noQty++,$qtydata) * ($arr_az[2].$noHarga++,$hargadata);
                // var_dump($sumrange);
                // die;
                //'=SUM(' . $sumrange . ')'
                //$sumrange = '=SUM(' . ($arr_az[1].$noQty++,$qtydata)*($arr_az[2].$noHarga++,$hargadata) . ')';
                $sheet->setCellValue($arr_az[3].($noTotal++), '='.$qtyCell.'*'.$hargaCell.'');
                $sheet->getStyle($arr_az[3].$styleTotal++,'='.$qtyCell.'*'.$hargaCell.'')->getNumberFormat()->setFormatCode("Rp #,##0.00");

                $sheet->setCellValue($arr_az[2].($noHarga+2),'Sub Total');
                $sheet->setCellValue($arr_az[3].($noTotal+2), '=SUM(D8:D9)');
                
                //$sheet->getStyle($arr_az[1].($noQty+2))->applyFromArray($styleArray2);
            }
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