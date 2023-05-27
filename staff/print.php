<?php
    session_start();
    ob_start();
    include "../condb.php";
    include "../data.php";


    
    if (!checkStaffRole()) {    
        header("location: ../index.php");
    }

    if (isset($_GET['print'])) {
        $name_staff = $_SESSION['name'];
        $id =$_GET['print'];
        $name = getInforCustomer(getInforOrder($id)['MAKH'])['TENKH'];
        $number = getInforCustomer(getInforOrder($id)['MAKH'])['SDTKH'];
        $premoney = getInforOrder($id)['SOTIENCOC'];
        $discount = getBill($id)['TONGKM'];
        $date = getCurrentTime('Y-m-d H:i:s');

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="print.css">
    
    <title>In hóa đơn</title>
</head>
<body onload="printSection('print-section');" style="display:none">

    <!-- <style>
        body{
            overflow-y: auto;
        }
        .print-section{
            --width:500px;
            font-size: calc(var(--width)/30);
            gap: calc(var(--width)/30) ;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            padding: 30px;
            background-color: #f2f2f2;
            width: var(--width);
            height: max-content;
        }
        .print-section h1{
            font-size: calc(var(--width)/10);
            font-family: Geomanist-Bold;
            text-align: center;
        }
        .print-section h2{
            text-align: center;
            font-size: calc(var(--width)/30);
            margin-bottom: calc(var(--width)/25);
        }
        .print-section table thead td{
            border-top: 2px solid #8e8e8e;
        }
        .print-section table tbody td{
            padding: calc(var(--width)/30);
        }
        .print-section table tfoot td{
            padding-top: calc(var(--width)/30);
            text-align: right;
            border-top: 2px solid #8e8e8e;
        }
        .print-section table tfoot td span{
            font-weight: bold;
        }

        .bottom-print span{
            justify-content: space-between;
            align-items: center;
            width: var(--width);
            height: calc(var(--width)/15);
            display: flex;
        }
        .bottom-print span h3{
            align-self: center;
        }

    </style> -->
    <div id="print-section" class="print-section">
        <img src="../img/logo.png" alt="">
        <h1>KARAOKE ICOOL</h1>
        <h2>Địa chỉ: 177 Trần Bình Trọng, Phường 3, Quận 5, Tp.Hồ Chí Minh </h2>
        <span>
            <h2>Hotline: 0803339189</h2>
            <h2>Email: tbtq5@icool.com</h2>
        </span>

        <h3>PHIẾU TÍNH TIỀN</h3>
        <p>Nhân viên thanh toán: <?php echo $name_staff ?></p>
        <p>Khách hàng: <?php echo $name ?> </p>
        <p>Số điện thoại: <?php echo $number ?></p>
        <p>Ngày: <?php echo $date ?></p>

        <table>
            <?php
                $sum = 0;
                $sql = "SELECT * FROM `pthttt`.`phieudat` INNER JOIN `loaidichvu` ON `loaidichvu`.MADV = `phieudat`.MADV INNER JOIN `phong` ON phong.MAPHONG = phieudat.MAPHONG WHERE `MAPD` = '$id' AND GIOVAO =0 ";
                if($result = mysqli_query($conn,$sql)){
                    if (mysqli_num_rows($result)>0){
                        echo "<thead><tr><td colspan='4'></td></tr></thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo"<td>" .$row['TENDV'] . "</td>";
                        echo"<td>" .$row['GHICHU'] . "</td>";
                        echo"<td>" . formatCurrency($row['DONGIADV'])  . "</td>";
                        echo"<td>" . formatCurrency($row['GHICHU']*$row['DONGIADV']) . "</td>";
                        $sum +=$row['GHICHU']*$row['DONGIADV'];
                        echo "</tr>";
                        }
                        echo "</tbody>";
                        echo"<tfoot><tr><td colspan='4'> Tổng cộng: <b> " . formatCurrency($sum). "</b></td></tr><tfoot>";
                    }
                    else{
                        echo "<tr>";
                        echo "</tr>";
                    }

                }
            ?>
        </table>
        <div class="bottom-print">
            <span>
                <label>Số giờ hát: </label>
                <h3><?php echo printUsingTime($id); ?></h3>
            </span>
            <span>
                <label>Tổng tiền giờ hát: </label>
                <h3>
                    <?php echo formatCurrency(calculatePriceRoom($id)); ?>
                </h3>
            </span>
            <span>
                <label>Cọc trước: </label>
                <h3>
                <?php echo formatCurrency($premoney); ?>
                </h3> 
            </span>
            <span>
                <label>Trừ khuyến mãi: </label>
                <h3>
                <?php echo formatCurrency($discount); ?>
                </h3> 
            </span>
            <span>
                <label>Thành tiền: </label>
                <h3>
                <?php echo formatCurrency(getBill($id)['TONGTIEN']); ?>
                </h3> 
            </span>
        </div>
    </div>

    <script type="text/javascript">    

        function printSection(el){
            var getFullContent = document.body.innerHTML;
                var printsection = document.getElementById(el).innerHTML;
                document.body.innerHTML = printsection;
                document.body.innerHTML = getFullContent;
                var popupWin = window.open('', '_blank', 'width=500,height=500');
                popupWin.document.open();
                popupWin.document.write('<html><link rel="stylesheet" href="../style.css"><link rel="stylesheet" href="print.css"><body onload="window.print()">' + document.body.innerHTML + '</html>');
                popupWin.document.close();
                document.location.href = 'payment.php?status=print';
        }

    </script>  
</body>
</html>