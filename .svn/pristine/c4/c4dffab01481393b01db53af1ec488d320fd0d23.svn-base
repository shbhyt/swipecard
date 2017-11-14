<?php
set_time_limit(0);
$MYSQL_HOST = "localhost";
$MYSQL_LOGIN = "root";
$MYSQL_PASSWORD = "foxlink";
$mysqli1 = new mysqli($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_PASSWORD, "swipecard");
$mysqli1->query("SET NAMES 'utf8'");
$mysqli1->query('SET CHARACTER_SET_CLIENT=utf8');
$mysqli1->query('SET CHARACTER_SET_RESULTS=utf8');


//$sql2="DELETE FROM NOTES_OVERTIME_STATE_NEW WHERE STR_TO_DATE(overtimedate,'%Y-%m-%d') <CURDATE()-3 AND notesStates <> 0";
//$mysqli1->query($sql2);
//將加班工時無異常的拋轉到notes_overtime_state_new表

$sql = "Select id,name,costID,depName,Direct,overTimeDate,WorkContent,overtimeHours,overtimeType,overtimeInterval,rid,shift,application_person, application_id, application_dep, application_tel ,depid,is_lmt from `notes_overtime_state` where notesStates = 0 and isException = 0 and rid in (select max(rid) FROM notes_overtime_state   GROUP BY id,overTimeDate)";
$rows = $mysqli1->query($sql);
// echo $sql;
// $dev_map_array = array();
$temp_array = array();
// id name  costID   depName Direct    overTimeDate WorkContent overtimeHours overtimeType overtimeInterval application_person application_id application_dep application_tel notesStates
$i = 0;
//獲取notesStates為0的數據，準備拋轉到table_new
if (mysqli_num_rows($rows) > 0) {
    while ($row = $rows->fetch_row()) {
        $temp_array[$i]['sort'] = $row[5] . "_" . $row[2] . "_" . $row[13] . "_" . $row[8];
        $temp_array[$i]['id'] = $row[0];
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
        $temp_array[$i]['depid'] = $row[16];
        $temp_array[$i]['is_lmt'] = $row[17];
        $i++;

    }
    mysqli_free_result($rows);

    $con = count($temp_array);
    //拆分字段
    for ($i = 0; $i < $con; $i++) {
        $val = $temp_array[$i]['overtimeInterval'];
        $temp = explode('-', $val);
        $temp_array[$i]['overtimeStart'] = $temp[0];
        $temp_array[$i]['overtimeEnd'] = $temp[1];
        unset($temp);
    }

    // var_dump($temp_array);
    $t = $temp_array;

    //進行二維排序 以temp_array[$i]['sort']為基準
    for ($i = 0; $i < $con; $i++) {
        $tempa[] = $t[$i]['sort'];
        $tempb[] = $t[$i]['depid'];
        $tempc[] = $t[$i]['overtimeHours'];
    }

    array_multisort($tempa, SORT_ASC, $tempb, SORT_ASC, $tempc, SORT_ASC, $t);

    unset($tempa);
    unset($tempb);
    unset($tempc);

    for ($i = 0; $i < $con; $i++) {

        $sql1 = "insert into notes_overtime_state_new (rid,group_sort,id,name,costID,depName,Direct,overTimeDate,overtimeHours,overtimeType,overtimeStart,overtimeEnd,application_person ,application_id ,application_dep,application_tel,WorkContent,depid,is_lmt) values (" . $t[$i]['rid'] . ", '" . $t[$i]['sort'] . "','" . $t[$i]['id'] . "','" . $t[$i]['name'] . "','" . $t[$i]['costID'] . "','" . $t[$i]['depName'] . "','" . $t[$i]['Direct'] . "','" . $t[$i]['overTimeDate'] . "','" . $t[$i]['overtimeHours'] . "','" . $t[$i]['overtimeType'] . "','" . $t[$i]['overtimeStart'] . "','" . $t[$i]['overtimeEnd'] . "','" . $t[$i]['application_person'] . "','" . $t[$i]['application_id'] . "','" . $t[$i]['application_dep'] . "','" . $t[$i]['application_tel'] . "', '" . $t[$i]['WorkContent'] . "','" . $t[$i]['depid'] . "','".$t[$i]['is_lmt']."')";
        //echo $sql1."<br>";
        $mysqli1->query($sql1);
    }

}//将new表当前日期前3天的记录删除
$sql2 = "DELETE FROM NOTES_OVERTIME_STATE_NEW WHERE STR_TO_DATE(overtimedate,'%Y-%m-%d') <CURDATE()-3 AND notesStates <> 0";
$mysqli1->query($sql2);


