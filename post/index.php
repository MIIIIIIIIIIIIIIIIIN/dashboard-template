<?php

session_start();
if(!isset($_SESSION["user"])){
  header("location: ../login/login.php");
}

require_once("../conn.php");


if (isset($_GET['query']) && !empty($_GET['query'])) {
  // 獲取搜尋關鍵字
  $query = $_GET['query'];

  $search = "`title` LIKE '%$query%' AND";
  $search2 = "`body` LIKE '%$query%' AND";
  // 顯示搜尋關鍵字


  // 示例: 在這裡你可以進行進一步的數據處理或查詢數據庫
  // 例如：使用 $query 來查詢數據庫並顯示結果
} else {
  $search = "";
  $search2 = "";
  $query = "";
}

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1; //頁數
$perPage = 10; //分頁資料筆數
$pageStart = $perPage * ($page - 1); //改變分頁起始資料


$gid = isset($_GET["gid"]) ? (int)$_GET["gid"] : 0;

if ($gid === 0) {
  $genSQL = "";
} else {
  $genSQL = "`post_genre_id` = $gid AND";
}


$sql = "SELECT * FROM `post` WHERE $genSQL $search `isValid` = 1 OR $genSQL $search2 `isValid` = 1 LIMIT $pageStart, $perPage"; //LIMIT 限制單次顯示的資料筆數
$sqlAll = "SELECT * FROM `post` WHERE  $genSQL $search `isValid` = 1 OR $genSQL $search2 `isValid` = 1";
$sql2 = "SELECT * FROM `genre`";

try {
  $result = $conn->query($sql);
  $result2 = $conn->query($sql2);
  $resultAll = $conn->query($sqlAll);
  $msgCount = $resultAll->num_rows; //取用 resultAll 讓顯示筆數不受分頁筆數影響
  $rows = $result->fetch_all(MYSQLI_ASSOC); //使用 fetch_all 取出資料，變成關聯式陣列
  $genRows = $result2->fetch_all(MYSQLI_ASSOC);
  $totalPage = ceil($msgCount / $perPage); //資料總數除以每頁筆數，得出分頁數
} catch (mysqli_sql_exception $exception) {
  echo "資料讀取錯誤：" . $exception->getMessage();
  $msgCount = -1;
  //設定為-1是為了讓下方if判斷，並在錯誤時不顯示過多訊息
}
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
  </style>

</head>

