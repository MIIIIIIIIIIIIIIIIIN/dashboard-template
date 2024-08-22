<?php
// 创建密码的哈希值
$hashed_password = password_hash("your_password", PASSWORD_DEFAULT);

// 用户输入的密码
$user_input_password = "your_password";

// 验证用户输入的密码是否正确
if (password_verify($user_input_password, $hashed_password)) {
    echo "Password is correct!";
} else {
    echo "Password is incorrect.";
}
?>