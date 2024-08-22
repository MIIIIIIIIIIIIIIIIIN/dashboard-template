<?php
require_once("../conn.php");
require_once("../utilities.php");

if(!isset($_POST["productsname"])){
    echo "請從正常管道進入";
    exit;
}

$productsNamesAry = $_POST["productsname"];
$productsPriceAry = $_POST["productsprice"];
$productsCreatedAtAry = $_POST["productsdate"];
$productsDescriptionAry = $_POST["productsdescription"];
$productsOriginAry = $_POST["productsorigin"];
$productsAddressAry = $_POST["productsaddress"];
$productsColorAry = $_POST["productscolor"];
$productsSizeAry = $_POST["productssize"];
$productsQuantityAry = $_POST["productsquantity"];
$productsNumberAry = $_POST["productsnumber"];
$categoryAry = isset($_POST["productscategoryid"])?$_POST["productscategoryid"]:[];
$length = count($productsNamesAry);
$categoryLength = count($categoryAry);

// 名稱未填提醒
$isNameEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsNamesAry[$i] === ""){
        $isNameEmpty = true;
    }
}
if($isNameEmpty === true){
    alertAndBack("請輸入產品名稱");
    exit;
}
// 價格未填提醒
$isPriceEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsPriceAry[$i] === ""){
        $isPriceEmpty = true;
    }
}
if($isPriceEmpty === true){
    alertAndBack("請輸入價格");
    exit;
}
// 顏色未填提醒
$isColorEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsColorAry[$i] === ""){
        $isColorEmpty = true;
    }
}
if($isColorEmpty === true){
    alertAndBack("請填入顏色");
    exit;
}
// 尺寸未填提醒
$isSizeEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsSizeAry[$i] === ""){
        $isSizeEmpty = true;
    }
}
if($isSizeEmpty === true){
    alertAndBack("請填入尺寸");
    exit;
}
// 數量未填提醒
$isQuantityEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsQuantityAry[$i] === ""){
        $isQuantityEmpty = true;
    }
}
if($isQuantityEmpty === true){
    alertAndBack("請填入數量");
    exit;
}
// 訂單編號未填提醒
$isNumberEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsNumberAry[$i] === ""){
        $isNumberEmpty = true;
    }
}
if($isNumberEmpty === true){
    alertAndBack("請填入訂單編號");
    exit;
}
// 產品描述未填提醒
$isContentEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsDescriptionAry[$i] === ""){
        $isContentEmpty = true;
    }
}
if($isContentEmpty === true){
    alertAndBack("產品描述尚未填寫");
    exit;
}
// 產地未填提醒
$isOriginEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsOriginAry[$i] === ""){
        $isOriginEmpty = true;
    }
}
if($isOriginEmpty === true){
    alertAndBack("請填入產地");
    exit;
}
// 地址未填提醒
$isAddressEmpty = false;
for($i = 0; $i < $length; $i++){
    if($productsAddressAry[$i] === ""){
        $isAddressEmpty = true;
    }
}
if($isAddressEmpty === true){
    alertAndBack("請填入地址");
    exit;
}


// 分類未填提醒
if($categoryLength != $length){
    alertAndBack("請選擇分類");
    exit;
}

$filesCount = count($_FILES["myFile"]["name"]);
$timestamp = time();
$productsImgAry = [];

if ($filesCount == 0 || $_FILES["myFile"]["name"][0] == "") {
    alertAndBack("請選擇至少一張圖片上傳");
    exit;
}

for($i=0;$i<$filesCount;$i++){
    if($_FILES["myFile"]["error"][$i] === 0){
        $ext = pathinfo($_FILES["myFile"]["name"][$i], PATHINFO_EXTENSION);
        $from = $_FILES["myFile"]["tmp_name"][$i];
        $to = "./upload_products_img/" . ($timestamp + $i).".".$ext; #不能只寫upload, 要給它完整檔名.
        $newFile = ($timestamp + $i).".".$ext;
        #if成功else失敗
        #move_uploaded_file($from, $to):bool 回傳布林值
        if(move_uploaded_file($from, $to)){ 
            array_push($productsImgAry, $newFile);
        }else{
            array_push($productsImgAry, NULL);
        }
    }else{
        array_push($productsImgAry, NULL);
    }
}


$sql = "";
$sqlimg = "";
for($i = 0;$i < $length;$i++){
    $productsName = $productsNamesAry[$i];
    $productsPrice = $productsPriceAry[$i];
    $productsCreatedAt = $productsCreatedAtAry[$i];
    $productsDescription = $productsDescriptionAry[$i];
    $productsCategoryId = intval($categoryAry[$i]);
    // $productsMemberId = intval($productsMemberIdAry[$i]);
    $productsAddress = $productsAddressAry[$i];
    $productsOrigin = $productsOriginAry[$i];
    $productsSize = $productsSizeAry[$i];
    $productsColor = $productsColorAry[$i]; 
    $productsQuantity = $productsQuantityAry[$i]; 
    $productsNumber = $productsNumberAry[$i]; 
    
//  原本的插 00
$sql = "INSERT INTO `products` 
(`id`, `productsName`, `productsPrice`, `productsCreateAt`, `productsDescription`, `productsCategoryId`, `productsAddress`, `productsOrigin`, `productsSize`, `productsColor`, `productsQuantity`, `productsNumber`) VALUES 
(NULL, '$productsName', '$productsPrice', CURRENT_TIMESTAMP, '$productsDescription', $productsCategoryId, '$productsAddress', '$productsOrigin', '$productsSize', '$productsColor', $productsQuantity, $productsNumber);";

try{
    $conn->multi_query($sql);
}catch(mysqli_sql_exception $e){
    echo "建立資料錯誤" . $e->getMessage();
    exit;
}

$productsid = $conn->insert_id;
$file01 = $productsImgAry[$i];
$sqlimg = "INSERT INTO `productsimg` (`file01`, `productsid`) VALUES
('$file01', $productsid);";

try{
    $conn->multi_query($sqlimg);
    echo "建立資料成功!請稍後...";
    echo '<script>
        setTimeout(function() {
        window.location.href = "./index.php";
        }, 1000);
        </script>';
}catch(mysqli_sql_exception $e){
    echo "建立資料錯誤" . $e->getMessage();
    exit;
}
}


$conn->close();


// try{
//     $conn->multi_query($sql);
//     $conn->multi_query($sqlimg);
//     echo "建立資料成功!請稍後...";
//     echo '<script>
//         setTimeout(function() {
//         window.location.href = "./index.php";
//         }, 1500);
//         </script>';
// }catch(mysqli_sql_exception $e){
//     echo "建立資料錯誤" . $e->getMessage();
//     exit;
// }