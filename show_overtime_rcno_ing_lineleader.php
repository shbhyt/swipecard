<?php 
	session_start();
	$access = $_SESSION["permission"];
?>
<html>

<head>
<!-- Bootstrap stylesheets (included template modifications) -->
<link href="assets/css/bootstrap.css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/Button_Plugins.js"></script>
<title>查詢頁面</title>
</head>
<body>
<?php 
	
	include("mysql_config.php");
	
	$workshopNo = $_POST['workshopNo'];
	$SDate = $_POST['SDate'];
	$EDate = $_POST['EDate'];
	$depid = $_SESSION['depid'];
	$url = $_POST['urlA'];
	$checkState = $_POST['checkState'];
//	 echo $workshopNo;
	// $rcno_sql   .= "SELECT 	rc_no,
							 // prod_line_code, 
							 // checkstate,
							 // Date_format(swipecardtime, '%Y-%m-%d') sdate,
							 // shift
					// FROM testswipecardtime
					// WHERE  	Date_format(swipecardtime, '%Y-%m-%d') >= '".$SDate."'
							// AND Date_format(swipecardtime, '%Y-%m-%d') <= '".$EDate."'
							// AND Date_format(swipecardtime2, '%H:%i:%s') > '18:00:00'
							// AND Date_format(swipecardtime2, '%H:%i:%s') < '23:59:00'
							// AND (checkState=0 or checkState=9)
							// AND 
							// AND prod_line_code like '".$lineno."'
							// ";
							
	$rcno_sql   .= "SELECT 	a.rc_no,
							a.prod_line_code,
							a.checkstate,
							Date_format(a.swipecardtime, '%Y-%m-%d') sdate,
							a.shift,
							a.WorkshopNo
					FROM testswipecardtime a,testemployee b
					WHERE  	Date_format(swipecardtime, '%Y-%m-%d') >= '".$SDate."'
							AND Date_format(swipecardtime, '%Y-%m-%d') <= '".$EDate."'
							and swipecardtime2 is not null
							AND Shift = 'D'
							AND (checkState=0 or checkState=9)
							AND a.cardid = b.cardid
							AND workshopNo like '".$workshopNo."'
							AND b.depid like '".$depid."'
							";						
		
	
	$rcno_sql_n = "SELECT 	a.rc_no,
							a.prod_line_code,
							a.checkstate,
							Date_format(a.swipecardtime, '%Y-%m-%d') sdate,
							a.shift,
							a.WorkshopNo
					FROM testswipecardtime a,testemployee b
					WHERE  	Date_format(swipecardtime, '%Y-%m-%d') >= '".$SDate."'
							AND Date_format(swipecardtime, '%Y-%m-%d') <= '".$EDate."'
							and swipecardtime2 is not null
							AND (checkState=0 or checkState=9)
							AND Shift = 'N'
							AND a.cardid = b.cardid							
							AND workshopNo like '".$workshopNo."'
							AND b.depid like '".$depid."'
							";														
	
