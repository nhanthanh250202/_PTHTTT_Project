
<?php
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

    if (isset($_POST['total'])) {
        selectValidCoupon($_POST['total']);
        exit();
    }
    if (isset($_POST['coupon'])) {
        if($_POST['coupon']!=0){

            if (getInforCoupon($_POST['coupon'])['LOAIKM'] == 4) {
                $discount_bill= getInforCoupon($_POST['coupon'])['GIATRIKM'];
                echo $discount_bill;
            }else{
                $coupon = getInforCoupon($_POST['coupon'])['GIATRIKM'];
                $discount_bill = $_POST['discount_bill'] * number_format(getInforCoupon($_POST['coupon'])['GIATRIKM'])/100;
                echo $discount_bill;
            }
        }else{
            echo 0;
        }

        exit();
    }

    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);
        if (!getInforOrder($id)) {
            header("location: payment.php");
        }else{
            $guest = getInforOrder($id)['TENKH'];
            $room = getInforOrder($id)['MAPHONG'];
            echo "<div class='delform' > <div class='delbox'>
            <h1>Xác nhận xóa phiếu</h1>
            <h2>$room</h2>
            <h3>$guest</h3>
            <div class='btn' style = 'margin-top:30px'>
                <a href='payment-data.php?delete=". $id ."'>OK</a>
                <a style='background-color:#0bb0a2' class='ri-close-fill' href='payment.php'></a>
            </div>
            </div></div>";
        }
    }

    if (isset($_GET['update'])) {
        $id = trim($_GET['update']);
        if (!getInforOrder($id)) {
            header("location: payment.php");
        }else{
            $guest = getInforOrder($id)['TENKH'];
            $room = getInforOrder($id)['MAPHONG'];
            echo "<div class='delform' > <div class='delbox'>
            <h1>Xác nhận giao phòng</h1>
            <h2>$room</h2>
            <h3>$guest</h3>
            <div class='btn' style = 'margin-top:30px'>
                <a href='payment-data.php?update=". $room ."&id=".$id."'>OK</a>
                <a style='background-color:#0bb0a2' class='ri-close-fill' href='payment.php'></a>
            </div>
            </div></div>";
        }
    }
    if (isset($_GET['pay'])) {
        setTimeOut($_GET['pay']);
        $id =$_GET['pay'];
        $name = getInforCustomer(getInforOrder($id)['MAKH'])['TENKH'];
        $number = getInforCustomer(getInforOrder($id)['MAKH'])['SDTKH'];
        $premoney = getInforOrder($id)['SOTIENCOC'];
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
    <script src="payment.js"></script>
    <script src="staff.js"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../uiverse.css">
    <link rel="stylesheet" href="../animation.css">
    <link rel="stylesheet" href="staff.css">
    <link rel="stylesheet" href="payment.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Thanh toán hóa đơn</title>
</head>
<body>
    <header>
        <div class="topbar">
        <a href="dashboard.php"><img src="../img/logo.png" alt="" srcset=""></a>

            <ul>
                <li><a href="dashboard.php">Đặt phòng</a></li>
                <li><a class="active" href="payment.php">Thanh toán</a></li>
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
                    $url = "<a href='payment.php'>OK</a>";
                    switch ($_GET['status']) {
                        case 'print':
                            $title = "Thông báo";
                            $subtitle = "Đang in hóa đơn";
                            $success = true;
                            break;
                        case 'success':
                            $title = "Thông báo";
                            $subtitle = "Thanh toán thành công";
                            $success = true;
                            $url = "<a href='print.php?print=".$_GET['id']."'><i class='ri-printer-fill'></i>  In hóa đơn</a>";
                            break;
                        case 'error':
                            $title = "Lỗi";
                            $subtitle = "Thanh toán không thành công";
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
                    $url
                </div>
                </div></div>";
            }

        ?>
        <div class="subtitle">
            <h1 class="tracking-in-expand side-text" ></h1>
            <h1 class="tracking-in-expand timer" id="current-time">Giờ</h1>
        </div>
        
        <div  class="content"> 
            <section id="tab-1" class="render-section" style="<?php if (isset($_GET['pay'])) {echo "display:none";} ?>">
                <h1>DANH SÁCH ĐẶT PHÒNG</h1>
                <div class="render-table">
                    <!-- Searching tool -->
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th style="width:5%">STT</th>
                                <th style="width:25%">Tên khách hàng</th>
                                <th style='width:10%'>Phòng đặt</th>
                                <th style='width:15%'>Số điện thoại</th>
                                <th style='width:10%'>Thời gian đặt phòng</th>
                                <th style='width:10%'>Thời gian giao phòng</th>
                                <th style='width:20%' >Tiền cọc</th>
                                <th style='width:15%'>Thao tác</th>
                            </tr>
                        </thead>
                        <?php
                            selectAllOrder();
                        ?>
                    </table>

                </div>
            </section>

            <section id="tab-2" style="<?php if (!isset($_GET['pay'])) {echo "display:none";} else{echo "dipslay: flex";} ?>"> 
                <div class="render-table">
                    <form action="payment-data.php" id="payment" method="post">
                        <div class="top">
                            <div class="input-group">
                                <input type="hidden" name="id" id="id" value="<?php if(isset($_GET['pay'])) {echo $id; } ?>">
                                <input type="hidden" name="premoney" id="premoney"  value="<?php if(isset($_GET['pay'])) {echo $premoney; } ?>" disabled>
                                <input type="hidden" name="room_price" id="room_price" value="<?php if(isset($_GET['pay'])) {echo calculatePriceRoom($id); } ?>">
                                <div>
                                    <div class="form-group">

                                        <label ><i class="ri-user-smile-line"></i>Tên khách hàng</label>
                                        <input type="text" name="name" value="<?php if(isset($_GET['pay'])) {echo $name; } ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label ><i class="ri-phone-line"></i>Số điện thoại khách hàng</label>
                                        <input type="text" name="number" value="<?php if(isset($_GET['pay'])) {echo $number; } ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="ri-coupon-3-line"></i>Khuyến mãi:</label>
                                        <select name="coupon" id="coupon" >
            
                                        </select>
                                    </div>
    
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="group">
                                    <div class="total-group">
                                        <label class="time">Tổng thời gian: <h1><?php if (isset($_GET['pay'])) {
                                            echo printUsingTime($id);
                                        } ?></h1></label>
                                        <label class="total">Tổng tiền:<h1 id="total">0</h1></label>
                                    </div>
                                    <div class="discount-total"> 
                                        <label class="preorder">Đặt cọc <h1 id="preorder"><?php if(isset($_GET['pay'])) {echo "-". $premoney; } ?></h1> </label>
                                        <label class="coupon-apply">Trừ chiết khấu: <h1 id="coupon-apply">-0₫</h1></label>
                                    </div>
                                </div>
                                <label class="total_bill_text" >Thành tiền:<h1 id="total_bill_text"></h1></label>
                                <input type="hidden" name="coupon_discount" id="coupon_discount" value="0">
                                <input type="hidden" id="total_bill" name="bill" value="<?php  if(isset($_GET['pay'])) {echo calculatePriceRoom($id);} ?>">
                                <label for="submit-btn" id="submit-label"><i class="ri-printer-line"></i> Thanh toán</label>
                                <input id="submit-btn" type="submit" value="Thanh toán" style="display:none">
                            </div>
                        </div>
                        <table id="myTable" class="service-table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style='width: 10%'>STT</th>
                                    <th style='width: 30%'>Tên dịch vụ</th>
                                    <th style='width: 30%'>Đơn giá</th>
                                    <th style='width: 20%'>Số lượng</th>
                                    <th style='width: 10%'></th>
                                </tr>
                            </thead>
                            
                            <?php
                            selectService();
                            ?>
                        </table>
                      
                       
                </form>
                <!-- <button id="print-btn" >print</button> -->
            </section>
        </div>


    </section>

</body>
</html>