<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/jquery.ui.all.css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
    $( "#datepicker" ).datepicker( "setDate" , new Date() );
	
	var d=document.getElementById('color_msg');
	document.onmousemove = function (ev) {
		var oEvent = ev || event;
		var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft;
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		d.style.position="absolute";
		d.style.top=oEvent.clientY + scrollTop + 'px';
		d.style.left=oEvent.clientX + scrollLeft +40+ 'px';
	}
});

function makeSure()
{
    var date = $("#datepicker").val();
    var shift = $("#shift").val();
    $.ajax({
				type : 'post',
				url : 'swipe_statistics1.php',
                dataType: 'json',
                data: {date:date, shift:shift},
				success : function(msg) {
                    $html = "零組件:  <br>在職"+msg['CABG_onWork']+"人,  刷卡"+msg['CABG']+"人<br>";
                    $html += msg['CABG_detail']+"<br><br>";
                    $html += "通訊:  在職"+msg['CSBG_onWork']+"人,  刷卡"+msg['CSBG']+"人<br>";
                    $html += msg['CSBG_detail'];
				    $("#result").empty();
					$("#result").append($html);
				}
		});
}
</script>
</head>
<body>
<form name="upload">
<input type="hidden" name="regex" value="^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-0?2-29))\s(0[0-9]?|1[0-9]?|2[0-3]?|[1-9])(：(0[0-9]?|[1-5][0-9]|\d)){2}|((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-0?2-29))$">
請選擇日期 <input type="text" id="datepicker" name="sele_date" size="10"/>
<select id="shift">
<option value="D1">日班上班</option>
<option value="D2">日班下班</option>
<option value="N1">夜班上班</option>
<option value="N2">夜班下班</option>
</select>
<br />
<input type="button" onclick="makeSure()" value="確定" />
<p id="result"></p>
</form>
</body>
</html>