<?php
require_once("../conn.php");
require_once("../utilities.php");
if (!isset($_POST["MS_ID"])) {
    echo "廢物";
    exit;
}

function replaceA($input)
{
    $input = str_replace("<script>", "", $input);
    $input = str_replace("</script>", "", $input);

    return $input;
}

$MS_ID = (int)$_POST["MS_ID"];
$account = $_POST["account"];
$password = $_POST["password"];
$img = $_POST["img"];

$memberName = $_POST["memberName"];
$email = $_POST["email"];
$PhoneNumber = $_POST["PhoneNumber"];
//下拉式選單
$ADD_city = isset($_POST["ADD_city"]) ? $_POST["ADD_city"] : 0;
$ADD_detail = $_POST["ADD_detail"];
var_dump($ADD_detail);

// $designerOrNot = $_POST["designerOrNot"];
$designerOrNot = isset($_POST["designerOrNot"]) ? (int)$_POST["designerOrNot"] : 0;


$img = $_POST["img"];

if ($MS_ID === "") {
    err1("不乖");
    exit;
}
// if($directions=== ""){
//     err2("不乖");
//     exit;
// }
// if($type===NULL){
//     err2("不乖");
//     exit;
// }
// echo $category;
// echo  "name:" . $name;
// echo  "content:" . $content;
if ($_FILES["myFile"]["error"] === 0) {
    $time = time();
    // $count++;
    $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    $from = $_FILES["myFile"]["tmp_name"];
    echo $time . "." . $ext;
    $to = "./php_image/" . $time . "." . $ext;
    if (move_uploaded_file($from, $to)) {
        $file = "./php_image/" . $img;
        if ($img != "" || $img != NULL) {
            if (file_exists($file)) {
                unlink($file);
            }
        }


        $img = $time . "." . $ext;
        // $file = "./upload/".$_FILES["myFile"]["name"];
        // echo "<img src=\"$to\" style=\"width:500px;\">";
    } else {
        echo "上船失敗";
    }
}
// `MS_ID` = '{$MS_ID}', 
// `account` = '{$account}', 
// `password` = '{$password}', 
// `img` = '{$img}',
// `memberName` = '{$memberName}',
// `email` = {$email}, 
// `PhoneNumber` = {$PhoneNumber}, 
// `ADD_city` = {$ADD_city}, 
// `ADD_detail` = {$ADD_detail}, 
// `designerOrNot` = '$designerOrNot'

$sql = "UPDATE `membershipsystem` SET 
    `MS_ID` = '{$MS_ID}', 
    `account` = '{$account}', 
    `img` = '{$img}',
    `password` = '{$password}',
    `memberName` = '{$memberName}',
    `email` = '{$email}',
    `PhoneNumber` = '{$PhoneNumber}', 
    `ADD_city` = {$ADD_city},
    `ADD_detail` = '{$ADD_detail}', 
    `designerOrNot` = $designerOrNot
WHERE `MS_ID` = {$MS_ID};";

try {
    $conn->query($sql);
    echo '成功';
    echo "<script>
    
    window.location.href='memberSys.php';
    
    </script>";
    // multi_query($sql)多行語句
} catch (mysqli_sql_exception $e) {
    echo "資料新增錯誤" . $e->getMessage();
    exit;
}
$conn->close();
