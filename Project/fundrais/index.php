<?php
session_start();
if(!isset($_SESSION["user"])){
  header("location: ../login/login.php");
}
require_once("../conn.php");

// 分頁
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1; //這邊的int沒加到 除錯除不出來
$perPage = 10;
$pageStart = $perPage * ($page - 1);

// 分類
$cid = isset($_GET["cid"]) ? (int)$_GET["cid"] : 0;
if ($cid === 0) {
  $cateSQL = "";
} else {
  $cateSQL = "AND `productsCategoryId` = $cid";
}

// 搜尋
$searchcate = isset($_GET["searchcate"]) ? $_GET["searchcate"] : "";
$query = isset($_GET["query"]) ? $_GET["query"] : "";
$search = "";
if ($searchcate == "productsCategoryId") {
  if ($query == '設計師') {
    $query = '';
  } else if ($query == '設計師A') {
    $query = 1;
  } else if ($query == '設計師B') {
    $query = 2;
  } else if ($query == '設計師C') {
    $query = 3;
  } else if ($query == '設計師D') {
    $query = 4;
  }
}
if ($searchcate && $query) {
  $search = "AND `$searchcate` LIKE '%$query%'";
}
// 升冪降冪
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'products.id'; // 默認排序欄位
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC'; // 默認排序方向
$sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';


// $sql = "SELECT * FROM `products` 
//         JOIN `category` ON `productsCategoryId` = `category`.`id` 
//         JOIN `productsimg` ON `productsid` = `products`.`id`
//         WHERE 1=1 $cateSQL $search
//         AND (`endTime` is NULL OR `endTime` > NOW())
//         LIMIT $pageStart, $perPage;";
$sql = "SELECT * FROM `products` 
        JOIN `category` ON `productsCategoryId` = `category`.`id` 
        JOIN `productsimg` ON `productsid` = `products`.`id`
        WHERE 1=1 $cateSQL $search
        AND (`endTime` is NULL OR `endTime` > NOW())
        ORDER BY $sortColumn $sortOrder
        LIMIT $pageStart, $perPage;";

$sql2 = "SELECT * FROM `category`;";
$sql3 = "SELECT * FROM `products` 
        JOIN `category` ON `productsCategoryId` = `category`.`id` 
        JOIN `productsimg` ON `productsid` = `products`.`id`
        WHERE 1=1 $cateSQL $search
        AND (`endTime` is NULL OR `endTime` > NOW())
        ";

try {
  $result = $conn->query($sql);
  $result2 = $conn->query($sql2);
  $result3 = $conn->query($sql3);
  $msgCount = $result3->num_rows;
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $categoryRows = $result2->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $exception) {
  echo "資料讀取錯誤：" . $exception->getMessage();
  $msgCount = -1;
}

$totalPage = ceil($msgCount / $perPage);

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-hant-TW">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    a {
      text-decoration: none;
    }
    body {
      margin: auto;
      font-family: -apple-system, BlinkMacSystemFont, sans-serif;
      overflow: auto;
      background: linear-gradient(315deg, rgba(180, 180, 180, 1) 3%, rgba(200, 200, 200, 1) 38%, rgba(220, 220, 220, 1) 68%, rgba(255, 255, 255, 1) 98%);
      animation: gradient 15s ease infinite;
      background-size: 400% 400%;
      background-attachment: fixed;
    }

    @keyframes gradient {
      0% {
        background-position: 0% 0%;
      }

      50% {
        background-position: 100% 100%;
      }

      100% {
        background-position: 0% 0%;
      }
    }

    .wave {
      background: rgb(255 255 255 / 25%);
      border-radius: 1000% 1000% 0 0;
      position: fixed;
      width: 200%;
      height: 12em;
      animation: wave 10s -3s linear infinite;
      transform: translate3d(0, 0, 0);
      opacity: 0.8;
      bottom: 0;
      left: 0;
      z-index: -1;
    }

    .wave:nth-of-type(2) {
      bottom: -1.25em;
      animation: wave 18s linear reverse infinite;
      opacity: 0.8;
    }

    .wave:nth-of-type(3) {
      bottom: -2.5em;
      animation: wave 20s -1s reverse infinite;
      opacity: 0.9;
    }

    @keyframes wave {
      2% {
        transform: translateX(1);
      }

      25% {
        transform: translateX(-25%);
      }

      50% {
        transform: translateX(-50%);
      }

      75% {
        transform: translateX(-25%);
      }

      100% {
        transform: translateX(1);
      }
    }
  </style>

</head>
<body>
  <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
  </div>
