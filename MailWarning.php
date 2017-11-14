<?php
require_once('cutycapt.php');
require_once('../PHPMailer/class.phpmailer.php');
require_once 'getExcel.php';

include("mysql_config.php");
include("config.php");
	$date = date('2017/07/22');
	// $date1 = strtotime('-30 days',strtotime($date));
	$date = strtotime('-1 days',strtotime($date));
	// $date1 = strtotime('-30 days',strtotime($date));
	$date = date("Y/m/d",$date);
	// $date1 = date("Y/m/d",$date1);
	// echo $date1;
	// $sql = "select a.prod_line_code,b.id,b.name,b.depname,a.swipecardtime,a.swipecardtime2 from testswipecardtime a,testemployee b WHERE a.cardid=b.cardid and swipecardtime > date_sub(curdate(),interval 30 day) ";
	
	// $employee_sql = "select b.cardid,b.id,b.depname,b.depid from (select cardid from testswipecardtime group by cardid) a,testemployee b where a.cardid = b.cardid and b.cardid = '0087670656'";
	
	$employee_sql = "select b.cardid,b.id,b.depname,b.depid from (select cardid from testswipecardtime group by cardid) a,testemployee b where a.cardid = b.cardid order by b.cardid";
	
	// $time_sql = "select prod_line_code,cardid,name,swipecardtime,swipecardtime2,shift,workshopno from testswipecardtime where swipecardtime > date_sub(curdate(),interval 30 day) and swipecardtime2 is not null order by cardid,swipecardtime desc";
	
	$time_sql = "select prod_line_code,cardid,name,swipecardtime,swipecardtime2,shift,WorkshopNo from testswipecardtime where swipecardtime >= date_sub('$date',interval 30 day) and date_format(swipecardtime,'%Y/%m/%d') <= '$date' and swipecardtime2 is not null order by cardid,swipecardtime desc";
    //echo $time_sql."<br>";
	// $time_sql = "select prod_line_code,cardid,name,swipecardtime,swipecardtime2,shift from testswipecardtime where swipecardtime > date_sub(curdate(),interval 30 day) and swipecardtime2 is not null  order by cardid,swipecardtime desc";
	
	// $time_inteval_setting = "select * from interval_setting where WorkshopNo='第八車間' and weekend = 0 and Shift = 'D'";
	// $interval_sql = "select * from interval_setting where WorkshopNo='$WorkshopNo' and weekend = '$weekend' and Shift = '$Shift'";
	$time_inteval_setting = "select * from interval_setting";
	// echo $time_inteval_setting;
	// exit;
	// $base_rows = $mysqli->query($sql); 
	// $i=0;
	
	
	$base_rows = $mysqli->query($employee_sql);
	while($row= $base_rows->fetch_assoc()){
		$temp['cardid'][] = $row['cardid'];
		$temp['id'][] = $row['id'];
		$temp['depid'][] = $row['depid'];
		$temp['depname'][] = $row['depname'];
		
	}
	
	$time_rows = $mysqli->query($time_sql);
	while($row= $time_rows->fetch_assoc()){
		$temp1['cardid'][] = $row['cardid'];
		$temp1['name'][] = $row['name'];
		$temp1['swipecardtime'][] = $row['swipecardtime'];
		$temp1['swipecardtime2'][] = $row['swipecardtime2'];
		$temp1['shift'][] = $row['shift'];
		$temp1['WorkshopNo'][] = $row['WorkshopNo'];
	}
	
	$setting_rows = $mysqli->query($time_inteval_setting);
	while($row1= $setting_rows->fetch_assoc()){
		$setting[$row1['WorkshopNo']][$row1['weekend']][$row1['Shift']][] = $row1['d_interval1'];
		$setting[$row1['WorkshopNo']][$row1['weekend']][$row1['Shift']][] = $row1['d_interval2'];
		$setting[$row1['WorkshopNo']][$row1['weekend']][$row1['Shift']][] = $row1['d_interval3'];
		$setting[$row1['WorkshopNo']][$row1['weekend']][$row1['Shift']][] = $row1['d_interval4'];
		$setting[$row1['WorkshopNo']][$row1['weekend']][$row1['Shift']][] = $row1['d_interval5'];
		
	}
	$con = count($temp1['cardid']);
	$conb = count($temp['cardid']);
	$temp2 =array();
	// echo $con;
	$k = 0;
	for($i = 0;$i<$con; $i++){
		for($j=0;$j<$conb;$j++){
			$k++;
			if($temp1['cardid'][$i]==$temp['cardid'][$j]){
				
				$temp2[$temp['id'][$j]][0][] = $temp['depid'][$j];
				$temp2[$temp['id'][$j]][1][] = $temp['depname'][$j];
				$temp2[$temp['id'][$j]][2][] = $temp['id'][$j];
				
				$temp2[$temp['id'][$j]][3][] = $temp1['name'][$i];
				$temp2[$temp['id'][$j]][4][] = $temp1['swipecardtime'][$i];
				$temp2[$temp['id'][$j]][5][] = $temp1['swipecardtime2'][$i];
				$temp2[$temp['id'][$j]][6][] = $temp1['shift'][$i];
				$temp2[$temp['id'][$j]][7][] = date('Y/m/d',strtotime($temp1['swipecardtime'][$i]));
				$temp2[$temp['id'][$j]][8][] = $temp1['WorkshopNo'][$i];
				break 1;
			}
		}
	}
	
	foreach($temp2 as $key => $value){
		// echo $key."<br>";
		$i=0;
		$flag=0;
		$temp4[$key]['cont_date']=0;
		$temp4[$key]['con_time']=0;
		// echo "key".$key."<Br>";
		foreach($value as $key1 => $value1){
			$sub = (strtotime($value[7][$i])-strtotime($value[7][$i+1]))/86400;
			// echo $value[7][0];
			if($value[7][0]==$date){
				if($flag==0){
					$temp4[$key]['cont_date']++;
					$weekend = getWeekend($value[7][$i]);
					$interval_setting = $setting[$value[8][$i]][$weekend][$value[6][$i]];
					$tempCal = getTime($value[4][$i],$value[5][$i],$value[7][$i],$interval_setting,$value[6][$i],$value[3][$i]);
					$tempCal = getNum($tempCal/3600);
					$temp4[$key]['cont_time'] += $tempCal;
					$flag=1;
				}
			}else{
				$temp4[$key]['cont_date']=0;
				$temp4[$key]['cont_time']= 0;
				// echo "123";
				break 1;
			}
			
			if($sub==1){
				$temp4[$key]['cont_date']++;
				
				$weekend = getWeekend($value[7][$i]);
				$interval_setting = $setting[$value[8][$i]][$weekend][$value[6][$i]];
				// var_dump($interval_setting);
				
				// $value[8][$i]
				
				$tempCal = getTime($value[4][$i],$value[5][$i],$value[7][$i],$interval_setting,$value[6][$i],$value[3][$i]);
				$tempCal = getNum($tempCal/3600);
				$temp4[$key]['cont_time'] += $tempCal;
			}else{
				break 1;
			}
			$i++;
		}
		$temp3[$key]['depid'] = $value[0][0];
		$temp3[$key]['depname'] = $value[1][0];
		$temp3[$key]['id'] = $value[2][0];
		$temp3[$key]['name'] = $value[3][0];
		$temp3[$key]['cont_date'] = $temp4[$key]['cont_date'];
		$temp3[$key]['cont_time'] = $temp4[$key]['cont_time'];
		$temp3[$key]['date_interval'] = $value[7][$i]." - ".$value[7][0];
		
	}	

	foreach($temp3 as $key => $value){
		if($value['cont_time']>=45||$value['cont_date']>=5){
			$depid[] = $value['depid'];
			$depname[] = $value['depname'];
			$id[] = $value['id'];
			$name[] = $value['name'];
			$cont_date[] = $value['cont_date'];
			$cont_time[] = $value['cont_time'];
			$date_interval[] = $value['date_interval'];
		}
	}
	
	
