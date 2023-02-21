<?php
    include('../db.php');
	$Invoice = $_GET['Invoice'];
	$sortfield = $_GET['sidx']; 
    $sortorder = $_GET['sord'];
	
	$position = getWithPosition($Invoice, $sortfield, $sortorder, $connect);
	
    function getWithPosition($Invoice, $sortfield, $sortorder, $connect)
	{
		$data = mysqli_query($connect, "SELECT temp.position, temp.*
		FROM 
		(
			SELECT @rownum := @rownum + 1 AS position, penjualan.*
			FROM penjualan
			JOIN 
			(
				SELECT @rownum := 0
			) rownum ORDER BY penjualan.$sortfield $sortorder
		) temp WHERE temp.Invoice = '". $Invoice ."'");

		$post = mysqli_fetch_assoc($data);
		$pos = $post['position'];
		return $pos;
	}
	$response = ['Invoice' => $Invoice, 'position' => $position];
    echo json_encode($response);
?>