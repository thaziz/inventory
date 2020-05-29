<?php

function get_due_time($time, $long){
	//date_default_timezone_set('GMT');
	$times = explode(' ', $long);
	if(is_array($times)){
		foreach ($times as $value) {
			if(strpos($value, 'd')!==false){
				$l = str_replace('d', ' days', $value);
			}elseif(strpos($value, 'h')!==false){
				$l = str_replace('h', ' hours', $value);
			}elseif(strpos($value, 'm')!==false){
				$l = str_replace('m', ' minutes', $value);
			}elseif(strpos($value, 's')!==false){
				$l = str_replace('s', ' seconds', $value);
			}
			$time = date('Y-m-d H:i:s', strtotime($time.' + '.$l));
		}
	}
    return $time;
}
function subtract($time, $long){
	//date_default_timezone_set('GMT');
	$times = explode(' ', $long);
	if(is_array($times)){
		foreach ($times as $value) {
			if(strpos($value, 'd')!==false){
				$l = str_replace('d', ' days', $value);
			}elseif(strpos($value, 'h')!==false){
				$l = str_replace('h', ' hours', $value);
			}elseif(strpos($value, 'm')!==false){
				$l = str_replace('m', ' minutes', $value);
			}elseif(strpos($value, 's')!==false){
				$l = str_replace('s', ' seconds', $value);
			}
			$time = date('Y-m-d H:i:s', strtotime($time.' - '.$l));
		}
	}
    return $time;
}
function subtract_stop($stop, $time, $long, $limit=''){
	//date_default_timezone_set('GMT');
	$time = subtract($time, $long);
	if(!empty($limit))
		$time = subtract($time, $limit);
	return diff_time($time, $stop);
}

function elapse_json($elapse){
	$elapse = explode(' ', $elapse);
	$d = array();
	foreach ($elapse as $val) {
		$d[substr($val, -1, 1)] = substr($val, 0, -1);
	}
	return $d;
}

function to_elapsed($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if($diff->m < 1){
	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}else{
		return $datetime;
	}
}

function elapsed_diff($date1, $date2) {
    $now = new DateTime($date2);
    $ago = new DateTime($date1);
    $diff = $now->diff($ago);


    $minus = '';

    if($now>$ago){
    	$minus = '-';
    }

    $string = array(
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
        's' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . $v;
        } else {
            unset($string[$k]);
        }
    }

    return $minus.implode(' ', $string);
}

function diff_time($date1, $date2) {
    $now = new DateTime($date2);
    $ago = new DateTime($date1);
    $diff = $now->diff($ago);

    $minus = '';

    if($now>$ago){
    	$minus = '-';
    }

    $string = array(
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
        's' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = ($diff->$k>9)?$diff->$k:'0'.$diff->$k;
        } else {
            $string[$k]='00';
        }
    }

    return $minus.implode(':', $string);
}

function ediff($date1, $date2) {
    $now = new DateTime($date2);
    $ago = new DateTime($date1);
    $diff = $now->diff($ago);

    $string = array(
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
        's' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . $v;
        } else {
            unset($string[$k]);
        }
    }

    return implode(' ', $string);
}

function total_duration($stop_list, $times){
	$now = date('Y-m-d H:i:s');
	$holder = $now;
	if(count($stop_list)>0){
		foreach($stop_list as $val){
			$diff = ediff($val[0], $val[1]);
			$holder = get_due_time($holder, $diff);
		}
		$mdiff = ediff($times[0], $times[1]);
		$diff = ediff($holder, $now);
		$holder = get_due_time($now, $mdiff);
		return ediff($now, subtract($holder, $diff));
	}else{
		return ediff($times[0], $times[1]);
	}
}