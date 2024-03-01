<?php
class mysql{
function __construct(){
$connect = 
mysqli_connect("localhost",'checkperiod_user','E&t_=U^,Q[de');
if(!$connect){
die('Could not connect:'.mysqli_error());
}
$this->connect =$connect;
mysqli_select_db($this->connect,config("mysqldb"));
mysqli_query($this->connect,"SET NAMES 'utf8'");
mysqli_query($this->connect,"SET CHARACTER SET 'utf8'");
mysqli_query($this->connect,"SET @@global.time_zone='+00:00'");
}
function __destruct(){
mysqli_close($this->connect);
}
function query($sql){0
try{
$query = mysqli_query($this->connect,$sql);
return $query;
}catch(Exception $e) {
echo 'Caught exception:'.$e->getMessage()."\n";
exit();
}
}
function result($sql){
$assoc=array();
$query = $this->query($sql);
while($row=mysqli_fetch_assoc($query)){
$assoc[] = $row;
}
return $assoc;
}

function json($sql){
$assoc=array();
$query = $this->query($sql);
$result=mysqli_fetch_assoc($query);
return json_encode($result);
}

function row($sql){
$query = $this->query($sql);
$assoc = "";
while($result=mysqli_fetch_assoc($query)){
$assoc = $result;
}
return $assoc;
}

function numrow($sql){
$numrow = mysqli_num_rows($this->query($sql));
return $numrow;
}

function insertid(){
$id= mysqli_insert_id($this->connect);
return $id;
}

function sql($var,$table){
	$column = array();
	$value = array();
	foreach($var as $key=>$val){
		$column[] = "`".$key."`";
		if(is_array($val)){
			$val = serialize($val);
		}
		$value[] = "'".$val."'";
	}
	
	$sql = "replace into `".$table."` (".implode(",",$column).") values (".implode(",",$value).");";
	$sql = $sql. "insert into `".$table."_log` (".implode(",",$column).") values (".implode(",",$value).");";
	return $sql;
}

function previous_sql() {
    return $this->sql;
  }



}
