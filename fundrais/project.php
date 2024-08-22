<?php
session_start();
if(!isset($_SESSION["user"])){
  header("location: ../login/login.php");
}
require_once("../conn.php");
// $mid=$_SESSION["user"]["id"];
// echo $id;

if (isset($_GET["switch"])) {
  $switch = $_GET["switch"];
  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    // $sqlSwitch="SELECT * FROM `project` WHERE `id`=1" ;
    if ($switch == 1) {
      $sqlSwitch = "UPDATE `project` SET `pass` = 0 WHERE `id` = $id;";
    } else {
      $sqlSwitch = "UPDATE `project` SET `pass` = 1 WHERE `id` = $id;";
    }
    $conn->query($sqlSwitch);
    // echo $switch;
  }
}

if (isset($_GET['query']) && !empty($_GET['query'])) {
  // 獲取搜尋關鍵字
  $query = $_GET['query'];

  $search = "`name` LIKE '%$query%' AND";
  // 顯示搜尋關鍵字


  // 示例: 在這裡你可以進行進一步的數據處理或查詢數據庫
  // 例如：使用 $query 來查詢數據庫並顯示結果
} else {
  $search = "";
  $query = "";
}





$cid = isset($_GET["cid"]) ? (int)$_GET["cid"] : 0;
if ($cid === 0) {
  $type = "";
} else {
  $type = "`type_id`= $cid AND";
}

if (isset($_GET['query']) && !empty($_GET['query'])) {
  // 獲取搜尋關鍵字
  $query = $_GET['query'];
  $queryType=isset($_GET['queryType'])?$_GET['queryType']:"name";
  

  $search = "`$queryType`  LIKE '%$query%' AND";
  // 顯示搜尋關鍵字


  //   // 示例: 在這裡你可以進行進一步的數據處理或查詢數據庫
  //   // 例如：使用 $query 來查詢數據庫並顯示結果
} else {
  $search = "";
  $query = "";
}

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$perPage = 10;
//$perPage = 10;
$pageStart = ($page - 1) * $perPage;


// $desc=true;
// if(isset($_GET["amount"])){
//   !$desc ;
//   echo $desc;
// }

$name="";
$order="";
$if=false;
// $a=$if;
if(isset($_GET["name"])){
  $name=$_GET["name"];
  if($_GET["if"]==1){ 
    $order="ORDER BY $name asc"; 
    $if=0;
  }else{
    $order="ORDER BY $name desc";
    $if=1;
  }
}




