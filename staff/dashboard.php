
<?php
    /**
     * @NOTE:
     * @đi css
     * @thêm ràng buộc nhập
     * @thêm bảng
     * 
     */
    session_start();
    ob_start();
    include "../condb.php";
    include "../data.php";

    if (!checkStaffRole()) {    
        header("location: ../index.php");
    }
    if (isset($_POST['key'])) {
        $type = $_POST['key'];
        $time = $_POST['time'];
        selectFreeRoom($type,$time);
        exit();
    }
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
    <script src="../payment.js"></script>
    <script src="staff.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="staff.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <div class="topbar">
        <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a class="active" href="dashboard.php">Đặt phòng</a></li>
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

    <section class="body">
        <?php
            if (isset($_GET['status'])) {
                $success = false;
                if (isset($_GET['status'])) {
                    switch ($_GET['status']) {
                        case 'empty-room':
                            $title = "Thông báo";
                            $subtitle = "Vui lòng chọn phòng";
                            break;
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Đặt phòng thành công";
                            $success = true;
                            break;
                        case 'error':
                            $title = "Lỗi";
                            $subtitle = "Đặt phòng không thành công";
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
                    <a href='dashboard.php'>OK</a>
                </div>
                </div></div>";
            }

        ?>
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text" ></h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        
        <div id="tab-1" class="content"> 
            <div  class="form-val">
                
                <form action="order-data.php" method="post" onsubmit="return checkValid();">
                    <h>Phiếu đặt phòng</h>
                    <div class="form-group">
                        <i class="ri-hashtag"></i>
                        <label>Tên khách hàng:</label>
                        <input type="text" name="name" id="name" required>
                    </div>

                    <div class="form-group ">
                         <i class="ri-building-2-fill"></i>
                        <label >Đặt phòng trước</label>
                        <label id="input-checkbox" class="box-unchecked" for="type">Điền thông tin</label>
                        <input type="checkbox" name="type" id="type" style="display: none">
                    </div>
                    
                    <div class="popping">
                        <div class="preor-group">
                            <label id="input-checkbox" class="box-unchecked" for="type"><i class="ri-close-line"></i></label>
                            <h>Thông tin đặt trước</h>
                            <div class="form-group">
                                <i class="ri-phone-line"></i>
                                <label>Số điện thoại:</label>
                                <input type="text" name="number" id="number" >
                            </div>
                            <div class="form-group">
                                <i class="ri-calendar-2-line"></i>
                                <label>Giờ đặt phòng:</label>
                                <input type="datetime-local" name="ortime" id="ortime">
                            </div>
                            <div class="form-group">
                                <i class="ri-map-pin-range-line"></i>
                                <label>Giờ giao phòng:</label>
                                <input type="datetime-local" name="intime" id="intime">
                            </div>
                            <div class="form-group">
                                <i class="ri-wallet-3-line"></i>
                                <label>Tiền cọc:</label>
                                <input type="text" name="premo" id="premo" value="0" onChange="format_curency(this);">
            
                            </div>
                            <error id="error"></error>
                        </div>
                    </div>

                    <div class="form-group">

                        <label id="refresh"><i class="ri-loop-left-line"></i></label>
                        <label id="type-room" >Loại phòng</label>
                        <input type="hidden" id="type-of-room" name="type-of-room" value="">
                        <select name="room" id="room">
                            <option value="" selected></option>
                        </select>
                        
                    </div>
            
    
    

                    <div class="form-group">
                        <i class="ri-sticky-note-line"></i>
                        <label>Ghi chú:</label>
                        <input type="text" name="note" id="note" >
    
                    </div>
    
                    <error id="error-room"></error>
                    <div class="submit-button">
                        <input id="submit" type="submit" style="display: none;" value="">
                        <label for="submit">Đặt phòng</label>
                    </div>
                    
                </form>
            </div>
            <section class="render-section">
                <h1>DANH SÁCH PHÒNG</h1>
                <div class="render-table">
                    <!-- Searching tool -->
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 25%">Mã phòng</th>
                                <th style="width: 25%">Phòng</th>
                                <th style="width: 25%">Loại phòng</th>
                                <th style="width: 25%">Trạng thái</th>
                            </tr>
                        </thead>
                        <?php
                            renderAllRoom();
                        ?>
                    </table>

                </div>
            </section>
        </div>


    </section>

</body>
</html>