<?
require_once("../conn.php");
require_once("../utilities.php");

if(!isset($_POST["id"])){
    echo "請由正常方法進入頁面";
    exit; #記得要退出
}
echo "<pre>";
var_dump($_FILES["myFile"]);
echo "</pre>";

$filesCount = count($_FILES["myFile"]["name"]);
echo $filesCount;

$productsid = (int)$_POST["id"];
$sql = "";
$timestamp = time();
for($i=0;$i<$filesCount;$i++){
    if($_FILES["myFile"]["error"][$i] === 0){
        $ext = pathinfo($_FILES["myFile"]["name"][$i], PATHINFO_EXTENSION);
        $from = $_FILES["myFile"]["tmp_name"][$i];
        $to = "./upload_products_img/" . ($timestamp + $i).".".$ext;
        $file = ($timestamp + $i).".".$ext;
        if(move_uploaded_file($from, $to)){ 
            $sql .= "INSERT INTO `productsimg` 
            (`id`, `file`, `productsid`, `isValid`) VALUES 
            (NULL, '$file', $productsid, '1');";
        }
    }
}

// echo $sql;
// exit;
try{
    $conn->multi_query($sql);
    $msg = "建立資料成功";
    $url = "./update.php?id=$productsid";
    alertAndGoTo($msg, $url);
}catch(mysqli_sql_exception $e){
    echo "建立資料錯誤" . $e->getMessage();
    exit;
}

$conn->close();