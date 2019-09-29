<?php
$db_host = 'localhost';
$db_username = 'root';
$db_passwd = 'root';
$db_name = 'cart';
$db_link = @new mysqli($db_host,$db_username,$db_passwd,$db_name);
if($db_link->connect_error != ''){
  echo 'fail to connect mysql';
}else{
  $db_link->query("SET NAMES 'utf8'");
}
 ?>
