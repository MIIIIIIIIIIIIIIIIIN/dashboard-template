<?php
require_once("../conn.php");
require_once("../utilities.php");

if (!isset($_POST["account"])) {
    echo "請從正常管道進入";
    exit;
}


//新增各項待填入內容 method為POST時 要使用$_POST
// $MS_IDAry = $_POST["MS_ID"];
$accountAry = $_POST["account"];
$passwordAry = $_POST["password"];
$memberNameAry = $_POST["memberName"];
$emailAry = $_POST["email"];
$PhoneNumberAry = $_POST["PhoneNumber"];

$ADD_cityAry = isset($_POST["city"])?$_POST["city"]:[];
$ADD_detailAry = $_POST["ADD_detail"];
$designerOrNotAry = isset($_POST["designerOrNot"])?$_POST["designerOrNot"]:[];
// 總長度?
$length = count($accountAry);
$ADD_cityLength = count($ADD_cityAry);
// $designerOrNotLength = count($designerOrNotAry);




// 如果帳號未填寫 ----------------------------------
$isAccountEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($accountAry[$i] === "") {
        $isAccountEmpty = true;
    }
}

if ($isAccountEmpty === true) {
    err1_1("請填入帳號!", "./memberSys.php");
    exit;
}

// 如果密碼未填寫 ----------------------------------
$isPasswordEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($passwordAry[$i] === "") {
        $isPasswordEmpty = true;
    }
}

if ($isPasswordEmpty === true) {
    err1_1("請填入密碼!", "./memberSys.php");
    exit;
}

// 如果姓名未填寫 ----------------------------------
$isMemberNameEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($memberNameAry[$i] === "") {
        $isMemberNameEmpty = true;
    }
}

if ($isMemberNameEmpty === true) {
    err1_1("要有姓名哦!", "./memberSys.php");
    exit;
}

// 如果email未填寫 ----------------------------------
$isEmailEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($emailAry[$i] === "") {
        $isEmailEmpty = true;
    }
}

if ($isEmailEmpty === true) {
    err1_1("記得留email", "./memberSys.php");
    exit;
}

// 如果電話未填寫 ----------------------------------
$isPhoneNumberEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($PhoneNumberAry[$i] === "") {
        $isPhoneNumberEmpty = true;
    }
}

if ($isPhoneNumberEmpty === true) {
    err1_1("電話記得填", "./memberSys.php");
    exit;
}




$filesCount = count($_FILES["myFile"]["name"]);

$timestamp = time();
$imgAry = [];
for ($i = 0; $i < $filesCount; $i++) {
    if ($_FILES["myFile"]["error"][$i] === 0) {
        $ext = pathinfo($_FILES["myFile"]["name"][$i], PATHINFO_EXTENSION);
        $from = $_FILES["myFile"]["tmp_name"][$i];
        $to = "./php_image/" . ($timestamp + $i) . "." . $ext;
        $newFile = ($timestamp + $i) . "." . $ext;
        if (move_uploaded_file($from, $to)) {
            array_push($imgAry, $newFile);
        } else {
            array_push($imgAry, NULL);
        }
    } else {
        array_push($imgAry, NULL);
    }
}
// $MS_ID = $MS_IDAry[$i];
// $img = $imgAry[$i];


$sql = "";
for ($i = 0; $i < $length; $i++) {
    $account = $accountAry[$i];
    $password = $passwordAry[$i];
    $img = $imgAry[$i];
    $memberName = $memberNameAry[$i];
    $email = $emailAry[$i];
    $PhoneNumber = $PhoneNumberAry[$i];
    $ADD_city = intval(isset($ADD_cityAry[$i])?$ADD_cityAry[$i]:23); 
    // $ADD_city = intval($ADD_cityAry[$i]);  原先的錯誤


    $ADD_detail = $ADD_detailAry[$i];
    $designerOrNot = intval(isset($designerOrNotAry[$i])?$designerOrNotAry[$i]:0);


    $sql .= "INSERT INTO `membershipsystem` 
    (`account`, `password`, `img`, `memberName`, `email`, `PhoneNumber`, `ADD_city`, `ADD_detail`, `designerOrNot`) VALUES 
    ('$account', '$password', '$img', '$memberName', '$email', '$PhoneNumber', $ADD_city, '$ADD_detail', $designerOrNot);";
}

try {
    $conn->multi_query($sql);
    echo "建立資料成功";
    echo '<script>
        setTimeout(function() {
        window.location.href = "./memberSys.php";
        }, 3000);
        </script>';
} catch (mysqli_sql_exception $e) {
    echo "建立資料錯誤" . $e->getMessage();
    exit;
}

$conn->close();
