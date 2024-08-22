<?php
require_once("../conn.php");
require_once("../utilities.php");

if (!isset($_POST["id"])) {
    echo "請從正常管道進入";
    exit;
}

// 宣告變數抓取資料
$id = (int)$_POST["id"];
// $name = $_POST["name"];
// $content = $_POST["content"];
$file01 = $_POST["file01"];
$productsName = replaceScript($_POST["productsname"]);
$productsPrice = replaceScript($_POST["productsprice"]);
$productsCreatedAt = replaceScript($_POST["productsdate"]);
$productsDescription = replaceScript($_POST["productsdescription"]);
$productsOrigin = replaceScript($_POST["productsorigin"]);
$productsAddress = replaceScript($_POST["productsaddress"]);
$productsColor = replaceScript($_POST["productscolor"]);
$productsSize = replaceScript($_POST["productssize"]);
$productsQuantity = replaceScript($_POST["productsquantity"]);
$productsNumber = replaceScript($_POST["productsnumber"]);
// $productsCategoryId = isset($_POST["category_name"]);
$productsCategoryId = isset($_POST["productscategoryid"]) ? (int)$_POST["productscategoryid"] : NULL;


// 警示區
// if ($productsname === "") {
//     alertAndBack("去把名字填上");
//     exit;
// }
// if ($content === "") {
//     alertAndClickBack("把內容寫一寫吧");
//     exit;
// }
// if ($category === NULL) {
//     alertAndClickBack("分類沒選哦");
//     exit;
// }


if ($_FILES["myFile"]["error"] === 0) {
    $timestamp = time();
    $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    $from = $_FILES["myFile"]["tmp_name"];
    $to = "./upload_products_img/" . $timestamp . "." . $ext; #不能只寫upload, 要給它完整檔名.
    if (move_uploaded_file($from, $to)) {
        // 刪除檔案
        $file = "./upload_products_img/" . $file01;
        // 刪除檔案很麻煩 要考慮到各種情況 否則跑不動
        if ($file01 !== "" && $file01 !== NULL) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        // 修正 $file01 變成 $newImg
        $file01 = $timestamp . "." . $ext;
    } else {
        echo "上傳失敗";
    }
}


$sql = "UPDATE `products` 
JOIN `productsimg` ON `productsid` = `products`.`id` 
SET 
`productsName` = '$productsName',
`productsPrice` = '$productsPrice',
`productsCreateAt` = '$productsCreatedAt',
`products`.`modifyTime` = CURRENT_TIMESTAMP, 
`productsDescription` = '$productsDescription',
`productsCategoryId` = $productsCategoryId,
`productsOrigin` = '$productsOrigin',
`productsAddress` = '$productsAddress',
`productsSize` = '$productsSize', 
`productsColor` = '$productsColor', 
`productsQuantity` = $productsQuantity, 
`productsNumber` = '$productsNumber',
`file01` = '$file01'
WHERE `products`.`id` = $id;";


try {
    $conn->query($sql);
    echo "修改資料成功";
    echo '<script>
    setTimeout(function() {
    window.location.href = "./index.php";
    }, 500);
    </script>';
} catch (mysqli_sql_exception $e) {
    echo "修改資料失敗" . $e->getMessage();
    exit; //這邊完成之後要出去, 或是用die的語法代替echo就可以省略exit.
}

$conn->close();
