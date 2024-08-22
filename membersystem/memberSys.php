<?php
session_start();
if(!isset($_SESSION["user"])){
  header("location: ../login/login.php");
}

// 執行外部PHP文件
require_once("../conn.php");


// 會員系統裡的ADD_city 串接 city table,對照CityID& CityName

$cityArray = array(
  0 => array('CityID' => 1, 'CityName' => '台北市',),
  1 => array('CityID' => 2, 'CityName' => '新北市',),
  2 => array('CityID' => 3, 'CityName' => '桃園市'),
  3 => array('CityID' => 4, 'CityName' => '台中市'),
  4 => array('CityID' => 5, 'CityName' => '台南市'),
  5 => array('CityID' => 6, 'CityName' => '高雄市'),
  6 => array('CityID' => 7, 'CityName' => '基隆市'),
  7 => array('CityID' => 8, 'CityName' => '新竹市'),
  8 => array('CityID' => 9, 'CityName' => '嘉義市'),
  9 => array('CityID' => 10, 'CityName' => '苗栗縣'),
  10 => array('CityID' => 11, 'CityName' => '彰化縣'),
  11 => array('CityID' => 12, 'CityName' => '南投縣'),
  12 => array('CityID' => 13, 'CityName' => '雲林縣'),
  13 => array('CityID' => 14, 'CityName' => '嘉義縣'),
  14 => array('CityID' => 15, 'CityName' => '屏東縣'),
  15 => array('CityID' => 16, 'CityName' => '宜蘭縣'),
  16 => array('CityID' => 17, 'CityName' => '花蓮縣'),
  17 => array('CityID' => 18, 'CityName' => '台東縣'),
  18 => array('CityID' => 19, 'CityName' => '澎湖縣'),
  19 => array('CityID' => 20, 'CityName' => '金門縣'),
  20 => array('CityID' => 21, 'CityName' => '連江縣'),
  21 => array('CityID' => 22, 'CityName' => '新竹縣')
);

// elseif ($search_field == '全域搜尋') {
// 全域搜尋：在多個欄位中進行模糊搜尋
// $search = "(`memberName` LIKE ? OR `MS_ID` LIKE ? OR `ADD_city` IN (SELECT `CityID` FROM `city` WHERE `CityName` LIKE ?)) AND ";


// 三層篩選 1.姓名 2.會員ID 3.縣市名稱
if (isset($_GET['query']) && !empty($_GET['query'])) {
  // 獲取搜尋關鍵字
  $query = $_GET['query'];

  if (isset($_GET['search_field']) && !empty($_GET['search_field'])) {
    // 根據選定的搜尋欄位進行搜尋
    if ($_GET['search_field'] == '姓名') {
      $search = "`memberName` LIKE '%$query%' AND";
    } elseif ($_GET['search_field'] == '會員ID') {
      $search = "`MS_ID` LIKE '%$query%' AND";
    } elseif ($_GET['search_field'] == '居住縣市') {
      // 匹配縣市資料
      $matchCityData = '';
      foreach ($cityArray as $city) {
        if (strpos($city['CityName'], $query) !== false) {
          $matchCityData .= intval($city['CityID']) . ',';
        }
      }
      $matchCityData = rtrim($matchCityData, ','); // 移除最後的逗號
      if (!empty($matchCityData)) {
        $search = "`ADD_city` IN ($matchCityData) AND";
      } else {
        $search = "`ADD_city` LIKE '%$query%' AND";
      }
    } elseif ($_GET['search_field'] == '全域搜尋') {
      // 全域搜尋：在姓名、會員ID 和縣市中進行搜尋
      $search = "(
      `MS_ID` LIKE '%$query%' OR 
      `account` LIKE '%$query%' OR 
      `memberName` LIKE '%$query%' OR 
      `email` LIKE '%$query%' OR 
      `PhoneNumber` LIKE '%$query%' OR 

      `ADD_city` IN (SELECT `CityID` FROM `city` WHERE `CityName` LIKE '%$query%')) AND";
    }
  }
} else {
  $query = "";
  $search = "";
}


