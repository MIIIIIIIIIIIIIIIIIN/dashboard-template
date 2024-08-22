<?php

function alertAndGoTo($msg, $url){
    echo "<script>
    alert(\"$msg\");
    window.location.href= \"$url\";
    </script>";
    exit;
}

function alertAndBack($msg){
    echo "<script>
    alert(\"$msg\");
    window.history.back()
    </script>";
    exit;
}
function alertAndClickBack($msg){
    echo"
    <style>
        button{
            padding: 8px;
            padding-left: 16px;
            padding-right: 16px;
            background-color: #1c8ced;
            color: #fff;
            border-radius: 4px;
            border: none;
        }
    </style>
    <button onclick=\"goBack()\">回上頁</button>
    <script>
    alert(\"$msg\");
        function goBack(){
            window.history.back()
        }
    </script>
    ";
    exit;
}
// 雙引號才有辦法引用變數, 雙引號內的雙引號要用跳脫字元表示.
function replaceScript($input){
    $input = str_replace("<script>", "[script]", $input);
    $input = str_replace("</script>", "[/script]", $input);
    return $input;
}

?>

