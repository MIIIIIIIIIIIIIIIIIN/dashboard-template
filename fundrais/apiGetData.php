<?php
require_once("../conn.php");
if (!isset($_GET["id"])) {
  echo "網址參數不存在";
  exit;
}
$id = $_GET["id"];
$sql = "SELECT * FROM `project` WHERE `id` = $id";
$sql2 = "SELECT * FROM `type`";
try {
  $result = $conn->query($sql);
  $result2 = $conn->query($sql2);
} catch (mysqli_sql_exception $exception) {
  echo "資料讀取錯誤：" . $exception->getMessage();
  exit;
}
$count = $result->num_rows;
$row = $result->fetch_assoc();
$typeRows = $result2->fetch_all(MYSQLI_ASSOC);
$data = [
  "project" => $row,
  "category" => $typeRows
];
echo json_encode($data);
$conn->close();
?>