<?php
require_once("../conn.php");
require_once("../utilities.php");

// if (!isset($_POST["name"])) {
//     echo "請從正常管道進入";
//     exit;
// }


$membershipAry = $_POST["membership_id"];
$titleAry = $_POST["title"];
$bodyAry = $_POST["body"];
$genreAry = isset($_POST["genre"]) ? $_POST["genre"] : []; //判斷分類是否填寫
$length = count($titleAry);
$genreLength = count($genreAry);

//名字未填警語
$isNameEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($membershipAry[$i] === "") {
        $isNameEmpty = true;
    }
}

if ($isNameEmpty === true) {
    err1_1("名字沒填啦", "./index.php");
    exit;
}
//標題未填警語
$isTitleEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($titleAry[$i] === "") {
        $isTitleEmpty = true;
    }
}

if ($isTitleEmpty === true) {
    err1_1("標題沒填啦", "./index.php");
    exit;
}

//內容未填警語
$isBodyEmpty = false;
for ($i = 0; $i < $length; $i++) {
    if ($bodyAry[$i] === "") {
        $isBodyEmpty = true;
    }
}

if ($isBodyEmpty === true) {
    err1_1("內容沒填啦", "./index.php");
    exit;
}
//分類未填警語，判斷分類數量與名字數量是否相同
if ($genreLength != $length) {
    err1_1("分類沒填啦", "./index.php");
    exit;
}

$filesCount = count($_FILES["myFile"]["name"]);
$imgAry = [];
$timestamp = time();
for ($i = 0; $i < $filesCount; $i++) {
    if ($_FILES["myFile"]["error"][$i] === 0) {

        $ext = pathinfo($_FILES["myFile"]["name"][$i], PATHINFO_EXTENSION);
        $from = $_FILES["myFile"]["tmp_name"][$i];
        $to = "./upload/" . ($timestamp + $i) . "." . $ext;
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




$sql = "";
for ($i = 0; $i < $length; $i++) {
    $title = $titleAry[$i];
    $img = $imgAry[$i];
    $body = $bodyAry[$i];
    $membership_id = $membershipAry[$i];
    $genre = intval($genreAry[$i]);
    $sql .= "INSERT INTO `post` 
    (`post_id`, `title`, `img`, `body`, `membership_id`, `post_genre_id`, `created_at`) VALUES 
    (NULL, '$title', '$img', '$body', '$membership_id', $genre, CURRENT_TIMESTAMP);";
}

try {
    $conn->multi_query($sql);
    echo "建立資料成功";
    echo '<script>
setTimeout(function() {
    window.location.href = "index.php";
}, 2000);
</script>'; //導入 Javasciprt 達成延遲跳轉，並顯示 echo 內容
} catch (mysqli_sql_exception $e) {
    echo "建立資料錯誤" . $e->getMessage();
    exit;
}


$conn->close();//關閉連線


// sleep(3); 使整個網頁停頓 3 秒再跳轉
// header("location: index.php");
