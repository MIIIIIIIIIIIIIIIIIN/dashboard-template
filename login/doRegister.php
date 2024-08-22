<?php
require_once("../conn.php");
require_once("../utilities.php");

if(!isset($_POST["account"]) || !isset($_POST["password"])){
  echo "請循正常管道進入本頁";
  exit;
}

$account = $_POST["account"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
// $name = $_POST["name"];

echo $account;
echo $password;

$sql = "INSERT INTO `membershipsystem` 
  (`MS_ID`, `account`, `password`, `memberName`) VALUES 
  (NULL, '$account', '$password', 'mike');";

try {
  $conn->query($sql);
  echo "
  <script>
  window.location.href=\"./login.php\";
  </script>";
} catch (mysqli_sql_exception $exception) {
  echo "資料新增錯誤：{$exception->getMessage()}";
  // echoGoBack();
  exit;
}
// alertAndGoToList("新增成功");
$conn->close();

