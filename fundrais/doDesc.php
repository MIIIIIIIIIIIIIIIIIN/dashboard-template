
   <?php
   // your-php-endpoint.php
   
   if ($_SERVER["REQUEST_METHOD"] === "POST") {
       // 获取原始 POST 数据
       $json = file_get_contents('php://input');
       $data = json_decode($json, true);
   
       // 从 JSON 数据中获取 name 的值
       $name = $data['name'] ?? '';
   
       if ($name === 'amount') {
           echo "Found amount!";
       } else {
           echo "Value not found!";
       }
   } else {
       echo "Invalid request method.";
   }
   ?>