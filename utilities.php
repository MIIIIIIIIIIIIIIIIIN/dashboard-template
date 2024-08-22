<?php
function err1_1($msg,$url)
{
    echo "
    <script>
    alert('{$msg}');
    window.location.href=\"{$url}\";
    </script>";
}

function echoGoBack(){
    echo "
    <script>
    window.history.back();
    </script>";
}
function err1($msg)
{
    echo "
    <script>
    alert('{$msg}');
    window.history.back();
    </script>";
}

function err2($msg)
{
    echo "
     <style>
        button{
            padding:10px;
            background-color:#333;
            color:#fff;
            border-radius:10px;
            border:none;
            cursor:pointer;
        }
    </style>
    <button onclick=back()>back</button>
    <script>
    alert('{$msg}');
    function back(){
        window.history.back();
    }
    </script>";
}


