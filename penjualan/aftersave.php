<?php
    include '../db.php';
	$name = $_GET['name'];
	$invoice = $_GET['Invoice'];
	echo $invoice;
	echo $name;
	// $Invoice = $_GET['Invoice'];
	// $pagenum = $_GET['page']; 
    // $pagesize = $_GET['rows'];
	// $sortfield = $_GET['sidx']; 
    // $sortorder = $_GET['sord'];
	//echo 'hello word';
	
	// getWithPosition();

    // function getWithPosition($Invoice, $sortfield, $sortorder)
	// {
	// 	$data = $this->db->query("
	// 		SELECT temp.position, temp.*
	// 		FROM (
	// 			SELECT @rownum := @rownum + 1 AS position,
	// 						 penjualan.*
	// 			FROM penjualan
	// 			JOIN (
	// 				SELECT @rownum := 0
	// 			) rownum
	// 			ORDER BY penjualan.$sortfield $sortorder
	// 		) temp
	// 		WHERE temp.Invoice = '". $Invoice ."'
	// 	")->row();
	// 	return $data;
	// }
?>