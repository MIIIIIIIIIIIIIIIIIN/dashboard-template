<?php
require_once("../conn.php");
require_once("../utilities.php");

function replaceScript($input)
{
    $input = str_replace("<script>", "", $input);
    //找到<script>以空字串取代，並放回同名變數。僅會消除內容中的 <script>
    $input = str_replace("</script>", "", $input);
    return $input;
}



$id = (int)$_POST["post_id"]; //前方加上 (int) 將字串轉為數字
$img = $_POST["img"];
$membership_id = (int)$_POST["membership_id"];
$title = htmlspecialchars($_POST["title"]);
// 使用 htmlspecialchars 將標籤字串化
$body = replaceScript($_POST["body"]);
$genre = isset($_POST["genre"]) ? $_POST["genre"] : NULL;

//若名稱或內容為空字串，則跳出警告
if ($title === "") {
    err1_1("標題沒填啦", "./index.php");
    exit; //取用(require) utilities.php 的共用功能
}

if ($body === "") {
    err1_1("內容沒填啦", "./index.php");
    exit;
}

if ($genre === NULL) {
    err1_1("分類沒填啦", "./index.php");
    exit;
}

if ($_FILES["myFile"]["error"] === 0) {
    $timestamp = time(); //檔名上加時間戳記
    $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION); //加上副檔名
    $from = $_FILES["myFile"]["tmp_name"]; //上傳的檔案
    $to = "./upload/" . $timestamp . "." . $ext; //修改檔名
    if (move_uploaded_file($from, $to)) {
        $file = "./upload/" . $img;
        if ($img !== "" && $img !== NULL) {
            if (file_exists($file)) {
                unlink($file);
            }
        } //若有找到現存圖片才會刪除檔案
        $img = $timestamp . "." . $ext; //修改 $img 變成 新檔案
    } else {
        echo "上傳失敗";
    }
}



$sql = "UPDATE `post` SET 
    `title` = '$title', 
    `img` = '$img', 
    `body` = '$body', 
    `membership_id` = $membership_id, 
    `post_genre_id` = $genre, 
    `edited_at` = CURRENT_TIMESTAMP 
    WHERE `post`.`post_id` = $id;";

try {
    $conn->multi_query($sql);
    echo "修改資料成功";
    echo '<script>
setTimeout(function() {
    window.location.href = "index.php";
}, 2000);
</script>';
} catch (mysqli_sql_exception $e) {
    echo "修改資料錯誤" . $e->getMessage();
    exit;
}


$conn->close();
