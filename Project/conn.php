<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fundrais";
$port = 3306;
try {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // echo "連線成功";
} catch (mysqli_sql_exception $exception) {
    echo $exception->getMessage();
}
?>