$data=array($depid,$depname,$id,$name,$cont_date,$cont_time,$date_interval);

// var_dump($data);
// exit;
// mysqli_free_result($query); 



//$project = "N71 E75";
$cur_date = Date("Y-m-d");
$cur_time = Date("H:i:s");

if($cur_time>="07:40:00" && $cur_time<"20:00:00") //執行時間為日班的話，抓取的報表應該為前一日夜班
{
    $shift = "夜班";
    $report_date = date("Y-m-d", strtotime("-1 day", time()));
}
else
{
    $shift = "日班";
    $report_date = $cur_date;
}

if($con > 0 && $conb > 0)
{
    $email = new PHPMailer();
    $email->From      = 'ken_lin@foxlink.com.tw';
    $email->FromName  = '工時預警';
    $email->Subject   = $report_date.' '.$project.' '.$shift.' 工時預警郵件';
    $message = "您好!\n"
    			."以下人員已連續上班5天/工時已達45H\n"
    			."詳情見附件！\n\n\n";
    		  
    		  
    // $message = "您好!\n"
    			// ."以下人員已連續上班5天/工時已達45H\n"
    			// ."詳情見附件！\n\n\n"
              // ."Contact Us\n系統整合課\n姓名:蒲秦川\n分機:32910\nE-mail: Paul_Qin@foxlink.com";
    $email->Body      = $message;
    
    $email->AddAddress("Guangrong_Tu@KUNSHAN");
    $email->AddAddress("Alice_Zhang@KUNSHAN");
    $email->AddAddress("Lucy_Wang@KUNSHAN");
    $email->AddAddress("Larry_Zhang@KUNSHAN");
    $email->AddAddress("Zhengbin_Liu@KUNSHAN");
    $email->AddAddress("Zuliang_Guo@KUNSHAN");
    $email->AddAddress("Tong_Wu@KUNSHAN");
    $email->AddAddress("John_Zhang@KUNSHAN");
    $email->AddAddress("Eajun_Zhang@KUNSHAN");
    $email->AddAddress("Shaohuan_Sang@KUNSHAN");
    $email->AddAddress("Wang_Ping@KUNSHAN");
    $email->AddAddress("Jinling_Meng@KUNSHAN");
    $email->AddAddress("denil_chuang@foxlink.com.tw");
    
    // $mysqli->close();
        
    $email->CharSet="UTF-8";
    //---------  ---------- "../sfc/excel/"
    $fileName = "Hours_Warning";
    $headArr = array("部門ID","部門名稱","工號","姓名","連續天數","連續小時","工作日期段");
    // $data = array(array(1,2,3),array(1,3,5),array(5,7,9));
    // getExcel($fileName,$headArr,$data);
    $excel_name =  getExcel($fileName,$headArr,$data);
    $file_to_attach="temp/".$excel_name;
    $email->AddAttachment($file_to_attach);
    
    //擷取HMI Official Report畫面圖檔-------------
    // $imgname = 'Worktime_Warning.png';
    // screenshot('http://localhost:8888/AddDemo/Compute_Hours_Warning.jsp',1200,4800,$imgname);
    //sleep(30);
    // $file_to_attach = '../sfc/img1/'.$imgname;
    
    // $email->AddAttachment($file_to_attach);
    
    $email->Send();
    echo $report_date." ".$project." ".$shift."Official Report發送郵件成功!!";
}
else
{
    echo $report_date." ".$project." ".$shift."無發生工時預警，不需寄送郵件!!";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript">setTimeout("window.opener = window.open('','_parent',''); window.close();" ,2000)</script>
</head>
<body></body>
</html>