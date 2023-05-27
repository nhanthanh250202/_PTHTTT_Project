<?php
    include "../data.php";
    session_start();
    ob_start();
    if (!checkAdminRole()) {
        header("location: ../index.php");
    }
    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);
        $name = getInforRoom($id)['TENPHONG'];
        echo "<div class='delform' > <div class='delbox'>
        <h1>Xác nhận xóa phòng</h1>
        <h2>$name</h2>
        <div class='btn'>
            <a href='svmanager-data.php?delete=". $id ."'>OK</a>
            <a style='background-color:#0bb0a2' class='ri-close-fill' href='svmanager.php'></a>
        </div>
        </div></div>";

    }
    if (isset($_GET['deletecoupon'])) {
        $id = trim($_GET['deletecoupon']);
        $name = getInforCoupon($id)['TENKM'];
        echo "<div class='delform' > <div class='delbox'>
        <h1>Xác nhận xóa khuyến mãi</h1>
        <h2>$name</h2>
        <div class='btn'>
            <a href='svmanager-data.php?deletecoupon=". $id ."'>OK</a>
            <a style='background-color:#0bb0a2' class='ri-close-fill' href='svmanager.php'></a>
        </div>
        </div></div>";

    }
    if (isset($_GET['deleteservice'])) {
        $id = trim($_GET['deleteservice']);
        $name = getInforService($id)['TENDV'];
        echo "<div class='delform' > <div class='delbox'>
        <h1>Xác nhận xóa phụ thu</h1>
        <h2>$name</h2>
        <div class='btn'>
            <a href='svmanager-data.php?deleteservice=". $id ."'>OK</a>
            <a style='background-color:#0bb0a2' class='ri-close-fill' href='svmanager.php'></a>
        </div>
        </div></div>";

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
    <script src="admin.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="svmanager.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Quản lí dịch vụ</title>
</head>
<body>
    <header>
        <div class="topbar">
        <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a href="hrmanager.php">Quản lí nhân sự</a></li>
                <li><a class="active"  href="svmanager.php">Quản lí dịch vụ</a></li>
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
    <section class="body" style="flex-direction:row;">
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text">Quản lí dịch vụ</h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        <?php
            if (isset($_GET['room'])||isset($_GET['coupon'])||isset($_GET['service'])) {
                $success = false;
                if (isset($_GET['coupon'])) {
                    switch ($_GET['coupon']) {
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Thêm Khuyến mãi thành công";
                            $success = true;
                            break;
                        case 'error':
                            $title = "Lỗi";
                            $subtitle = "Thêm không thành công";
                            break;
                        default:
                            break;
                    }
                }
                if (isset($_GET['room'])) {
                    switch ($_GET['room']) {
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Thêm phòng thành công";
                            $success = true;
                            break;
                        case 'fail':
                            $title = "Lỗi";
                            $subtitle = "Mã phòng đã tồn tại<br>Vui lòng đặt mã khác";
                            break;
                        case 'error':
                            $title = "Lỗi";
                            $subtitle = "Thêm không thành công";
                            break;
                        default:
                            break;
                    }
                }
                if (isset($_GET['service'])) {
                    switch ($_GET['service']) {
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Thêm phụ thu thành công";
                            $success = true;
                            break;
                        case 'fail':
                            $title = "Lỗi";
                            $subtitle = "Phụ thu này đã tồn tại<br>Vui lòng xóa và đặt lại";
                            break;
                        case 'error':
                            $title = "Lỗi";
                            $subtitle = "Thêm không thành công";
                            break;
                        default:
                            break;
                    }
                }
                echo "<div class='annouform' > <div class='annoubox' style = '";
                if($success){
                    echo "border-top-color:#0bb0a2";
                }
                echo"'>
                <h1>$title</h1>
                <h2>$subtitle</h2>
                <div class='btn'>
                    <a href='svmanager.php' onclick='hiddenDisplay()'>OK</a>
                </div>
                </div></div>";
            }


        ?>
        <div class="switch-btn-group">
            <div id="group-tab-1" class="active-tab-btn">
                <button id="tab-1-btn">Quản lí phòng</button>
                <i class="ri-mic-line"></i>
            </div>
            <div id="group-tab-2">
                <button id="tab-2-btn">Quản lí khuyến mãi</button>
                <i class="ri-coupon-2-line"></i>
            </div>
            <div id="group-tab-3">
                <button id="tab-3-btn">Quản lí phụ thu</button>
                <i class="ri-price-tag-3-line"></i>
            </div>
        </div>
        <div class="content">
            <tab id="tab-1">
                <div class="form-val">
                    <form action="svmanager-data.php" method="post" id="room-form">
                        <input type="hidden" name="action" value="room">
                        <h for="">Quản lí phòng hát</h>
                        <div class="form-group">
                            <i class="ri-hashtag"></i>
                            <label>Mã Phòng:</label>
                            <input type="text" name="id" id="id" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-home-5-line"></i>
                            <label>Tên Phòng:</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-user-smile-line"></i>
                            <label>Loại phòng:</label>
                            <select name="type" id="type" >
                                <option value="2">---Chọn---</option>
                                <option value="1">VIP</option>
                                <option value="2">Thường</option>       
                            </select>
                        </div>
                        
    
                        <div class="submit-button">
                            <input id="room-submit" type="submit" style="display: none;" value="">
                            <label for="room-submit"><i class='ri-add-box-line'></i> Thêm Phòng</label>
                        </div>
                        
                    </form>
                </div>
                <section class="render-section">
                    <div class="render-table" >
                        <h1>DANH SÁCH PHÒNG</h1>
                        <table id="myTable" style="text-align: center">
                            <thead style="width: 100%">
                                <tr>
                                    <th>Mã Phòng</th>
                                    <th>Tên phòng</th>
                                    <th>Loại phòng</th>
                                    <th style="width: 5% "> </th>
                                </tr>
                            </thead>
                            <?php
                                selectAllRoom();
                            ?>
                        </table>
                    </div>
                </section>
            </tab>
            <tab id="tab-2" style="display:none">
                <div class="form-val" id="form-tab-2">
                    <form action="svmanager-data.php" method="post" id="coupon-form">
                        <input type="hidden" name="action" value="coupon">
                        <h for="">Quản lí Khuyến mãi</h>
                        <div class="form-group">
                            <i class="ri-hashtag"></i>
                            <label>Tên khuyến mãi:</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-calendar-2-line"></i>
                            <label>Ngày bắt đầu:</label>
                            <input type="date" name="sday" id="sday" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-calendar-2-line"></i>
                            <label>Ngày kết thúc:</label>
                            <input type="date" name="eday" id="eday" required>
                        </div>
                        <div class="form-group">    
                            <i class="ri-coupon-line"></i>
                            <label>Khuyến mãi:</label>
                            <input style="width:6vw" type="text" name="vlue" id="vlue" onChange="format_curency(this);" required>
                            <select name="type" id="type" style="width:10.3vw; border:none">
                                <option value="">--Chọn--</option>
                                <option value="1">% vào ngày thường</option>
                                <option value="2">% vào cuối tuần</option>    
                                <option value="3">%</option>
                                <option value="4">đồng</option>
                            </select>
                        </div>
                        <div class="form-group">    
                            <label>Cho hóa đơn từ </label>
                            <input type="text" name="condition" id="condition" value="0"  onChange="format_curency(this);" required>
                            <label>đồng</label>
                        </div>
                        
    
                        <div class="submit-button">
                            <input id="coupon-submit" type="submit"  style="display: none;" value="">
                            <label for="coupon-submit"><i class='ri-add-box-line'></i> Thêm Khuyến mãi</label>
                        </div>
                        
                    </form>
                </div>
                <section class="render-section" style=" display:none" id="table-tab-2">
                    <div class="render-table" >
                        <h1>DANH SÁCH KHUYẾN MÃI</h1>
                        <table id="myTable" style="text-align: center">
                            <thead style="width: 100%">
                                <tr>
                                    <th style="width:30%">Khuyến mãi</th>
                                    <th style="width:20%">Thời gian Khuyến mãi</th>
                                    <th style="width:40%">Chi tiết</th>
                                    <th style="width: 10% ">Thao tác</th>
                                </tr>
                            </thead>
                            <?php
                                selectAllCoupon();
                            ?>
                        </table>
                    </div>
                </section>
                <div class="switch-view-btn">
                    <label for="switch-view-btn" onclick="switchView()" ><i class="ri-arrow-right-double-line"></i></label>
                    <button id="switch-view-btn" onclick="switchTab('form-tab-2','table-tab-2','Danh sách khuyến mãi','Thêm khuyến mãi')">Danh sách khuyến mãi</button>
                </div>

            </tab>
            <tab id="tab-3" style="display:none;">
                <div class="form-val" >
                    <form action="svmanager-data.php" method="post" id="service-form">

                        <input type="hidden" name="action" value="service">
                        <h for="">Quản lí Phụ thu</h>
                        <div class="form-group">    
                            <i class="ri-hashtag"></i>
                            <label>Mã phụ thu:</label>
                            <input type="text" name="id" id="id" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-character-recognition-line"></i>
                            <label>Tên phụ thu:</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                      
                        <div class="form-group">  
                            <i class="ri-coupon-line"></i>  
                            <label>Đơn giá:</label>
                            <input type="text" name="price" id="price" value="0"  onChange="format_curency(this);" required>
                        </div>
                        
    
                        <div class="submit-button">
                            <input id="service-submit" type="submit"  style="display: none;" value="">
                            <label for="service-submit"><i class='ri-add-box-line'></i> Thêm Phụ thu</label>
                        </div>
                        
                    </form>
                </div>
                <section class="render-section" >
                    <div class="render-table">
                        <h1>CÁC LOẠI PHỤ THU</h1>
                        <table id="myTable" style="text-align: center">
                            <thead style="width: 100%">
                                <tr>
                                    <th style="width:20%">Mã phụ thu</th>
                                    <th style="width:40%">Tên phụ thu</th>
                                    <th style="width:20%">Đơn giá</th>
                                    <th style="width: 20% ">Thao tác</th>
                                </tr>
                            </thead>
                            <?php
                                selectAllService();
                            ?>
                        </table>
                    </div>
                </section>

            </tab>
        </div>



    </section>
</body>
</html>