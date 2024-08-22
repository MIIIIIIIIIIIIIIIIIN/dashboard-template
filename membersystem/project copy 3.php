<?php
require_once("../conn.php");


if (isset($_GET["switch"])) {
  $switch = $_GET["switch"];
  if(isset($_GET["id"])){
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

  $search = "`name` LIKE '%$query%' AND";
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




$sql = "SELECT *  FROM `project` WHERE $search  $type   (`endtime` is NULL or `endtime` > NOW()) LIMIT $pageStart,$perPage";
$sqlAll = "SELECT *  FROM `project` WHERE $search  $type   (`endtime` is NULL or `endtime` > NOW()) ";
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="../css/reset.css"> -->
  <link rel="stylesheet" href="../css/style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



</head>

<body>

  <header class="position-sticky top-0 z-3 container-fluid bg-dark py-2 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <a href="#" class="text-light mr-3">logo</a>
      <div class="toogle text-light btn" id="toggle-sidebar"><i class="fa-solid fa-bars"></i></div>
    </div>
    <div class="member text-light  d-flex">
      <i class="fa-solid fa-user d-flex align-items-center btn  btn-primary btn-lg"></i>
      <p class="ml-2 mb-0 align-content-center">cindy</p>
    </div>
  </header>

  <main class="">
    <div class="sidebar " id="sidebar">
      <h2 class="text-center">system</h2>
      <div class="mem">
        <a href="#" class="align-items-center" id="toggle-feature"><i class="fas fa-home d-inline-block mr-1"></i> 募資系統<i class="d-inline-block ml-5 fa-solid fa-chevron-right " id="m-r"></i></a>
        <div id="feature" class="feature hidden ">
          <ul class="pb-2 border-bottom">
            <li>專案</li>
            <li>方案</li>
            <li>常見問題</li>
          </ul>
        </div>
      </div>

      <!-- <a href="#"><i class="fas fa-user"></i> Profile</a>
          <a href="#"><i class="fas fa-envelope"></i> Messages</a>
          <a href="#"><i class="fas fa-cog"></i> Settings</a> -->
    </div>
    <div class="info">
      <section class="data_table text-center">
        <h2>( 專案資料 )</h2>
        <div class="table_container">
          <div class="container ">
            <h1>訊息列表</h1>
            <?php

            echo "<h3>搜尋結果</h3>";
            echo "<p>您搜尋的關鍵字是: " . htmlspecialchars($query) . "</p>";

            ?>
            <form action="" method="get">
              <div class="input-group flex-nowrap">
                <input type="text" class="form-control" name="query" id="search" placeholder="搜尋專案名稱" aria-label="Username" aria-describedby="addon-wrapping" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                <button class="input-group-text search" id="addon-wrapping "><i class="fa-solid fa-magnifying-glass"></i></button>
              </div>
            </form>
            <div class="my-2 d-flex">
              <span class="me-auto">目前共 <?= $projectNumber ?> 筆資料</span>

              <a class="btn btn-primary  me-1" href="./project copy 3.php">全部資料</a>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">增加資料</button>
              <!-- Button trigger modal -->



              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">增加專案</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="container mt-3">
                        <form action="./doAdd.php" method="post" enctype="multipart/form-data">
                          <div class="contentArea">
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
                            <div class="input-group mb-2">
                              <input class="form-control imageFile" type="file" name="myFile[]" id="imageFileAdd" accept="image/*" onchange="previewImageAdd()">
                            </div>

                            <img class=" ms-5 mb-2 imagePreview" id="imagePreviewAdd" src="" alt="">
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
                            <img class="size ms-5 mb-4" id="imagePreviewAdd" src="" alt="">

                          </template>
                          <div class="modal-footer">
                            <div class="mt-1 text-end">
                              <button type="submit" class="btn btn-outline-primary mr-2">送出</button>
                              <button type="button" class="btn btn-outline-primary btn-add">增加專案</button>

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
          <div class="nav nav-tabs">
            <a class="nav-link <?= $cid === 0 ? "active text-black" : "text-black-50" ?>" href="?query=<?= $query ?>">全部</a>
            <?php foreach ($typeRows as $typeRow) : ?>
              <a class=" nav-link <?= $cid === (int)$typeRow["id"] ? "active text-black" : "text-black-50" ?>" href="?cid=<?= $typeRow["id"] ?>&query=<?= $query ?>"><?= $typeRow["name"] ?></a>
            <?php endforeach; ?>
          </div>

          <div class="msg text-bg-dark ps-1">
            <div class="index">#</div>
            <div class="id">id</div>
            <div class="ms_id">ms_id</div>
            <div class="name">name</div>
            <div class="amount">amount</div>
            <div class="sponsors">sponsors</div>
            <div class="directions">directions</div>
            <div class="img">img</div>
            <div class="time">time</div>
            <div class="pass">pass</div>
            <div class="success">success</div>
            <div class="controls">controls</div>
          </div>
          <!-- while重複動作並賦值後判斷$result是否還有資料 -->
          <? if ($Number >= 0) : ?>
            <?php foreach ($rows as $index => $row) : ?>
              <div class="msg mb-10 mt-2">
                <div class="index"><?= $index + 1 ?></div>
                <div class="id"><?= $row["id"] ?></div>
                <div class="ms_id"><?= $row["ms_id"] ?></div>
                <div class="name"><?= $row["name"]; ?></div>
                <div class="amount"><?= $row["amount"] ?></div>
                <div class="sponsors"><?= $row["sponsors"] ?></div>
                <div class="directions"><?= $row["directions"] ?></div>
                <div class="img "><img class="size" src="../img/<?= $row["img"] ?>" alt=""></div>
                <div class="time"><?= $row["time"] ?></div>

                <div class="pass">
                  <form action="./project copy 3.php ">
                    <div class="form-check form-switch">
                      <input class="form-check-input pass" type="checkbox" name="switch" role="switch" id="pass<?= $index + 1 ?>" <?= $row["pass"] == 1 ? "checked" : "" ?> onchange="pass(event)">
                      <label class="form-check-label" for="pass"></label>

                      <input type="hidden" name="id" value="<?= $row["id"] ?>">
                      <input type="hidden" name="switch" value="<?= $row["pass"] ?>">
                      <button style="position:absolute;top:0;display:none" id="passSubmit<?= $index + 1 ?>"> <?= $row["pass"] ?></button>
                    </div>
                  </form>
                </div>
                <div class="success "><?= $row["success"] ?></div>
                <div class="controls  mb-2">
                  <!-- <a href="../del/doDelete01.php?id=<?= $row["id"] ?>" class=" btn btn-danger btn-sm">delete</a> -->
                  <div class=" btn   btn-del" idn="<?= $row["id"] ?>"> <i class="fa-solid fa-circle-xmark fa-lg d-inline-block" style="color: #ff0000;"></i></div>

                  <div  class=" btn" data-bs-toggle="modal" data-bs-target="#setModal<?=$index?>"><i class="fa-solid fa-gear"></i></div>

                  <!-- Button trigger modal -->
                  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setModal">
                        Launch demo modal
                      </button> -->

                  <!-- Modal -->
                  <div class="modal fade" id="setModal<?=$index?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <?php if (!$row) : ?>
                            <h1>不存在</h1>
                            <a class="btn btn-primary btn-add" href=".index.php">資料列表</a>
                          <?php else : ?>
                            <div class="container mt-3">
                              <form action="doupdate01.php" method="post" enctype="multipart/form-data">
                                <div class="contentArea">
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
                                    <input class="form-control" type="file" name="myFile" id="imageFileSet<?=$index?>" accept="image/*" onchange="previewImageSet()">
                                  </div>
                                </div>
                                <input name="id" type="hidden" value="<?=$row["id"] ?>">
                                <input name="img" type="hidden" value="<?= $row["img"] ?>">
                                <div class="d-flex">
                                <? if ($row["img"] != "" ) : ?>
                                  <div>
                                    <img class="" src="../img/<?= $row["img"] ?>" alt="">
                                  </div>
                                  <div class="align-middle setImg"><i class="fa-solid fa-arrow-right p-5 mt-5 d-flex align-items-center">更換成</i></div>
                                  <div>
                                    <img class="" src="" alt="" id="imagePreviewSet<?=$index?>">
                                  </div>
                                <? endif; ?>
                              </div>
                              
                          
                            </div>
                          <?php endif ?>
                          </div>
                          <div class="modal-footer">
                          <div class="mt-1 ms-auto">
                                  <button type="submit" class="btn btn-outline-primary">送出</button>
                                  <a class="btn btn-primary btn-add" href="./project copy 3.php">取消</a>
                                </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            <?php endforeach; ?>
          <? endif ?>

        </div>

        <nav aria-label="..." class="d-flex justify-content-center mt-5">
          <ul class="pagination pagination-sm">
            <? for ($i = 0; $i < $totlePage; $i++) : ?>
              <li class=" page-item <?= $page === $i + 1 ? "active" : "" ?>" aria-current="page">
                <a href="?page=<?= $i + 1 ?><?= '&cid=' . $cid > 0 ? $cid : "" ?>" class="page-link"><?= $i + 1 ?></a>
              </li>
            <? endfor; ?>
          </ul>
        </nav>
      </section>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
            
            
            reader.onloadend = function () {
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
      node.innerHTML = `        <div class="input-group">
                    <span class="input-group-text">名稱</span>
                    <input name="name[]" type="text" class="form-control" placeholder="發文者名稱">
                </div>
                <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">內容</span>
                    <textarea name="content[]" class="form-control"></textarea>
                </div>
                <div class="input-group mt-1 mb-1">
                <span class="input-group-text">分類</span>
                <select name="category[]" class="form-select">
                    <option value selected disabled>請選擇</option>
                    <?php foreach ($typeRows as $row) : ?>
                                  <option value="<?= $row["id"] ?>"><?= $row["name"] ?></option>
                     <?php endforeach; ?>
                </select>
                </div> 
                 <div class="input-group mb-2">
                    <input class="form-control " type="file" name="myFile[]" id="imageFile${imgNumber}" accept="image/*" ">
                  </div>
                  <img class="size ms-5 mb-2 imagePreview" id="imagePreview${imgNumber}" src="" alt="">
                

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

    })



    // document.querySelector("#imagePreview").style.display = "none";

      
    function previewImageSet() {
      for(let i=0;i<10;i++){
      const file = document.querySelector("#imageFileSet"+i).files[0];
      
      const reader = new FileReader();
      reader.onloadend = function() {
        const imagePreview = document.getElementById('imagePreviewSet'+i);
        imagePreview.src = reader.result;
        imagePreview.style.display = 'block';
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        document.getElementById("imagePreviewSet"+i).style.display = "none";
      }
    }
  }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>