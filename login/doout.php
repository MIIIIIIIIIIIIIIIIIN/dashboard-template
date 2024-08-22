<?php
    session_start();
    
    session_destroy();
    
    echo "<script>
    alert('登出成功');
    window.location.href = '../fundrais/project.php';
    </script>";
?>