//	 echo $rcno_sql;
	$rcno_true = array();
	$rcno_all = array();
	$norcno = array();
	$rcno_rows = $mysqli->query($rcno_sql);
	// echo mysqli_num_rows($rcno_rows);;
	// while($row = $rcno_rows->fetch_row()){
		
		// if($row[2]==0||$row[2]==9){
			// $rcno_true[$row[0]] +=1;
		// }
		// if($row[2]==1){
			// $rcno_false[$row[0]] +=1;
		// }
		// $rcno_all[$row[0]][$row[3]] += 1;
		// $arr_date[$row[0]] = $row[3];
		// $arr_lineno[$row[0]] = $row[1];
	// }
	
	// var_dump($rcno_all);
	while($row1 = $rcno_rows->fetch_row()){
		if((empty($row1[0]))&&($row1[4]=='D'||$row1[4]=='N')){
			if($row1[2]==0||$row1[2]==9){
				$norcno_not[$row1[5]][$row1[1]][$row1[3]][$row1[4]] +=1;
			}else if($row1[2]==1){
				$norcno_is[$row1[5]][$row1[1]][$row1[3]][$row1[4]] +=1;
			}
		}else{
			if($row1[2]==0||$row1[2]==9){
				$rcno_true[$row1[0]] +=1;
			}
			if($row1[2]==1){
				$rcno_false[$row1[0]] +=1;
			}
		}
		$rcno_all[$row1[0]][$row1[3]] += 1;
		$arr_date[$row1[0]] = $row1[3];
		$arr_lineno[$row1[0]] = $row1[1];
		$arr_workshopno[$row1[0]] = $row1[5];
	}
			
	// var_dump($rcno_true);
	// var_dump($norcno_is);
	// echo "<br>";
	mysqli_free_result($rcno_rows);
	
	$rcno_true_n = array();
	$rcno_all_n = array();
	// echo $rcno_sql_n."<br>";
	$rcno_rows_nshift = $mysqli->query($rcno_sql_n);
	
	//夜班
	while($row_n = $rcno_rows_nshift->fetch_row()){
		if(empty($row_n[0])&&($row_n[4]=='D'||$row_n[4]=='N')){
			if($row_n[2]==0||$row_n[2]==9){
				$norcno_not[$row_n[5]][$row_n[1]][$row_n[3]][$row_n[4]] +=1;
			}else if($row_n[2]==1){
				$norcno_is[$row_n[5]][$row_n[1]][$row_n[3]][$row_n[4]] +=1;
			}
		}else{
			if($row_n[2]==0||$row_n[2]==9){
				$rcno_true_n[$row_n[0]] +=1;
			}
			if($row_n[2]==1){
				$rcno_false_n[$row_n[0]] +=1;
			}
			
		}
		$rcno_all_n[$row_n[0]][$row_n[3]] += 1;
		$arr_date_n[$row_n[0]] = $row_n[3];
		$arr_lineno_n[$row_n[0]] = $row_n[1];
		$arr_workshopno_n[$row_n[0]] = $row_n[5];
	}
	// $countDay = mysqli_num_rows($rcno_rows_nshift);
	
	// echo "countDay: ".$countDay;
	
	mysqli_free_result($rcno_rows_nshift);
	
	if($rcno_true!=null){
		foreach($rcno_true as $key => $val){
			if(end(array_keys($rcno_true))==$key){
				$rcnoStr .= "'".$key."'";
			}else{
				$rcnoStr .= "'".$key."',";
			}
			
		}
	}else{
		$rcnoStr="''";
	}
	
	
	// echo $rcnoStr."<br>";
	foreach($rcno_true_n as $key => $val){
		if(end(array_keys($rcno_true_n))==$key){
			$rcnoStr_n .= "'".$key."'";
		}else{
			$rcnoStr_n .= "'".$key."',";
		}
		
	}
	
	//TODO rc_no 最早一筆的前30天
		$manPower_sql = "select rc_no,std_man_power,primary_item_no from testrcline where CUR_DATE > DATE_SUB(curdate(),INTERVAL 30 DAY)
			and rc_no in (".$rcnoStr.")	";
		// echo $manPower_sql."<br>";
		$man_rows = $mysqli->query($manPower_sql);
		// $countPower = mysqli_num_rows($man_rows);
		if($man_rows!=null){
			while($row = $man_rows->fetch_row()){
				$manPower[$row[0]] = $row[1];
				$item_no[$row[0]] = $row[2];
				$rc_no[] = $row[0];
			}
			mysqli_free_result($man_rows);
		}
		
		
		$manPower_sql_n = "select rc_no,std_man_power,primary_item_no from testrcline where CUR_DATE > DATE_SUB(curdate(),INTERVAL 30 DAY)
			and rc_no in (".$rcnoStr_n.")	";
		// echo $manPower_sql;
		$man_rows_n = $mysqli->query($manPower_sql_n);
		
		
		if($man_rows_n!=null){
			while($row = $man_rows_n->fetch_row()){
				$manPower_n[$row[0]] = $row[1];
				$item_no_n[$row[0]] = $row[2];
				$rc_no_n[] = $row[0];
			}
			mysqli_free_result($man_rows_n);
		}
	
	// var_dump($countDay);
	// $countPower = mysqli_num_rows($man_rows);
	// echo "countPower: ".$countPower;
	
	$count_RC_D = count($rc_no);
	$count_RC_N = count($rc_no_n);
	$count_noRC = count($norcno_not);
