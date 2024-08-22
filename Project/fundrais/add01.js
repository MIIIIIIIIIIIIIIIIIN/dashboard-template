// input宣告
const productsForm = document.getElementById("productsForm");
const productsName = document.getElementById("productsName");
const productsPrice = document.getElementById("productsPrice");
const productsDate = document.getElementById("productsdate");
const productsColor = document.getElementById("productsColor");
const productsSize = document.getElementById("productsSize");
const productsQuantity = document.getElementById("productsQuantity");
const productsNumber = document.getElementById("productsNumber");
const productsDescription = document.getElementById("productsDescription");
const productsOrigin = document.getElementById("productsOrigin");
const productsAddress = document.getElementById("productsAddress");
const productsCategory = document.getElementById("productsCategory");
const productsImage = document.getElementById("productsImage");
// 錯誤訊息宣告
const errorName = document.querySelector(".errorName");
const errorPrice = document.querySelector(".errorprice");
const errorDate = document.querySelector(".errordate");
const errorColor = document.querySelector(".errorcolor");
const errorSize = document.querySelector(".errorsize");
const errorQuantity = document.querySelector(".errorquantity");
const errorNumber = document.querySelector(".errornumber");
const errorDescription = document.querySelector(".errordescription");
const errorOrigin = document.querySelector(".errororigin");
const errorAddress = document.querySelector(".erroraddress");
const errorCategory = document.querySelector(".errorcategory");
const errorimg = document.querySelector(".errorimg");

// 產品名稱警告
productsName.addEventListener("focus", (aa) => {
  errorName.style.display = "none";
  productsName.addEventListener("input", (addalertPrice) => {
    if (productsName.value.trim() == "") {
      errorName.style.display = "block";
    } else {
      errorName.style.display = "none";
    }
    productsName.addEventListener("blur", () => {
      errorName.style.display = "none";
      productsName.removeEventListener("input", addalertPrice);
      aa.stopPropagation();
    });
  });
});



// (isNaN(productsPrice.value) || productsPrice.value.trim() == "")
// 價格名稱警告 :需識別是否為數字
productsPrice.addEventListener("focus", (aa) => {
  errorPrice.style.display = "none";
  productsPrice.addEventListener("input", (addalertPrice) => {
    if (isNaN(productsPrice.value) || productsPrice.value.trim() == "") {
      errorPrice.style.display = "block";
    } else {
      errorPrice.style.display = "none";
    }
    productsPrice.addEventListener("blur", () => {
      errorPrice.style.display = "none";
      productsPrice.removeEventListener("input", addalertPrice);
      aa.stopPropagation();
    });
  });
});

// date
productsDate.addEventListener("focus", (aa) => {
  errorDate.style.display = "none";
  productsDate.addEventListener("input", (addalertDate) => {
    if (productsDate.value == "") {
      errorDate.style.display = "block";
    } else {
      errorDate.style.display = "none";
    }
    productsDate.addEventListener("blur", () => {
      errorDate.style.display = "none";
      productsDate.removeEventListener("input", addalertDate);
      aa.stopPropagation();
    });
  });
});

// 顏色警告
productsColor.addEventListener("focus", (aa) => {
  errorColor.style.display = "none";
  productsColor.addEventListener("input", (addalertColor) => {
    if (productsColor.value == "") {
      errorColor.style.display = "block";
    } else {
      errorColor.style.display = "none";
    }
    productsColor.addEventListener("blur", () => {
      errorColor.style.display = "none";
      productsColor.removeEventListener("input", addalertColor);
      aa.stopPropagation();
    });
  });
});

// 尺寸警告
productsSize.addEventListener("focus", (aa) => {
  errorSize.style.display = "none";
  productsSize.addEventListener("input", (addalertSize) => {
    if (productsSize.value == "") {
      errorSize.style.display = "block";
    } else {
      errorSize.style.display = "none";
    }
    productsSize.addEventListener("blur", () => {
      errorSize.style.display = "none";
      productsSize.removeEventListener("input", addalertSize);
      aa.stopPropagation();
    });
  });
});


// 數量警告
productsQuantity.addEventListener("focus", (aa) => {
  errorQuantity.style.display = "none";
  productsQuantity.addEventListener("input", (addalertQuantity) => {
    if (isNaN(productsQuantity.value) || productsQuantity.value.trim() == "") {
      errorQuantity.style.display = "block";
    } else {
      errorQuantity.style.display = "none";
    }
    productsQuantity.addEventListener("blur", () => {
      errorQuantity.style.display = "none";
      productsQuantity.removeEventListener("input", addalertQuantity);
      aa.stopPropagation();
    });
  });
});

// 訂單編號警告
productsNumber.addEventListener("focus", (aa) => {
  errorNumber.style.display = "none";
  productsNumber.addEventListener("input", (addalertNumber) => {
    if (productsNumber.value == "") {
      errorNumber.style.display = "block";
    } else {
      errorNumber.style.display = "none";
    }
    productsNumber.addEventListener("blur", () => {
      errorNumber.style.display = "none";
      productsNumber.removeEventListener("input", addalertNumber);
      aa.stopPropagation();
    });
  });
});

// 產品描述警告
productsDescription.addEventListener("focus", (aa) => {
  errorDescription.style.display = "none";
  productsDescription.addEventListener("input", (addalertDescription) => {
    if (productsDescription.value == "") {
      errorDescription.style.display = "block";
    } else {
      errorDescription.style.display = "none";
    }
    productsDescription.addEventListener("blur", () => {
      errorDescription.style.display = "none";
      productsDescription.removeEventListener("input", addalertDescription);
      aa.stopPropagation();
    });
  });
});

// 出產地警告
  productsOrigin.addEventListener("focus", (aa) => {
    errorOrigin.style.display = "none";
    productsOrigin.addEventListener("input", (addalertOrigin) => {
      if (productsOrigin.value == "") {
        errorOrigin.style.display = "block";
      } else {
        errorOrigin.style.display = "none";
      }
      productsOrigin.addEventListener("blur", () => {
        errorOrigin.style.display = "none";
        productsOrigin.removeEventListener("input", addalertOrigin);
        aa.stopPropagation();
      });
    });
  });

// 地址警告
productsAddress.addEventListener("focus", (aa) => {
  errorAddress.style.display = "none";
  productsAddress.addEventListener("input", (addalertAddress) => {
    if (productsAddress.value == "") {
      errorAddress.style.display = "block";
    } else {
      errorAddress.style.display = "none";
    }
    productsAddress.addEventListener("blur", () => {
      errorAddress.style.display = "none";
      productsAddress.removeEventListener("input", addalertAddress);
      aa.stopPropagation();
    });
  });
});


// 圖片警告
productsImage.addEventListener("focus", (aa) => {
  errorimg.style.display = "none";
  productsImage.addEventListener("input", (addalertImg) => {
    if (productsImage.value == "") {
      errorimg.style.display = "block";
    } else {
      errorimg.style.display = "none";
    }
    productsImage.addEventListener("blur", () => {
      errorimg.style.display = "none";
      productsImage.removeEventListener("input", addalertImg);
      aa.stopPropagation();
    });
  });
});
