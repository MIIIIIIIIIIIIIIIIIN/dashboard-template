<?php
require_once("../conn.php");
require_once("../utilities.php");



if (!isset($_POST["id"])) {
    echo "請從正常管道進入";
    exit;
}
echo "<pre>";
var_dump($_FILES["myFile"]);
echo "</pre>";
$fileCount = count($_FILES["myFile"]["name"]);
echo $fileCount;

$id = (int)$_POST["post_id"];
$sql = "";
$timestamp = time(); //檔名上加時間戳記
for ($i = 0; $i < $fileCount; $i++) {
    // ["error"] === 0 確認沒有錯誤再上傳
    if ($_FILES["myFile"]["error"][$i] === 0) {
        $ext = pathinfo($_FILES["myFile"]["name"][$i], PATHINFO_EXTENSION); //加上副檔名
        $from = $_FILES["myFile"]["tmp_name"][$i]; //上傳的檔案
        $to = "../upload/" . ($timestamp + $i) . "." . $ext;
        //新檔名，($timestamp + $i) 避免處理時間太快導致時間戳記相同
        $file = ($timestamp + $i) . "." . $ext;
        if (move_uploaded_file($from, $to)) {
            echo "<img src=\"$to\">";
            $sql .= "INSERT INTO `post` 
    (`post_id`, `title`, `img`, `body`, `membership_id`, `post_genre_id`, `edited_at`) VALUES 
    ($id, '$title', '$img', '$body', '$membership_id', $genre, CURRENT_TIMESTAMP);";
        }
    }
}


try {
    $conn->multi_query($sql);
    $msg = "圖片上傳成功";
    $url = "./update.php?id=$msgID";
    alertAndGoTo($msg, $url);
} catch (mysqli_sql_exception $e) {
    echo "圖片上傳失敗" . $e->getMessage();
    exit;
}

$conn->close();
