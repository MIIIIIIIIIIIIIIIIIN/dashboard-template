<?php
session_start();

require_once("../conn.php");
require_once("../utilities.php");

if (!isset($_POST["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}

$account = $_POST["account"];
// echo $account;
$password = $_POST["password"];




// if (empty($account)) {
//     err1("請輸入使用者帳號");
//     exit;
// }
// if (empty($password)) {
//     err1("請輸入密碼");
//     exit;
// }

function loginFailed(){
    if (!isset($_SESSION["error"]["times"])) {
        $_SESSION["error"]["times"] = 1;
    } else {
        $_SESSION["error"]["times"]++;
    }
    $_SESSION["error"]["timestamp"] = time();
    $_SESSION["error"]["message"] = "登入失敗，請確認帳號碼";
    unset($_SESSION["user"]);
    err1("登入失敗，請確認帳號碼！");
}


$sqlAccount = "SELECT * FROM `employees` WHERE `email` = '$account'";

try {
    $result = $conn->query($sqlAccount);
    $rows = $result->fetch_assoc();
    if($result->num_rows==0){
        loginFailed();
    }
    $userCount = count($rows);
   
} catch (Exception $e) {
    echo $e->getMessage();
}



if ($userCount > 0) {
    
    
    if($password ==$rows["password"]) {

        $userID = $rows["MS_ID"];
       
        } else {
            loginFailed();
            exit;
        }

} else {
    loginFailed();
    exit;
}





$_SESSION["user"] = [
    "id" => $rows["EmployeeID"],
    "account" => $rows["email"],
    "password" => $rows["password"],
    "name" => $rows["employeeName"],
    "img" => $rows["img"]
    
];

unset($_SESSION["error"]);
$msg = "登入成功";
$URL = "../home/index.php";
err1_1($msg, $URL);
