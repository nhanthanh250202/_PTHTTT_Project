<?php
    session_start();
    ob_start();
    include "../data.php";

    if (!checkAdminRole()) {
        header("location: ../index.php");
    }
    $name = $_SESSION['name'];
    

    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 'signout':
                unset($_SESSION['user']);
                unset($_SESSION['name']);
                unset($_SESSION['role']);
                header("location: ../index.php");
                break;
            
            default:
                break;
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
    <script src="../script.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <div class="topbar">
            <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>
            <ul>
                <li><a href="hrmanager.php">Quản lí nhân sự</a></li>
                <li><a href="svmanager.php">Quản lí dịch vụ</a></li>
                <li><a href="fcmanager.php">Quản lí cơ sở vật chất</a></li>
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
    <section class="body">
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text">Hệ thống quản lí quán karaoke</h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        <h1>CHÀO QUẢN LÝ <b > <?php echo $_SESSION['name']; ?> </b> </h1>
        <div class="container">
            <div class="function">
                <img src="../img/img-1.jpg" alt="" srcset="">
                <div class="function-text">
                    <a  href="hrmanager.php">Quản lí nhân sự</a>
                </div>
            </div>
            <div class="function">
                <img src="../img/img-2.jpg" alt="" srcset="">
                <div class="function-text">
                    <a  href="svmanager.php">Quản lí dịch vụ</a>
                </div>
            </div>
            <div class="function">
                <img src="../img/img-3.jpg" alt="" srcset="">
                <div class="function-text">
                    <a  href="fcmanager.php">Quản lí <br> cơ sở vật chất</a>
                </div>
            </div>
        </div>
    </section>

</body>
</html>