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
function total_day($date1, $date2) {
    $now = new DateTime($date2);
    $ago = new DateTime($date1);
    $diff = $now->diff($ago);
    return $diff->days;	
}

function remain($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
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
function add_duration($old, $new){
	$now = date('Y-m-d H:i:s');
	$old = get_due_time($now, $old);
	$old = get_due_time($old, $new);
	return ediff($old, $now);
}

function stop_total($stop_list, $times=null){
	$now = date('Y-m-d H:i:s');
	$holder = $now;
	if($times==null){
		if(count($stop_list)>0){
			foreach($stop_list as $val){
			//	echo $val->stop_time.' -> '.$val->start_time.'<br>';
				$diff = ediff($val->stop_time, $val->start_time);
			//	echo $holder.' -> '.$diff.'<br>';
				$holder = get_due_time($holder, $diff);
			}
			//echo $holder.' -> '.$now.'<br>';

			return ediff($holder, $now);
		}
	}else{
		if(count($stop_list)>0){
			foreach($stop_list as $val){
				$diff = ediff($val->stop_time, $val->start_time);
			//	echo $holder.' -> '.$diff.'<br>';
				$holder = get_due_time($holder, $diff);
			}
			//echo $holder.' -> '.$now.'<br>';
			$diff = ediff($holder, $now);
			$holder = get_due_time($now, $times);
			return ediff($now, get_due_time($holder, $diff));
		}else{
			return ediff($times[0], $times[1]);
		}
	}
}

function time_to_minute($time){
	$now = date('Y-m-d H:i:s');
	$time = get_due_time($now, $time);
	return total_minutes($now, $time);
}
function total_minutes($date1, $date2) {
    $now = new DateTime($date2);
    $ago = new DateTime($date1);
    $diff = $now->diff($ago);

    $string = array(
        'days' => 'd',
        'h' => 'h',
        'i' => 'm',
    );
    $total=0;
    foreach ($string as $k => &$v) {
        if ($k=='days' && $diff->days) {
    		$total += (intval($diff->days)*1440);
        }else if($k=='h' && $diff->h){
        	$total += (intval($diff->h)*60);
        }else if($k=='i' && $diff->i){
        	$total += intval($diff->i);
        }
    }

    return $total;
}
function rformat($time) {
    $now = date('Y-m-d H:i:s');
	$time = get_due_time($now, $time);
	$now = new DateTime($now);
    $time = new DateTime($time);
    $diff = $now->diff($time);

    $string = array(
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
    );
    $d=0;
    $m=0;
    foreach ($string as $k => &$v) {
        if ($k=='d' && $diff->d) {
    		$d += (intval($diff->d)*24);
        }else if($k=='h' && $diff->h){
        	$d += (intval($diff->h));
        }else if($k=='i' && $diff->i){
        	$m = intval($diff->i);
        }
    }
    $time = $d.'.'.(($m<10)?'0'.$m:$m);
    return $time;
}

function remaintime_day($time, $isend=false){
	$t1 = new DateTime($time);
	$t2 = null;
	if(!$isend){
		$t2 = date('Y-m-d 00:00:00', strtotime($time));
	}else{
		$t2 = date('Y-m-d 00:00:00', strtotime($time." + 1days"));
	}
	//echo $time.' '.$t2.' ';
	return total_minutes($time, $t2);
}