<?php
error_reporting(0);
/*$queue=$_GET['queue'];*/
require_once(APPPATH.'libraries/phpagi/phpagi-asmanager.php');
/*require_once(APPPATH.'/libraries/dbagent.php');*/

$myfile = '/etc/asterisk/queues_additional.conf';

$asm = new AGI_AsteriskManager();
  if($asm->connect())
  {
    $result = $asm->Command("queue show");

    if(!strpos($result['data'], ':'))
      echo $peer['data'];
    else
    {
$arr = array();
/*$data_result = $result['data'];*/
$data_result = file_get_contents(dirname(__FILE__).'/data_raw.txt');
$SL    			=    preg_match_all('/SL\:[-+]?[0-9]*\.?[0-9]*/',$data_result,$matches_sl);
$call_active    =    preg_match_all('/[0-9]+(?= has)/',$data_result,$matches);
$call_in_queue  =    preg_match_all('/has\s[0-9]+(?= calls)/',$data_result,$queue_matches);
$hold_time      =    preg_match_all('/[0-9]+(?=\w holdtime)/',$data_result,$hold_match);
$talk_time      =    preg_match_all('/[0-9]+(?=\w talktime)/',$data_result,$talk_match);
$abandon_call   =    preg_match_all('/A\:[0-9]+(?=,)/',$data_result,$abandon_match);
$answered_call  =    preg_match_all('/C\:[0-9]+(?=,)/',$data_result,$answered_match);
$sip_position   =    preg_match_all('/[0-9]+\.(?= SIP)/',$data_result,$sip_match);
$sip_wait       =    preg_match_all('/wait\:\s[0-9]\:[0-9][0-9]/',$data_result,$sip_wait_match);
$sip_prio       =    preg_match_all('/prio\:\s[0-9]/',$data_result,$sip_prio_match);
$agent_id       =    preg_match_all('/(?!(Agent(\s|)[0-9])\s)\(SIP\/[0-9]+/',$data_result,$agent_match);
$call_secs      =    preg_match_all('/(?!has\staken\s)no(?=\scalls)|([0-9]+(?=\ssecs))/',$data_result,$secs_matches);
$agent_in_call  =    preg_match_all('/\(In\s+use\)/',$data_result,$agent_in_call_match);
$agent_waiting_call  =    preg_match_all('/\(Not\s+in\s+use\)/',$data_result,$agent_waiting_call_match);
$agent_unavailable  =    preg_match_all('/\(Unavailable\)/',$data_result,$agent_unavailable_match);

for ($i=0; $i < count($matches); $i++) {
    $arr['call_active'][]=$matches[$i][$i];
}

for ($j=0; $j < count($queue_matches); $j++) {
    $arr['call_in_queue'][]=preg_replace('/has\s/','',$queue_matches[$j][$j]);
}

for ($k=0; $k < count($hold_match); $k++) {
    $arr['hold_time'][]=$hold_match[$k][$k];
}

for ($l=0; $l < count($talk_match); $l++) {
    $arr['talk_time'][]=$talk_match[$l][$l];
}

for ($m=0; $m < count($abandon_match); $m++) {
    $arr['abandon_call'][]=preg_replace('/A\:/','',$abandon_match[$m][$m]);
}

for ($n=0; $n < count($answered_match); $n++) {
    $arr['answered_call'][]=preg_replace('/C\:/','',$answered_match[$n][$n]);
}

for ($o=0; $o < count($sip_match); $o++) {
    $arr['position'][][]=preg_replace('/\./','',$sip_match[$o][$o]);
    //array_push($arr['position'][$o],preg_replace('/wait\:/','',$sip_wait_match[$o][$o]));
    //array_push($arr['position'][$o],preg_replace('/prio\:/','',$sip_prio_match[$o][$o]));
}

for ($p=0; $p < count($agent_match); $p++) {
    $arr['agent_id'][$p]=preg_replace('/[^0-9]/','',$agent_match[$p]);
    $arr['second'][$p]=str_replace('no',0,$secs_matches[$p]);
    //array_push($arr['agent_id'][$p],$secs_matches[$p]);
}

//$arr['agent_id'] = ksort($arr['agent_id']);
//$arr['second'] = ksort($arr['second']);
/*for ($q=0; $q < count($secs_matches); $q++) {
    $arr['second'][]=str_replace('no',0,$secs_matches[$q]);
}*/

for ($r=0; $r < count($sip_wait_match); $r++) {
    $arr['call_wait'][]=preg_replace('/wait\:/','',$sip_wait_match[$r]);
}

for ($s=0; $s < count($agent_in_call_match); $s++) {
    $arr['agent_in_call'][]=$agent_in_call_match[$s][$s];
}
$arr['agent_watting_call'] = array();
for ($t=0; $t < count($agent_waiting_call_match[0]); $t++) {
    if($agent_waiting_call_match[0][$t]!=null){
        $arr['agent_watting_call'][]=$agent_waiting_call_match[0][$t];
    }
}

$arr['sl_arr'] = array();
for ($i=0; $i < count($matches_sl[0]); $i++) {
    $arr['sl_arr']  =   $matches_sl[0][0];
}
/*for ($t=0; $t < count($agent_unavailable_match[0]); $t++) {
    if($agent_unavailable_match[0][$t]!=null){
        $arr['agent_watting_call'][]=$agent_unavailable_match[0][$t];
    }
}*/
//echo json_encode($arr['agent_watting_call']);
/*echo '<pre>';
print_r($arr);
echo '</pre>';
exit;*/
?>
<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="tester.css">
<link rel="stylesheet" href="table.css">
<html>
<title></title>
<head>
<?php
  /*$queue=$_GET['queue'];*/
  /*echo "<meta http-equiv='refresh' content='5'>";*/
?>
<script src="jquery-3.3.1.min.js"></script>

<script>
function blink_text() {
    $('#calls_que').fadeOut(500);
    $('#calls_que').fadeIn(500);

    $('#agent_in_call').fadeOut(500);
    $('#agent_in_call').fadeIn(500);

}
setInterval(blink_text, 1000);
</script>
</head>
<body>
<?php

/*echo "<form style= 'display : none;' id='queue' action='' method='GET'>";
$lines = file($myfile);
echo "Select the queue - ";
foreach($lines as $queues){
if (preg_match("/]/i", $queues)) {
echo "<button name='queue' type='submit' value='".substr($queues, 1, -2)."'>".substr($queues, 1, -2)."</button>";
}
}
echo "</form>";*/
?>
<div id="parent" class="wallboard" style="height: auto;">
<div id="child-left" class="wallboard_stamp">
    <div class="">
    <span class="stamp_copy">Total Call</span>
    <?php
        $final = $arr['answered_call'][0] + $arr['abandon_call'][0];
        echo '<div class="stamp_copy-blackTxt">'.$final.'</div>';
        /*for ($i=0; $i < count($arr['call_active']); $i++) {
            echo '<div class="stamp_copy-blackTxt">'.$arr['call_active'][$i].'</div>';
        }*/
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style = "background-color: #f7ca44;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Calls in Queue</span>
    <?php
    for ($j=0; $j < count($arr['call_in_queue']); $j++) {
        //echo '<div class="stamp_copy-blackTxt"><div id = "calls_que">'.$arr['call_in_queue'][$j].'</div></div>';
        echo '<div class="stamp_copy-blackTxt">';
            if($arr['call_in_queue'][$j] > 0){
                echo '<div id = "calls_que">';
            }else{
                echo '<div id = "">';
            }
                    echo $arr['call_in_queue'][$j];
                echo '</div>';
        echo '</div>';
    }
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style = "background-color: #fc6b3f;">
    <div class="">
    <span class="stamp_copy">Answered Calls</span>
    <?php
    for ($k=0; $k < count($arr['answered_call']); $k++) {
        echo '<div class="stamp_copy-blackTxt">'.$arr['answered_call'][$k].'</div>';
    }
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style = "background-color: #ff2e4c;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Abandoned Calls</span>
    <?php
    for ($l=0; $l < count($arr['abandon_call']); $l++) {
        echo '<div class="stamp_copy-blackTxt">'.$arr['abandon_call'][$l].'</div>';
    }
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style = "background-color: #f85959;">
    <div class="">
    <span class="stamp_copy">Average Hold Time</span>
    <?php
    function numb_to_times($numb){
        $now = date_create(date('Y-m-d H:i:s'));
        $ago = date_create(date('Y-m-d H:i:s',strtotime('+'.$numb.' seconds')));
        $diff=date_diff($ago,$now);
        //$diff = $now->diff($ago);
        $string = array(
           // 'h' => 'h', //used if you want to show hour
            'i' => 'm',
            's' => 's',
        );
        foreach ($string as $k => &$v) {
            if ($diff->format('%'.$k)) {
                $v = ($diff->format('%'.$k)>9)?$diff->format('%'.$k):'0'.$diff->format('%'.$k);
            } else {
                $string[$k]='00';
            }
        }

      return implode(':', $string);
    }
    for ($m=0; $m < count($arr['hold_time']); $m++) {
        echo '<div class="stamp_copy-blackTxt">'.numb_to_times($arr['hold_time'][$m]).'</div>';
    }
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style="background-color: #7da87b;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Average Talk Time</span>
    <?php
        function numb_to_time($numb){
            $now = date_create(date('Y-m-d H:i:s'));
            $ago = date_create(date('Y-m-d H:i:s',strtotime('+'.$numb.' seconds')));
            $diff=date_diff($ago,$now);
            //$diff = $now->diff($ago);
            $string = array(
               // 'h' => 'h', //used if you want to show hour
                'i' => 'm',
                's' => 's',
            );
            foreach ($string as $k => &$v) {
                if ($diff->format('%'.$k)) {
                    $v = ($diff->format('%'.$k)>9)?$diff->format('%'.$k):'0'.$diff->format('%'.$k);
                } else {
                    $string[$k]='00';
                }
            }

          return implode(':', $string);
        }

        for ($n=0; $n < count($arr['talk_time']); $n++) {
            echo '<div class="stamp_copy-blackTxt">'.numb_to_time($arr['talk_time'][$n]).'</div>';
        }

    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style="background-color: #e6a4b4;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Agent in call</span>
    <?php
        for ($s=0; $s < count($agent_in_call_match); $s++) {
            //echo '<div class="stamp_copy-blackTxt"><div id = "agent_in_call">'.count($arr['agent_in_call'][$s]).'</div></div>';
            echo '<div class="stamp_copy-blackTxt">';
                if(count($arr['agent_in_call'][$s]) > 0){
                    echo '<div id = "agent_in_call">';
                }else{
                    echo '<div id = "">';
                }
                    echo count($arr['agent_in_call'][$s]);
                echo '</div>';
            echo '</div>';
        }
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style="background-color: #ffb400;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Agent waiting call</span>
    <?php
        //for ($t=0; $t < count($arr['agent_watting_call']); $t++) {
            echo '<div class="stamp_copy-blackTxt">'.count($arr['agent_watting_call']).'</div>';
        //}
    ?>
    </div>
</div>

<div id="child-left" class="wallboard_stamp" style="background-color: #db456f;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">SL</span>
    <?php
        //for ($t=0; $t < count($arr['agent_watting_call']); $t++) {
        $a = str_replace('SL:', '', $arr['sl_arr']);
        $b = ($a == (float)0.0) ? (int)100 : (int)100 - $a;
		echo '<div class="stamp_copy-blackTxt">'.$a.'%'.'</div>';
        //}
    ?>
    </div>
</div>

<!--<div id="child-left" class="wallboard_stamp" style="background-color: #448ef6;">
    <div class="stamp_imgBg">
    <span class="stamp_copy">Agent break</span>
    </div>
</div>!-->

<!--<div id="child-left">
    <span class="stamp_copy">Position</span>
</div>

<div id="child-left">
    <span class="stamp_copy">Call wait time</span>
</div>!-->
</div>
<div class="wrapper">
  <div class="col-md-6">
      <div class="table">

        <div class="row header">
          <div class="cell">
            Position
          </div>
          <div class="cell">
            Call wait time
          </div>
          <div class="cell">
            Agent Name
          </div>
          <div class="cell">
            On call for (second)
          </div>
        </div>

        <div class="row">
          <div class="cell" data-title="Name">
            <?php
                $counter = 0;
                for ($a=0; $a < count($arr['agent_id'][$counter]); $a++) {
                    $pos = $arr['position'][$counter][$a];
                    echo '<div class="'.($a%2==0?'odd':'even').'">'.(empty($pos)?'-':$pos).'</div>';
                }
            ?>
          </div>
          <div class="cell" data-title="Age">
            <?php
                $counter = 0;
                if(count($arr['call_wait'][$counter])>0){
                    for ($e=0; $e < count($arr['call_wait'][$counter]); $e++) {
                        $wait = $arr['call_wait'][$counter][$e];
                        echo '<div class="'.($e%2==0?'odd':'even').'">'.(empty($wait)?'0':$wait).'</div>';
                    }
                }else{
                    for ($c=0; $c < count($arr['agent_id'][$counter]); $c++) {
                        echo '<div class="'.($c%2==0?'odd':'even').'">'.'0'.'</div>';
                    }
                }
            ?>
          </div>
          <div class="cell" data-title="Occupation">
            <?php
                $counter = 0;
                for ($c=0; $c < count($arr['agent_id'][$counter]); $c++) {
                    echo '<div class="'.($c%2==0?'odd':'even').'">'.$agents[$arr['agent_id'][$counter][$c]].'</div>';
                }
            ?>
          </div>
          <div class="cell" data-title="Location">
            <?php
            /*function numb_to_second($numb){
                $now = date_create(date('Y-m-d H:i:s'));
                $ago = date_create(date('Y-m-d H:i:s',strtotime('+'.$numb.' seconds')));
                $diff=date_diff($ago,$now);
                //$diff = $now->diff($ago);
                $string = array(
                // 'h' => 'h', //used if you want to show hour
                    'i' => 'm',
                    's' => 's',
                );
                foreach ($string as $k => &$v) {
                    if ($diff->format('%'.$k)) {
                        $v = ($diff->format('%'.$k)>9)?$diff->format('%'.$k):'0'.$diff->format('%'.$k);
                    } else {
                        $string[$k]='00';
                    }
                }

            return implode(':', $string);
            }*/
            $counter = 0;
            for ($d=0; $d < count($arr['second'][$counter]); $d++) {
                echo '<div class="'.($d%2==0?'odd':'even').'">'.$arr['second'][$counter][$d].'</div>';
            }
        ?>
          </div>
        </div>

      </div>
    </div>
    <div class="col-md-6">
        <div class="table">
            <div class="row header">
                <div class="cell">
                    Number
                </div>
                <div class="cell">
                    Agent Name
                </div>
            </div>

            <div class="row">
                <div class="cell" data-title="Name">
                    <?php
                        $counter = 0;
                        for ($c=0; $c < count($arr['agent_id'][$counter]); $c++) {
                            echo '<div class="'.($c%2==0?'odd':'even').'">'.$arr['agent_id'][$counter][$c].'</div>';
                        }
                    ?>
                </div>

                <div class="cell" data-title="Name">
                    <?php
                        $counter = 0;
                        for ($c=0; $c < count($arr['agent_id'][$counter]); $c++) {
                            echo '<div class="'.($c%2==0?'odd':'even').'">'.$agents[$arr['agent_id'][$counter][$c]].'</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $asm->disconnect();
    }
  }
?>
<!--<table style = "float : left;">
    <tr>
        <th>Calls today</th>
    </tr>
</table>!-->
</body>
</html>