//將加班工時有異常的拋轉到notes_overtime_state_abnormal表
$sql = "Select id,name,costID,depName,Direct,overTimeDate,WorkContent,overtimeHours,overtimeType,overtimeInterval,rid,shift,application_person, application_id, application_dep, application_tel ,depid,is_lmt from `notes_overtime_state` where notesStates = 0 and isException = 1 and rid in (select max(rid) FROM notes_overtime_state   GROUP BY id,overTimeDate)";

$rows = $mysqli1->query($sql);
// echo $sql;
// $dev_map_array = array();
$temp_array1 = array();
// id name  costID   depName Direct    overTimeDate WorkContent overtimeHours overtimeType overtimeInterval application_person application_id application_dep application_tel notesStates
$i = 0;
//獲取notesStates為0的數據，準備拋轉到table_new
if (mysqli_num_rows($rows) > 0) {
    while ($row = $rows->fetch_row()) {
        $temp_array1[$i]['sort'] = $row[5] . "_" . $row[2] . "_" . $row[13] . "_" . $row[8];
        $temp_array1[$i]['id'] = $row[0];
        $temp_array1[$i]['name'] = $row[1];
        $temp_array1[$i]['costID'] = $row[2];
        $temp_array1[$i]['depName'] = $row[3];
        $temp_array1[$i]['Direct'] = $row[4];
        $temp_array1[$i]['overTimeDate'] = $row[5];
        $temp_array1[$i]['WorkContent'] = $row[6];
        $temp_array1[$i]['overtimeHours'] = $row[7];
        $temp_array1[$i]['overtimeType'] = $row[8];
        $temp_array1[$i]['overtimeInterval'] = $row[9];
        $temp_array1[$i]['rid'] = $row[10];
        $temp_array1[$i]['shift'] = $row[11];
        $temp_array1[$i]['application_person'] = $row[12];
        $temp_array1[$i]['application_id'] = $row[13];
        $temp_array1[$i]['application_dep'] = $row[14];
        $temp_array1[$i]['application_tel'] = $row[15];
        $temp_array1[$i]['depid'] = $row[16];
        $temp_array1[$i]['is_lmt'] = $row[17];
        $i++;

    }
    mysqli_free_result($rows);

    $con1 = count($temp_array1);
    //拆分字段
    for ($i = 0; $i < $con1; $i++) {
        $val = $temp_array1[$i]['overtimeInterval'];
        $temp = explode('-', $val);
        $temp_array1[$i]['overtimeStart'] = $temp[0];
        $temp_array1[$i]['overtimeEnd'] = $temp[1];
        unset($temp);
    }

    // var_dump($temp_array1);
    $t1 = $temp_array1;

    //進行二維排序 以temp_array[$i]['sort']為基準
    for ($i = 0; $i < $con1; $i++) {
        $tempa[] = $t1[$i]['sort'];
        $tempb[] = $t1[$i]['depid'];
        $tempc[] = $t1[$i]['overtimeHours'];
    }

    array_multisort($tempa, SORT_ASC, $tempb, SORT_ASC, $tempc, SORT_ASC, $t1);
    unset($tempa);
    unset($tempb);
    unset($tempc);

    for ($i = 0; $i < $con1; $i++) {
        $sql1 = "insert into notes_overtime_state_abnormal (rid,group_sort,id,name,costID,depName,Direct,overTimeDate,overtimeHours,overtimeType,overtimeStart,overtimeEnd,application_person ,application_id ,application_dep,application_tel,WorkContent,depid,is_lmt) values (" . $t1[$i]['rid'] . ", '" . $t1[$i]['sort'] . "','" . $t1[$i]['id'] . "','" . $t1[$i]['name'] . "','" . $t1[$i]['costID'] . "','" . $t1[$i]['depName'] . "','" . $t1[$i]['Direct'] . "','" . $t1[$i]['overTimeDate'] . "','" . $t1[$i]['overtimeHours'] . "','" . $t1[$i]['overtimeType'] . "','" . $t1[$i]['overtimeStart'] . "','" . $t1[$i]['overtimeEnd'] . "','" . $t1[$i]['application_person'] . "','" . $t1[$i]['application_id'] . "','" . $t1[$i]['application_dep'] . "','" . $t1[$i]['application_tel'] . "', '" . $t1[$i]['WorkContent'] . "' ,'" . $t1[$i]['depid'] . "','" . $t1[$i]['is_lmt'] . "')";
        //echo $sql1."<br>";
        $mysqli1->query($sql1);
        $mysqli1->query($sql1);
    }

}   //将abnormal表当前日期前3天的记录删除
$sql3 = "DELETE FROM NOTES_OVERTIME_STATE_abnormal WHERE STR_TO_DATE(overtimedate,'%Y-%m-%d') <CURDATE()-3 AND notesStates <> 0";
$mysqli1->query($sql3);


