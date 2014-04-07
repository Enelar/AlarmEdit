<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

function phoxy_conf()
{
	$ret = phoxy_default_conf();
	unset($ret["cache_global"]);
	return $ret;
}

$link = mssql_connect('192.168.0.106:1433', 'tsoft', 'qwerty');
//var_dump($link);	
//var_dump(mssql_get_last_message());	

//$server = 'ENELAR-TSOFT\SQLEXPRESS';
//$link = mssql_connect($server, 
include('phoxy/index.php');