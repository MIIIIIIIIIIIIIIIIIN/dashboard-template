<?php
require_once("../conn.php");
require_once("../utilities.php");
if (!isset($_POST["id"])) {
    echo "廢物";
    exit;
}
function replaceA($input){
    $input = str_replace("<script>","",$input);
    $input = str_replace("</script>","",$input);

    return $input;
}


$id = (int)$_POST["id"];
$img = $_POST["img"];
$name = htmlspecialchars($_POST["name"]);
$directions = replaceA($_POST["directions"]);
$type = isset($_POST["type"])?(int)$_POST["type"]:NULL;
if($name === ""){
    err1("不乖");
    exit;
}
if($directions=== ""){
    err2("不乖");
    exit;
}
if($type===NULL){
    err2("不乖");
    exit;
}
// echo $category;
// echo  "name:" . $name;
// echo  "content:" . $content;
if($_FILES["myFile"]["error"] === 0){
    $time = time();
    // $count++;
    $ext = pathinfo($_FILES["myFile"]["name"],PATHINFO_EXTENSION);
    $from = $_FILES["myFile"]["tmp_name"];
    echo $time.".".$ext;
    $to = "./img/".$time.".".$ext;
    if(move_uploaded_file($from,$to)){
        $file = "./img/".$img;
        if($img!="" || $img != NULL){
            if(file_exists($file)){
                unlink($file);
            }
        }
       
        
        $img = $time.".".$ext;
        // $file = "./upload/".$_FILES["myFile"]["name"];
        // echo "<img src=\"$to\" style=\"width:500px;\">";
    }else{
        echo "上船失敗";
}
}

$sql = "UPDATE `project` SET 
`name` = '{$name}', 
`directions` = '{$directions}',
`type_id` = {$type}, 
`img` = '$img',
`time` = CURRENT_TIMESTAMP
WHERE `project`.`id` = {$id};";

try {
    $conn -> query($sql);
    echo '成功';
    echo "<script>
    
    window.location.href='project.php';
    
    </script>";
    // multi_query($sql)多行語句
} catch (mysqli_sql_exception $e) {
    echo "資料新增錯誤" . $e->getMessage();
    exit;
}
$conn->close();
