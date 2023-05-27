<?php
    include "../data.php";
    session_start();
    ob_start();
    if (!checkAdminRole()) {
        header("location: ../index.php");
    }
    $is_edit = false;

    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);
        if (!getInforUser($id)) {
            header("location: hrmanager.php");
        }else{
            $name = getInforUser($id)['TENNV'];
            echo "<div class='delform' > <div class='delbox'>
            <h1>Xác nhận xóa nhân viên</h1>
            <h2>$name</h2>
            <div class='btn'>
                <a href='hrmanager-data.php?delete=". $id ."'>OK</a>
                <a style='background-color:#0bb0a2' class='ri-close-fill' href='hrmanager.php'></a>
            </div>
            </div></div>";
        }


    }
    if (isset($_GET['update'])) {
        $id = trim($_GET['update']);
        if (!getInforUser($id)) {
            header("location: hrmanager.php");
        }else{
            $is_edit = true;
            $name = getInforUser($id)['TENNV'];
            $gender = getInforUser($id)['GIOITINH'];
            $bday = getInforUser($id)['NGAYSINH'];
            $address = getInforUser($id)['DIACHI'];
            $number = getInforUser($id)['SDTNV'];
            $wday = getInforUser($id)['NGAY'];
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
    <script src="admin.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="hrmanager.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Quản lí nhân sự</title>
</head>
<body>
    <header>
        <div class="topbar">
        <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a class="active"  href="hrmanager.php">Quản lí nhân sự</a></li>
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
    <section class="body" style="flex-direction:row;">
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text">Quản lí nhân sự</h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        <?php
            if (isset($_GET['status'])) {
                switch ($_GET['status']) {
                    case 'success':
                        $title = "Thông báo";
                        $subtitle = "Thêm nhân viên thành công";
                        break;
                    case 'fail':
                        $title = "Lỗi";
                        $subtitle = "Mã nhân viên đã tồn tại<br>Vui lòng đặt mã khác";
                        break;
                    case 'error':
                        $title = "Lỗi";
                        $subtitle = "Thêm không thành công";
                        break;
                    case 'update-success':
                        $title = "Thông báo";
                        $subtitle = "Cập nhật thành công";
                        break;
                    case 'update-error':
                        $title = "Lỗi";
                        $subtitle = "Cập nhật không thành công";
                        break;
                    default:
                        break;
                }
                echo "<div class='annouform' > <div class='annoubox' style = '";
                if($_GET['status'] == 'success' || $_GET['status'] == 'update-success'){
                    echo "border-top-color:#0bb0a2";
                }
                echo"'>
                <h1>$title</h1>
                <h2>$subtitle</h2>
                <div class='btn'>
                    <a href='hrmanager.php' onclick='hiddenDisplay()'>OK</a>
                </div>
                </div></div>";
            }
        ?>


        <div id="tab-1" class="form-val">
            
            <form action="hrmanager-data.php<?php if($is_edit)  echo "?update=".$id.""; ?>" method="post">
                <h for="">Thông tin nhân viên</h>
                <div class="form-group">
                    <i class="ri-hashtag"></i>
                    <label>Mã NV:</label>
                    <input type="text" name="id" id="id" value="<?php if($is_edit) echo "$id"; else echo "" ?>" <?php if($is_edit) echo "disabled" ?> required>
                </div>
                <div class="form-group">
                    <i class="ri-user-5-line"></i>
                    <label>Tên NV:</label>
                    <input type="text" name="name" id="name" value="<?php if($is_edit) echo $name; else echo "" ?>" required>
                </div>
                <div class="form-group">
                    <i class="ri-user-smile-line"></i>
                    <label>Giới tính:</label>
                    <select name="gender" id="gender" >
                        <option value="">---Chọn---</option>
                        <option value="0" <?php if($is_edit== true && $gender == 0)  echo "selected='selected'"; ?>>Nữ</option>
                        <option value="1" <?php if($is_edit== true && $gender == 1)  echo "selected='selected'"; ?>>Nam</option>
                    </select>
                </div>
                <div class="form-group">
                    <i class="ri-calendar-2-line"></i>
                    <label>Ngày sinh:</label>
                    <input type="date" name="bday" id="bday" value="<?php if($is_edit) echo $bday; else echo "" ?>" required>
                </div>
                <div class="form-group">
                    <i class="ri-map-pin-range-line"></i>
                    <label>Địa chỉ:</label>
                    <input type="text" name="address" id="address" value="<?php if($is_edit) echo $address; else echo "" ?>"required>
                </div>
                <div class="form-group">
                    <i class="ri-phone-line"></i>
                    <label>Số điện thoại:</label>
                    <input type="text" name="number" id="number" value="<?php if($is_edit) echo $number; else echo "" ?>" required>
                </div>
                <div class="form-group">
                    <i class="ri-briefcase-4-line"></i>
                    <label>Ngày vào làm:</label>
                    <input type="date" name="wdate" id="wdate" value="<?php if($is_edit) echo $wday; ?>" required>
                    <script>
                            document.getElementById('wdate').valueAsDate = new Date();
                    </script>
                </div>
                

                <div class="submit-button">
                    <input id="submit" type="submit" style="display: none;" value="">
                    <label for="submit"><?php if($is_edit) echo "Hoàn tất chỉnh sửa";else echo "Thêm nhân viên" ?></label>
                </div>
                
            </form>
        </div>
        <div id="tab-2" class="render-section" style="display:none; width: 70vw; height: 65vh; padding: 0 30px ;flex-direction:column">
            <h1>DANH SÁCH NHÂN VIÊN</h1>
            <div class="render-table">
                <!-- Searching tool -->
                <table id="myTable">
                    <thead>
                        <tr>
                            <th style="width: 10%">Mã Nhân viên</th>
                            <th style="width: 25%">Tên Nhân viên</th>
                            <th style="width: 5%">Giới tính</th>
                            <th style="width: 10%">Ngày sinh</th>
                            <th style="width: 25%">Địa chỉ</th>
                            <th style="width: 10%">Số điện thoại</th>
                            <th style="width: 10%">Ngày vào làm</th>
                            <th style="width: 5%" > Thao tác</th>
                        </tr>
                    </thead>
                    <?php
                        selectAllStaff();
                    ?>

                </table>
                    
    
            </div>
        </div>
        <div class="switch-view-btn">
            <label for="switch-view-btn" onclick="switchView()" ><i class="ri-arrow-left-right-line"></i></i></label>
            <button id="switch-view-btn"  onclick="switchTab('tab-1','tab-2','Danh sách nhân viên','Thêm nhân viên')">Danh sách nhân viên</button>
        </div>


    </section>
</body>
</html>