if($count_RC_D>0||$count_RC_N>0){
		echo"<div class=\"panel-body\" style=\"border: 1px solid #e1e3e6;\">"
		  . "	<table class=\"table table-striped\">"
		  . "		<tr>"
		  . "			<th>車間</th>"
//		  . "			<th>線號</th>"
		  . "			<th>日期</th>"
		  . "			<th>班別</th>"
		  . "			<th>指示單號</th>"
		  . "			<th>料號</th>"
		  . "			<th>標準人數</th>"
		  . "			<th>實際加班人數</th>"
		  . "			<th>詳情</th>"
		  . "		</tr>"
		  ."";
		 
		 if($count_RC_D>0){
			 foreach($rc_no as $key => $value){
				$cch .= "<tr>";
				$cch .= "<td>".$arr_workshopno[$value]."</td>";
//				$cch .= "<td>".$arr_lineno[$value]."</td>";
				$cch .= "<td>".$arr_date[$value]."</td>";
				$cch .= "<td>日班</td>";
				$cch .= "<td>".$value."</td>";
				$cch .= "<td>".$item_no[$value]."</td>";
				$cch .= "<td>".$manPower[$value]."</td>";
				$cch .= "<td>".$rcno_true[$value]."/".$rcno_all[$value][$arr_date[$value]]."</td>";
				$cch .= "<td>";
				$cch .= "<form method=\"post\" action=\"".$url."\"
							target=\"gameWindow\" onsubmit=\"return openTableWindow();\">
							<input type=\"hidden\" name=\"SDate\" value=\"".$arr_date[$value]."\">
							<input type=\"hidden\" name=\"LineNo\" value=\"".$arr_lineno[$value]."\">
							<input type=\"hidden\" name=\"WorkshopNo\" value=\"".$arr_workshopno[$value]."\">
							<input type=\"hidden\" name=\"rc_no\" value=\"".$value."\">
							<input type=\"hidden\" name=\"item_no\" value=\"".$item_no[$value]."\">
							<input type=\"hidden\" name=\"Shift\" value=\"D\">
							<input class=\"btn btn-primary\" type=\"submit\" value=\"詳情\" > 
						</form>";
				$cch .="</td>";
				$cch .= "</tr>";
			}
		 }
		 
		 
		
		
		if($count_RC_N>0){
			foreach($rc_no_n as $key => $value){
				$cch .= "<tr>";
				$cch .= "<td>".$arr_workshopno_n[$value]."</td>";
				$cch .= "<td>".$arr_lineno_n[$value]."</td>";
				$cch .= "<td>".$arr_date_n[$value]."</td>";
				$cch .= "<td>夜班</td>";
				$cch .= "<td>".$value."</td>";
				$cch .= "<td>".$item_no_n[$value]."</td>";
				$cch .= "<td>".$manPower_n[$value]."</td>";
				$cch .= "<td>".$rcno_true_n[$value]."/".$rcno_all_n[$value][$arr_date_n[$value]]."</td>";
				$cch .= "<td>";
				$cch .= "<form method=\"post\" action=\"".$url."\"
							target=\"gameWindow\" onsubmit=\"return openTableWindow();\">
							<input type=\"hidden\" name=\"SDate\" value=\"".$arr_date_n[$value]."\">
							<input type=\"hidden\" name=\"LineNo\" value=\"".$arr_lineno_n[$value]."\">
							<input type=\"hidden\" name=\"WorkshopNo\" value=\"".$arr_workshopno_n[$value]."\">
							<input type=\"hidden\" name=\"rc_no\" value=\"".$value."\">
							<input type=\"hidden\" name=\"item_no\" value=\"".$item_no_n[$value]."\">
							<input type=\"hidden\" name=\"Shift\" value=\"N\">
							<input class=\"btn btn-primary\" type=\"submit\" value=\"詳情\" > 
					</form>";
				$cch .="</td>";
				$cch .= "</tr>";
			}
		}
		echo $cch;
		echo	"</table>"
			  . "</div>"
			 ."";
	}else{
		echo "當前查詢條件下無刷卡資料"."<br>";
	}
	
	if($count_noRC>0){
		echo"<div class=\"panel-body\" style=\"border: 1px solid #e1e3e6;\">"
		  . "	<table class=\"table table-striped\">"
		  . "		<tr>"
		  . "			<th>車間</th>"
//		  . "			<th>線號</th>"
		  . "			<th>日期</th>"
		  . "			<th>班別</th>"
		  . "			<th>實際加班人數</th>"
		  . "			<th>詳情</th>"
		  . "		</tr>"
		  ."";
		  
		foreach($norcno_not as $key => $value){//車間 //TODO 這裡$key 應該放在最裏面
			// $cch_no .= "<tr>";
			// $cch_no .="<td>".$key."</td>";
			// var_dump($value);
			foreach($value as $key1 => $value1){//線別 
				// $cch_no .= "<td>".$key1."</td>";
				// var_dump($value1);
				foreach($value1 as $key2 => $value2){//日期
				
					foreach($value2 as $key3 => $value3){//班別
						$cch_no .= "<tr>";
						$cch_no .="<td>".$key."</td>";
//						$cch_no .= "<td>".$key1."</td>";
						$cch_no .= "<td>".$key2."</td>";
						$cch_no .= "<td>".$key3."</td>";
						$cch_no .= "<td>".$value3."/".$value3."</td>";
						$cch_no .= "<td>";
						$cch_no .= "<form method=\"post\" action=\"".$url."\"
									target=\"gameWindow\" onsubmit=\"return openTableWindow();\">
									<input type=\"hidden\" name=\"WorkshopNo\"value=\"".$key."\">
									<input type=\"hidden\" name=\"LineNo\" value=\"".$key1."\">
									<input type=\"hidden\" name=\"SDate\" value=\"".$key2."\">
									<input type=\"hidden\" name=\"Shift\"value=\"".$key3."\">
									
									<input class=\"btn btn-primary\" type=\"submit\" value=\"詳情\" > 
								</form>";
						$cch_no .="</td>";
					}
					
				}
			}
			$cch_no .= "</tr>";
		}
			
			echo $cch_no;
			echo	"</table>"
				  . "</div>"
				 ."";
	}else{
		echo "當前查詢條件下無刷卡資料"."<br>";
	}
?>
</body>
</html>