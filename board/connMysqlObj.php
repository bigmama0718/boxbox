<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db_name = 'phpboard';
$db_link = @new mysqli($db_host, $db_username, $db_password, $db_name);
if($db_link->connect_errot != ''){
  echo 'fail to connect mysql';
}else{
  $db_link->query("SET NAMES 'utf8'");
}
 ?>