// 檢查參數是否存在,若不存在則顯示第一頁內容
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$perPage = 5; // 每頁 N 則資料
$pageStart = $perPage * ($page - 1);
$sql22 = "SELECT * FROM `city`"; //縣市下拉式選單 0812
$sql23 = "SELECT * FROM `designerornot`"; //會員身分下拉式選單 0812


// 建立頁籤: 2:全部;1:設計師;0:一般會員
$cid = isset($_GET["cid"]) ? (int)$_GET["cid"] : 2;
if ($cid === 2) {
  $designerSQL = "";
} else {
  $designerSQL = "`designerOrNot` = $cid AND";
}

// 頁面載入時判斷有沒有query
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : '';
$search_query = isset($_GET['query']) ? $query : '';

// SQL語法
// 顯示內容（不含軟刪除）且順序排列由設計師->一般會員
$sql = "SELECT * FROM `membershipsystem` WHERE $designerSQL $search isValid = 1  LIMIT $pageStart, $perPage;";
$sqlAll = "SELECT * FROM `membershipsystem` WHERE $designerSQL $search isValid = 1"; // 目前共 ？ 筆資料（不含軟刪除）
$sqlCity = "SELECT * FROM `city`";
$sql2 = "SELECT * FROM `membershipsystem` WHERE `designerOrNot`";
// $member = "SELECT * FROM `membershipsystem`";


// echo 'sqlAll' . $sqlAll;

//try-catch語法 用來捕捉SQL查詢時發生的異常,並回報資料讀取錯誤,預設為-1
try {
  // $add_city = isset($member['ADD_city']) ? $member['ADD_city'] : 23;//會員未輸入自動帶入
  $result22 = $conn->query($sql22); //縣市下拉式選單 0812
  $result23 = $conn->query($sql23); //會員身分下拉式選單 0812

  $resultCity = $conn->query($sqlCity);
  $rowsCity = $resultCity->fetch_all(MYSQLI_ASSOC);
  $result = $conn->query($sql);
  $resultAll = $conn->query($sqlAll);

  $result2 = $conn->query($sql2);
  $msgCount = $resultAll->num_rows;
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $roleRows = $result2->fetch_all(MYSQLI_ASSOC);
  // print_r($msgCount);
  if ($msgCount) {
    //   echo '有 resultAll';
    //   print_r($msgCount);
    $totalPage = ceil($msgCount / $perPage);
  } else {
    //   echo '沒有 resultAll';
    //   print_r($msgCount);
    $totalPage = 0;
  }
  // echo 'totalPage'.$totalPage;
  $cityrows = $result22->fetch_all(MYSQLI_ASSOC); //縣市下拉式選單
  $designerOrNotrows = $result23->fetch_all(MYSQLI_ASSOC); //身分下拉式選單

  // echo 'eddie';
} catch (mysqli_sql_exception $exception) {
  echo "資料讀取錯誤：" . $exception->getMessage();
  $msgCount = -1;
}