</body>
<body>
  <div class="p-0 container-fluid d-flex  ">
    <!-- 要把collapse1 的1拿掉 -->
    <div class="collapse show collapse-horizontal rounded-end-5 sticky-top z-1 h100vh" id="collapseWidthExample">
      <nav class="w250px h100vh bg-dark p-2 rounded-end-5 ">
        <!-- >後台系統 -->
        <div class="my-4 mt-5">
          <h2 class="text-center text-light fw-bold"><i class="fa-solid fa-chart-line me-1 text-warning"></i>後台系統</h2>
        </div>
        <!-- 大頭照 -->
        <div>
          <img class="d-block m-auto rounded-circle mt-2 w150px h150px object-fit-contain bg-warning-subtle" src="../../membersystem/php_image/<?=$_SESSION["user"]["img"]?>" alt="">
          <p class="text-white text-center my-2 fs-4"><?=$_SESSION["user"]["name"]?></p>
          <button type="button" class="btn btn-outline-light d-block m-auto">
            <i class="fa-solid fa-right-from-bracket"></i>
          </button>
        </div>

        <!-- 系統 -->
        <div class="accordion mt-5 " id="accordionExample">
          <div class="accordion-item w-75 m-auto ">
            <h2 class="accordion-header ">
              <button class=" fw-bold  accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-user me-2"></i>會員系統
              </button>
              <div id="collapseOne" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body p-0">
                  <div class="d-grid  ">
                    <div>
                      <a href="../../membersystem/memberSys.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">會員</a>
                    </div>
                    <div>
                      <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">...</a>
                    </div>
                  </div>
                </div>
              </div>
              <button class=" fw-bold  accordion-button collapsed show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-cart-shopping me-2"></i>商城系統
              </button>
              <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
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
                      <a href="../../fundrais/project.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">專案</a>
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
                      <a href="../../post/index.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">聊天紀錄</a>
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
    <button class="btn btn-warning z-3  position-fixed start-0 top-0 mt-2 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="flex-grow-1 px-3">
      <div class="d-flex p-5 justify-content-between">
        <div class="">
          <h2 class="fw-bold">Status</h2>
        </div>
        <!-- 搜尋 -->
        <div class="flex-grow">
          <form action="./index.php" method="get" id="searchForm">
            <!-- 搜尋分類 -->
            <div class="flex">
              <!-- 搜尋輸入欄 -->
              <div class="input-group flex-nowrap">
                <select name="searchcate" id="searchcate" class="border border-light-subtle w100px text-center border-1 rounded-start me-2">
                  <option value="XX" selected disabled>搜尋類別</option>
                  <option value="productsName">產品名稱</option>
                  <option value="productsPrice">價格</option>
                  <option value="productsColor">顏色</option>
                  <option value="productsSize">尺寸</option>
                  <option value="productsCategoryId">分類</option>
                </select>
                <input type="text" class="form-control inputWidth" name="query" id="search" placeholder="搜尋" aria-label="Username" aria-describedby="addon-wrapping" value="">
                <button class="input-group-text search" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></button>
                <!-- <?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?> -->
              </div>
            </div>
          </form>
        </div>
        <!-- nav bar -->
        <div>
          <button type="button" class="btn btn-outline-dark"><i class="fa-solid fa-bell"></i></button>
        </div>
      </div>
      <div class="container border p-5 rounded-5 bg-light shadow">
        <div class="d-flex justify-content-between align-items-center">
          <p class="fs-3 fw-bold">
            <i class="fa-solid fa-table me-2"></i>Table
          </p>
          <p class=" fw-bold m-0 letter-spacing ms-5">共有<?= $msgCount ?>筆資料</p>
          <div class="d-flex align-items-center">
            <a class="btn btn-outline-primary  me-3" href="./index.php">全部資料</a>
            <a class="btn btn-outline-success" href="./add01.php">增加資料</a>
          </div>
        </div>

        <div class="nav nav-tabs mx-auto justify-content-center">
          <a class="nav-link <?= $cid === 0 ? "active text-black fw-bold" : "text-black-50 fw-bold" ?>" href="./index.php?" <?= $cid = 0 ?>>全部</a>
          <? foreach ($categoryRows as $categoryRow) : ?>
            <a class="nav-link <?= $cid === (int)$categoryRow["id"] ? "active text-black fw-bold" : "text-black-50 fw-bold" ?>" href="./index.php?cid=<?= $categoryRow["id"] ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>"><?= $categoryRow["category_name"] ?></a>
          <? endforeach ?>
        </div>
            


        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <table class="table table-hover">
              <!-- 欄位名稱 -->
              <thead>
                <tr class="table-dark">
                  <th class="index align-middle" scope="col">#</th>
                  <!-- <th class="id" scope="col" >id</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=products.id&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      ID <?= $sortColumn === 'products.id' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>

                  <!-- <th class="productsname" scope="col">Products</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsName&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Product Name <?= $sortColumn === 'productsName' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="price" scope="col">Price</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsPrice&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Price <?= $sortColumn === 'productsPrice' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="time" scope="col">Time</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsCreateAt&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Time <?= $sortColumn === 'productsCreateAt' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="color" scope="col">Color</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsColor&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Color <?= $sortColumn === 'productsColor' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="size" scope="col">Size</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsSize&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Size <?= $sortColumn === 'productsSize' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="amount" scope="col">Quantity</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsQuantity&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Quantity <?= $sortColumn === 'productsQuantity' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <!-- <th class="orderNumber" scope="col">Numbers</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsNumber&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Number <?= $sortColumn === 'productsNumber' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <th class="description align-middle" scope="col">Description</th>
                  <th class="origin align-middle" scope="col">Origin</th>
                  <th class="address align-middle" scope="col">Address</th>
                  <!-- <th class="category" scope="col">Cate.</th> -->
                  <th class="id align-middle" scope="col">
                    <a href="?page=<?= $page ?>&cid=<?= $cid ?>&query=<?= $query ?>&searchcate=<?= $searchcate ?>&sort=productsCategoryId&order=<?= $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white">
                      Cate. <?= $sortColumn === 'productsCategoryId' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                  </th>
                  <th class="picture align-middle" scope="col">Pictures</th>
                  <th class="controls align-middle" scope="col">U/D</th>
                </tr>
              </thead>
              <!-- 內容 -->
              <tbody>
                <? if ($msgCount >= 0) : ?>
                  <?php foreach ($rows as $index => $row) : ?>
                    <tr id="searchResults">
                      <th scope="row"><?= $index + 1 ?></th>
                      <td><?= $row["id"] ?></td>
                      <td><?= $row["productsName"] ?></td>
                      <td><?= $row["productsPrice"] ?></td>
                      <td><?= $row["productsCreateAt"] ?></td>
                      <td><?= $row["productsColor"] ?></td>
                      <td><?= $row["productsSize"] ?></td>
                      <td><?= $row["productsQuantity"] ?></td>
                      <td><?= $row["productsNumber"] ?></td>
                      <td><?= $row["productsDescription"] ?></td>
                      <td><?= $row["productsOrigin"] ?></td>
                      <td><?= $row["productsAddress"] ?></td>
                      <td><?= $row["category_name"] ?></td>
                      <td>
                        <div class="w50px h50px"><img class="w-100 h-100" src="./upload_products_img/<?= $row["file01"] ?>" alt=""></div>
                      </td>
                      <td class="position-relative ">
                        <div class="d-flex pe-2 ">
                          <a class="btn btn-sm text-dark" href="./updatee.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-gear me-1 hover"></i></a>
                          <a class="btn btn-sm text-center pe-2" href="./doDelete02.php?id=<?= $row["id"] ?>"><i class=" btn-del fa-solid fa-trash hover" idn="<?= $row["id"] ?>"></i></a>
                        </div>
                      </td>
                    <?php endforeach; ?>
                  <? endif ?>
              </tbody>
            </table>
            <nav aria-label="..." class="d-flex justify-content-center mt-5">
              <ul class="pagination pagination-sm">
                <? for ($i = 0; $i < $totalPage; $i++) : ?>
                  <li class=" page-item <?= $page === $i + 1 ? "active" : "" ?>" aria-current="page">
                    <a href="?page=<?= $i + 1 ?><?= '&cid=' . $cid > 0 ? $cid : "" ?>" class="page-link"><?= $i + 1 ?></a>
                  </li>
                <? endfor; ?>
              </ul>
            </nav>
          </div>

        </div>
      </div>
    </main>
  </div>
  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- <a class="btn btn-primary btn-sm me-1" href="../user/logout.php">登出</a> -->
  </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleButton = document.getElementById('toggle-sidebar');
      const sidebar = document.getElementById('sidebar');
      const m_r = document.getElementById('m-r');

      toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        toggleButton.classList.toggle('rotate');
      });

      const toggleFeature = document.getElementById('toggle-feature');
      const feature = document.getElementById('feature');

      toggleFeature.addEventListener('click', function() {
        feature.classList.toggle('hidden');
        m_r.classList.toggle('rotate');
      });
    });
  </script>


  <script>
    // Delete的跳視窗
    const btn_del = document.querySelectorAll(".btn-del");
    btn_del.forEach(btn => {
      btn.addEventListener("click", e => {
        let btn = e.target.getAttribute("idn");
        if (confirm("是否刪除此筆資料")) {
          window.location.href = "./doDelete.php?id=" + btn;
        } else {
          alert("確認刪除");
        };

        console.log(e);
      })
    })
  </script>
  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>