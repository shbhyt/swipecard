<?php 
	session_start();
	$access = $_SESSION["permission"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- 

<script src="assets/js/jquery-1.8.3.min.js"></script>
<link href="assets/css/bootstrap.css" rel="stylesheet">
<!-- Bootstrap stylesheets (included template modifications) -->

<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
	
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
<script src="Button_Plugins.js"></script>

<script type="text/javascript">
	function allCheck(check) {
		var checkbox = document.getElementsByName("checkbox");
		if (check.checked) {
			for ( var i = 0; i < checkbox.length; i++) {
				checkbox[i].checked = "checked";
			}
		} else {
			for ( var i = 0; i < checkbox.length; i++) {
				checkbox[i].checked = "";
			}
		}
	}

	function getValue() {//此為取recordID
		var checkbox = document.getElementsByName("checkbox");
		var record = [];
		for ( var i = 0; i < checkbox.length; i++) {
			if (checkbox[i].checked == true) {
				//alert("box[i]: "+checkbox[i].checked);
				record[i] = checkbox[i].value;
				console.log(record[i]);
			}
		}
		return record;
	}

	function getValueA() {//此為取id/工號
		var checkbox1 = document.getElementsByName("testid");
		var record = [];
		for ( var i = 0; i < checkbox1.length; i++) {
			//alert("box[i]: "+checkbox[i].checked);
			record[i] = checkbox1[i].value;
			console.log(record[i]);
		}
		return record;
	}

//	var calInterval, calHour;
	function getValueB() {//獲取上下班時間并處理
		var checkbox1 = document.getElementsByName("stime");
		var checkbox2 = document.getElementsByName("etime");
		var checkbox3 = document.getElementsByName("checkbox");   //取得testswipecardtime.recordid
		var shift = $("#Shift").val();
        var classStart = $("#Class_Start").val();  //上班時間
        var classEnd = $("#Class_End").val();  //下班時間
        var overTime = $("#Overtime_Start").val();  //工作日加班開始計算時間
		var t_set = $("#Interval_Setting").val();  //休息间隔
		var sdate = [];
		var sdate1 = [];
		var edate = [];
		var edate1 = [];
		var t_s = [];
		var calInterval = [];
		var calHour = [];
		var spellC = "cal_";//小時數小計  ,加班时间可修改时的写法
		var spellT = "tck_";
		
		var overHour="hour_"//小時數小計  ,加班时间不修改时的写法
		var spOverHour = [];//小時數小計  ,加班时间不可修改时的写法
		
		var sp = [];//小時數小計  ,加班时间可修改时的写法
		var spT = [];//時間段
		var record = [];
		//加班時間
		var minus = 0;
		var str=null;
		t_s = t_set.split("*");
		// console.log("t_set:" +t_set);
		// console.log("t_s:" +t_s);
		for ( var i = 0; i < checkbox1.length; i++) {
			//alert("box[i]: "+checkbox[i].checked);
			sdate[i] = checkbox1[i].value;    //上班时间
			edate[i] = checkbox2[i].value;    //下班时间
			sdate1[i] = getDate1(sdate[i]);  //getDate1()字符串转换为日期
			edate1[i] = getDate1(edate[i]);

			str = checkbox3[i].value.split("_");
			//record[i] = checkbox3[i].value;
			record[i] = str[0];
			//console.log("sdate: "+sdate[i]);
			//console.log("edate: "+edate[i]);
			//alert(msg); 
			//拼接表格id
			sp[i] = spellC + record[i];
			spT[i] = spellT + record[i];
			
			spOverHour[i] = overHour + record[i];
			//console.log("sp: "+sp[i]);
			min = (edate1[i].getTime() - sdate1[i].getTime()) / 1000 / 3600;      //getTime() 方法可返回距 1970 年 1 月 1 日之间的毫秒数
			//console.log("min: "+typeof(sdate[i]));
			//console.log("min: "+min);
			//console.log("sdate1: "+sdate1[i]);
		}
		//加班計算為普通或是全天
		var cal = $("#overtimeCal").val(); //加班时间 正常/假日
		//console.log("cal: "+cal);
		//拼接加班時間段
		var sub;
		var tempInterval = [];
		var tempHour1,tempHour2;//17:30 19:30
		var tempTime;
		var tempTime1;
		var tempTime2;//17 30
		// var tempTime1 = new Date();
		// var tempTime2 = new Date();//17 30
		var tempEnd,tempStart;
		for ( var i = 0; i < checkbox1.length; i++) {
		
		if(sdate[i]==edate[i]){
		//	console.log("sdate: "+sdate[i]);
		//	console.log("edate: "+edate[i]);
			
			minus = 99;           
			sub = getHour(sdate1[i]) + "-" + getHour1(edate1[i]);
		}
		else{
		
			//minus-根據選擇的加班時間類型得出不同時段
			if (cal == "1") {  //正常班
				if(classEnd > classStart){ //班別無跨夜
				//console.log("sdate1[0]:"+ sdate1[0]);{
					sdate1[i].setHours(overTime.substr(0,2), overTime.substr(2,2), 0);  //setHours(hour,min,sec,millisec) 方法用于设置指定的时间的小时字段。
				}else{
					// var tempDay  = getNextDay.time.getPreDate(1,sdate1[i]);
					var tempDay = sdate1[i].getDate();    //getDate() 方法可返回月份的某一天。
					sdate1[i].setDate(tempDay+1);
					// console.log(sdate1[i]);
				//	sdate1[i].setHours(05, 00, 0);
					sdate1[i].setHours(overTime.substr(0,2), overTime.substr(2,2), 0);
				}
                minus = (edate1[i] - sdate1[i]);
				//console.log("sdate1[0]"+typeof(sdate1[0]));
				//console.log("時長minus: "+ minus);
				//根據選擇的加班時間類型得出不同時段
				//console.log(getHour(sdate1[i]));
			} else if (cal == "2") {   //假日班
				// minus = (edate1[i] - sdate1[i]) / 3600000 - 2;
			//	 console.log("t_s:" +t_s);
                if(t_s[t_s.length-1].length < 11) //若最後一個時間段是overtime_start的數據，假日班忽略
                     t_s.splice((t_s.length-1),1);
            
				if(classEnd > classStart){ //班別無跨夜
                
					for(var j = 0;j<t_s.length;j++){  //t_s[]休息间隔

					//	console.log("t_s[j]:" +t_s[j]);
						tempInterval = t_s[j].split("-");        //例：[07:40,09:30]
						
						tempHour1 = tempInterval[0].split(":"); //[07,40]
						tempHour2 = tempInterval[1].split(":");  //[09,30]
   
                        var	tempTime1 = new Date(checkbox1[i].value.substr(0,10)+" "+tempHour1[0]+":"+tempHour1[1]+":0"); 
                        var	tempTime2 = new Date(checkbox2[i].value.substr(0,10)+" "+tempHour2[0]+":"+tempHour2[1]+":0"); 

						calStart = sdate1[i]-tempTime1;  //$calStart=上班时间-上班时段的起始时间
						calEnd   = edate1[i]-tempTime2;  //$calEnd=下班时间-上班时段的终止时间
                        
                        if((sdate1[i]-tempTime1)<0 && (edate1[i]-tempTime1)<0)
                            continue;
                            
                        if((sdate1[i]-tempTime2)>0 && (edate1[i]-tempTime2)>0)
                            continue;
                        
                        if(calStart>0 || (j==0)){    
							tempStart = sdate1[i];
							tempStart.setSeconds(0);    
						}else{  
							tempStart = tempTime1;
						}
                        
                        if(calEnd<0 || (j==(t_s.length-1)))
                        {
                            tempEnd = edate1[i];
                            tempEnd.setSeconds(0);
                        }
                        else 
                            tempEnd = tempTime2;
					
						minus += tempEnd - tempStart;
					}
				}else{                                  //夜班
					// minus = (edate1[i] - sdate1[i]);
					for(var j = 0;j<t_s.length;j++){
					// for(var j = 0;j<1;j++){
						var x = $("#1").find("[name='yd']").val();     //yd:下班刷卡时间日期-12小时   yd24小时制
						tempTime = getDate1(x);              //取得夜班下班刷卡时间-12小时的日期
						// console.log(typeof(x));
						tempInterval = t_s[j].split("-");              //例：[07:40,09:30]
						tempHour1 = tempInterval[0].split(":");        //[07,40]
						tempHour2 = tempInterval[1].split(":");        //[09,30]
						// console.log(edate1[i]);
						// console.log(tempHour2[0]);
						
						var	tempTime1 = new Date(tempTime);
						if(tempHour1[0]>0&&tempHour1[0]<12){
							 tempTime1 = new Date(tempTime.getTime() + 24 * 60 * 60 * 1000);
							 tempTime1 = tempTime1.setHours(tempHour1[0],tempHour1[1],0);
						}else{
							tempTime1 = tempTime.setHours(tempHour1[0],tempHour1[1],0);
						}
						
						// console.log("T1 :" + tempTime1);                      
						var	tempTime2 = new Date(tempTime);
						// console.log("T2 :" + tempTime2);
						// console.log(tempTime);                       
						if(tempHour2[0] >= 0 && tempHour2[0]<12){
							tempTime2 = new Date(tempTime.getTime() + 24 * 60 * 60 * 1000);
							tempTime2 = tempTime2.setHours(tempHour2[0],tempHour2[1],0);
						}else{
							tempTime2 = tempTime.setHours(tempHour2[0],tempHour2[1],0);			
						}
						
						tempTime1 = new Date(tempTime1);
					//	console.log("T1 :" + edate1[i]);
						tempTime2 = new Date(tempTime2);
					//	console.log("T2 :" + tempTime2);
						
						calStart = sdate1[i]-tempTime1;
						calEnd   = edate1[i]-tempTime2;
						// console.log($calEnd);
                        
                        if((sdate1[i]-tempTime1)<0 && (edate1[i]-tempTime1)<0)
                            break;
                            
                        if((sdate1[i]-tempTime2)>0 && (edate1[i]-tempTime2)>0)
                            break;
                        
                        if(calStart>0 || (j==0)){    //上班刷卡时间 晚于 上班时段的起始时间
							tempStart = sdate1[i];
							tempStart.setSeconds(0);    //当前时间的秒字段设置为 0
						}else{  //上班刷卡时间 早于 上班时段的起始时间
							tempStart = tempTime1;
						}
                        
                        if(calEnd<0 || (j==(t_s.length-1)))
                        {
                            tempEnd = edate1[i];
                            tempEnd.setSeconds(0);
                        }
                        else 
                            tempEnd = tempTime2;
     
						minus += tempEnd - tempStart;
					}
				}
				
				//根據選擇的加班時間類型得出不同時段
			}
		
			minus = minus / 3600000;
			minus = getNum(minus);
            
            if(minus<0){
                minus = 0;
            }
            
			sub = getHour(sdate1[i]) + "-" + getHour1(edate1[i]);
		}
			//console.log("時段sub: "+sub);
			calInterval[i] = sub;
			calHour[i] = minus;
			//console.log("時段sub: " + sub);
			//console.log("時長minus: " + minus);
			
			//document.getElementById(sp[i]).innerHTML = minus;
			document.getElementById(spT[i]).innerHTML = sub;
			// console.log(sub);
        /*加班实时为可修改时的写法
			$("#"+sp[i]).find(".textBoxtest").attr("value",minus);		
			var x = $("#"+sp[i]).find("[switchbuttonName='stButton']");
			x.switchbutton('setValue',minus);
		*/
		//加班实时为不可修改时的写法
		document.getElementById(spOverHour[i]).setAttribute("align","center");
		document.getElementById(spOverHour[i]).innerHTML = minus;
			minus = 0;
			
		}
	}

	function getNextDay() {
		var time={
			getPreDate:function(pre,mydate){
				var self=this;
				// var c = new Date();
				var c = mydate;
				// var c = "2017-06-15 08:00:00";
				// c = Date(c);
				console.log(c);
				c.setDate(c.getDate() + pre);
				return self.formatDate(c);
			},
			formatDate:function(d){
				var self=this;
				return d.getFullYear() + "-" + self.getMonth1(d.getMonth()) + "-" + d.getDate();
			},
			getMonth1:function(m){
				var self=this;
				m++;
				if(m<10)
					return "0" + m.toString();
				return m.toString();
			}
		}
		function getnextDate(pre,mydate){
			var c = mydate;
			c.setDate(c.getDate+next);
			return formatDate(c);
		}
		function formateDate(x){
			return 
		}
		
	}
	$(function(){
		
		var time={
			getPreDate:function(pre,mydate){
				var self=this;
				var c = mydate;
				c.setDate(c.getDate() + pre);
				return self.formatDate(c);
			},
			formatDate:function(d){
				var self=this;
				return d.getFullYear() + "-" + self.getMonth1(d.getMonth()) + "-" + d.getDate();
			},
			getMonth1:function(m){
				var self=this;
				m++;
				if(m<10)
					return "0" + m.toString();
				return m.toString();
			}
		}
	})
	
	
	function getHourValue(){
		var $check_boxes = $('input[type=checkbox][name=checkbox]:checked');
		console.log($check_boxes);
	}
	/*
		$(function(){
			var swiButton = $(".changeStatus").find("[switchbuttonName='stButton']");
			swiButton.switchbutton({
				
				
				onChange: function(checked){
					this_Id=$(this).parent().find("input").eq(1).attr("id");
					temp = this_Id.split("_");
					str = temp[1];
					
					if (checked == true){
					
						x = $(this);
						console.log(x.val());
						console.log(x);
						
						console.log("被選中");
						$("#cal_"+str).find(".textBoxtest").removeAttr("readOnly");					
						$("#reason_"+str).textbox('readonly',false);
					}
					if (checked == false){
						$("#cal_"+str).find(".textBoxtest").attr("readOnly","true");					
						$("#reason_"+str).textbox('readonly',true);
					}
				}
			});
		});
	//}
	
*/	

	function setOverType() {//設置加班類型：1、2、3
		var type = $("#overtimeType").val();
		//var cal = $("#overtimeCal").val();
		//console.log("cal: "+cal);
		var itype = "type_";
		var mType = [];
		console.log("type:" + type);
		type1 = "延時加班";
		atype = [ "", "延時加班", "例假日加班", "節假日加班" ];
		var checkbox3 = document.getElementsByName("checkbox");
		
		for ( var i = 0; i < checkbox3.length; i++) {
			str = checkbox3[i].value.split("_");
			//record[i] = checkbox3[i].value;
			
			mType[i] = itype + str[0];;
			//console.log(mType[i]);
			
			document.getElementById(mType[i]).innerHTML = atype[type];
		}

	}
	
	

	//得到時間段
	function getHour(strDate) {
		var hours = strDate.getHours();
		var mins = strDate.getMinutes();
		
		if(hours<10){
			hours="0"+hours;
		}
		// if(hours!='08'&&hours=='07'){
			// hours='08';
			// mins='00';
		// }
		if(mins<10){
			mins="0"+mins;
		}
		var Hour = hours + ":" + mins;
		return Hour;
	}
	
	
	function getHour1(strDate) {
		var hours = strDate.getHours();
		var mins = strDate.getMinutes();
		
		if(hours<10){
			hours="0"+hours;
		}
		// if(hours!='08'&&hours=='07'){
			// hours='08';
			// mins='00';
		// }
		if(mins<10){
			mins="0"+mins;
		}
		var Hour = hours + ":" + mins;
		return Hour;
	}
	//字符串轉日期格式
	function getDate1(strDate) {
		var date = eval('new Date('
				+ strDate.replace(/\d+(?=-[^-]+$)/, function(a) {
					return parseInt(a, 10) - 1;
				}).match(/\d+/g) + ')');
		return date;
	}

	function getNum(Num) {
		var front = 0;
		var surplus = 0;
		front = Math.floor(Num);           //floor() 方法执行的是向下取整计算
		surplus = Num - front;
		// if (surplus <= 0.25) {
			// surplus = 0;
		// } else if (surplus > 0.25 && surplus <= 0.75) {
			// surplus = 0.5;
		// } else if (surplus > 0.75) {
			// surplus = 1;
		// }
		if (surplus < 0.25) {
			surplus = 0;
		} else if (surplus > 0.25 && surplus < 0.5) {
			surplus = 0.25;
		} else if (surplus>=0.5 && surplus < 0.75) {
			surplus = 0.5;
		}else if(surplus >=0.75 && surplus < 1 ){
			surplus = 0.75;
		}
		
		return surplus + front;
	}
	
	function firm() {
		getValue();
		if (confirm("你确定提交吗？")) {

			alert("点击了确定");
		} else {
			alert("点击了取消");
		}
	}

	function update() {
		
		if (confirm("你确定提交當前選擇人員名單吗？")) {
			//獲取選中人員recordid
			//var $check_boxes = $('input[type=checkbox][checked=checked][id!=check_all_box][id!=inlineCheckbox1][name=stButton]');
			//var $check_boxes = $('input[type=checkbox][name=stButton]');
			var $check_boxes = $('input[type=checkbox][name=checkbox][id!=check_all_box][id!=inlineCheckbox1]:checked');
			var timeCal = $("#overtimeCal").val();
			var timeType = $("#overtimeType").val();
			var dropIds = new Array();
			$check_boxes.each(function() {
				dropIds.push($(this).val());
			});
			var shift = $("#Shift").val();
			var workcontent=$("#workcontent").val();
			//console.log($check_boxes);
			//console.log(dropIds);
			var workshopNo=$("#WorkshopNo").val();
			var rC_NO=$("#RC_NO").val();
			var item_No=$("#Item_No").val();
		//	console.log("item_No： "+item_No);
			var jtest;
			var ids = [];
			var names = [];
			var depids = [];
			var costids = [];
			var directs = [];
			var yds = [];
			var calInterval = [];
			var calHour = [];
			var dropId=[];
			var depname=[];
			var reason=[];
			var tr = null;
			//dp= $('#3').find('input')[2].val();
			//console.log("workshopNo: " +workshopNo+"rC_NO: " +rC_NO+"item_No: " +item_No);
			for ( var i = 0; i < dropIds.length; i++) {
				//console.log("dropIds[i]:" + dropIds[i]);
				var str = dropIds[i].split("_");
				jtest = str[1];
				tr= $("tr[id=" + jtest + "]");
				depname[i] = tr.find('input[ID$=depname]').val();
				
				//console.log(depname[i]);
				dropId[i] = str[0];
				ids[i] = document.getElementById("tbl").rows[jtest].cells[2].innerText;
				names[i] = document.getElementById("tbl").rows[jtest].cells[3].innerText;
				depids[i] = document.getElementById("tbl").rows[jtest].cells[4].innerText;
				
				costids[i]=document.getElementById("tbl").rows[jtest].cells[5].innerText;
				directs[i]=document.getElementById("tbl").rows[jtest].cells[6].innerText;
				
				yds[i] = document.getElementById("tbl").rows[jtest].cells[7].innerText;
				//console.log(typeof(yds[i]));
				calInterval[i] = document.getElementById("tbl").rows[jtest].cells[8].innerText;
			//	calHour[i] = tr.find(".textBoxtest").val(); //加班时间可以修改时的写法		
				calHour[i] = document.getElementById("tbl").rows[jtest].cells[9].innerText;
			//    console.log(typeof(calHour[i]));
				if(calHour[i]<=0){
					alert("工時小於等於0，有誤，請重新選擇加班人員！");
					return false;
				}
				calHour[i] = calHour[i].toString();
			//	reason[i]=$("#reason_"+str[0]).textbox('getText');
				
				//reason[i]=$("#reason_"+str[0]).find(".textbox-value").val();
				//console.log("jtest:"+jtest);
				//console.log(reason[i]);
				//console.log(costids[i]+"  "+directs[i]);
				//console.log(dropId[i]+" "+ ids[i]+" "+names[i]+" "+depids[i]+" "+yds[i]+" "+calInterval[i]+" "+calHour[i]);
			}
			console.log(calInterval);

			ydss = yds[0];			
			$.ajax({
				type : 'post',
				traditional : true,
				url : 'overtime_order_pending_update1.php',
				data : {
					'dropId[]' : dropId,
					'ids[]' : ids,
					'names[]' : names,
					'depids[]' : depids,
					'depname[]':depname,
					'costids[]':costids,
					'directs[]':directs,
					'ydss' : ydss,
					'shift':shift,
					'calInterval[]' : calInterval,
					'calHour[]' : calHour,
					'reason[]': reason,
					'workcontent':workcontent,
					'timeCal' : timeCal,
					'timeType' : timeType,
					'workshopNo':workshopNo,
					'rC_NO':rC_NO,
					'item_No':item_No
				},
				success : function(msg) {
					alert("提交成功,窗口即將關閉！");
					 console.log(msg);
					window.close();
				}
			});
			
		}
	}

	function check() {
		
		// checkBox1();
		if(checkBox1()==false){
			return false;
		}else{
			update();
		}
		
	}
	
	function isInteger(obj) {
		 return (obj | 0) === obj;
	}
	
	function checkBox1(){
		var timeCal = $("#overtimeCal").val();
		var timeType = $("#overtimeType").val();
		if (timeCal == 0 || timeType == 0) {
			alert("請選擇時間及加班類型");
			return false;
		}
		
		var $check_boxes = $('input[type=checkbox][name=checkbox][id!=check_all_box][id!=inlineCheckbox1]:checked');
		if($check_boxes.length==0){
			alert("沒有選擇加班人員，請重新選擇");
			return false;
		}
		
		
		if($("#workcontent").length >0) {
			var checkContent = $("#workcontent").val();
			if(checkContent.length==0){
				alert("請輸入工作內容！");
				return false;
			}
		}
		
		//console.log($check_boxes);
		//var $check_boxes = document.getElementById("test123").checked;
		var dropIds = new Array();
		$check_boxes.each(function() {
			dropIds.push($(this).val());
		});
		
		var text_v;
		console.log(dropIds);
		for( var i = 0; i < dropIds.length; i++){
			//console.log("dropIds[i]:" + dropIds[i]);
			var str = dropIds[i].split("_");
			jtest = str[1];
			//str[0];
			tr= $("tr[id=" + jtest + "]");
			
			//$(tr).find(".textBoxtest").val();
		 	//text_v = parseFloat(calHour[i]);
		 //	text_v = $(tr).find(".textBoxtest").val();
		 
			text_v = document.getElementById("tbl").rows[jtest].cells[9].innerText;
		 	text_v = parseFloat(text_v);
		// 	check_v = $(tr).find("[switchbuttonName='stButton']").val();
		// 	reason_v=$("#reason_"+str[0]).textbox('getText');
		 	//console.log(text_v);
		 	//console.log(check_v);
		 	//console.log(reason_v);
		 	
		 	
		 	// console.log(text_v);
		 	isInt = text_v/0.25;
		 	// console.log(isInt);
		 	isInt = isInteger(isInt);
		 	/*
		 	if(text_v<=12&&text_v>=0&&isInt==true){
		 		if(text_v==check_v){
		 			if(reason_v.length!=0){
		 				alert("修改工時和原工時一樣,請重新確認！！！");
		 				return false;
		 			}
		 		}
				else if(text_v!=check_v){
		 			if(reason_v.length==0){
		 				alert("請輸入修改加班工時原因，不少於6個字!");
		 				return false;
		 			}else if(reason_v.length<12){
		 				alert("請繼續補充，不少於6個字!");
				 		return false;
		 			}
		 		}
		 	}else{
		 		alert("非法輸入，請輸入0-12的正數！");
		 		return false;
		 	}
		 	//console.log(reason_v.length);
			*/
		}
	}
</script>
<title>SELECT Operation</title>
</head>
<body class="pace-done">
	<?php 
	
		$SDate = $_POST['SDate'];
		$WorkshopNo = $_POST['WorkshopNo'];
		$lineno = $_POST['LineNo']; //為null
		$RC_NO = $_POST['rc_no'];
		$Item_No = $_POST['item_no'];
		$Shift = $_POST['Shift'];
		$assistant_id = $_SESSION['assistant_id'];
		$w=date('w',strtotime($SDate));
		if($w==6){
			$weekend = 1;
		}else{
			$weekend = 0;//TODO
		}
		
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
	//	 echo $cch."<br>";
	}
	// echo $cch;
		
		include("mysql_config.php");

		 $employee_overtime_sql = "SELECT
									t.id,
									t. NAME,
									t.depid,
									t.depname,
									t.direct,
									t.costid,
									DATE_FORMAT(t.swipecardtime, '%Y-%m-%d') AS yd,
									t.checkstate,
									t.recordid,
									t.overtimeCal,
									t.overtimeType,
									t.swipecardtime,
									t.swipecardtime2
							FROM
							(
								(SELECT
									b.id,
									b. NAME,
									b.depid,
									b.depname,
									b.direct,
									b.costid,
									DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') AS yd,
									a.checkstate,
									a.recordid,
									a.overtimeCal,
									a.overtimeType,
									a.swipecardtime,
									IFNULL(a.swipecardtime2, a.swipecardtime) swipecardtime2,
									a.WorkshopNo,
									a.RC_NO,
									c.class_no
								FROM
									`testswipecardtime` a
								LEFT JOIN `testemployee` b ON a.`ID` = b.`ID`
								LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
									AND c.`emp_date` = SUBSTRING(a.swipecardtime, 1, 10)
								WHERE
									DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') = '" . $SDate . "'
                                    and a.swipecardtime2 is null
									AND b.isOnWork = 0	
									and a.`WorkshopNo` = '" . $WorkshopNo . "'
AND a.`rc_no` = '" . $RC_NO . "' 
AND a.checkstate IN ('0', '9')
AND b.costid IN ($cch)
AND c.`class_no` = '" . $Shift . "'				
								)
						UNION
								(SELECT
								b.id,
								b. NAME,
								b.depid,
								b.depname,
								b.direct,
								b.costid,
								DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') AS yd,
								a.checkstate,
								a.recordid,
								a.overtimeCal,
								a.overtimeType,
								IFNULL(a.swipecardtime,a.swipecardtime2) swipecardtime,
								a.swipecardtime2,
								a.WorkshopNo,
								a.RC_NO,
								c.class_no
							FROM
								`testswipecardtime` a
								LEFT JOIN `testemployee` b ON a.`ID` = b.`ID`
								LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
								AND c.`emp_date` = SUBSTRING(a.swipecardtime2, 1, 10)
							WHERE
								DATE_FORMAT(a.swipecardtime2, '%Y-%m-%d') = '" . $SDate . "'
								and a.swipecardtime is null and shift='D'
								AND b.isOnWork = 0
								and a.`WorkshopNo` = '" . $WorkshopNo . "'
AND a.`rc_no` = '" . $RC_NO . "' 
AND a.checkstate IN ('0', '9')
AND b.costid IN ($cch)
AND c.`class_no` = '" . $Shift . "'
								)
							UNION
								(SELECT
								b.id,
								b. NAME,
								b.depid,
								b.depname,
								b.direct,
								b.costid,
								DATE_FORMAT(a.swipecardtime, '%Y-%m-%d') AS yd,
								a.checkstate,
								a.recordid,
								a.overtimeCal,
								a.overtimeType,
								IFNULL(a.swipecardtime,DATE_ADD(a.swipecardtime2,INTERVAL - 1 DAY)) swipecardtime,
								DATE_ADD(a.swipecardtime2,INTERVAL - 1 DAY) swipecardtime2,
								a.WorkshopNo,
								a.RC_NO,
								c.class_no
							FROM
								`testswipecardtime` a
								LEFT JOIN `testemployee` b ON a.`ID` = b.`ID`
								LEFT JOIN `emp_class` c ON b.`ID` = c.`ID`
								AND c.`emp_date` = SUBSTRING(DATE_ADD(a.swipecardtime2,INTERVAL - 1 DAY), 1, 10)
							WHERE
								DATE_FORMAT(a.swipecardtime2, '%Y-%m-%d') = DATE_ADD('" . $SDate . "',INTERVAL + 1 DAY) 
								and a.swipecardtime is null and shift='N'
								AND b.isOnWork = 0	
								and a.`WorkshopNo` = '" . $WorkshopNo . "'
AND a.`rc_no` = '" . $RC_NO . "' 
AND a.checkstate IN ('0', '9')
AND b.costid IN ($cch)
AND c.`class_no` = '" . $Shift . "'							
							) 
							) t 

								";


                                        
