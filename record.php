<?php
include "mysql.php";
$mysql = new mysql;
$mysql->query("insert into `record` (`question`,`result`) values ('".$_POST['question']."','".$_POST['result']."')");


?>