//將忘卡的異常的拋轉到notes_overtime_state_null表
$sql = "Select id,name,costID,depName,Direct,overTimeDate,WorkContent,overtimeHours,overtimeType,overtimeInterval,rid,shift,application_person, application_id, application_dep, application_tel ,depid ,is_lmt from `notes_overtime_state` where notesStates = 0 and isException = 2 and rid in (select max(rid) FROM notes_overtime_state   GROUP BY id,overTimeDate)";

$rows = $mysqli1->query($sql);
// echo $sql;
// $dev_map_array = array();
$temp_array1 = array();
// id name  costID   depName Direct    overTimeDate WorkContent overtimeHours overtimeType overtimeInterval application_person application_id application_dep application_tel notesStates
$i = 0;
//獲取notesStates為2的數據，準備拋轉到table_new
if (mysqli_num_rows($rows) > 0) {
    while ($row = $rows->fetch_row()) {
        $temp_array1[$i]['sort'] = $row[5] . "_" . $row[2] . "_" . $row[13] . "_" . $row[8];
        $temp_array1[$i]['id'] = $row[0];
        $temp_array1[$i]['name'] = $row[1];
        $temp_array1[$i]['costID'] = $row[2];
        $temp_array1[$i]['depName'] = $row[3];
        $temp_array1[$i]['Direct'] = $row[4];
        $temp_array1[$i]['overTimeDate'] = $row[5];
        $temp_array1[$i]['WorkContent'] = $row[6];
        $temp_array1[$i]['overtimeHours'] = $row[7];
        $temp_array1[$i]['overtimeType'] = $row[8];
        $temp_array1[$i]['overtimeInterval'] = $row[9];
        $temp_array1[$i]['rid'] = $row[10];
        $temp_array1[$i]['shift'] = $row[11];
        $temp_array1[$i]['application_person'] = $row[12];
        $temp_array1[$i]['application_id'] = $row[13];
        $temp_array1[$i]['application_dep'] = $row[14];
        $temp_array1[$i]['application_tel'] = $row[15];
        $temp_array1[$i]['depid'] = $row[16];
        $temp_array1[$i]['is_lmt'] = $row[17];
        $i++;

    }
    mysqli_free_result($rows);

    $con1 = count($temp_array1);
    //拆分字段
    for ($i = 0; $i < $con1; $i++) {
        $val = $temp_array1[$i]['overtimeInterval'];
        $temp = explode('-', $val);
        $temp_array1[$i]['overtimeStart'] = $temp[0];
        $temp_array1[$i]['overtimeEnd'] = $temp[1];
        unset($temp);
    }

    // var_dump($temp_array1);
    $t1 = $temp_array1;

    //進行二維排序 以temp_array[$i]['sort']為基準
    for ($i = 0; $i < $con1; $i++) {
        $tempa[] = $t1[$i]['sort'];
        $tempb[] = $t1[$i]['depid'];
        $tempc[] = $t1[$i]['overtimeHours'];
    }

    array_multisort($tempa, SORT_ASC, $tempb, SORT_ASC, $tempc, SORT_ASC, $t1);

    unset($tempa);
    unset($tempb);
    unset($tempc);

    for ($i = 0; $i < $con1; $i++) {
        //$sql="select id,overTimeDate from notes_overtime_state_null";
        $sql1 = "insert into notes_overtime_state_null (rid,group_sort,id,name,costID,depName,Direct,overTimeDate,overtimeHours,overtimeType,overtimeStart,overtimeEnd,application_person ,application_id ,application_dep,application_tel,WorkContent,depid,is_lmt) values (" . $t1[$i]['rid'] . ", '" . $t1[$i]['sort'] . "','" . $t1[$i]['id'] . "','" . $t1[$i]['name'] . "','" . $t1[$i]['costID'] . "','" . $t1[$i]['depName'] . "','" . $t1[$i]['Direct'] . "','" . $t1[$i]['overTimeDate'] . "','" . $t1[$i]['overtimeHours'] . "','" . $t1[$i]['overtimeType'] . "','" . $t1[$i]['overtimeStart'] . "','" . $t1[$i]['overtimeEnd'] . "','" . $t1[$i]['application_person'] . "','" . $t1[$i]['application_id'] . "','" . $t1[$i]['application_dep'] . "','" . $t1[$i]['application_tel'] . "', '" . $t1[$i]['WorkContent'] . "' ,'" . $t1[$i]['depid'] . "','" . $t1[$i]['is_lmt'] . "')";
        //echo $sql1."<br>";
        $mysqli1->query($sql1);
    }

}//将null表当前日期前3天的记录删除
$sql4 = "DELETE FROM notes_overtime_state_null WHERE STR_TO_DATE(overtimedate,'%Y-%m-%d') <CURDATE()-3 AND notesStates <> 0";
$mysqli1->query($sql4);
$mysqli1->close();

?>
<script language="javascript">setTimeout("window.opener = window.open('','_parent',''); window.close();", 200000)</script>