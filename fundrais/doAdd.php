<?php
require_once("../conn.php");
require_once("../utilities.php");
// $conn = mysqli_connect($servername, $username, $password);
// if(!$conn){
//   die("連線失敗：" .mysqli_connect_error());
// }else{
//   echo "連線成功";

// echo "連線成功";
if (!isset($_POST["name"])) {
  echo "廢物";
  exit;
}

$filesCount = count($_FILES["myFile"]["name"]);
// echo $filesCount;
// exit;
// $count =0;
$time = time();
$imgArr = [];
for($i=0;$i<$filesCount;$i++){

    if($_FILES["myFile"]["error"][$i] === 0){
        // $count++;
        $ext = pathinfo($_FILES["myFile"]["name"][$i],PATHINFO_EXTENSION);
        $from = $_FILES["myFile"]["tmp_name"][$i];
        // echo $time.".".$ext;
        $to = "./img/".($time+$i).".".$ext;
        $newFile = ($time+$i).".".$ext;
        if(move_uploaded_file($from,$to)){
            // $file = "./upload/".$_FILES["myFile"]["name"];
            array_push($imgArr,$newFile);
        }else{
            echo "上船失敗"; 
        }
    }else{
      array_push($imgArr,NULL);
    }
}
// echo '<pre>';
//     var_dump($imgArr) ;
// echo '</pre>';

$arrName = $_POST["name"];
$arrDirections = $_POST["directions"];
$arrAmount = $_POST["amount"];
// $arrType = $_POST["type"];
$arrType = isset($_POST["type"]) ? $_POST["type"] : [];
$length = count($arrName);
$isempty = false;
// echo '<pre>';
// var_dump($arrcategory);
// echo '</pre>';
if (count($arrType) != count($arrName)) {
}
for ($i = 0; $i < $length; $i++) {
  if ($arrName[$i] == "") {
    $isempty = true;
  } elseif ($arrDirections[$i] == "") {
    $isempty = true;
  }
  // elseif($arrcategory==="xxx"){
  //   $isempty = true ;
  // }
}

if ($isempty) {
  err1("少填什麼");
  exit;
}
if (count($arrType) != count($arrName)) {
  err1("少填什麼");
  exit;
}

// if($content=== ""){
//     err2("不乖");
//     exit;
// }
$sql = '';
for ($i = 0; $i < $length; $i++) {
  // echo $arrName[$i];
  // echo $arrContent[$i];
  // echo $arrContent[$i];

  $name = $arrName[$i];
  $directions = $arrDirections[$i];
  $amount = $arrAmount[$i];
  $type = $arrType[$i];
  $img =$imgArr[$i];
  $sql .= "INSERT INTO `project` (`id`, `type_id`,`name`, `amount`, `directions`, `img`) VALUES (NULL, '{$type}', '{$name}' , '{$amount}','{$directions}' , '{$img}');";
}
// $sql = "INSERT INTO `msgs` (`id`, `name`, `content`, `createTime`) VALUES (NULL, '{$name}', '{$content}', CURRENT_TIMESTAMP);";
try {
  $conn->multi_query($sql);
  echo '更新成功';

  echo 
    "<script>
      window.location.href='project.php';
      alert('新增成功');
    </script>";
} catch (mysqli_sql_exception $e) {
  echo "資料新增錯誤" . $e->getMessage();
  exit;
}

// echo $name;
// echo "<br/>";
// echo $content;
$conn->close();
  // header("location: ./project.php");
