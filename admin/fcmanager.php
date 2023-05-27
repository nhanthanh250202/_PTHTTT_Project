<?php
    include "../data.php";
    session_start();
    ob_start();
    if (!checkAdminRole()) {
        header("location: ../index.php");
    }
    if (isset($_GET['del'])&& isset($_GET['room'])) {
        $device = $_GET['del'];
        $room = $_GET['room'];
        echo "<div class='delform' > <div class='delbox'>
        <h1>Xác nhận xóa</h1>
        <h2>". getInforDevice($device)['TENTB'] ." phòng ". getInforRoom($room)['TENPHONG'] ."</h2>
        <div class='btn'>
            <a href='fcmanager-data.php?del=". $device ."&room=".$room."'>OK</a>
            <a style='background-color:#0bb0a2' class='ri-close-fill' href='fcmanager.php'></a>
        </div>
        </div></div>";
    }

    if (isset($_POST['selected_room'])) {
        $id = $_POST['selected_room'];
        selectAllDeviceInRoom($id);
        exit();
    }
    if (isset($_GET['deletedevice'])) {
        $id = trim($_GET['deletedevice']);
        $name = getInforDevice($id)['TENTB'];
        echo "<div class='delform' > <div class='delbox'>
        <h1>Xác nhận xóa Thiết bị</h1>
        <h2>$name</h2>
        <div class='btn'>
            <a href='fcmanager-data.php?deletedevice=". $id ."'>OK</a>
            <a style='background-color:#0bb0a2' class='ri-close-fill' href='fcmanager.php'></a>
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
    <script src="admin-ajax.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="stylesheet" href="fcmanager.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Quản lí cơ sở vật chất</title>
</head>
<body>
    <header>
        <div class="topbar">
            <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a href="hrmanager.php">Quản lí nhân sự</a></li>
                <li><a href="svmanager.php">Quản lí dịch vụ</a></li>
                <li><a class="active" href="fcmanager.php">Quản lí cơ sở vật chất</a></li>
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
            if (isset($_GET['device'])) {
                $success = false;
                if (isset($_GET['device'])) {
                    switch ($_GET['device']) {
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Thêm Thiết bị thành công";
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
                echo "<div class='annouform' > <div class='annoubox' style = '";
                if($success){
                    echo "border-top-color:#0bb0a2";
                }
                echo"'>
                <h1>$title</h1>
                <h2>$subtitle</h2>
                <div class='btn'>
                    <a href='fcmanager.php' onclick='hiddenDisplay()'>OK</a>
                </div>
                </div></div>";
            }


        ?>
        <div class="switch-view-btn">
            <label for="switch-view-btn" onclick="switchView()" ><i class="ri-arrow-right-double-line"></i></label>
            <button id="switch-view-btn" onclick="switchTab('tab-1','tab-2','Danh sách thiết bị','Thiết bị các phòng')">Danh sách thiết bị</button>
        </div>
        <div class="content">
            <tab id="tab-1" style="display:none">
                <div class="form-val">
                    <form action="fcmanager-data.php" method="post" id="device-form">
                        <input type="hidden" name="action" value="device">
                        <h>Nhập thêm thiết bị</h>
                        <div class="form-group">
                            <i class="ri-qr-code-line"></i>
                            <label>Mã Thiết bị:</label>
                            <input type="text" name="id" id="id" required>
                        </div>
                        <div class="form-group">
                            <i class="ri-character-recognition-line"></i>
                            <label>Tên Thiết bị:</label>
                            <input type="text" name="name" id="name" required>
                        </div>

                        
    
                        <div class="submit-button">
                            <input id="device-submit" type="submit" style="display: none;" value="">
                            <label for="device-submit"><i class='ri-add-box-line'></i> Thêm thiết bị</label>
                        </div>
                        
                    </form>
                </div>
                <section class="render-section">
                    <div class="render-table" >
                        <h1>DANH SÁCH CÁC THIẾT BỊ</h1>
                        <table id="myTable" style="text-align: center">
                            <thead style="width: 100%">
                                <tr>
                                    <th>Mã Thiết bị</th>
                                    <th>Tên Thiết bị</th>
                                    <th style="width: 5% "> </th>
                                </tr>
                            </thead>
                            <?php
                                selectAllDevice();
                            ?>
                        </table>
                    </div>
                </section>

            </tab>
            <tab id="tab-2" style="gap: 50px">
                <div class="form-val" id="form-tab-2">
                    <form action="fcmanager-data.php" method="post" id="rdevice-form">
                        <input type="hidden" name="action" value="rdevice">
                        <h>Quản lí thiết bị phòng</h>
                        <div class="form-group">
                            <i class="ri-hashtag"></i>
                            <label>Phòng:</label>
                            <select name="room" id="room" style="width:10.3vw; border:none">
                                <option value="">--Chọn--</option>
                                <?php
                                    include '../condb.php';
                                    $sql = "SELECT * FROM `phong`";
                                    if($result = mysqli_query($conn,$sql)){
                                        if (mysqli_num_rows($result)>0){
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value= '".$row['MAPHONG'] . "'>" .$row['TENPHONG']. "</option>";
                                                
                                            }
                                            mysqli_free_result($result);
                                        }
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <div class="form-group">    
                            <i class="ri-coupon-line"></i>
                            <label>Chọn thiết bị:</label>
                            <select name="device" id="device" style="width:10.3vw; border:none">
                                <option value="">--Chọn--</option>
                                <?php
                                    include '../condb.php';
                                    $sql = "SELECT * FROM `thietbi`";
                                    if($result = mysqli_query($conn,$sql)){
                                        if (mysqli_num_rows($result)>0){
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value= '".$row['MATB'] . "'>".$row['MATB'] ." - " .$row['TENTB']. "</option>";
                                                
                                            }
                                            mysqli_free_result($result);
                                        }
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <div class="form-group">    
                            <label>Số lượng thiết bị</label>
                            <input type="number" name="amount"  style="width:10.3vw;" id="amount" value="0" required>

                        </div>
                        <div class="form-group">    
                            <label>Ghi chú</label>
                            <input type="text" name="note"  style="width:10.3vw;" id="note">
                        </div>
                        
    
                        <div class="submit-button">
                            <input id="rdevice-submit" type="submit"  style="display: none;" value="">
                            <label for="rdevice-submit"><i class='ri-add-box-line'></i> Thêm Thiết bị vào phòng</label>
                        </div>
                        
                    </form>
                </div>
                <section class="render-section">
                    <div class="render-table" >
                        <h1>CÁC THIẾT BỊ</h1>
                        <table id="myTable" style="text-align: center">
                            <thead style="width: 100%">
                                <tr>
                                    <th style="width: 20% ">Thiết bị</th>
                                    <th style="width: 20% ">Số lượng</th>
                                    <th style="width: 40% ">Ghi chú</th>
                                    <th style="width: 20% "> </th>
                                </tr>
                            </thead>
                            <tbody id="device-room-table">
                                    <tr >
                                        <td colspan='4'>
                                         Vui lòng chọn phòng
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </section>


            </tab>
        </div>



    </section>
</body>
</html>