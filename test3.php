<?php
function getNum($Num) {//向下取整
		$front = 0;
		$$surplus = 0;
		$front = floor($Num);
		$surplus = $Num - $front;
		// if ($surplus <= 0.25) {
			// $surplus = 0;
		// } else if ($surplus > 0.25 && $surplus <= 0.75) {
			// $surplus = 0.5;
		// } else if ($surplus > 0.75) {
			// $surplus = 1;
		// }
		if ($surplus < 0.25) {
			$surplus = 0;
		} else if ($surplus > 0.25 && $surplus < 0.5) {
			$surplus = 0.25;
		} else if ($surplus>=0.5 && $surplus < 0.75) {
			$surplus = 0.5;
		}else if($surplus >=0.75 && $surplus < 1 ){
			$surplus = 0.75;
		}
		$sum = $surplus+$front;
		return $sum;
	}
	$ss = 12.33333;
	$test= getNum($ss);
	echo $test;
?>