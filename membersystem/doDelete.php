<?php
require_once("../conn.php");
require_once("../utilities.php");
if(!isset($_GET["id"])){
    echo "null";
}
$id = (int)$_GET["id"];
$sql = "UPDATE `membershipsystem` SET `isValid` = 0 WHERE MS_ID = $id;";

try{
    $conn->query($sql);
}catch(mysqli_sql_exception $e){
    echo $e->getMessage();
    exit;
}
err1_1('成功',"memberSys.php");


$conn->close();