//        if($Shift=="")
//            $employee_overtime_sql .= "and t.`class_no` is null ";
//        else
//            $employee_overtime_sql .= "and t.`class_no`='".$Shift."'  ";
            
        $employee_overtime_sql .= "order by t.depid,t.id ";
		
    		//echo $employee_overtime_sql;
		$interval_sql = "select class_start,rest_start1,rest_end1,rest_start2,rest_end2,class_end,overtime_start from `classno` where class_no='$Shift'";
		//echo $interval_sql.'<br>';
		$timeset_row = $mysqli->query($interval_sql);
		
		$temp = array();
        $class_start = "";
        $class_end = "";
        $overtime_start = "";
		
		while($row1 = $timeset_row->fetch_assoc()){
		    if(!empty($row1['rest_start1']))
            {
    			$temp[] = substr($row1['class_start'],0,2).":".substr($row1['class_start'],2,2)."-".substr($row1['rest_start1'],0,2).":".substr($row1['rest_start1'],2,2);
                $temp[] = substr($row1['rest_end1'],0,2).":".substr($row1['rest_end1'],2,2)."-".substr($row1['class_end'],0,2).":".substr($row1['class_end'],2,2);
                
                if(!empty($row1['rest_start2']))
                {
                    $temp[] = substr($row1['rest_end2'],0,2).":".substr($row1['rest_end2'],2,2)."-".substr($row1['rest_end2'],0,2).":".substr($row1['rest_end2'],2,2);
                }
            }
            else
            {
                $temp[] = substr($row1['class_start'],0,2).":".substr($row1['class_start'],2,2)."-".substr($row1['class_end'],0,2).":".substr($row1['class_end'],2,2);
            }
            
            if(!empty($row1['overtime_start']))
            {
    			$temp[] = substr($row1['overtime_start'],0,2).":".substr($row1['overtime_start'],2,2);
            }
            
            $class_start = $row1['class_start'];
            $class_end = $row1['class_end'];
            $overtime_start = $row1['overtime_start'];
		}
		foreach($temp as $key => $value){
			if($value==end($temp)){
				$cch_t_set.= $value;
			}else{
				$cch_t_set.= $value."*";
			}
		}	  	   
			   	
	?>

	<div class="panel-body" style="border: 1px solid #e1e3e6;">
		時間： <select id="overtimeCal" onclick="getValueB()">
			<option value="0">待選</option>
			<option value="1">正常班</option>
			<option value="2">假日班</option>

		</select> 加班類型： <select id="overtimeType" onclick="setOverType()">
			<option value="0">待選</option>
			<option value="1">加班1</option>
			<option value="2">加班2</option>
			<option value="3">加班3</option>
		</select>
		<?php 
			if($RC_NO==NULL){
				echo"工作內容：<input type=\"text\" id=\"workcontent\" />" ."";
			}
		?>
		<table class="table table-striped" id="tbl">
			<tr>
				<th class="per5"><input name="checkbox1" type="checkbox"
					id="inlineCheckbox1" value="option1" onclick="allCheck(this)">
				</th>
				<th>序號</th>
				<th>工號</th>
				<th>名字</th>
				<th>部門代碼</th>
				
				<th>費用代碼</th>
				<th>直間接人員</th>
				
				<th>加班日期</th>
				<th>加班時段</th>
				<th>加班小時</th>
				<th>加班類型</th>
				<th>審核狀態</th>
			</tr>
			<?php 
			 
				$over_rows = $mysqli->query($employee_overtime_sql);
				 
				$cch = '';
				$j=1;
				while($row = $over_rows->fetch_row()){

					if($row[7]==0){
						$checkState="未審核";
					}else if($row[7]==9){
						$checkState="退回";
					}
					
					
					
					echo"<tr id =\"".$j."\">"
					  . "<input type=\"hidden\" id=\"depname\" value=\"".$row[3]."\"/>"
					  . "<input type=\"hidden\" name=\"stime\" value=\"".$row[11]."\" />"
					  . "<input type=\"hidden\" name=\"etime\" value=\"".$row[12]."\" />"
					  . "<td><input id=\"checkValue\" name=\"checkbox\" type=\"checkbox\" value=\"".$row[8]."_".$j."\"></td>"
					  . "<td>".$j."</td>"
					  . "<td><input type=\"hidden\" name=\"testid\" value=\"".$row[0]."\" />".$row[0]."</td>"
					  . "<td><input type=\"hidden\" name=\"name\" value=\"".$row[1]."\" />".$row[1]."</td>"
					  . "<td><input type=\"hidden\" name=\"depid\" value=\"".$row[2]."\" />".$row[2]."</td>"
					  . "<td><input type=\"hidden\" name=\"costid\" value=\"".$row[5]."\" />".$row[5]."</td>"
					  . "<td><input type=\"hidden\" name=\"direct\" value=\"".$row[4]."\" />".$row[4]."</td>"
					  . "<td><input type=\"hidden\" name=\"yd\" value=\"".$row[6]."\" />".$row[6]."</td>"
					  . "<td id=\"tck_".$row[8]."\"></td>"	
					  
					  ."<td id=\"hour_".$row[8]."\" class=\"overHour\" ></td>"
					  
					 
					  /*加班时间可更改
					  ."<td id=\"cal_".$row[8]."\" class=\"changeStatus\" >"
					  . "<input type=\"text\" class=\"textBoxtest\" style=\"width:50px;height:32px\" value=\"\" readonly />"
					  . "<input class=\"easyui-switchbutton\" name=\"stButton\" id=\"but_".$row[8]."\" value=\"\"  /> "
					  . "</td>"
					  */
					//  . "<input type=\"text\" class=\"textBoxtest\" style=\"width:50px;height:32px\" value=\"\" readonly />"					 
					  . "<td id=\"type_".$row[8]."\"></td>"
					  . "<td>".$checkState."</td>"
				//	  . "<td><input class=\"easyui-textbox\" id=\"reason_".$row[8]."\" style=\"width:100%;height:32px\" readonly /></td>"
					  
					  ."</tr>";
					 $j++;
				}
                mysqli_free_result($over_rows);
                $mysqli->close();
				// echo $cch;
			?>
		</table>
		<?php
			if($assistant_id){
					echo "<input class=\"btn btn-primary\" name=\"\" type=\"button\"\n";
					echo "		onclick=\"check()\" value=\"提交\" />\n";
			}
		?>

	</div>
	<div>
		<input type="hidden" id="LineNo" value="<?php echo $lineno?>"/>
		<input type="hidden" id="RC_NO" value="<?php echo $RC_NO?>" />
		<input type="hidden" id="Item_No" value="<?php echo $Item_No?>" />
		<input type="hidden" id="Shift" value="<?php echo $Shift?>" />
		<input type="hidden" id="WorkshopNo" value="<?php echo $WorkshopNo?>" />
        <input type="hidden" id="Class_Start" value="<?php echo $class_start?>" />
        <input type="hidden" id="Class_End" value="<?php echo $class_end?>" />
        <input type="hidden" id="Overtime_Start" value="<?php echo $overtime_start?>" />
		<input type="hidden" id="Interval_Setting" value="<?php echo $cch_t_set  ?>" />		
	</div>
   <!--	<input type="hidden" id="yds" value="<?php echo $SDate?>"/> 
	<input name="" type="button" onclick="location.href = 'index_test.jsp'"		value="返回" />
	 -->
</body>
</html>

