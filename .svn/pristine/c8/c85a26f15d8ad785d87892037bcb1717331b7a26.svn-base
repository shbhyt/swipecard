<?php

$MYSQL_HOST="localhost";
$MYSQL_LOGIN="root";
$MYSQL_PASSWORD="foxlink";
$mysqli1 = new mysqli($MYSQL_HOST,$MYSQL_LOGIN,$MYSQL_PASSWORD,"swipecard");
$mysqli1->query("SET NAMES 'utf8'");	 
$mysqli1->query('SET CHARACTER_SET_CLIENT=utf8');
$mysqli1->query('SET CHARACTER_SET_RESULTS=utf8');

//將正常加班工時的加班單(NOTES系統已處理過)，回寫到notes_overtime_state表
$sql = "Select id,OverTimeDate,notesStates,rid,reason,backtime  from `notes_overtime_state_new` where notesStates != 0";

$rows = $mysqli1->query($sql);
$temp_array=array();
$i=0;
while($row = $rows->fetch_row())
{
	$temp_array[$i]['id']= $row[0];
	$temp_array[$i]['overTimeDate'] = $row[1];
	$temp_array[$i]['notesStates'] = $row[2];
	$temp_array[$i]['rid'] = $row[3];
	$temp_array[$i]['reason'] = $row[4];
	$temp_array[$i]['backtime'] = $row[5];
	$i++;
}
mysqli_free_result($rows);

$con = count($temp_array);
// echo $con;
// echo 123;
for($i=0;$i<$con;$i++){
	$sql1 = "update notes_overtime_state set notesStates = ".$temp_array[$i]['notesStates'].",reason = '".$temp_array[$i]['reason']."' , backtime = '".$temp_array[$i]['backtime']. "' where rid = '".$temp_array[$i]['rid']."'";
	// echo $sql1."<br>";
	$rows = $mysqli1->query($sql1);
}

unset($temp_array);
//將加班工時null的加班單(NOTES系統已處理過)，回寫到notes_overtime_state表
$sql = "Select id,OverTimeDate,notesStates,rid,reason,backtime  from `notes_overtime_state_null` where notesStates != 0";

$rows = $mysqli1->query($sql);
$temp_array=array();
$i=0;
while($row = $rows->fetch_row())
{
    $temp_array[$i]['id']= $row[0];
    $temp_array[$i]['overTimeDate'] = $row[1];
    $temp_array[$i]['notesStates'] = $row[2];
    $temp_array[$i]['rid'] = $row[3];
    $temp_array[$i]['reason'] = $row[4];
    $temp_array[$i]['backtime'] = $row[5];
    $i++;
}
mysqli_free_result($rows);

$con = count($temp_array);
// echo $con;
// echo 123;
for($i=0;$i<$con;$i++){
    $sql1 = "update notes_overtime_state set notesStates = ".$temp_array[$i]['notesStates'].",reason = '".$temp_array[$i]['reason']."' , backtime = '".$temp_array[$i]['backtime']. "' where rid = '".$temp_array[$i]['rid']."'";
    // echo $sql1."<br>";
    $rows = $mysqli1->query($sql1);
}

unset($temp_array);

//將異常加班工時的加班單(NOTES系統已處理過)，回寫到notes_overtime_state表
$sql = "Select id,OverTimeDate,notesStates,rid,reason,backtime  from `notes_overtime_state_abnormal` where notesStates != 0";

$rows = $mysqli1->query($sql);
$i=0;
while($row = $rows->fetch_row())
{
	$temp_array[$i]['id']= $row[0];
	$temp_array[$i]['overTimeDate'] = $row[1];
	$temp_array[$i]['notesStates'] = $row[2];
	$temp_array[$i]['rid'] = $row[3];
	$temp_array[$i]['reason'] = $row[4];
	$temp_array[$i]['backtime'] = $row[5];
	$i++;
}
mysqli_free_result($rows);

$con = count($temp_array);
// echo $con;
// echo 123;
for($i=0;$i<$con;$i++){
	$sql1 = "update notes_overtime_state set notesStates = ".$temp_array[$i]['notesStates'].",reason = '".$temp_array[$i]['reason']."' , backtime = '".$temp_array[$i]['backtime']. "' where rid = '".$temp_array[$i]['rid']."'";
	// echo $sql1."<br>";
	$rows = $mysqli1->query($sql1);
}

unset($temp_array);
$mysqli1->close();
?>
<script type="text/javascript">setTimeout("window.opener = null;window.open('','_self');window.close();",2000)</script>
