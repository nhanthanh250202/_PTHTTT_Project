<?php
    session_start();
    ob_start();
    include "data.php";
    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        if($_SESSION['role']==0){
            header("location: admin/dashboard.php");
        }
        else{
            header("location: staff/dashboard.php");
        }
    }

    if((isset($_POST['login'])) && ($_POST['login'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        if (checkAccount($user,$pass))
        {
            $name = getInforUser($user)['TENNV'];
            $role = getInforUser($user)['CHUCVU'];
            $_SESSION['user']= $user;
            $_SESSION['name']= $name;
            $_SESSION['role']= $role;
            if ($role == 0) {
                header("location: admin/dashboard.php");
            }else if($role == 1){
                header("location: staff/dashboard.php");
            }
        }
        else
        {
            $txt_passerror = "Sai mật khẩu hoặc tài khoản";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="uiverse.css">
    <link rel="stylesheet" href="animation.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Hệ thống quản lí quán Karaoke</title>
</head>
<body onload="loadAnimation()">
    
    <section id="loading" class="loading">
        <h id="loading-percent">0</h>
        <img src="img/loading-head.png" alt="" id="loading-head">
        <h1 id="loader-text">
            HỆ THỐNG QUẢN LÍ QUÁN KARAOKE
        </h1>
        <div class="progress-loader">
            <div class="progress"></div>
        </div>
    </section>
    <section id="login-form" class="login-form">
        <h1 id="current-day">Ngày</h1>
        <h id="current-time">0</h>
        <div class="form-box">
            <div class="form-val">
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post" >

                    <h2>ĐĂNG NHẬP</h2>
                    <div class="inputbox">
                        <i class="ri-mail-fill"></i>
                        <input type="text" name="user" autocomplete="off" required>
                        <label for="">Mã nhân viên</label>
                    </div>
                    <div class="inputbox">
                        <i class="ri-lock-password-fill" id="password-btn" onclick="showPassword()"></i>
                        <input type="password" name="pass" id="password" autocomplete="off" required>
                        <label for="">Mật khẩu</label>
                    </div>
                    <?php
                        if (isset($txt_passerror) && $txt_passerror!="") {
                            echo "<p class = 'error' style = 'color: red'; >".$txt_passerror. "</p>";
                        }
                     ?>
                    <input type="submit" name="login" value="Đăng nhập ngay">
                </form>
                
            </div>
        </div>
    </section>
</body>
</html>