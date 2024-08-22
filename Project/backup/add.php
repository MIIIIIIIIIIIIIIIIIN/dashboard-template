<?php
require_once("../conn.php");
$sql = "SELECT * FROM `category`";
// $sqlorigin = "SELECT * FROM `productsorigin`";
try {
    $result = $conn->query($sql);
    $msgCount = $result->num_rows;
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $exception) {
    echo "資料讀取錯誤：" . $exception->getMessage();
    $msgCount = -1;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <H1 class="text-center mt-3 mb-3">商品資料建立</H1>
    <div class="container mt-3">
        <form action="./doInsert.php" method="post" enctype="multipart/form-data">
            <!-- enctype="multipart/form-data一定要加阿 否則傳過去myFile會Undefined -->
            <div class="content-area">
                <div class="input-group">
                    <span class="input-group-text">產品名稱</span>
                    <input name="productsname[]" type="text" class="form-control" placeholder="請輸入產品中文名稱">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;價&ensp;&ensp;格&ensp;</span>
                    <input name="productsprice[]" type="text" class="form-control" placeholder="請輸入金額">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">建立時間</span>
                    <input name="productsdate[]" type="date" class="form-control" id="productsdate">
                </div>
                <div class="input-group mb-1">
                <span class="input-group-text">&ensp;顏&ensp;&ensp;色&ensp;</span>
                <input name="productscolor[]" type="text" class="form-control" placeholder="請填入顏色">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;尺&ensp;&ensp;寸&ensp;</span>
                <input name="productssize[]" type="text" class="form-control" placeholder="請填入尺寸">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;數&ensp;&ensp;量&ensp;</span>
                <input name="productsquantity[]" type="text" class="form-control" placeholder="請填入數量">
            </div>
            <div class="input-group">
                <span class="input-group-text">訂單編號</span>
                <input name="productsnumber[]" type="text" class="form-control" placeholder="請填入訂單編號">
            </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品描述</span>
                    <textarea name="productsdescription[]" class="form-control"></textarea>
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;產&ensp;&ensp;地&ensp;</span>
                    <input name="productsorigin[]" type="text" class="form-control" placeholder="請輸入產地">
                </div>

                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">出貨地址</span>
                    <input name="productsaddress[]" type="text" class="form-control" placeholder="請填入詳細地址">
                </div>

                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品分類</span>
                    <select name="productscategoryid[]" class="form-select">
                        <option value="XX" selected disabled>請選擇</option>
                        <?foreach($rows as $row):?>
                            <option value="<?=$row["id"]?>"><?=$row["category_name"]?></option>
                        <?endforeach?>
                    </select>
                </div>

                <div class="input-group mb-3">
                <input class="form-control" type="file" name="myFile[]" accept="image/*">
                </div>
            </div>
            
            <div class="mt-1 text-end">
            <a class="btn btn-dark" href="./index.php">資料列表</a>
                <button type="submit" class="btn btn-secondary btn-add">增加一組</button>
                <button type="submit" class="btn btn-secondary">送出</button>
            </div>
        </form>
        <template id="inputs">
            <div class="input-group">
                <span class="input-group-text">產品名稱</span>
                <input name="productsname[]" type="text" class="form-control" placeholder="">
            </div>
            <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;價&ensp;&ensp;格&ensp;</span>
                    <input name="productsprice[]" type="text" class="form-control" placeholder="請輸入金額">
                </div>
            <div class="input-group mt-1 mb-1">
                <span class="input-group-text">建立時間</span>
                <input name="productsdate[]" type="date" class="form-control" id="productsdate">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;顏&ensp;&ensp;色&ensp;</span>
                <input name="productscolor[]" type="text" class="form-control" placeholder="請填入顏色">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;尺&ensp;&ensp;寸&ensp;</span>
                <input name="productssize[]" type="text" class="form-control" placeholder="請填入尺寸">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">&ensp;數&ensp;&ensp;量&ensp;</span>
                <input name="productsquantity[]" type="text" class="form-control" placeholder="請填入數量">
            </div>
            <div class="input-group">
                <span class="input-group-text">訂單編號</span>
                <input name="productsnumber[]" type="text" class="form-control" placeholder="請填入訂單編號">
            </div>
            <div class="input-group mt-1 mb-1">
                <span class="input-group-text">產品描述</span>
                <textarea name="productsdescription[]" class="form-control"></textarea>
            </div>
            <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;產&ensp;&ensp;地&ensp;</span>
                    <input name="productsorigin[]" type="text" class="form-control" placeholder="請輸入產地">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">出貨地址</span>
                    <input name="productsaddress[]" type="text" class="form-control" placeholder="請填入詳細地址">
                </div>
            <div class="input-group mt-1 mb-3">
                <span class="input-group-text">產品分類</span>
                <select name="productscategoryid[]" class="form-select">
                    <option value="XX" selected disabled>請選擇</option>
                    <?foreach($rows as $row):?>
                        <option value="<?=$row["id"]?>"><?=$row["category_name"]?></option>
                    <?endforeach?>
                </select>
            </div>
            <div class="input-group mb-3">
                <input class="form-control" type="file" name="myFile[]" accept="image/*">
            </div>
        </template>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const btnAdd = document.querySelector(".btn-add");
        const contentArea = document.querySelector(".content-area");
        const template = document.querySelector("#inputs");
        const today = new Date().toISOString().split('T')[0]
        btnAdd.addEventListener("click", e => {
            e.preventDefault();

            const node = template.content.cloneNode(true);
            contentArea.append(node);
        });
        document.getElementById('productsdate').setAttribute('max', today);
        document.getElementById('productsdate').value = today;

    </script>
</body>

</html>