$sql = "SELECT *  FROM `project` WHERE    $search  $type    (`endtime` is NULL or `endtime` > NOW())  $order LIMIT $pageStart,$perPage";
$sqlAll = "SELECT *  FROM `project` WHERE  $search  $type   (`endtime` is NULL or `endtime` > NOW()) ";
$sqlType = "SELECT *  FROM `type`";
$sqlCate = "SELECT *  FROM `type`;";
try {
  $result = $conn->query($sql);
  $allResult = $conn->query($sqlAll);
  $typeResult = $conn->query($sqlType);
  $catResult = $conn->query($sqlCate);

  $projectNumber = $allResult->num_rows;
  // echo $projectNumber;
  $totlePage = ceil($projectNumber / $perPage);
  $Number = $result->num_rows;
  $rows = $result->fetch_all(MYSQLI_ASSOC);
  $typeRows = $typeResult->fetch_all(MYSQLI_ASSOC);
  $catRows = $catResult->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
  echo $e->getMessage();
}
// echo $Number;
$conn->close();
// var_dump($rows)
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

    .form-check-input:checked{
      border:none
    }
    .page-link {
      color:#333;
    }
    .active>.page-link{
      background-color: #333;
      border:1px solid #333;
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
    <div class="collapse show collapse-horizontal  sticky-top z-1 h100vh" id="collapseWidthExample">
      <nav class="w250px h100vh bg-dark p-2 rounded-end-5 ">
        <!-- >後台系統 -->
        <div class="my-4 mt-5">
          <h2 class="text-center text-light fw-bold"><i class="fa-solid fa-chart-line me-1 text-warning"></i>後台系統</h2>
        </div>
        <!-- 大頭照 -->
        <div>
          <img class="d-block m-auto rounded-circle mt-2 w150px h150px" src="../membersystem/php_image/<?=$_SESSION["user"]["img"]?>" alt="">
          <p class="text-white text-center my-2 fs-4"><?=$_SESSION["user"]["name"]?></p>

          <!-- <a href="../login/doout.php"> -->
            <button type="button" class="btn btn-outline-light d-block m-auto loginOut">
              <i class="fa-solid fa-right-from-bracket"></i>
            </button>
          <!-- </a> -->
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
                    <a href="../membersystem/memberSys.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">會員</a>
                  </div>
                  <div>
                    <a href="#" class="btn d-block bg-dark text-white rounded-0 border rounded-bottom">...</a>
                  </div>
                </div>
              </div>
            </div>
              <button class=" fw-bold  accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
              <i class="fa-solid fa-cart-shopping me-2" ></i>商城系統
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
              <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body p-0">
                <div class="d-grid  ">
                  <div>
                    <a href="./project.php" class="btn d-block bg-dark fw-bold text-white rounded-0 border">專案</a>
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
    <button class="btn btn-warning z-3   position-fixed start-0 top-0 mt-2 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="flex-grow-1 px-3 mb-5">
      <div class="d-flex p-5 justify-content-between">
        <div class="">
          <h2 class="fw-bold">Status</h2>
        </div>
        <div class="flex-grow">
          <form action="" method="get">
            <div class="input-group flex-nowrap">
              <div class="input-group-text">
                <select id="Select" name="queryType" class="form-select">
                  <option <?=isset($_GET["queryType"])?"":"selected"?> value="" disabled>請選擇</option>
                    <option <?=isset($_GET["queryType"])&&$_GET["queryType"]=="name"?"selected":""?>  value="name">name</option>
                    <option <?=isset($_GET["queryType"])&&$_GET["queryType"]=="amount"?"selected":""?> value="amount">account</option>
                    <option <?=isset($_GET["queryType"])&&$_GET["queryType"]=="directions"?"selected":""?> value="directions">directions</option>
                </select>
              </div>
              <input type="text" class="form-control  inputWidth" name="query" id="search" placeholder="搜尋專案名稱" aria-label="Username" aria-describedby="addon-wrapping" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
              <button class="input-group-text search" id="addon-wrapping "><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </form>
        </div>
        <div>
          <button type="button" class="btn btn-outline-dark"><i class="fa-solid fa-bell"></i></button>
        </div>
      </div>
      <div class="container border p-5 rounded-5 bg-light shadow">
        <div class="d-flex justify-content-between align-items-center">
          <p class="fs-3 fw-bold">
            <i class="fa-solid fa-table me-2"></i>Table
          </p>
          <p class=" fw-bold m-0 letter-spacing ms-5">共有<?= $projectNumber ?>筆資料</p>
          <div class="d-flex align-items-center">

            <a class="btn text-white btn-dark fw-bold me-3" href="./project.php">全部資料</a>
            <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">增加資料</button>

          </div>

        </div>

        <div class="nav nav-tabs mx-auto justify-content-center">
          <a class="nav-link fw-bold <?= $cid === 0 ? "active text-black fw-bold" : "text-black-50 fw-bold" ?>" href="?query=<?= isset($query)?$query:""?>&queryType=<?= isset($queryType)?$queryType:"" ?>">全部</a>
          <?php foreach ($typeRows as $typeRow) : ?>
            <a class=" nav-link fw-bold <?= $cid === (int)$typeRow["id"] ? "active text-black fw-bold" : "text-black-50 fw-bold" ?>" href="?cid=<?= $typeRow["id"] ?>&query=<?= isset($query)?$query:"" ?>&queryType=<?= isset($queryType)?$queryType:"" ?>"><?= isset($typeRow["name"])?$typeRow["name"]:"" ?></a>
          <?php endforeach; ?>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <table class="table table-hover ">
              <thead>
                <tr class="table-dark " style="border:none;">
                  <th class="index rounded-start-circle" scope="col">#</th>
                  <th class="id" scope="col">
                    <a class="a d-flex align-items-center rotate-link1" href="?name=id&page=<?=$page?>&cid=<?=$cid?>&if=<?=$if?>&queryType=<?= isset($queryType)?$queryType:""?>&query=<?= isset($query)?$query:"" ?>"> 
                      <i class="fa-solid fa-chevron-up me-1" id="link1"></i>id
                    </a>
                  </th>
                  <th class="ms_id" scope="col">ms_id</th>
                  <th class="name" scope="col">name</th>
                  <th class="amountDesc  " scope="col">
                    <a class="a d-flex align-items-center rotate-link2" href="?name=amount&page=<?=$page?>&cid=<?=$cid?>&if=<?=$if?>&queryType=<?= isset($queryType)?$queryType:""?>&query=<?= isset($query)?$query:"" ?>"> 
                      <i class="fa-solid fa-chevron-up me-1" id="amount"></i>amount
                    </a>
                  </th>
                  <th class="sponsors" scope="col">sponsors</th>
                  <th class="directions" scope="col">directions</th>
                  <th class="img" scope="col">img</th>
                  <th class="time" scope="col">time</th>
                  <th class="pass" scope="col">control</th>
                  <th class="success" scope="col">pass</th>
                  <th class="controls rounded-end-3" scope="col">controls</th>
                </tr>
              </thead>
              <tbody>
                <? if ($Number >= 0) : ?>
                  <?php foreach ($rows as $index => $row) : ?>
                    <tr>
                      <th scope="row"><?= $index + 1 ?></th>
                      <td><?= $row["id"] ?></td>
                      <td><?= $row["ms_id"] ?></td>
                      <td><?= $row["name"] ?></td>
                      <td><?= $row["amount"] ?></td>
                      <td><?= $row["sponsors"] ?></td>
                      <td><?= $row["directions"] ?></td>
                      <td><div class="w50px h50px bg-light overflow-hidden"><img class="rounded-2 w-100 object-fit-cover" src="./img/<?= $row["img"] ?>" alt=""></div></td>
                      <td><?= $row["time"] ?></td>
                      <td>
                        <form action="./project.php ">
                          <div class="form-check form-switch">
                            <input class="form-check-input pass bg-warning " type="checkbox" name="switch" role="switch" id="pass<?= $index + 1 ?>" <?= $row["pass"] == 1 ? "checked" : "" ?> onchange="pass(event)">
                            <label class="form-check-label" for="pass"></label>
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <input type="hidden" name="switch" value="<?= $row["pass"] ?>">
                            <button style="position:absolute;top:0;display:none" id="passSubmit<?= $index + 1 ?>"> <?= $row["pass"] ?></button>
                          </div>
                        </form>
                      </td>
                      <td class="align-items-center">
                        <? if($row["pass"]==1):?>
                          <i class="fa-regular fa-circle-check"></i>
                        <? else:?>
                          <i class="fa-regular fa-circle-xmark"></i>
                        <?endif?>
                      </td>
                      <td>
                        <!-- hover -->
                        <i class=" fa-solid fa-gear me-2 hover" data-bs-toggle="modal" data-bs-target="#setModal<?= $index ?>"></i>
                        <i class=" btn-del fa-solid fa-trash hover" idn="<?= $row["id"] ?>"></i>
                      </td>
                    </tr>


                    <div class="modal fade" id="setModal<?= $index ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">資料更改</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <?php if (!$row) : ?>
                              <h1>不存在</h1>
                              <a class="btn btn-primary btn-add" href=".index.php">資料列表</a>
                            <?php else : ?>
                              <div class="container mt-3">
                                <form action="doupdate01.php" method="post" enctype="multipart/form-data">
                                  <div class="">
                                    <div class="input-group">
                                      <span class="input-group-text">名稱</span>
                                      <input name="name" type="text" class="form-control" placeholder="發文者名稱" value="<?= isset($row) ? $row["name"] : "不存在" ?>">
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">內容</span>
                                      <textarea name="directions" class="form-control"><?= isset($row) ? $row["directions"] : "不存在" ?></textarea>
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">分類</span>
                                      <select name="type" class="form-select">
                                        <option value="xx" disabled>請選擇</option>
                                        <?php foreach ($catRows as $catrow) : ?>
                                          <option value="<?= $catrow["id"] ?> " <?= $row["type_id"] === $catrow["id"] ? "selected" : "" ?>>
                                            <?= $catrow["name"] ?>
                                          </option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                    <div class="input-group mb-3">
                                      <input class="form-control" type="file" name="myFile" id="imageFileSet<?= $index ?>" accept="image/*" onchange="previewImageSet()">
                                    </div>
                                  </div>
                                  <input name="id" type="hidden" value="<?= $row["id"] ?>">
                                  <input name="img" type="hidden" value="<?= $row["img"] ?>">
                                  <div class="d-flex">
                                    
                                      <div>
                                        <img class="rounded-3 h150px" src="./img/<?= $row["img"] ?>" alt="">
                                      </div>
                                      <div class=" align-middle setImg"><i class="fa-solid fa-arrow-right p-5 mt-4 d-flex align-items-center">更換成</i></div>
                                      <div>
                                        <img class="rounded-3 h150px" src="" alt="" id="imagePreviewSet<?= $index ?>">
                                      </div>
                                    
                                  </div>
                                 

                              </div>
                            <?php endif ?>
                          </div>
                          <div class="modal-footer">
                            <div class="mt-1 ms-auto">
                              <button type="submit" class="btn btn-outline-primary">送出</button>
                              <a class="btn btn-primary " href="./project.php">取消</a>
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
            <nav aria-label="..." class="d-flex justify-content-center mt-5">
          <ul class=" pagination pagination-sm">
            <? for ($i = 0; $i < $totlePage; $i++) : ?>
              <li class="me-1  page-item <?= $page === $i + 1 ? "active" : "" ?>" aria-current="page">
                <a href="?page=<?= $i + 1 ?><?= '&cid=' . $cid > 0 ? $cid : "" ?>" class="btn page-link "><?= $i + 1 ?></a>
              </li>
            <? endfor; ?>
          </ul>
        </nav>
          </div>

        </div>
      </div>
    </main>




    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">增加專案</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container mt-3">
              <form class="form-add" action="./doAdd.php" method="post" enctype="multipart/form-data">
                <div class="contentArea">
                  <div class="input-group">
                    <span class="input-group-text">名稱</span>
                    <input  name="name[]" type="text" class="form-control addName" placeholder="發文者名稱">
                    <div id="addNameCk" class="addNameCk input-group-text"></div>
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">內容</span>
                    <textarea id="addContent" name="directions[]" class="form-control"></textarea>
                    <div id="addContentCk" class="addContentCk input-group-text"></div>
                  </div>  
                  <div class="input-group">
                    <span class="input-group-text">金額</span>
                    <input id="addCount" name="amount[]" type="number" class="form-control addCount" placeholder="發文者名稱">
                    <div id="addCountCk" class="addContentCk input-group-text"></div>
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">分類</span>
                    <select id="addSelect" name="type[]" class="form-select">
                      <option value="xx" selected disabled>請選擇</option>
                      <?php foreach ($typeRows as $row) : ?>
                        <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div id="addSelectCk" class="addContentCk input-group-text"></div>
                  </div>
                  <div class="input-group mb-2">
                    <input class="form-control imageFile mb-4" type="file" name="myFile[]" id="imageFileAdd" accept="image/*" onchange="previewImageAdd()">
                    <div id="addImgCk" class="addContentCk mb-4  input-group-text"></div>
                  </div>
                  <img class="rounded-3 h150px ms-5 mb-4 imagePreview" id="imagePreviewAdd" src="" alt="">

                </div>




                <template id="inputs">
                  <button type="button" class="btn btn-outline-danger mb-3 delete">delete<i class="ml-2 fa-solid fa-arrow-down"></i></button>
                  <div class="input-group">
                    <span class="input-group-text">名稱</span>
                    <input name="name[]" type="text" class="form-control" placeholder="發文者名稱">
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">內容</span>
                    <textarea name="directions[]" class="form-control"></textarea>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text">金額</span>
                    <input name="amount[]" type="number" class="form-control" placeholder="發文者名稱">
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">分類</span>
                    <select name="type[]" class="form-select">
                      <option value="xx" selected disabled>請選擇</option>
                      <?php foreach ($typeRows as $row) : ?>
                        <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="input-group mb-1">
                    <input class="form-control " type="file" name="myFile[]" id="imageFileAdd" accept="image/*" onchange="previewImageAdd()">
                  </div>
                  <img class=" rounded-3 h150px ms-5 mb-4" id="imagePreviewAdd" src="" alt="">
                </template>



                <div class="modal-footer">
                  <div class="mt-1 text-end">
                    <button type="submit" class="btn btn-outline-primary mr-2">送出</button>
                    <button type="button" class="btn btn-outline-primary btn-add">增加專案</button>

                  </div>
              </form>
            </div>
          </div>
          <!-- <div class="modal-footer">
                              <div class="mt-1 text-end">
                                <button type="submit" class="btn btn-outline-primary mr-2">送出</button>
                                <button type="submit" class="btn btn-outline-primary btn-add">增加專案</button>
                                
                            </div> -->
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  <!-- <a class="btn btn-primary btn-sm me-1" href="../user/logout.php">登出</a> -->
  </div>



  </div>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->



  <script>





  



    // 登出 ../login/doout.php
    const loginOut = document.querySelector(".loginOut");
    loginOut.addEventListener("click",()=>{
      if (confirm("是否登出?")) {
          window.location.href = "../login/doout.php";
        } else {
          alert("登出失敗!");
        };
      
    })





    const btn_del = document.querySelectorAll(".btn-del");
    btn_del.forEach(btn => {
      btn.addEventListener("click", e => {
        let btn = e.target.getAttribute("idn");
        if (confirm("確定刪除?")) {
          window.location.href = "./doDelete.php?id=" + btn;
        } else {
          alert("刪除失敗!");
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
    // const doDelete = document.querySelector(".delete");
    // doDelete.addEventListener("click",()=>{

    // })
    
    const add = document.querySelector(".btn-add");
    const area = document.querySelector(".contentArea");
    const template = document.querySelector("#inputs")
    let imgNumber = 0;
    add.addEventListener("click", e => {
      e.preventDefault();
      imgNumber++;
      // const node = template.content.cloneNode(true);
      // area.append(node);


      const node = document.createElement("div");
      node.innerHTML = `
                <div class="input-group">
                    <span  class="input-group-text">名稱</span>
                    <input  id="addName${imgNumber}" name="name[]" type="text" class="form-control addName" placeholder="發文者名稱">
                    <div id="addNameCk${imgNumber}" class="addNameCk input-group-text"></div>
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">內容</span>
                    <textarea id="addContent${imgNumber}" name="directions[]" class="form-control"></textarea>
                    <div id="addContentCk${imgNumber}" class="addContentCk input-group-text"></div>
                  </div>  
                  <div class="input-group">
                    <span class="input-group-text">金額</span>
                    <input id="addCount${imgNumber}" name="amount[]" type="number" class="form-control addCount" placeholder="發文者名稱">
                    <div id="addCountCk${imgNumber}" class="addContentCk input-group-text"></div>
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">分類</span>
                    <select id="addSelect${imgNumber}" name="type[]" class="form-select">
                      <option value="xx" selected disabled>請選擇</option>
                      <?php foreach ($typeRows as $row) : ?>
                        <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div id="addSelectCk${imgNumber}" class="addContentCk input-group-text"></div>
                  </div>
                  <div class="input-group mb-3">
                    <input class="form-control imageFile mb-4" type="file" name="myFile[]" id="imageFile${imgNumber}" accept="image/*" ">
                    <div id="addImgCk${imgNumber}" class="addContentCk mb-4  input-group-text"></div>
                  </div>
                  <img class="rounded-3 h150px ms-5 mb-2 imagePreview" id="imagePreview${imgNumber}" src="" alt="">
                

                `;
      while (node.children[0]) {
        area.append(node.children[0]);
      }
      // area.append(node);
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



      // 判斷
        

        document.querySelector("#addNameCk"+imgNumber).innerHTML="請輸入名稱";  
        document.querySelector("#addNameCk"+imgNumber).style="background-color:red;color:white";  
        document.querySelector("#addName"+imgNumber).addEventListener("input",()=>{
          const regex = /^[A-Za-z0-9]{5,}$/;
          let addName = document.querySelector("#addName"+imgNumber);
          let addNameCk = document.querySelector("#addNameCk"+imgNumber);  
          if(addName.value ==""){
            addNameCk.innerHTML="請輸入名稱";
             addNameCk.style="background-color:red;color:white";
          }else if(!regex.test(addName.value)){
            addNameCk.innerHTML="字符串至少有5個字符長，且僅包含字母和數字，不能有空格或標點符號";
             addNameCk.style="background-color:red;color:white";
          }else{
            addNameCk.innerHTML="ok";
            addNameCk.style="background-color:green;color:white";
          }
        })

      



        document.querySelector("#addContentCk"+imgNumber).innerHTML="請輸入內容描述";
        document.querySelector("#addContentCk"+imgNumber).style="background-color:red;color:white";
        document.querySelector("#addContent"+imgNumber).addEventListener("input",()=>{
          let addContent = document.querySelector("#addContent"+imgNumber);
          let addContentCk = document.querySelector("#addContentCk"+imgNumber);
          const regex = /^.{20,}$/;
          console.log(addName.value);  
          if(addContent.value ==""){
            addContentCk.innerHTML="請輸入名稱";
            addContentCk.style="background-color:red;color:white"
          }else if(!regex.test(addContent.value)){
            addContentCk.innerHTML="字符串至少有20個字符長";
            addContentCk.style="background-color:red;color:white"
          }else{
            addContentCk.innerHTML="ok"
            addContentCk.style="background-color:green;color:white"
          }
        })


       

        
        document.querySelector("#addSelectCk"+imgNumber).innerHTML="請選擇分類"
        document.querySelector("#addSelectCk"+imgNumber).style="background-color:red;color:white"
        document.querySelector("#addSelect"+imgNumber).addEventListener("change",()=>{
          let addSelect = document.querySelector("#addSelect"+imgNumber);
          let addSelectCk = document.querySelector("#addSelectCk"+imgNumber);
          addSelectCk.innerHTML="ok"
          addSelectCk.style="background-color:green;color:white"
        })




        
        document.querySelector("#addCountCk"+imgNumber).innerHTML="請輸入金額"
        document.querySelector("#addCountCk"+imgNumber).style="background-color:red;color:white"
        document.querySelector("#addCount"+imgNumber).addEventListener("input",()=>{
          let addCount = document.querySelector("#addCount"+imgNumber);
          let addCountCk = document.querySelector("#addCountCk"+imgNumber);
          console.log(1);
          // const regex = /^.{20,}$/;
          console.log(addName.value);  
          if(addCount.value ==""){
            addCountCk.innerHTML="請輸入金額";
            addCountCk.style="background-color:red;color:white"
          }else if(addCount.value<3000){
            addCountCk.innerHTML="金額需大於3000";
            addCountCk.style="background-color:red;color:white"
          }else{
            addCountCk.innerHTML="ok"
            addCountCk.style="background-color:green;color:white"
          }

        })



        document.querySelector("#addImgCk"+imgNumber).innerHTML="請上傳圖檔"
        document.querySelector("#addImgCk"+imgNumber).style="background-color:red;color:white"
        document.querySelector("#imageFile"+imgNumber).addEventListener("change",()=>{
          let imageFileAdd = document.querySelector("#imageFile"+imgNumber);
          let addImgCk = document.querySelector("#addImgCk"+imgNumber);
          if(!(imageFileAdd.files[0])){
            addImgCk.innerHTML="請上傳圖檔";
            addImgCk.style="background-color:red;color:white"
          }else{
            addImgCk.innerHTML="ok"
            addImgCk.style="background-color:green;color:white"
          }

        })


    })



    // document.querySelector("#imagePreview").style.display = "none";


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
    // 資料輸入內容
              
            // const loginAccountCheck = document.querySelector(".loginAccountCheck");
            // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            // const check = emailRegex.test(loginAccount.value);
            // // accountCheck.innerHTML="輸入錯誤"
            // if(!check){
            //     loginAccountCheck.innerHTML="輸入錯誤"
            // }else{
            //     loginAccountCheck.innerHTML=""
            // }
            // } 
        let addName = document.querySelector(".addName");
        let addNameCk = document.querySelector("#addNameCk");  
        addNameCk.innerHTML="請輸入名稱"
        addNameCk.style="background-color:red;color:white"
        
        addName.addEventListener("input",()=>{
          const regex = /^[A-Za-z0-9]{5,}$/;
          // console.log(addName.value);
          
          if(addName.value ==""){
            addNameCk.innerHTML="請輸入名稱";
             addNameCk.style="background-color:red;color:white"
          }else if(!regex.test(addName.value)){
            addNameCk.innerHTML="字符串至少有5個字符長，且僅包含字母和數字，不能有空格或標點符號";
             addNameCk.style="background-color:red;color:white"
          }else{
            addNameCk.innerHTML="ok"
            addNameCk.style="background-color:green;color:white"
          }
        })

      


        let addContent = document.querySelector("#addContent");
        let addContentCk = document.querySelector("#addContentCk");
        addContentCk.innerHTML="請輸入內容描述"
        addContentCk.style="background-color:red;color:white"
        addContent.addEventListener("input",()=>{
          const regex = /^.{20,}$/;
          // console.log(addName.value);  
          if(addContent.value ==""){
            addContentCk.innerHTML="請輸入名稱";
            addContentCk.style="background-color:red;color:white"
          }else if(!regex.test(addContent.value)){
            addContentCk.innerHTML="字符串至少有20個字符長";
            addContentCk.style="background-color:red;color:white"
          }else{
            addContentCk.innerHTML="ok"
            addContentCk.style="background-color:green;color:white"
          }
        })


       

        let addSelect = document.querySelector("#addSelect");
        // console.log(addSelect );
        
        let addSelectCk = document.querySelector("#addSelectCk");
        
        addSelectCk.innerHTML="請選擇分類"
        addSelectCk.style="background-color:red;color:white"

        addSelect.addEventListener("change",()=>{
          console.log(1);
          
          addSelectCk.innerHTML="ok"
          addSelectCk.style="background-color:green;color:white"
        })




        let addCount = document.querySelector("#addCount");
        let addCountCk = document.querySelector("#addCountCk");
        addCountCk.innerHTML="請輸入金額"
        addCountCk.style="background-color:red;color:white"
        addCount.addEventListener("input",()=>{
          // console.log(1);
          // const regex = /^.{20,}$/;
          // console.log(addName.value);  
          if(addCount.value ==""){
            addCountCk.innerHTML="請輸入金額";
            addCountCk.style="background-color:red;color:white"
          }else if(addCount.value<3000){
            addCountCk.innerHTML="金額需大於3000";
            addCountCk.style="background-color:red;color:white"
          }else{
            addCountCk.innerHTML="ok"
            addCountCk.style="background-color:green;color:white"
          }

        })


        let imageFileAdd = document.querySelector("#imageFileAdd");
        let addImgCk = document.querySelector("#addImgCk");
        addImgCk.innerHTML="請上傳圖檔"
        addImgCk.style="background-color:red;color:white"
        imageFileAdd.addEventListener("change",()=>{
         
          if(!(imageFileAdd.files[0])){
            addImgCk.innerHTML="請上傳圖檔";
            addImgCk.style="background-color:red;color:white"
          }else{
            addImgCk.innerHTML="ok"
            addImgCk.style="background-color:green;color:white"
          }

        })
       



     
      document.querySelector('.rotate-link1').addEventListener('click', function(event) {
      sessionStorage.setItem('rotateLinkId', 1); // 存儲點擊的鏈接 ID

      // 檢查當前旋轉角度，默認為 0
      let currentRotation = parseInt(sessionStorage.getItem('rotation') || '0', 10);

      // 每次點擊增加 180 度
      currentRotation += 180;

      // 儲存新的旋轉角度
      sessionStorage.setItem('rotation', currentRotation);

      });
      
      window.addEventListener('DOMContentLoaded', function() {
        const rotateLinkId = sessionStorage.getItem('rotateLinkId'); // 獲取存儲的 ID
        console.log(123);
        // console.log(rotateLinkId);
        // console.log(rotateLinkId=="");
        
        let currentRotation = parseInt(sessionStorage.getItem('rotation') || '0', 10);
        if (rotateLinkId==1) {
            const linkToRotate = document.querySelector(".rotate-link1 i");
            console.log(1);
            
            if (linkToRotate) {

                linkToRotate.style.transform = `rotate(${currentRotation}deg)`
              

                // 可選：動畫完成後清除存儲的 ID
                // setTimeout(() => {
                //     sessionStorage.removeItem('rotateLinkId');
                // }, 500);
            }
        }

        // 2
        const rotateLinkId2 = sessionStorage.getItem('rotateLinkId2'); // 獲取存儲的 ID
        // console.log(rotateLinkId);
        // console.log(rotateLinkId=="");
        
        let currentRotation2 = parseInt(sessionStorage.getItem('rotation2') || '0', 10);
        if (rotateLinkId2==2) {
            const linkToRotate2 = document.querySelector(".rotate-link2 i");
            // console.log(1);
            
            if (linkToRotate2) {

                linkToRotate2.style.transform = `rotate(${currentRotation2}deg)`
              

                // 可選：動畫完成後清除存儲的 ID
                // setTimeout(() => {
                //     sessionStorage.removeItem('rotateLinkId');
                // }, 500);
            }
        }





    });

    
    document.querySelector('.rotate-link2').addEventListener('click', function(event) {
      sessionStorage.setItem('rotateLinkId2', 2); // 存儲點擊的鏈接 ID

      // 檢查當前旋轉角度，默認為 0
      let currentRotation2 = parseInt(sessionStorage.getItem('rotation2') || '0', 10);

      // 每次點擊增加 180 度
      currentRotation2 += 180;

      // 儲存新的旋轉角度
      sessionStorage.setItem('rotation2', currentRotation2);

      });
      






        window.addEventListener('load', function() {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
            }
        });

        


        window.addEventListener('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        });
    
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>