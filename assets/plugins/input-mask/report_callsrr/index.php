<?php

require_once("libs/paloSantoGrid.class.php");

function _moduleContent(&$smarty, $module_name)
{

	load_language_module($module_name);

	//$smarty->assign("relative_dir_rich_text", $relative_dir_rich_text);
	$relative_dir_rich_text = "modules/$module_name/theme/".$arrConf['theme'];

	$base_dir = dirname($_SERVER['SCRIPT_FILENAME']);
	$local_templates_dir = "$base_dir/modules/$module_name/theme";
    
	$sAction = 'rep_kanmo';
    if (isset($_REQUEST['action'])) $sAction = $_REQUEST['action'];
    switch ($sAction) {
    default:
        return listTicket($pDB, $smarty, $module_name, $local_templates_dir);
    }
}

function listTicket($pDB, $smarty, $module_name, $local_templates_dir){

    if(isset($_SESSION['issabel_user'])){
    	//echo $_SESSION['issabel_user'];exit;
    }
    //$page = $smarty->fetch("$local_templates_dir/ticket.php");

    /*https://172.16.177.21/kanmo/report_agent_activity/index/kanmo/3ec8112b9e277cf4d24c85136fc9ee95*/
    $url = 'https://localhost'.str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'kanmo/report_calls/index/nespresso/3ec8112b9e277cf4d24c85136fc9ee95?issabel_user='.$_SESSION['issabel_user'];
    $str = file_get_contents($url);
    if($str === false){
        return error_get_last();
    }else{
        return $str;
    }
    //return file_get_contents('https://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']).'kanmo/panel/api/ticket/ticket_list/kanmo/3ec8112b9e277cf4d24c85136fc9ee95?issabel_user='.$_SESSION['issabel_user']);
}

?>