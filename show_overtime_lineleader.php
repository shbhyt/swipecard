<?php 
	session_start();
	$access = $_SESSION["permission"];
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>

<link href="assets/css/icons.css" rel="stylesheet">
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/plugins.css" rel="stylesheet">
<link href="assets/css/main.css" rel="stylesheet">

<script src="assets/js/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript"
	src="assets/My97DatePicker/WdatePicker.js"></script>
<script src="js/Button_Plugins.js"></script>


</head>
<body>
<?php 

include("mysql_config.php");

$line_sql = "SELECT workshopno FROM `lineno` WHERE workshopno != '' GROUP BY workshopno";
$line_rows = $mysqli->query($line_sql);
while($row = $line_rows->fetch_row()){
	$workshopNo[] = $row[0];
}
	

?>

	<div id="header" class="header-fixed">
		<div class="navbar">
			<a class="navbar-brand" href="Login.html"> <i
				class="im-windows8 text-logo-element animated bounceIn"></i><span
				class="text-logo">FOX</span><span class="text-slogan">LINK</span>
			</a>
		</div>
		<!-- Start .header-inner -->
	</div>

	<div style="position: absolute; top: 55px; margin-left: 10px">
		<div class="panel-body" style="border: 1px solid #e1e3e6;">
			開始日期-<input id="dpick1" class="Wdate" type="text"
				onClick="WdatePicker()"> 結束日期-<input id="dpick2"
				class="Wdate" type="text" onClick="WdatePicker()"> 車間-<select
				id="WorkshopNo">
				<option value="%">All</option>
				<?php 
				
				$cch = '';
				foreach($workshopNo as $key => $val){
					$cch .= "<option value = \"".$val."\">";
					$cch .= $val;
					$cch .= "</option>";
					
				}
				echo $cch;
				?>
			</select> 加班單狀態-<select id="checkState">
				<option value="'0','9'">未審核</option>
				<option value="1">已審核</option>
			</select> <input name="" class="btn btn-primary" type="button"
				onclick="showRCInforByDate_lineleader();" value="查詢" />
		</div>
		<div id="showRcNoTable"></div>
	</div>
?>

</body>
</html>