// var_dump($rows);
// exit;
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
  <!-- <link rel="stylesheet" href="../css/reset.css"> -->
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
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

    .wall1 {
      width: 100px;
      margin-left: 30px;
      /* position: fixed; */
      /* 設置圖片為固定位置 */
      /* left: 70px; */
      /* 靠右對齊 */
      /* top: 25%; */
      /* 垂直方向置中 */
      /* transform: translateY(-50%); */
      /* 修正讓圖片完全垂直置中 */
      /* transform: translateY(-20%) rotate(340deg); */
      z-index: 9999;
    }

    .wall2 {
      width: 150px;
      position: fixed;
      /* 設置圖片為固定位置 */
      right: 30px;
      /* 靠右對齊 */
      top: 90%;
      /* 垂直方向置中 */
      transform: translateY(-50%);
      /* 修正讓圖片完全垂直置中 */
    }



    /* .transparent-input {
      background-color: transparent;
    } */

    th,
    td {
      vertical-align: middle;
      text-align: center;
      /* 讓所有 th 和 td 中的文字上下置中 */
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

  <!-- 背景圖 -->

  <a href="./memberSys.php" style="text-decoration: none; color: inherit;">
    <img class="wall2" src="./php_image/wall5.png" alt="">
  </a>



  <!-- 左側隱藏欄位 -->
  <div class="p-0 container-fluid d-flex  ">
    <!-- 要把collapse1 的1拿掉 -->
    <div class="collapse  collapse-horizontal rounded-end-5 sticky-top z-1 h100vh" id="collapseWidthExample">
      <nav class="w250px h-100 bg-dark p-2 rounded-end-5">
        <!-- >後台系統 -->
        <div class="my-4 mt-5">
          <h2 class="text-center text-light fw-bold"><i class="fa-solid fa-chart-line me-1 text-warning"></i>後台系統</h2>
        </div>
        <!-- 大頭照 -->
        <div>
          <img class="d-block m-auto rounded-circle mt-2 w150px h150px" src="../membersystem/php_image/<?=$_SESSION["user"]["img"]?>" alt="">
          <p class="text-white text-center my-2 fs-4"><?=$_SESSION["user"]["name"]?></p>
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
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
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
                      <a href="../Project/fundrais/index.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">商品</a>
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
                      <a href="../fundrais/project.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">專案</a>
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
                      <a href="../post/index.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">聊天紀錄</a>
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


    <!--  -->
    <button class="btn btn-warning z-3  position-fixed start-0 top-0 mt-2 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="flex-grow-1 px-3">
      <div class="d-flex p-5 justify-content-between">
        <div class="ms-5">
          <!-- <a href="./memberSys.php" style="text-decoration: none; color: inherit;">
            <img class="d-block m-auto mt-2 w50px h50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/LEGO_logo.svg/640px-LEGO_logo.svg.png" alt=""> </a> -->
        </div>
        <!-- 搜尋欄位 -->
        <form action="" method="get">
          <div class="input-group mt-4 flex-nowrap">
            <button class="btn btn-light border border-end dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= isset($_GET['search_field']) ? htmlspecialchars($_GET['search_field']) : 'ALLLLLL'; ?>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" onclick="document.getElementById('search_field').value='姓名'; this.closest('form').submit();">姓名</a></li>
              <li><a class="dropdown-item" href="#" onclick="document.getElementById('search_field').value='會員ID'; this.closest('form').submit();">會員ID</a></li>
              <li><a class="dropdown-item" href="#" onclick="document.getElementById('search_field').value='居住縣市'; this.closest('form').submit();">縣市</a></li>
              <li><a class="dropdown-item" href="#" onclick="document.getElementById('search_field').value='全域搜尋'; this.closest('form').submit();">全域搜尋</a></li>
            </ul>
            <input type="hidden" name="search_field" id="search_field" value="<?= isset($_GET['search_field']) ? htmlspecialchars($_GET['search_field']) : '全域搜尋'; ?>">
            <input type="text" class="form-control transparent-input" name="query" id="search" placeholder="搜尋關鍵字" aria-label="Query" aria-describedby="addon-wrapping" value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
            <button class="input-group-text search" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>




        <div>
          <button type="button" class="btn btn-outline-dark"><i class="fa-solid fa-bell"></i></button>
        </div>
      </div>

      <div class="container border p-5 rounded-5 bg-light shadow">
        <!-- table上列 人頭區塊 -->
        <div class="d-flex justify-content-between align-items-center">
          <p class="fs-3 fw-bold" style="width:10%;">



          
            <a href="./memberSys.php" style="text-decoration: none; color: inherit;">
              <img class="wall1" src="./php_image/15.png" alt="">
            </a>

          </p>
          <!-- table上列 共有 ? 筆資料 -->

          <span class=" fw-bold m-0 letter-spacing text-center" style="width:80%; ; text-align: center;">共有<?= $msgCount ?>筆資料</span>
          <!-- table上列 增加資料 -->
          <!-- class="d-flex justify-content-end align-items-center" style="width:100%;" -->
          <div class="d-flex align-items-center" style="width:10%;">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal" class="ms-end">建立會員</button>
          </div>

        </div>
        <!-- 分類頁籤 -->
        <div class="nav nav-tabs mx-auto justify-content-center">
          <div class="nav nav-tabs">
            <a class="nav-link <?= $cid === 2 ? "active text-black fw-bold" : "text-black-50 fw-bold"?>" href="./memberSys.php?cid=2<?= "&search_field=$search_field&query=$search_query" ?>">All</a>
            <a class="nav-link <?= $cid === 1 ? "active text-black fw-bold" : "text-black-50 fw-bold"?>" href="./memberSys.php?cid=1<?= "&search_field=$search_field&query=$search_query" ?>">設計師</a>
            <a class="nav-link <?= $cid === 0 ? "active text-black fw-bold" : "text-black-50 fw-bold" ?>" href="./memberSys.php?cid=0<?= "&search_field=$search_field&query=$search_query" ?>">一般會員</a>
          </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <table class="table table-hover">
              <thead>
                <tr class="table-dark">
                  <th class="index" scope="col">#</th>
                  <th class="MS_ID" scope="col"> 會員ID</th>
                  <th class="account" scope="col">帳號</th>
                  <th class="password" hidden scope="col">密碼</th>
                  <th class="img" scope="col">大頭照</th>
                  <th class="memberName" scope="col">姓名</th>
                  <th class="	email" scope="col"> email</th>
                  <th class="PhoneNumber" scope="col">電話</th>
                  <th class="ADD_city" scope="col">縣市</th>
                  <th class="ADD_detail" hidden scope="col">地址</th>
                  <th class="JoinDate" hidden scope="col">加入時間</th>
                  <th class="designerOrNot " scope="col">身分 </th>
                  <th class="isValid" hidden scope="col">isValid</th>
                  <th class="ctrls" scope="col">設定</th>
                </tr>
              </thead>
              <tbody>
                <? if ($msgCount > 0) : ?>
                  <?php foreach ($rows as $index => $row) : ?>
                    <tr>
                      <th style="color: #535953;" scope="row"><?= $index + 1 ?></th>
                      <td style="color: #535953;"><?= $row["MS_ID"] ?></td>
                      <td style="color: #535953;"><?= $row["account"] ?></td>
                      <td hidden><?= $row["password"] ?></td>
                      <td>
                        <div class="w50px h50px bg-light overflow-hidden">
                          <img class="w-100 object-fit-cover" src="./php_image/<?= $row["img"] ?>" alt="">
                        </div>
                      </td>
                      <td style="color: #535953;"><?= $row["memberName"] ?></td>
                      <td style="color: #535953;"><?= $row["email"] ?></td>
                      <td style="color: #535953;"><?= $row["PhoneNumber"] ?></td>
                      <td style="color: #535953;">
                        <?= $cityName = "";
                        foreach ($rowsCity as $rowCity) {
                          if ($row["ADD_city"] == $rowCity["CityID"]) {
                            $cityName = $rowCity["CityName"];
                            break;
                          }
                        }
                        echo $cityName;
                        ?>
                      </td>
                      <td hidden><?= $row["ADD_detail"] ?></td>
                      <td hidden><?= $row["JoinDate"] ?></td>
                      <td style="color: #535953;"> <?php
                                                    if ($row["designerOrNot"] == 1) {
                                                      echo "設計師";
                                                    } else {
                                                      echo "一般會員";
                                                    }
                                                    ?>
                      </td>
                      <td hidden><?= $row["isValid"] ?> </td>
                      <!-- <td>
                        <div class="w50px h50px bg-light overflow-hidden"><img class="w-100 object-fit-cover" src="./img/<?= $row["img"] ?>" alt=""></div>
                      </td> -->
                      <td>
                        <!-- hover -->
                        <!-- 修改/刪除 -->
                        <i class=" fa-solid fa-gear me-2 hover" data-bs-toggle="modal" data-bs-target="#setModal<?= $index ?>"></i>
                        <i class=" btn-del fa-solid fa-trash hover" idn="<?= $row["MS_ID"] ?>"></i>
                      </td>
                    </tr>
                    <div class="modal fade" id="setModal<?= $index ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">更新資料</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <?php if (!$row) : ?>
                              <h1>不存在</h1>
                              <a class="btn btn-primary btn-add" href=".index.php">資料列表</a>
                            <?php else : ?>
                              <!------------ 更新資料 ------------>
                              <div class="container mt-3">
                                <form action="doupdate01.php" method="post" enctype="multipart/form-data">
                                  <div class="contentArea">
                                    <!-- account 帳號 0813從這裡開始!!!! -->
                                    <div class="input-group mt-1 mb-1 MS_ID">
                                      <span class="input-group-text" readonly>帳號</span>
                                      <input name="account" type="text" class="form-control" readonly placeholder="帳號" value="<?= isset($row) ? $row["account"] : "不存在" ?>">
                                    </div>
                                    <div class="input-group mt-1 mb-1 MS_ID">
                                      <span class="input-group-text" readonly>密碼</span>
                                      <input name="password" type="text" class="form-control" placeholder="密碼" value="<?= isset($row) ? $row["password"] : "不存在" ?>">
                                    </div>
                                    <div class="input-group">
                                      <span class="input-group-text" readonly>姓名</span>
                                      <input name="memberName" type="text" class="form-control" placeholder="發文者名稱" value="<?= isset($row) ? $row["memberName"] : "不存在" ?>">
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">email</span>
                                      <input name="email" type="text" class="form-control" placeholder="email" value="<?= isset($row) ? $row["email"] : "不存在" ?>">
                                    </div>
                                    <div class="input-group">
                                      <span class="input-group-text">電話</span>
                                      <input name="PhoneNumber" type="text" class="form-control" placeholder="PhoneNumber" value="<?= isset($row) ? $row["PhoneNumber"] : "不存在" ?>">
                                    </div>
                                    <!-- 縣市***注意下拉式選單 -->
                                    <div class="input-group mt-1 mb-1 ADD_city">
                                      <span class="input-group-text">縣市</span>
                                      <select name="ADD_city" class="form-select">
                                        <option value="XX" selected disabled>請選擇</option>
                                        <? foreach ($cityrows as $cityrow) : ?>
                                          <option <?= $cityrow["CityID"] === $row["ADD_city"] ? "selected" : "" ?> value="<?= $cityrow["CityID"] ?>"><?= $cityrow["CityName"] ?></option>
                                        <? endforeach; ?>
                                      </select>
                                    </div>
                                    <!-- 詳細地址 -->
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">地址</span>
                                      <input name="ADD_detail" type="text" class="form-control" placeholder="ADD_detail" value="<?= isset($row) ? $row["ADD_detail"] : "不存在" ?>">
                                    </div>
                                    <!-- designerornot 會員身分 -->
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">會員身分</span>
                                      <select name="designerOrNot" class="form-select">
                                        <option value="XX" selected disabled>請選擇</option>
                                        <? foreach ($designerOrNotrows as $designerOrNotrow) : ?>
                                          <option value="<?= $designerOrNotrow["designerID"] ?>"><?= $designerOrNotrow["role"] ?></option>
                                        <? endforeach ?>
                                      </select>
                                    </div>
                                    <div class="input-group mb-3">
                                      <input class="form-control" type="file" name="myFile" id="imageFileSet<?= $index ?>" accept="image/*" onchange="previewImageSet()">
                                    </div>
                                  </div>
                                  <input name="MS_ID" type="hidden" value="<?= $row["MS_ID"] ?>">
                                  <input name="img" type="hidden" value="<?= $row["img"] ?>">
                                  <div class="d-flex">
                                    <? if ($row["img"] != "") : ?>
                                      <div>
                                        <img class="" src="./php_image/<?= $row["img"] ?>" alt="">
                                      </div>
                                      <div style="width:300px; object-fit:contain" class="align-middle setImg"><i class="fa-solid fa-arrow-right p-5 mt-5 d-flex align-items-center">更換成</i></div>
                                      <div>
                                        <img style="width:350px; object-fit: contain" class="" src="" alt="" id="imagePreviewSet<?= $index ?>">
                                      </div>
                                    <? endif; ?>
                                  </div>
                              </div>
                            <?php endif ?>
                          </div>
                          <div class="modal-footer">
                            <div class="mt-1 ms-auto">
                              <button type="submit" class="btn btn-outline-primary">送出</button>
                              <a class="btn btn-primary btn-add" href="memberSys.php">取消</a>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <? endif ?>
              </tbody>
            </table>
            <? if ($msgCount == 0): ?>
              <div class="text-center">找不到符合的資料</div>
            <? endif ?>
            <!-- 分頁/ page -->
            <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-5">
              <ul class="pagination pagination-sm">
                <?php if ($msgCount > 0): ?>
                  <!-- 前一頁  max(1, $page - 1) 來確保前一頁不會超出第 1 頁。-->
                  <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= max(1, $page - 1) ?><?= "&cid=$cid" ?><?= "&search_field=$search_field" ?><?= "&query=$search_query" ?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>

                  <!-- 頁碼按鈕 -->
                  <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>" aria-current="page">
                      <a href="?page=<?= $i ?><?= "&cid=$cid" ?><?= "&search_field=$search_field" ?><?= "&query=$search_query" ?>" class="page-link"><?= $i ?></a>
                    </li>
                  <?php endfor; ?>

                  <!-- 後一頁 min($totalPage, $page + 1) 來確保後一頁不會超出總頁數。-->
                  <li class="page-item <?= $page == $totalPage ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= min($totalPage, $page + 1) ?><?= "&cid=$cid" ?><?= "&search_field=$search_field" ?><?= "&query=$search_query" ?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </nav>
            <!--  -->
          </div>

        </div>
      </div>
    </main>



    <!-- 建立會員(接到doAdd) -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">新增會員</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container mt-3">
              <form action="./doAdd.php" method="post" enctype="multipart/form-data">
                <div class="contentArea">
                  <!-- account 帳號 -->
                  <div class="input-group mt-1 mb-1 MS_ID">
                    <span class="input-group-text">帳號</span>
                    <input name="account[]" type="text" class="form-control" placeholder="*必填項目">
                  </div>
                  <!-- 	password 密碼 -->
                  <div class="input-group mt-1 mb-1 MS_ID">
                    <span class="input-group-text">密碼</span>
                    <input name="password[]" type="text" class="form-control" placeholder="*必填項目">
                  </div>
                  <!-- 姓名 -->
                  <div class="input-group mt-1 mb-1 MS_ID">
                    <span class="input-group-text">姓名</span>
                    <input name="memberName[]" type="text" class="form-control" placeholder="*必填項目">
                  </div>
                  <!-- email -->
                  <div class="input-group mt-1 mb-1 email">
                    <span class="input-group-text">email</span>
                    <input name="email[]" type="text" class="form-control" placeholder="*必填項目">
                  </div>
                  <!-- PhoneNumber -->
                  <div class="input-group mt-1 mb-1 PhoneNumber">
                    <span class="input-group-text">電話</span>
                    <input name="PhoneNumber[]" type="text" class="form-control" placeholder="*必填項目">
                  </div>
                  <!-- 縣市***注意下拉式選單 -->
                  <div class="input-group mt-1 mb-1 ADD_city">
                    <span class="input-group-text">縣市</span>
                    <select name="city[]" class="form-select">
                      <option value="XX" selected disabled>請選擇</option>
                      <? foreach ($cityrows as $cityrow) : ?>
                        <option value="<?= $cityrow["CityID"] ?>"><?= $cityrow["CityName"] ?></option>
                      <? endforeach ?>
                    </select>
                  </div>
                  <!-- 詳細地址 -->
                  <div class="input-group mt-1 mb-1 ADD_detail" hidden>
                    <span class="input-group-text">地址</span>
                    <input name="ADD_detail[]" type="text" class="form-control" placeholder="">
                  </div>
                  <!-- designerornot 會員身分 -->
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">會員身分</span>
                    <select name="designerOrNot" class="form-select">
                      <option value selected disabled>請選擇</option>
                      <? foreach ($designerOrNotrows as $designerOrNotrow) : ?>
                        <option value="<?= $designerOrNotrow["designerID"] ?>"><?= $designerOrNotrow["role"] ?></option>
                      <? endforeach ?>
                    </select>
                  </div>


                  <div class="input-group mb-1">
                    <input class="form-control " type="file" name="myFile[]" id="imageFileAdd" accept="image/*" onchange="previewImageAdd()">
                  </div>
                  <img class="size ms-5 mb-4" id="imagePreviewAdd" src="" alt="">

                  </template>
                  <div class="modal-footer">
                    <div class="mt-1 text-end">
                      <button type="submit" class="btn btn-outline-primary mr-2">新增</button>
                      <a class="btn btn-primary btn-add" href="memberSys.php">取消</a>
                    </div>
              </form>
            </div>
          </div>

          <script>
            document.querySelector("#imagePreview").style.display = "none";


            function previewImageSet() {
              for (let i = 0; i < 10; i++) {
                const file = document.querySelector("#imageFileSet" + i).files[0];

                const reader = new FileReader();
                reader.onloadend = function() {
                  const imagePreview = document.getElementById('imagePreviewSet' + i);
                  imagePreview.src = reader.result;
                  imagePreview.style.display = 'block';
                };

                if (file) {
                  reader.readAsDataURL(file);
                } else {
                  document.getElementById("imagePreviewSet" + i).style.display = "none";
                }
              }
            }
          </script>


          <script>
            const btn_del = document.querySelectorAll(".btn-del");
            btn_del.forEach(btn => {
              btn.addEventListener("click", e => {
                let btn = e.target.getAttribute("idn");
                if (confirm("delete??")) {
                  window.location.href = "./doDelete.php?id=" + btn;
                } else {
                  alert("阿不是要山");
                };

                console.log(e);
              })
            })
          </script>


          <script>
            // document.getElementsByClassName('setImg')[0].style.display = 'none';
            document.getElementById('imagePreviewAdd').style.display = 'none';

            function previewImageAdd() {
              const file = document.getElementById('imageFileAdd').files[0];
              const reader = new FileReader();


              reader.onloadend = function() {
                const imagePreview = document.getElementById('imagePreviewAdd');
                imagePreview.src = reader.result;
                // document.getElementsByClassName('setImg')[0].style.display = 'block';
                imagePreview.style.display = 'block';
              };

              if (file) {
                reader.readAsDataURL(file);
              } else {
                document.getElementById('imagePreview').style.display = 'none';
              }
            }
          </script>



          <!-- pass switch -->
          <script>
            function pass(e) {
              console.log(e);
              var triggeredElement = event.target;
              var parentElement = triggeredElement.parentNode;
              const pass = parentElement.querySelector("button");

              console.log(pass);

              // for (var i = 0; i < siblingElements.length; i++) {

              //   }
              pass.click();
            }
          </script>



          <script>
            document.getElementById('imagePreviewAdd').style.display = 'none';

            function previewImageAdd() {
              const file = document.getElementById('imageFileAdd').files[0];
              const reader = new FileReader();


              reader.onloadend = function() {
                const imagePreview = document.getElementById('imagePreviewAdd');
                imagePreview.src = reader.result;
                // document.getElementsByClassName('setImg')[0].style.display = 'block';
                imagePreview.style.display = 'block';
              };

              if (file) {
                reader.readAsDataURL(file);
              } else {
                document.getElementById('imagePreview').style.display = 'none';
              }
            }


            // const doDelete = document.querySelector(".delete");
            // doDelete.addEventListener("click",()=>{

            // })

            const add = document.querySelector(".btn-add");
            const area = document.querySelector(".contentArea");
            const template = document.querySelector("#inputs")
            let imgNumber = 0;
            document.getElementById('imagePreview' + imgNumber).style.display = 'none';
            document.getElementById('imageFile' + imgNumber).addEventListener("change", () => {
              const file = document.getElementById('imageFile' + imgNumber).files[0];
              const reader = new FileReader();
              reader.onloadend = function() {
                const imagePreview = document.getElementById('imagePreview' + imgNumber);
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
              };
              if (file) {
                reader.readAsDataURL(file);
              } else {
                document.getElementsByClassName('imagePreview').style.display = 'none';
              }
            })
          </script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>