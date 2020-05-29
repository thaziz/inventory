<?php

$config_file = '/etc/issabel.conf';
$lines = file($config_file);
$dbhost = 'localhost';
$dbuser = 'root';
$dbpswd = 'dut4_MEDIA';
$dbname = 'call_center';
foreach ($lines as $l) {
	if (strpos($l,"mysqlrootpwd")!==false) {
		$dbpswd = trim(str_replace('mysqlrootpwd=', '', $l));
	}
}

$agents = array();
$con=new mysqli($dbhost,$dbuser,$dbpswd,$dbname);
// Check connection
if ($con->connect_error)
{
	echo "Failed to connect to MySQL: " . $con->connect_error;
	exit;
}

//get agents list
$result = $con->query("SELECT `number`, `name` FROM agent GROUP BY `number`");
if($result->num_rows > 0 ){
	while ($row = $result->fetch_row()) {
	    $agents[$row[0]] = $row[1];
	}
}
