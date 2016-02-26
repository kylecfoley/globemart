<?
error_reporting(1);	// disable
error_reporting(E_ERROR | E_PARSE);

$cookietime = 3600*24*30;	// 30 days

$x_login = "4s6NkE8sJf";
$x_tran_key = "2fdUrmKfW97576KL";
$x_test_request = "TRUE"; 	// test
//$x_test_request = "FALSE";	// live
$post_url = "https://secure.authorize.net/gateway/transact.dll";

//MYSQL_CONNECT ("localhost", "root", "sub2_dd48") or die ('I cannot connect to the database.');
MYSQL_CONNECT ("localhost:8889", "root", "root") or die ('I cannot connect to the database.');
MYSQL_SELECT_DB ("kylefole_madetochina"); 
?>