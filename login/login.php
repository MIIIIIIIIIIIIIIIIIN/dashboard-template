<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/index.css">
    <style>
        body{
            background-image: url("./img/07c26e2250ecd190925c2432ea148d42_Image\ Enhancer.jpg");
            background-size: cover;
        }
        h1{
            font-size: 70px;

        }
        .bg-filter{
            /* background-color: rgb(90, 90, 90); */
            backdrop-filter: blur(.8);
            background-color: #ffffff2d;
            
        }
    </style>
</head>
<body class="   d-flex align-items-center  justify-content-center h100vh" >
    <div class="  w-50 p-5">
        <h1 class="text-center text-white mb-5 ">LogIn</h1>

        <div class="border p-5 bg-filter rounded-3 ">
            <form action="./doLogin.php" method="post">
                <div class="input-group mb-3 ">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="account" id="loginAccount" class="form-control" placeholder="輸入帳號" aria-label="Username" aria-describedby="basic-addon1">
                    <div id="loginAccountCheck" class="input-group-text"></div>
                </div>
                
                <!-- 密碼 -->
                <div class="input-group mb-4 ">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="loginPassword" class="form-control" placeholder="輸入密碼" aria-label="Username" aria-describedby="basic-addon1">
                    <div class="password-check"></div>
                    <div class="input-group-text">
                        <input type="checkbox"  id="loginToggle">  
                    </div>
                    <div id="passwordCheck" class="input-group-text"></div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button class="fw-bold p-2 px-4 border-0 rounded-4 me-2">登入<i class="fa-solid fa-arrow-right"></i></button>
                    <!-- <button type="button" class="fw-bold p-2 px-4 border-0 rounded-4" data-bs-toggle="modal" data-bs-target="#exampleModal">註冊</button> -->
                </div>
            </form>

            
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">註冊</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="./doRegister.php" method="post" id="register">
                <div class="input-group mb-3 ">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" name="account"  class="form-control account" placeholder="輸入帳號" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="account-check"></div>
                <!-- 密碼 -->
                <div class="input-group mb-4 ">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control password" placeholder="輸入密碼" aria-label="Username" aria-describedby="basic-addon1">
                    <div class="password-check"></div>
                    <div class="input-group-text">
                        <input type="checkbox"  id="togglePassword">  
                    </div>
                    
                </div>
                <div class="password-check"></div>
                
            
        </div>
        <div class="modal-footer">
            <div   class="d-flex justify-content-center">
                <button class="fw-bold p-2 px-4 border-0 rounded-4 me-2 bg-dark-subtle text-light" id="register-send">註冊<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        </form>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // 判定是否輸入正確
        
        // accountCheck.innerHTML =123


        const loginAccount = document.getElementById("loginAccount");
        const loginAccountCheck = document.querySelector("#loginAccountCheck");
        loginAccountCheck.innerHTML="請輸入帳號"
        loginAccountCheck.style="background-color:red;color:white"

        loginAccount.addEventListener("input",()=>{
            console.log(1);
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const check = emailRegex.test(loginAccount.value);

            if(loginAccount.value ==""){
                loginAccountCheck.innerHTML="請輸入帳號";
                loginAccountCheck.style="background-color:red;color:white"
            }else if(!check){
                loginAccountCheck.innerHTML="格式不正確";
                loginAccountCheck.style="background-color:red;color:white"
            }else{
                loginAccountCheck.innerHTML="ok"
                loginAccountCheck.style="background-color:green;color:white"
            }

            // if(!check){
            //     loginAccountCheck.innerHTML="輸入錯誤"
            // }else{
            //     loginAccountCheck.innerHTML=""
            // }
            // } 
        })
        const loginPassword = document.getElementById("loginPassword");
        const logintoggle= document.getElementById('loginToggle');
        logintoggle.addEventListener('change', function () {
            // 切换密码输入框的类型
            // const passwordRegex = /^[A-Za-z0-9]{4,}$/;
            // const check = passwordRegex.test(loginPassword.value);
            if (this.checked) {
                loginPassword.type = 'text';
            } else {
                loginPassword.type = 'password';
            }
        });

     
        const passwordCheck= document.getElementById('passwordCheck');
        passwordCheck.innerHTML="請輸入密碼"
        passwordCheck.style="background-color:red;color:white"
        loginPassword.addEventListener('input', function () {
            // 切换密码输入框的类型
            const passwordRegex = /^[A-Za-z0-9]{4,}$/;
            const check = passwordRegex.test(loginPassword.value);
            if(loginPassword.value ==""){
                passwordCheck.innerHTML="請輸入密碼";
                passwordCheck.style="background-color:red;color:white"
            }else if(!check){
                passwordCheck.innerHTML="需輸入4字以上";
                passwordCheck.style="background-color:red;color:white"
            }else{
                passwordCheck.innerHTML="ok"
                passwordCheck.style="background-color:green;color:white"
            }
        });





    </script>
</body>
</html>