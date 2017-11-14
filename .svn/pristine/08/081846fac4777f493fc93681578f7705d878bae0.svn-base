<?php

$MYSQL_HOST="localhost";
$MYSQL_LOGIN="root";
$MYSQL_PASSWORD="foxlink";
$mysqli1 = new mysqli($MYSQL_HOST,$MYSQL_LOGIN,$MYSQL_PASSWORD,"swipecard");
$mysqli1->query("SET NAMES 'utf8'");  
$mysqli1->query('SET CHARACTER_SET_CLIENT=utf8');
$mysqli1->query('SET CHARACTER_SET_RESULTS=utf8');
$sql = "Select id,name,costID,depName,Direct,overTimeDate,WorkContent,overtimeHours,overtimeType,overtimeInterval,rid,shift,application_person, application_id, application_dep, application_tel from `notes_overtime_state` where notesStates = 0";

$rows = $mysqli1->query($sql);
// echo $sql;
// $dev_map_array = array();
$temp_array=array();
// id name  costID   depName Direct    overTimeDate WorkContent overtimeHours overtimeType overtimeInterval application_person application_id application_dep application_tel notesStates
$i=0;
//獲取notesStates為0的數據，準備拋轉到table_new
if(mysqli_num_rows($rows)>0){
 while($row = $rows->fetch_row())
 {
  $temp_array[$i]['sort'] = $row[5]."_".$row[2]."_".$row[13]."_".$row[8];
  $temp_array[$i]['id']= $row[0];
  $temp_array[$i]['name'] = $row[1];
  $temp_array[$i]['costID'] = $row[2];
  $temp_array[$i]['depName'] = $row[3];
  $temp_array[$i]['Direct'] = $row[4];
  $temp_array[$i]['overTimeDate'] = $row[5];
  $temp_array[$i]['WorkContent'] = $row[6];
  $temp_array[$i]['overtimeHours'] = $row[7];
  $temp_array[$i]['overtimeType'] = $row[8];
  $temp_array[$i]['overtimeInterval'] = $row[9];
  $temp_array[$i]['rid'] = $row[10];
  $temp_array[$i]['shift'] = $row[11];
  $temp_array[$i]['application_person'] = $row[12];
  $temp_array[$i]['application_id'] = $row[13];
  $temp_array[$i]['application_dep'] = $row[14];
  $temp_array[$i]['application_tel'] = $row[15];
  $i++;
  
 }
 mysqli_free_result($rows);

 $con = count($temp_array);
 //拆分字段
 for($i=0;$i<$con;$i++){
  $val = $temp_array[$i]['overtimeInterval'];
  $temp = explode('-',$val);
  $temp_array[$i]['overtimeStart'] = $temp[0];
  $temp_array[$i]['overtimeEnd'] = $temp[1];
  unset($temp);
 }

 // var_dump($temp_array);
 $t = $temp_array;

 //進行二維排序 以temp_array[$i]['sort']為基準
 for($i=0;$i<$con;$i++){
  $tempa[] = $t[$i]['sort'];
  $tempb[] = $t[$i]['WorkContent'];
  $tempc[] = $t[$i]['shift'];
 }

 array_multisort($tempa, SORT_ASC,$tempb,SORT_ASC,$tempc,SORT_ASC, $t);
 
 $temp_p=array();
 for($i=0;$i<$con;$i++){
  $sql1 = "insert into notes_overtime_state_new (rid,group_sort,id,name,costID,depName,Direct,overTimeDate,overtimeHours,overtimeType,overtimeStart,overtimeEnd,application_person ,application_id ,application_dep,application_tel,WorkContent) values (".$t[$i]['rid'].", '".$t[$i]['sort']."','".$t[$i]['id']."','".$t[$i]['name']."','".$t[$i]['costID']."','".$t[$i]['depName']."','".$t[$i]['Direct']."','".$t[$i]['overTimeDate']."','".$t[$i]['overtimeHours']."','".$t[$i]['overtimeType']."','".$t[$i]['overtimeStart']."','".$t[$i]['overtimeEnd']."','".$t[$i]['application_person']."','".$t[$i]['application_id']."','".$t[$i]['application_dep']."','".$t[$i]['application_tel']."', '".$t[$i]['WorkContent']."')";
  //echo $sql1."<br>";
  $rows = $mysqli1->query($sql1);
 }
 
}


?>
<script language="javascript">setTimeout("window.opener = window.open('','_parent',''); window.close();" ,200000)</script>