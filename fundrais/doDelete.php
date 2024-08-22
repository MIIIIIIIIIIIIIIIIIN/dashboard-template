<?php
require_once("../conn.php");
require_once("../utilities.php");
if(!isset($_GET["id"])){
    echo "null";
}
$id = (int)$_GET["id"];
$sql = "UPDATE  `project` SET `endtime` = CURRENT_TIMESTAMP  WHERE `project`.`id` = {$id}";
try{
    $conn->query($sql);
}catch(mysqli_sql_exception $e){
    echo $e->getMessage();
    exit;
}
err1_1('成功',"project.php");


$conn->close();