<body>

  <body>
    <div>
      <div class="wave"></div>
      <div class="wave"></div>
      <div class="wave"></div>
    </div>
  </body>
  <div class="p-0 container-fluid d-flex  ">
    <!-- 要把collapse1 的1拿掉 -->
    <div class="collapse show collapse-horizontal rounded-end-5 sticky-top z-1 h100vh" id="collapseWidthExample">
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
              <button class=" fw-bold  accordion-button collapsed  show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
              <div id="collapseFour" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
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


    <!--  -->
    <button class="btn btn-warning z-3  position-fixed start-0 top-0 mt-2 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="flex-grow-1 px-3">
      <div class="d-flex p-5 justify-content-between">
        <div class="">
          <h2 class="fw-bold">Status</h2>
        </div>
        <div class="flex-grow">
          <form action="index.php" method="get">
            <div class="input-group flex-nowrap">
              <input type="text" class="form-control  inputWidth" name="query" id="search" placeholder="搜尋" aria-label="Username" aria-describedby="addon-wrapping" value="">
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
          <p class=" fw-bold m-0 letter-spacing ms-5">共有<?= $msgCount ?>筆資料</p>
          <div class="d-flex align-items-center">

            <a class="btn btn-outline-primary  me-3" href="./index.php">所有資料</a>
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">增加資料</button>

          </div>

        </div>
        <nav aria-label="..." class="d-flex justify-content-center mt-5">
          <ul class="pagination pagination-sm">
            <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?><?= $gid > 0 ? "&gid=$gid" : "" ?>" tabindex="-1">Previous</a>
            </li>
            <? for ($i = 1; $i <= $totalPage; $i++) : ?>
              <li class="page-item <?= $page === $i ? "active" : "" ?>" aria-current="page">
                <a href="?page=<?= $i ?><?= $gid > 0 ? "&gid=$gid" : "" ?>" class="page-link"><?= $i ?></a>
              </li>
            <? endfor; ?>
            <li class="page-item <?= $page >= $totalPage ? "disabled" : "" ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?><?= $gid > 0 ? "&gid=$gid" : "" ?>">Next</a>
            </li>
          </ul>
        </nav>


        <div class="nav nav-tabs mx-auto justify-content-center">
          <a class="nav-link fw-bold <?= $gid === 0 ? "active text-black" : "text-black-50" ?>" href="./index.php?gid=0 &query=<?= $query ?>">全部</a>
          <? foreach ($genRows as $genRow) : ?>
            <a class=" nav-link fw-bold <?= $gid === (int)$genRow["genre_id"] ? "active text-black" : "text-black-50" ?>" href="?gid=<?= $genRow["genre_id"] ?>&query=<?= $query ?>"><?= $genRow["genre"] ?></a>
          <? endforeach; ?>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <table class="table table-hover">
              <thead>
                <tr class="table-dark">
                  <th class="index" scope="col">#</th>
                  <th class="post_id" scope="col">id</th>
                  <th class="title" scope="col">title</th>
                  <th class="body" scope="col">body</th>
                  <th class="member_id" scope="col">membership_id</th>
                  <th class="genre" scope="col">post_genre_id</th>
                  <th class="img" scope="col">img</th>
                  <th class="time" scope="col">time</th>
                  <th class="ctrls" scope="col">control</th>
                </tr>
              </thead>
              <tbody>
                <? if ($msgCount >= 0) : ?>
                  <? foreach ($rows as $index => $row) : ?>
                    <tr>
                      <th scope="row"><?= $index + 1 ?></th>
                      <td><?= $row["post_id"] ?></td>
                      <td><?= $row["title"] ?></td>
                      <td><?= $row["body"] ?></td>
                      <td><?= $row["membership_id"] ?></td>
                      <td>
                        <?= $postGenre = "";
                        foreach ($genRows as $genRow) {
                          if ($row["post_genre_id"] == $genRow["genre_id"]) {
                            $postGenre = $genRow["genre"];
                            break;
                          }
                        }
                        echo $postGenre;
                        ?>
                      </td>
                      <td>
                        <div class="w50px h50px bg-light overflow-hidden align-content-center"><img class="w-100 object-fit-cover" src="./upload/<?= $row["img"] ?>" alt=""></div>
                      </td>
                      <td><?= $row["created_at"] ?></td>

                      <td>
                        <!-- hover -->
                        <i class=" fa-solid fa-gear me-2 hover" data-bs-toggle="modal" data-bs-target="#setModal<?= $index ?>"></i>
                        <i class=" btn-del fa-solid fa-trash hover" idn="<?= $row["post_id"] ?>"></i>
                      </td>
                    </tr>

                    <div class="modal fade" id="setModal<?= $index ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <? if (!$row) : ?>
                              <h1>不存在</h1>
                              <a class="btn btn-primary btn-add" href=".index.php">資料列表</a>
                            <? else : ?>
                              <div class="container mt-3">
                                <form action="doUpdate01.php" method="post" enctype="multipart/form-data">
                                  <div class="contentArea">
                                    <div class="input-group">
                                      <span class="input-group-text">會員</span>
                                      <input readonly name="membership_id" type="text" class="form-control" placeholder="發文者名稱" value="<?= $row["membership_id"] ?>">
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">標題</span>
                                      <textarea name="title" class="form-control"><?= $row["title"] ?></textarea>
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">內容</span>
                                      <textarea name="body" class="form-control"><?= $row["body"] ?></textarea>
                                    </div>
                                    <div class="input-group mt-1 mb-1">
                                      <span class="input-group-text">分類</span>
                                      <select name="genre" class="form-select">
                                        <option value="XX" selected disabled>請選擇</option>
                                        <? foreach ($genRows as $genRow) : ?>
                                          <option <?= $genRow["genre_id"] === $row["post_genre_id"] ? "selected" : "" ?> value="<?= $genRow["genre_id"] ?>"><?= $genRow["genre"] ?></option>
                                        <? endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="input-group mb-3">
                                    <input class="form-control" type="file" name="myFile" accept="image/*" id="imageFileSet<?= $index ?>" onchange="previewImageSet()">
                                  </div>
                                  <input name="post_id" type="hidden" value="<?= $row["post_id"] ?>">
                                  <input name="img" type="hidden" value="<?= $row["img"] ?>">
                                  <div class="d-flex">
                                    <? if ($row["img"] != "") : ?>
                                      <div>
                                        <img style="width:400px; object-fit: contain" class="" src="./upload/<?= $row["img"] ?>" alt="">
                                      </div>
                                      <div class="align-middle setImg"><i class="fa-solid fa-arrow-right p-5 mt-5 d-flex align-items-center">更換成</i></div>
                                      <div>
                                        <img style="width:400px; object-fit: contain" class="" src="" alt="" id="imagePreviewSet<?= $index ?>">
                                      </div>
                                    <? endif; ?>
                                  </div>
                              </div>
                            <? endif ?>
                          </div>
                          <div class="modal-footer">
                            <div class="mt-1 ms-auto">
                              <button type="submit" class="btn btn-outline-primary">更新</button>
                              <a class="btn btn-primary btn-add" href="index.php">取消</a>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  <? endforeach; ?>
                <? endif ?>

              </tbody>
            </table>
            <nav aria-label="..." class="d-flex justify-content-center mt-5">
              <ul class="pagination pagination-sm">
                <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                  <a class="page-link" href="?page=<?= $page - 1 ?><?= $gid > 0 ? "&gid=$gid" : "" ?>" tabindex="-1">Previous</a>
                </li>
                <? for ($i = 1; $i <= $totalPage; $i++) : ?>
                  <li class="page-item <?= $page === $i ? "active" : "" ?>" aria-current="page">
                    <a href="?page=<?= $i ?><?= $gid > 0 ? "&gid=$gid" : "" ?>" class="page-link"><?= $i ?></a>
                  </li>
                <? endfor; ?>
                <li class="page-item <?= $page >= $totalPage ? "disabled" : "" ?>">
                  <a class="page-link" href="?page=<?= $page + 1 ?><?= $gid > 0 ? "&gid=$gid" : "" ?>">Next</a>
                </li>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">新增資料</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container mt-3">
              <form action="./DoInsert02.php" method="post" enctype="multipart/form-data">
                <div class="content-area">
                  <!-- <div class="input-group">
                    <span class="input-group-text">名稱</span>
                    <input name="name[]" type="text" class="form-control" placeholder="發文者名稱">
                </div> -->
                  <div class="input-group">
                    <span class="input-group-text">會員</span>
                    <input name="membership_id[]" type="text" class="form-control">
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">標題</span>
                    <input name="title[]" type="text" class="form-control">
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">內文</span>
                    <textarea name="body[]" class="form-control"></textarea>
                  </div>
                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">分類</span>
                    <select name="genre[]" class="form-select">
                      <option value="XX" selected disabled>請選擇</option>
                      <? foreach ($genRows as $row) : ?>
                        <option value="<?= $row["genre_id"] ?>"><?= $row["genre"] ?></option>
                      <? endforeach; ?>
                    </select>
                  </div>

                  <div class="input-group mb-3">
                    <input class="form-control" type="file" name="myFile[]" accept="image/*" onchange="previewImageSet()">
                  </div>
                </div>
                <div class="mt-1 text-end">
                  <button type="submit" class="btn btn-info">新增</button>
                  <a class="btn btn-primary btn-add" href="index.php">取消</a>
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
    const btnDels = document.querySelectorAll(".btn-del");
    //使用 arrow function 製作刪除前警語
    btnDels.forEach(btnDel => {
      btnDel.addEventListener("click", (e) => {
        let id = e.target.getAttribute("idn");
        if (confirm("確定要刪除嗎") === true) {
          // window.location.href = `doDelete01.php?id=${id}`; //另一種寫法
          window.location.href = "doDelete02.php?post_id=" + id;
        }
      })
    });
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>