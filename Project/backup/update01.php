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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../css/reset.css"> -->
  <link rel="stylesheet" href="../css/index.css">
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
<div class="p-0 container-fluid d-flex">
    <!-- 要把collapse1 的1拿掉 -->
    <div class="collapse collapse-horizontal rounded-end-5 sticky-top z-1 h100vh show" id="collapseWidthExample">
      <nav class="w250px h100vh bg-dark p-2 rounded-end-5 ">
        <!-- >後台系統 -->
        <div class="my-4 mt-5">
          <h2 class="text-center text-light fw-bold"><i class="fa-solid fa-chart-line me-1 text-warning"></i>後台系統</h2>
        </div>
        <!-- 大頭照 -->
        <div>
          <img class="d-block m-auto rounded-circle mt-2 w150px h150px object-fit-contain bg-warning-subtle" src="https://pa1.aminoapps.com/5803/1dbab24728b45a0db8005ab4f045854a7226de59_hq.gif" alt="">
          <p class="text-white text-center my-2 fs-4">Terrance Torres</p>
          <button type="button" class="btn btn-outline-light d-block m-auto">
            <i class="fa-solid fa-right-from-bracket"></i>
          </button>
        </div>

        <!-- 系統 -->
        <div class="accordion mt-5 " id="accordionExample">
          <div class="accordion-item w-75 m-auto ">
            <h2 class="accordion-header ">
              <button class=" fw-bold  accordion-button collapsed  " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-user me-2"></i>會員系統
              </button>
              <div id="collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body p-0">
                  <div class="d-grid  ">
                    <div>
                      <a href="#" class="btn d-block bg-dark fw-bold text-white rounded-0 border">會員</a>
                    </div>
                    <div>
                      <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">...</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class=" fw-bold  accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-cart-shopping me-2"></i>商城系統
              </button>
              <div id="collapseTwo" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body p-0">
                  <div class="d-grid  ">
                    <div>
                      <a href="#" class="btn d-block bg-dark fw-bold text-white rounded-0 border">商品</a>
                    </div>
                    <div>
                      <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">...</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class=" fw-bold  accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-piggy-bank me-2"></i>募資系統
              </button>
              <div id="collapseThree" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body p-0">
                  <div class="d-grid  ">
                    <div>
                      <a href="#" class="btn d-block bg-dark fw-bold text-white rounded-0 border">專案</a>
                    </div>
                    <div>
                      <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">方案</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class=" fw-bold  accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-message me-2"></i>社群系統
              </button>
              <div id="collapseFour" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body p-0">
                  <div class="d-grid  ">
                    <div>
                      <a href="#" class="btn d-block bg-dark fw-bold text-white rounded-0 border">聊天紀錄</a>
                    </div>
                    <div>
                      <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">...</a>
                    </div>
                  </div>
                </div>
              </div>
            </h2>
          </div>
        </div>
      </nav>
    </div>


    <!-- Status -->
    <button class="btn btn-warning z-3 position-fixed start-0 top-0 mt-2 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="flex-grow-1 px-3">
      <div class="d-flex p-5 justify-content-between">
        <div class="">
          <h2 class="fw-bold">Status</h2>
        </div>
        <!-- nav bar -->
        <div>
          <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-bell"></i></button>
        </div>
      </div>
      <div class="container border p-5 rounded-5 bg-light shadow">
        <div class="d-flex justify-content-between align-items-center">
          <p class="fs-3 fw-bold">
            <i class="fa-solid fa-table me-2"></i>資料修改
          </p>
          <p class=" fw-bold m-0 letter-spacing ms-5"></p>
          <div class="d-flex align-items-center">
            <a class="btn btn-outline-primary  me-3" href="./index.php">123</a>
            <a class="btn btn-outline-success" href="./add.php">123</a>
          </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="container mt-3">
            <?php if($count === 0): 
              ?>
            <h2>資料不存在</h2>
            <a class="btn btn-primary btn-add" href="./index.php">資料列表</a>
            <?php else: 
            ?>
              <form action="./doInsert.php" method="post" enctype="multipart/form-data">
                <!-- enctype="multipart/form-data一定要加阿 否則傳過去myFile會Undefined -->
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
                  <!-- 抓取圖片 -->
                  <?foreach ($row as $roww):?>
                  <img class="img150" src="../upload_products_img/<?=$roww["file01"]?>" alt="">
                  <?endforeach?>
                  <?php endif;
                  ?>
            </div>
          </div>
        </div>
        </div>
    </form>
    </main>
  
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- <a class="btn btn-primary btn-sm me-1" href="../user/logout.php">登出</a> -->
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>

</body>

</html>