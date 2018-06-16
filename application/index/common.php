<?php

function arr_unique($arr2d){
	foreach ($arr2d as $k=>$v) {
		$v=join(',',$v);
		//得到一维数组
		$temp[]=$v;
	}
	if($temp){
		//去重
		$temp=array_unique($temp);
		//再变为二维维数组
		foreach ($temp as $k=>$v) {
			$temp[$k]=explode(',', $v);
		}

		return $temp;
	}


}
