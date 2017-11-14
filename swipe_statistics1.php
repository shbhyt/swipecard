<?php
$date = $_POST["date"];
$shift = $_POST["shift"];
$shift1 = substr($shift,0,1);
$result = array();

$MYSQL_LOGIN = "root";
$MYSQL_PASSWORD = "foxlink";
$MYSQL_HOST = "192.168.78.153";

$mysqli = new mysqli($MYSQL_HOST,$MYSQL_LOGIN,$MYSQL_PASSWORD,"swipecard");
$mysqli->query("SET NAMES 'utf8'");	 
$mysqli->query('SET CHARACTER_SET_CLIENT=utf8');
$mysqli->query('SET CHARACTER_SET_RESULTS=utf8');

//計算在職人數
$sql = "SELECT COUNT(*) FROM testemployee WHERE isOnWork = 0";
$rows = $mysqli->query($sql);
$row = $rows->fetch_row();

mysqli_free_result($rows);
$result['CABG_onWork'] = $row[0];
unset($row); 
$html = "";
$total = 0;

if($shift=="D1") //日班上班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime`>'".$date." 06:00:00' AND `SwipeCardTime`<'".$date." 10:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="D2") //日班下班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime2`>'".$date." 16:00:00' AND `SwipeCardTime2`<'".$date." 21:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="N1") //夜班上班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime`>'".$date." 18:00:00' AND `SwipeCardTime`<'".$date." 22:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="N2") //夜班下班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime2`>'".$date." 03:30:00' AND `SwipeCardTime2`<'".$date." 09:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
$rows = $mysqli->query($sql);
while($row = $rows->fetch_row())
{
    $html .= "車間:".$row[0].",  數量:".$row[1]."<br>";
    $total += $row[1];
}

mysqli_free_result($rows);
$mysqli->close();

$result['CABG'] = $total;
$result['CABG_detail'] = $html;

//=============================================================================================================

$MYSQL_HOST = "192.168.78.152";

$mysqli = new mysqli($MYSQL_HOST,$MYSQL_LOGIN,$MYSQL_PASSWORD,"swipecard");
$mysqli->query("SET NAMES 'utf8'");	 
$mysqli->query('SET CHARACTER_SET_CLIENT=utf8');
$mysqli->query('SET CHARACTER_SET_RESULTS=utf8');

//計算在職人數
$sql = "SELECT COUNT(*) FROM testemployee WHERE isOnWork = 0";
$rows = $mysqli->query($sql);
$row = $rows->fetch_row();

mysqli_free_result($rows);
$result['CSBG_onWork'] = $row[0];
unset($row);
$html = "";
$total=0;

if($shift=="D1") //日班上班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime`>'".$date." 06:00:00' AND `SwipeCardTime`<'".$date." 10:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="D2") //日班下班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime2`>'".$date." 16:00:00' AND `SwipeCardTime2`<'".$date." 21:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="N1") //夜班上班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime`>'".$date." 18:00:00' AND `SwipeCardTime`<'".$date." 22:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
else if($shift=="N2") //夜班下班
{
    $sql = "SELECT `WorkshopNo`,count(*) FROM `testswipecardtime` where `SwipeCardTime2`>'".$date." 03:30:00' AND `SwipeCardTime2`<'".$date." 09:00:00' and `Shift`='".$shift1."' group by `WorkshopNo` order by `WorkshopNo`";
}
$rows = $mysqli->query($sql);
while($row = $rows->fetch_row())
{
    $html .= "車間:".$row[0].",  數量:".$row[1]."<br>";
    $total += $row[1];
}

mysqli_free_result($rows);
$mysqli->close();

$result['CSBG'] = $total;
$result['CSBG_detail'] = $html;

echo json_encode($result);
?>