<?php
    session_start();
    ob_start();
    include "../data.php";
    if (!checkStaffRole()) {    
        header("location: ../index.php");
    }
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if(checkAccount($_SESSION['user'],$_POST['oldpass'])){
        if (updatePassword($_SESSION['user'],$_POST['newpass'])) {
            header("location: changepassword.php?status=success");
        }else{
            header("location: changepassword.php?status=fail");
        }
       }else{
        $error = "Sai mật khẩu vui lòng kiểm tra lại";
       };
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
    <script src="../script.js"></script>
    <script src="../admin/admin.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="../admin/admin.css">
    <link rel="stylesheet" href="../admin/hrmanager.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Đổi mật khẩu</title>
</head>
<body>
    <header>
        <div class="topbar">
        <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a href="dashboard.php">Đặt phòng</a></li>
                <li><a href="payment.php">Thanh toán</a></li>
            </ul>
            <div class="btn-menu">
                <input type="checkbox" id="checkbox">
                <label for="checkbox" class="toggle">
                    <div class="bars" id="bar1"></div>
                    <div class="bars" id="bar2"></div>
                    <div class="bars" id="bar3"></div>
                </label>
                <div class="hidden-menu">
                    <a href="changepassword.php"><i class="ri-lock-line"></i> Đổi mật khẩu</a>
                    <a href="dashboard.php?act=signout"><i class="ri-logout-box-r-line"></i> Đăng xuất</a>
                </div>
            </div>
            
        </div>
    </header>
    <section class="body" style="flex-direction:row;">
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text"> </h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 'success':
                        $title = "Thông báo";
                        $subtitle = "Cập nhật mật khẩu thành công";
                        $link = "dashboard.php";
                        break;
                    case 'fail':
                        $title = "Lỗi";
                        $subtitle = "Cập nhật mật khẩu không thành công";
                        $link = "changepassword.php";
                        break;
                }
                echo "<div class='annouform' > <div class='annoubox' style = '";
                if($_GET['status'] == 'success'){
                    echo "border-top-color:#0bb0a2";
                }
                echo"'>
                <h1>$title</h1>
                <h2>$subtitle</h2>
                <div class='btn'>
                    <a href='$link''>OK</a>
                </div>
                </div></div>";
            }
        ?>


        <div class="form-val">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return checkConfirm()">
                <h >Thay đổi mật khẩu</h>
                <div class="form-group">
                <i class="ri-lock-2-fill"></i>
                    <label>Nhập lại password:</label>
                    <input type="password" name="oldpass" id="oldpass" required>
                    <label class="ri-lock-password-fill" style="width:10px; cursor:pointer" onclick="showPassword('#oldpass')"> </label>
                </div>
                <div class="form-group">
                <i class="ri-key-line"></i>
                    <label>Password mới:</label>
                    <input type="password" name="newpass" id="newpass" required>
                    <label class="ri-lock-password-fill" style="width:10px; cursor:pointer" onclick="showPassword('#newpass')"> </label>
                </div>
                <div class="form-group">
                <i class="ri-key-line"></i>
                    <label>Xác nhận Password mới:</label>
                    <input type="password" name="confpass" id="confpass" required>
                    <label class="ri-lock-password-fill" style="width:10px; cursor:pointer" onclick="showPassword('#confpass')"> </label>
                </div>
                
                <label id="error" style="color: red; font-weight:bold; align-self:center; margin-top:20px"><?php if ($error!="") {
                    echo $error;
                }?></label>
                <div class="submit-button">
                    <input id="submit" type="submit" style="display: none;" value="" >
                    <label for="submit">Thay đổi mật khẩu</label>
                </div>
                
            </form>
        </div>
        <script>
            function checkConfirm() {
            var pass = $("#newpass").val();
            var confpass = $("#confpass").val();
            if (pass != confpass) {
                $("#error").html("Xác nhận mật khẩu sai vui lòng nhập lại");
                return false;
            }else{
                return true;
            }
            }

        </script>


    </section>
</body>
</html>