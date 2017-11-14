<?php 
	session_start();
	$access = $_SESSION["permission"];
?>
<html>

<head>
<!-- Bootstrap stylesheets (included template modifications) -->
<link href="assets/css/bootstrap.css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/Button_Plugins1.js"></script>
<title>查詢頁面</title>
</head>
<body>
<?php 
	
	include("mysql_config.php");
	
	$workshopNo = $_POST['workshopNo'];
	$SDate = $_POST['SDate'];
	$EDate = $_POST['EDate'];
	$url = $_POST['urlA'];	
	$checkState = $_POST['checkState'];
	$costid = $_SESSION['costid'];
	// echo $costid;
	$temp_cost = explode("*",$costid);  //explode() 函数把字符串打散为数组。
	$cch = "";
	foreach($temp_cost as $key => $val){
		if(end($temp_cost)==$val){
			$cch .= "'$val'";
		}else{
			$cch .= "'$val'".",";
		}
		// echo $cch."<br>";
	}
	// echo $cch;
	
    $rcno_sql = "SELECT
	t.WorkshopNo,
	t.sdate,
	t.class_no,
	t.rc_no,
	t.checkstate,
	SUM(t.count)
FROM
	(
		(
			SELECT
				a.`WorkshopNo`,
				DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') sdate,
				IFNULL(DATE_FORMAT(a.swipecardtime2,'%Y-%m-%d'),DATE_FORMAT(a.swipecardtime, '%Y-%m-%d')) edate,
				c.`class_no`,
				a.`rc_no`,
				a.`checkstate`,
				COUNT(*) count
			FROM
				`testswipecardtime` a
			LEFT JOIN `testemployee` b ON a.`CardID` = b.`CardID`
			LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
			AND c.`emp_date` = SUBSTRING(a.swipecardtime, 1, 10)
			WHERE
				DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') >= '".$SDate."'
			AND DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') <= '".$EDate."'
			and a.swipecardtime2 is null
			AND b.isOnWork = 0
			AND a.`WorkshopNo` LIKE '".$workshopNo."'
			AND b.costid IN ($cch)
			GROUP BY
				a.`WorkshopNo`,
				sdate,
				edate,
				c.`class_no`,
				a.`rc_no`,
				a.`checkstate`
			ORDER BY
				a.`WorkshopNo`,
				sdate,
				c.`class_no`,
				a.`rc_no`,
				a.`checkstate`
		)
		UNION
			(
				SELECT
					a.`WorkshopNo`,
					IFNULL(DATE_FORMAT(a.swipecardtime, '%Y-%m-%d'),DATE_FORMAT(a.swipecardtime2,'%Y-%m-%d')) sdate,
					DATE_FORMAT(a.swipecardtime2,'%Y-%m-%d') edate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`,
					COUNT(*) count
				FROM
					`testswipecardtime` a
				LEFT JOIN `testemployee` b ON a.`CardID` = b.`CardID`
				LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
				AND c.`emp_date` = SUBSTRING(a.swipecardtime2, 1, 10)
				WHERE
					DATE_FORMAT(a.SwipeCardTime2,'%Y-%m-%d') >= '".$SDate."'
				AND DATE_FORMAT(a.SwipeCardTime2,'%Y-%m-%d') <= '".$EDate."'
				AND a.SwipeCardTime IS NULL
				AND a.shift = 'D'
				AND b.isOnWork = 0
				AND a.`WorkshopNo` LIKE '".$workshopNo."'
				AND b.costid IN ($cch)
				GROUP BY
					a.`WorkshopNo`,
					sdate,
					edate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`
				ORDER BY
					a.`WorkshopNo`,
					sdate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`
			)
		UNION
			(
				SELECT
					a.`WorkshopNo`,
					IFNULL(DATE_FORMAT(a.swipecardtime, '%Y-%m-%d'),DATE_FORMAT(DATE_ADD(a.swipecardtime2,INTERVAL - 1 DAY),'%Y-%m-%d')) sdate,
					DATE_FORMAT(a.swipecardtime2,'%Y-%m-%d') edate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`,
					COUNT(*) count
				FROM
					`testswipecardtime` a
				LEFT JOIN `testemployee` b ON a.`CardID` = b.`CardID`
				LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
				AND c.`emp_date` = SUBSTRING(DATE_ADD(a.swipecardtime2,INTERVAL - 1 DAY),1,10)
				WHERE
					DATE_FORMAT(a.SwipeCardTime2,'%Y-%m-%d') >= DATE_ADD('".$SDate."', INTERVAL + 1 DAY)
				AND DATE_FORMAT(a.SwipeCardTime2,'%Y-%m-%d') <= DATE_ADD('".$EDate."', INTERVAL + 1 DAY)
				AND a.SwipeCardTime IS NULL
				AND b.isOnWork = 0
				AND a.shift = 'N'
				AND a.`WorkshopNo` LIKE '".$workshopNo."'
				AND b.costid IN ($cch)
				GROUP BY
					a.`WorkshopNo`,
					sdate,
					edate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`
				ORDER BY
					a.`WorkshopNo`,
					sdate,
					c.`class_no`,
					a.`rc_no`,
					a.`checkstate`
			)
	) t
GROUP BY
	t.`WorkshopNo`,
	t.sdate,
	t.`class_no`,
	t.`rc_no`,
	t.`checkstate`";
    
    //echo $rcno_sql;            
    $rcno_rows = $mysqli->query($rcno_sql);
	$cch = "";
    $rc_list = array();
    $norc_list = array();
    $rcnoStr = "";
    
    while($row = $rcno_rows->fetch_row())
    {
        if($row[4]==1) //找已審核
        {
            if($row[3]=="") //無指示單號
                $norc_list[$row[0]][$row[1]][$row[2]]['mount'] = $row[5];
            else //有指示單號
            {
                $rc_list[$row[0]][$row[1]][$row[2]][$row[3]]['mount'] = $row[5];
                $rcnoStr .= "'".$row[3]."',";
            }
        }
        
        if($row[3]=="") //無指示單號
        {
            if(isset($norc_list[$row[0]][$row[1]][$row[2]]))
                $norc_list[$row[0]][$row[1]][$row[2]]['total'] += $row[5];
        }
        else //有指示單號
        {
            if(isset($rc_list[$row[0]][$row[1]][$row[2]][$row[3]]))
                $rc_list[$row[0]][$row[1]][$row[2]][$row[3]]['total'] += $row[5];
        }
    }
    $rcnoStr = substr($rcnoStr,0,-1);
    mysqli_free_result($rcno_rows);
    
    $manPower_sql = "select rc_no,std_man_power,primary_item_no from testrcline 
                    where CUR_DATE > DATE_SUB(curdate(),INTERVAL 30 DAY) ";
                    
    if($rcnoStr!="")
        $manPower_sql .= "and rc_no in (".$rcnoStr.")";
	// echo $manPower_sql."<br>";
	$man_rows = $mysqli->query($manPower_sql);
	// $countPower = mysqli_num_rows($man_rows);
    $rc_no = array();
	if($man_rows!=null){
		while($row = $man_rows->fetch_row()){
		    $rc_no[$row[0]]['manpower'] = $row[1];
            $rc_no[$row[0]]['itemno'] = $row[2];
		}
		mysqli_free_result($man_rows);
	}
    $mysqli->close();
    
    echo "<div><h4>有指示單號列表：</h4></div>";
    if(count($rc_list)>0){
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
		 
		 foreach($rc_list as $workshop => $date_array)
         {
            foreach($date_array as $date => $class_array)
            {
                foreach($class_array as $class => $rcno_array)
                {
                    foreach($rcno_array as $rcno => $data)
                    {
            			$cch .= "<tr>";
            			$cch .= "<td>".$workshop."</td>";
            			$cch .= "<td>".$date."</td>";
            			$cch .= "<td>".$class."</td>";
            			$cch .= "<td>".$rcno."</td>";
            			$cch .= "<td>".$rc_no[$rcno]['itemno']."</td>";
            			$cch .= "<td>".$rc_no[$rcno]['manpower']."</td>";
            			$cch .= "<td>".$data['mount']."/".$data['total']."</td>";
            			$cch .= "<td>";
            					//	<input type=\"hidden\" name=\"LineNo\" value=\"".$arr_lineno[$value]."\"> -->
            			$cch .= "<form method=\"post\" action=\"".$url."\"
            						target=\"gameWindow\" onsubmit=\"return openTableWindow();\">
            						<input type=\"hidden\" name=\"SDate\" value=\"".$date."\">		
            						<input type=\"hidden\" name=\"WorkshopNo\" value=\"".$workshop."\">
            						<input type=\"hidden\" name=\"rc_no\" value=\"".$rcno."\">
            						<input type=\"hidden\" name=\"item_no\" value=\"".$rc_no[$rcno]['itemno']."\">
            						<input type=\"hidden\" name=\"Shift\" value=\"".$class."\">
            						<input class=\"btn btn-primary\" type=\"submit\" value=\"詳情\" > 
            					</form>";
            			$cch .="</td>";
            			$cch .= "</tr>";
                    }
                }
            }            
		}
		 
		echo $cch;
		echo	"</table>"
			  . "</div><br>";
	}else{
		echo "<div style=\"border: 1px solid #e1e3e6;\">當前查詢條件下無刷卡資料</div>";
        echo "<br>";
	}
    
    echo "<div><h4>無指示單號列表：</h4></div>";
    if(count($norc_list)>0){
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
		
        foreach($norc_list as $workshop => $date_array)
        {
            foreach($date_array as $date => $class_array)
            {
                foreach($class_array as $class => $data)
                {
					$cch_no .= "<tr>";
					$cch_no .="<td>".$workshop."</td>";
					$cch_no .= "<td>".$date."</td>";
					$cch_no .= "<td>".$class."</td>";
					$cch_no .= "<td>".$data['mount']."/".$data['total']."</td>";
					$cch_no .= "<td>";
				//	<input type=\"hidden\" name=\"LineNo\" value=\"".$key1."\">
					$cch_no .= "<form method=\"post\" action=\"".$url."\"
								target=\"gameWindow\" onsubmit=\"return openTableWindow();\">
								<input type=\"hidden\" name=\"WorkshopNo\"value=\"".$workshop."\">									
								<input type=\"hidden\" name=\"SDate\" value=\"".$date."\">
								<input type=\"hidden\" name=\"Shift\"value=\"".$class."\">
								
								<input class=\"btn btn-primary\" type=\"submit\" value=\"詳情\" > 
							</form>";
					$cch_no .="</td>";
                    $cch_no .= "</tr>";
				}
			}
		}
			
			echo $cch_no;
			echo	"</table>"
				  . "</div>"
				 ."";
	}else{
		echo "<div style=\"border: 1px solid #e1e3e6;\">當前查詢條件下無刷卡資料</div>";
        echo "<br>";
	}
?>
	
</body>
</html>
