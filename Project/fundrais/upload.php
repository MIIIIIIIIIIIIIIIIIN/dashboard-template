<!DOCTYPE html>
<html lang="zh-hant-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
            <form action="./doUpload03.php" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <span for="" class="input-group-text">名稱</span>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="input-group mb-3">
                <input class="form-control" type="file" name="myFile[]" accept="image/*" multiple>
                <!-- accept="image/*" 意思是所有圖片檔都可接受 -->
            </div>
            <div>
                <button class="btn btn-dark">送出</button>
            </div>
        </form>
    </div>
</body>

</html>