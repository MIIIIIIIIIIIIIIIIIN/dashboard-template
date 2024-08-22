<?php
require_once("../conn.php");
if(!isset($_GET["id"])){
    echo "資料參數不存在";
    exit;
}

$id = $_GET["id"];
// $sql = "SELECT * FROM `products` WHERE `id` = $id+1";
$sql = "SELECT * FROM `products` 
        JOIN `category` ON `productsCategoryId` = `category`.`id` 
        JOIN `productsimg` ON `productsid` = `products`.`id`
        WHERE `products`.`id` = $id;";
$sql2 = "SELECT * FROM `category`";
// $sqlImgs = "SELECT * FROM `products` WHERE `productsImgId` = $id;";
try {
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    // $resultImgs = $conn->query($sqlImgs);
} catch (mysqli_sql_exception $exception) {
    echo "資料讀取錯誤：" . $exception->getMessage();
    exit;
}

$count = $result->num_rows;
$row = $result->fetch_assoc();
$categoryRows = $result2->fetch_all(MYSQLI_ASSOC);
// $imgRows = $resultImgs->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .img150{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <?php if($count === 0): 
        ?>
        <h2>資料不存在</h2>
        <a class="btn btn-primary btn-add" href="./index.php">資料列表</a>
        <?php else: 
        ?>
        <h1 class="text-center">資料修改</h1>
        <form action="./doUpdate01.php" method="post" enctype="multipart/form-data">
            <div class="content-area">
            <div class="input-group">
                    <span class="input-group-text">產品名稱</span>
                    <input name="productsname" type="text" class="form-control" placeholder="請輸入產品中文名稱" value="<?=$row["productsName"]?>">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;價&ensp;&ensp;格&ensp;</span>
                    <input name="productsprice" type="text" class="form-control" placeholder="請輸入金額" value="<?=$row["productsPrice"]?>">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">建立時間</span>
                    <input name="productsdate" type="date" class="form-control" id="productsdate" value="<?=$row["productsCreateAt"]?>">
                </div>
                <div class="input-group mb-1">
                <span class="input-group-text">&ensp;顏&ensp;&ensp;色&ensp;</span>
                <input name="productscolor" type="text" class="form-control" placeholder="請填入顏色" value="<?=$row["productsColor"]?>">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;尺&ensp;&ensp;寸&ensp;</span>
                <input name="productssize" type="text" class="form-control" placeholder="請填入尺寸" value="<?=$row["productsSize"]?>">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;數&ensp;&ensp;量&ensp;</span>
                <input name="productsquantity" type="text" class="form-control" placeholder="請填入數量" value="<?=$row["productsQuantity"]?>">
            </div>
            <div class="input-group">
                <span class="input-group-text">訂單編號</span>
                <input name="productsnumber" type="text" class="form-control" placeholder="請填入訂單編號" value="<?=$row["productsNumber"]?>">
            </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品描述</span>
                    <textarea name="productsdescription" class="form-control"><?=$row["productsDescription"]?></textarea>
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;產&ensp;&ensp;地&ensp;</span>
                    <input name="productsorigin" type="text" class="form-control" placeholder="請輸入產地" value="<?=$row["productsOrigin"]?>">
                </div>

                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">出貨地址</span>
                    <input name="productsaddress" type="text" class="form-control" placeholder="請填入詳細地址" value="<?=$row["productsAddress"]?>">
                </div>

                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品分類</span>
                    <select name="productscategoryid" class="form-select">
                        <option value="XX" selected disabled>請選擇</option>
                        <?foreach($categoryRows as $categoryRow):?>
                            <option <?=$categoryRow["id"] === $row["productsCategoryId"]?"selected":""?> value="<?=$categoryRow["id"]?>"><?=$categoryRow["category_name"]?></option>
                        <?endforeach?>
                    </select>
            </div>
        <!-- 圖片區 -->
        <div class="input-group mb-3">
            <input class="form-control" type="file" name="myFile" accept="image/*" multiple>
            <!-- accept="image/*" 意思是所有圖片檔都可接受 -->
        </div>
        <input type="hidden" value="<?=$row["id"]?>" name="id">
        <input type="hidden" value="<?=$row["file01"]?>" name="file01">

        <!-- 傳送 -->
        <div class="mt-1 text-end">
            <button type="submit" class="btn btn-info">送出</button>
            <a class="btn btn-primary btn-add" href="./index.php">取消</a>
            </div>
        </form>

        <!-- 圖片區 -->
        <?if($row["file01"]!="" && $row["file01"]!=NULL):?>
        <img class="img150" src="./upload_products_img/<?=$row["file01"]?>" alt="">
        <?endif?>

        <!-- 上傳複數圖片 -->
        <!-- <form action="./doUpload03.php" method="post" enctype="multipart/form-data">
            <div class="input-group mt-3 mb-2">
                <input class="form-control" type="file" name="myFile[]" accept="image/*" multiple>
                <button class="btn btn-dark input-group-text">送出</button>
            </div>
            <input name="id" type="hidden" value="<?= $row["id"] ?>">
        </form> -->

        <!-- 抓取圖片 -->
        <?foreach ($row as $roww):?>
        <img class="img150" src="../upload_products_img/<?=$roww["file01"]?>" alt="">
        <?endforeach?>
        <?php endif;
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>