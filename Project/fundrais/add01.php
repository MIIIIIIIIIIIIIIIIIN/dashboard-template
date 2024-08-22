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
  $conn->close();
}
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



</head>

<body>
  <div class="p-0 container-fluid d-flex">
    <!-- 要把collapse1 的1拿掉 -->
    <div class="collapse collapse-horizontal rounded-end-5 sticky-top z-1 h100vh" id="collapseWidthExample">
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
            <i class="fa-solid fa-table me-2"></i>商品資料建立
          </p>
          <p class=" fw-bold m-0 letter-spacing ms-5"></p>
          <div class="d-flex align-items-center">
            <!-- <a class="btn btn-outline-primary  me-3" href="./index.php">123</a>
            <a class="btn btn-outline-success" href="./add.php">123</a> -->
          </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="container mt-3">
              <form action="./doInsert.php" method="post" enctype="multipart/form-data" id="productsForm">
                <!-- enctype="multipart/form-data一定要加阿 否則傳過去myFile會Undefined -->
                <div class="content-area">
                  <div class="input-group">
                    <span class="input-group-text">產品名稱</span>
                    <input name="productsname[]" type="text" class="form-control" placeholder="請輸入產品中文名稱" id="productsName">
                  </div>
                  <div class="errorName" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填寫產品名稱</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;價&ensp;&ensp;格&ensp;</span>
                    <input name="productsprice[]" type="text" class="form-control" placeholder="請輸入金額" id="productsPrice">
                  </div>
                  <div class="errorprice" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入金額(請填入數字)</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">建立時間</span>
                    <input name="productsdate[]" type="date" class="form-control" id="productsdate">
                  </div>
                  <div class="errordate" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需選擇日期</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;顏&ensp;&ensp;色&ensp;</span>
                    <input name="productscolor[]" type="text" class="form-control" placeholder="請填入顏色" id="productsColor">
                  </div>
                  <div class="errorcolor" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入產品顏色</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;尺&ensp;&ensp;寸&ensp;</span>
                    <input name="productssize[]" type="text" class="form-control" placeholder="請填入尺寸" id="productsSize">
                  </div>
                  <div class="errorsize" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入產品尺寸</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;數&ensp;&ensp;量&ensp;</span>
                    <input name="productsquantity[]" type="text" class="form-control" placeholder="請填入數量" id="productsQuantity">
                  </div>
                  <div class="errorquantity" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入數量</div>

                  <div class="input-group">
                    <span class="input-group-text">訂單編號</span>
                    <input name="productsnumber[]" type="text" class="form-control" placeholder="請填入訂單編號" id="productsNumber">
                  </div>
                  <div class="errornumber" style="color: red; display: none; font-size: 12px; font-weight: bold;">請確認訂單編號</div>


                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品描述</span>
                    <textarea name="productsdescription[]" class="form-control" id="productsDescription"></textarea>
                  </div>
                  <div class="errordescription" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填寫產品描述</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;產&ensp;&ensp;地&ensp;</span>
                    <input name="productsorigin[]" type="text" class="form-control" placeholder="請輸入產地" id="productsOrigin">
                  </div>
                  <div class="errororigin" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入出產地</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">出貨地址</span>
                    <input name="productsaddress[]" type="text" class="form-control" placeholder="請填入詳細地址" id="productsAddress">
                  </div>
                  <div class="erroraddress" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入出貨地址</div>


                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品分類</span>
                    <select name="productscategoryid[]" class="form-select" id="productsCategory">
                      <option value="XX" selected disabled>請選擇</option>
                      <? foreach ($rows as $row): ?>
                        <option value="<?= $row["id"] ?>"><?= $row["category_name"] ?></option>
                      <? endforeach ?>
                    </select>
                  </div>
                  <div class="errorcategory" style="color: red; display: none; font-size: 12px; font-weight: bold;">請選擇分類</div>


                  <div class="input-group mb-3">
                    <input class="form-control" type="file" name="myFile[]" accept="image/*" id="productsImage">
                  </div>
                  <div class="errorimg" style="color: red; display: none; font-size: 12px; font-weight: bold;">請上傳圖片</div>
                </div>
                <div class="mt-1 text-end">
                  <a class="btn btn-dark" href="./index.php">返回資料頁</a>
                  <button type="submit" class="btn btn-dark btn-add">增加一組</button>
                  <button type="submit" class="btn btn-success">送出</button>
                </div>
              </form>
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
    // Delete alert
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

  <script>
    // 增加一組
    const btnAdd = document.querySelector(".btn-add");
    const contentArea = document.querySelector(".content-area");
    const template = document.querySelector("#inputs");
    const today = new Date().toISOString().split('T')[0];
    let pain = 0;
    btnAdd.addEventListener("click", e => {
      e.preventDefault();
      pain++;
      // contentArea.append(node);
      const node = document.createElement("div");
      console.log(node);
      
      node.innerHTML = `<div class="template-container" id="addtag${pain}">
                  <div class="d-flex justify-content-end">
                    <button type="button" class="border-0 bg-light w20px" id="btnoff${pain}"><i class="fa-regular fa-circle-xmark ms-auto fs-5 font-weight-bold"></i></button>
                  </div>
                  <div class="input-group">
                    <span class="input-group-text">產品名稱</span>
                    <input name="productsname[]" type="text" class="form-control" placeholder="請輸入產品中文名稱" id="productsName${pain}">
                  </div>
                  <div class="errorName${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填寫產品名稱</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;價&ensp;&ensp;格&ensp;</span>
                    <input name="productsprice[]" type="text" class="form-control" placeholder="請輸入金額" id="productsPrice${pain}">
                  </div>
                  <div class="errorprice${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入金額(請填入數字)</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">建立時間</span>
                    <input name="productsdate[]" type="date" class="form-control" id="productsdate${pain}">
                  </div>
                  <div class="errordate${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需選擇日期</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;顏&ensp;&ensp;色&ensp;</span>
                    <input name="productscolor[]" type="text" class="form-control" placeholder="請填入顏色" id="productsColor${pain}">
                  </div>
                  <div class="errorcolor${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入產品顏色</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;尺&ensp;&ensp;寸&ensp;</span>
                    <input name="productssize[]" type="text" class="form-control" placeholder="請填入尺寸" id="productsSize${pain}">
                  </div>
                  <div class="errorsize${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入產品尺寸</div>

                  <div class="input-group mb-1">
                    <span class="input-group-text">&ensp;數&ensp;&ensp;量&ensp;</span>
                    <input name="productsquantity[]" type="text" class="form-control" placeholder="請填入數量" id="productsQuantity${pain}">
                  </div>
                  <div class="errorquantity${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入數量</div>

                  <div class="input-group">
                    <span class="input-group-text">訂單編號</span>
                    <input name="productsnumber[]" type="text" class="form-control" placeholder="請填入訂單編號" id="productsNumber${pain}">
                  </div>
                  <div class="errornumber${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">請確認訂單編號</div>


                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品描述</span>
                    <textarea name="productsdescription[]" class="form-control" id="productsDescription${pain}"></textarea>
                  </div>
                  <div class="errordescription${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填寫產品描述</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">&ensp;產&ensp;&ensp;地&ensp;</span>
                    <input name="productsorigin[]" type="text" class="form-control" placeholder="請輸入產地" id="productsOrigin${pain}">
                  </div>
                  <div class="errororigin${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入出產地</div>

                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">出貨地址</span>
                    <input name="productsaddress[]" type="text" class="form-control" placeholder="請填入詳細地址" id="productsAddress${pain}">
                  </div>
                  <div class="erroraddress${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">此欄位需填入出貨地址</div>


                  <div class="input-group mt-1 mb-1">
                    <span class="input-group-text">產品分類</span>
                    <select name="productscategoryid[]" class="form-select" id="productsCategory${pain}">
                      <option value="XX" selected disabled>請選擇</option>
                      <? foreach ($rows as $row): ?>
                        <option value="<?= $row["id"] ?>"><?= $row["category_name"] ?></option>
                      <? endforeach ?>
                    </select>
                  </div>
                  <div class="errorcategory${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">請選擇分類</div>


                  <div class="input-group mb-3">
                    <input class="form-control" type="file" name="myFile[]" accept="image/*" id="productsImage${pain}">
                  </div>
                  <div class="errorimg${pain}" style="color: red; display: none; font-size: 12px; font-weight: bold;">請上傳圖片</div>
                </div>
                </div>`;
                while (node.children[0]) {
                contentArea.append(node.children[0]);
                  };
                  // 刪除增加組數
                  let addtag = document.getElementById('addtag'+pain);
                  let btnoff = document.getElementById('btnoff'+pain);
                  console.log(addtag);
                  console.log(btnoff);
                  btnoff.addEventListener('click', (dlt) => {
                    addtag.innerHTML = ""
                  })


                  // 產品名稱警示
                  let productsName = document.getElementById("productsName"+pain)
                  productsName.addEventListener("focus", (aa) => {
                  let errorName = document.querySelector(".errorName"+pain);
                    errorName.style.display = "none";
                    productsName.addEventListener("input", (addalertName) => {
                      if (productsName.value.trim() == "") {
                        errorName.style.display = "block";
                      } else {
                        errorName.style.display = "none";
                      }
                      productsName.addEventListener("blur", () => {
                        let errorName = document.querySelector(".errorName"+pain);
                        errorName.style.display = "none";
                        productsName.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });

                  // 價格名稱警示
                  let productsPrice = document.getElementById("productsPrice"+pain)
                  productsPrice.addEventListener("focus", (aa) => {
                  let errorPrice = document.querySelector(".errorprice"+pain);
                  errorPrice.style.display = "none";
                    productsPrice.addEventListener("input", (addalertName) => {
                      if (isNaN(productsPrice.value) || productsPrice.value.trim() == "") {
                        errorPrice.style.display = "block";
                      } else {
                        errorPrice.style.display = "none";
                      }
                      productsPrice.addEventListener("blur", () => {
                        let errorPrice = document.querySelector(".errorprice"+pain);
                        errorPrice.style.display = "none";
                        productsPrice.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // date
                  let productsDate = document.getElementById("productsdate"+pain)
                  productsDate.addEventListener("focus", (aa) => {
                  let errorDate = document.querySelector(".errordate"+pain);
                  errorDate.style.display = "none";
                  productsDate.addEventListener("input", (addalertName) => {
                      if (productsDate.value.trim() == "") {
                        errorDate.style.display = "block";
                      } else {
                        errorDate.style.display = "none";
                      }
                      productsDate.addEventListener("blur", () => {
                        let errorDate = document.querySelector(".errordate"+pain);
                        errorDate.style.display = "none";
                        productsDate.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // color
                  let productsColor = document.getElementById("productsColor"+pain)
                  productsColor.addEventListener("focus", (aa) => {
                  let errorColor = document.querySelector(".errorcolor"+pain);
                  errorColor.style.display = "none";
                  productsColor.addEventListener("input", (addalertName) => {
                      if (productsColor.value.trim() == "") {
                        errorColor.style.display = "block";
                      } else {
                        errorColor.style.display = "none";
                      }
                      productsColor.addEventListener("blur", () => {
                        let errorColor = document.querySelector(".errorcolor"+pain);
                        errorColor.style.display = "none";
                        productsColor.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // size
                  let productsSize = document.getElementById("productsSize"+pain)
                  productsSize.addEventListener("focus", (aa) => {
                  let errorSize = document.querySelector(".errorsize"+pain);
                  errorSize.style.display = "none";
                  productsSize.addEventListener("input", (addalertName) => {
                      if (productsSize.value.trim() == "") {
                        errorSize.style.display = "block";
                      } else {
                        errorSize.style.display = "none";
                      }
                      productsSize.addEventListener("blur", () => {
                        let errorSize = document.querySelector(".errorsize"+pain);
                        errorSize.style.display = "none";
                        productsSize.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // quantity
                  let productsQuantity = document.getElementById("productsQuantity"+pain)
                  productsQuantity.addEventListener("focus", (aa) => {
                  let errorQuantity = document.querySelector(".errorquantity"+pain);
                  errorQuantity.style.display = "none";
                  productsQuantity.addEventListener("input", (addalertName) => {
                      if (productsQuantity.value.trim() == "") {
                        errorQuantity.style.display = "block";
                      } else {
                        errorQuantity.style.display = "none";
                      }
                      productsQuantity.addEventListener("blur", () => {
                        let errorQuantity = document.querySelector(".errorquantity"+pain);
                        errorQuantity.style.display = "none";
                        productsQuantity.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // ordernumber
                  let productsNumber = document.getElementById("productsNumber"+pain)
                  productsNumber.addEventListener("focus", (aa) => {
                  let errorNumber = document.querySelector(".errornumber"+pain);
                  errorNumber.style.display = "none";
                  productsNumber.addEventListener("input", (addalertName) => {
                      if (productsNumber.value.trim() == "") {
                        errorNumber.style.display = "block";
                      } else {
                        errorNumber.style.display = "none";
                      }
                      productsNumber.addEventListener("blur", () => {
                        let errorNumber = document.querySelector(".errornumber"+pain);
                        errorNumber.style.display = "none";
                        productsNumber.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // description
                  let productsDescription = document.getElementById("productsDescription"+pain)
                  productsDescription.addEventListener("focus", (aa) => {
                  let errorDescription = document.querySelector(".errordescription"+pain);
                  errorDescription.style.display = "none";
                  productsDescription.addEventListener("input", (addalertName) => {
                      if (productsDescription.value.trim() == "") {
                        errorDescription.style.display = "block";
                      } else {
                        errorDescription.style.display = "none";
                      }
                      productsDescription.addEventListener("blur", () => {
                        let errorDescription = document.querySelector(".errordescription"+pain);
                        errorDescription.style.display = "none";
                        productsDescription.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // origin
                  let productsOrigin = document.getElementById("productsOrigin"+pain)
                  productsOrigin.addEventListener("focus", (aa) => {
                  let errorOrigin = document.querySelector(".errororigin"+pain);
                  errorOrigin.style.display = "none";
                  productsOrigin.addEventListener("input", (addalertName) => {
                      if (productsOrigin.value.trim() == "") {
                        errorOrigin.style.display = "block";
                      } else {
                        errorOrigin.style.display = "none";
                      }
                      productsOrigin.addEventListener("blur", () => {
                        let errorOrigin = document.querySelector(".errororigin"+pain);
                        errorOrigin.style.display = "none";
                        productsOrigin.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // address
                  let productsAddress = document.getElementById("productsAddress"+pain)
                  productsAddress.addEventListener("focus", (aa) => {
                  let errorAddress = document.querySelector(".erroraddress"+pain);
                  errorAddress.style.display = "none";
                  productsAddress.addEventListener("input", (addalertName) => {
                      if (productsAddress.value.trim() == "") {
                        errorAddress.style.display = "block";
                      } else {
                        errorAddress.style.display = "none";
                      }
                      productsAddress.addEventListener("blur", () => {
                        let errorAddress = document.querySelector(".erroraddress"+pain);
                        errorAddress.style.display = "none";
                        productsAddress.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                  // img
                  let productsImage = document.getElementById("productsImage"+pain)
                  productsImage.addEventListener("focus", (aa) => {
                  let errorimg = document.querySelector(".errorimg"+pain);
                  errorimg.style.display = "none";
                  productsImage.addEventListener("input", (addalertName) => {
                      if (productsImage.value.trim() == "") {
                        errorimg.style.display = "block";
                      } else {
                        errorimg.style.display = "none";
                      }
                      productsImage.addEventListener("blur", () => {
                        let errorimg = document.querySelector(".errorimg"+pain);
                        errorimg.style.display = "none";
                        productsImage.removeEventListener("input", addalertName);
                        aa.stopPropagation();
                      });
                    });
                  });
                // 預設今天時間
                document.getElementById('productsdate'+pain).setAttribute('max', today);
                document.getElementById('productsdate'+pain).value = today;
                });
                document.getElementById('productsdate').setAttribute('max', today);
                document.getElementById('productsdate').value = today;
  </script>
  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <script src="./add01.js"></script>

</body>

</html>