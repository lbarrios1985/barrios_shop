<?php

$db_username = 'nikeven'; //MySql database username
$db_password = 'Haydelis26.'; //MySql dataabse password
$db_name = 'nikeven'; //MySql database name
$db_host = 'localhost'; //MySql hostname or IP

$currency = '$'; //currency symbol
$shipping_cost = 0; //shipping cost

$mysqli_conn = new mysqli($db_host, $db_username, $db_password, $db_name); //connect to MySql
if ($mysqli_conn->connect_error) {
    //Output any connection error
    die('Error : ('.$mysqli_conn->connect_errno.') '.$mysqli_conn->connect_error);
}
