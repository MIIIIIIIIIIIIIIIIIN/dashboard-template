<?php
require_once("../conn.php");
require_once("../utilities.php");

if (!isset($_GET["post_id"])) {
    echo "網址參數不存在";
    exit;
}
$id = (int)$_GET["post_id"];

// $sql = "UPDATE `post` SET `isValid` = '0' WHERE `post`.`post_id` = $id;";

$sql = "UPDATE post SET `isValid` = 0 WHERE post_id = $id;";

try {
    $conn->multi_query($sql);
} catch (mysqli_sql_exception $e) {
    echo "修改資料錯誤" . $e->getMessage();
    exit;
}
err1_1("刪除資料成功", "./index.php");

$conn->close();
