<?php

function zabbix_api($params){

	$ch = curl_init();

    if (FALSE === $ch) {
        throw new Exception('failed to initialize');
    }

    $request = json_encode($params);

    curl_setopt($ch, CURLOPT_URL, 'http://45.77.46.56/zabbix/api_jsonrpc.php');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json-rpc'));
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $content = curl_exec($ch);

    return $content;
}