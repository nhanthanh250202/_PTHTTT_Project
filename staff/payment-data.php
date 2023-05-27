<?php
    include "../condb.php";
    include "../data.php";
    session_start();
    ob_start();
    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);

        deleteOrder($id);
        setStatRoom($room, 0);
        header("location: payment.php");
    }
    if (isset($_GET['update'])) {
        $room = trim($_GET['update']);
        $id = trim($_GET['id']);
        setStatRoom($room, 1);
        setTimeIn($id);
        header("location: payment.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $bill_id = "HD" . time();
        $coupon = $_POST['coupon'];
        // if ($_POST['coupon']='') {
        //     $coupon = 'KM000000000';
        // }
        // echo $coupon;
        // exit();

        $bill = $_POST['bill'];
        $discount_bill = $_POST['coupon_discount'];
        $staff = $_SESSION['user'];
        $room = getInforOrder($id)['MAPHONG'];
        $guest = getInforOrder($id)['MAKH'];
        if (isset( $_POST['select'])){
            $amount = [];
            foreach ($_POST['amount'] as $value) {
                if($value != 0){
                    array_push($amount,$value);
                }
            }
            $selection = $_POST['select'];
            for ($i=0; $i < count($selection); $i++) {
                $sql = "INSERT INTO `phieudat`(`index`, `MAPD`, `MANV`, `MAKH`, `MAPHONG`, `MADV`, `GIODAT`, `GIOVAO`, `GIORA`, `SOTIENCOC`, `GHICHU`) VALUES ('',?,?,?,?,?,'','','','',?)";
                if ($stmt = mysqli_prepare($conn,$sql)) {
                    mysqli_stmt_bind_param ($stmt,"ssssss",$id,$staff,$guest,$room,$selection[$i],$amount[$i]);
                    if (mysqli_stmt_execute($stmt)) {
                        continue;
                    } else{
                        header("location: payment.php?pay=error");    
                        exit();           
                    }
                    mysqli_stmt_close($stmt);
                }     
            }
        } 

        $sql = "INSERT INTO `thanhtoan`(`MAKM`, `MAPD`, `MAHD`,`TONGKM` ,`TONGTIEN`) VALUES (?,?,?,?,?)";
        if ($stmt = mysqli_prepare($conn,$sql)) {
            
            mysqli_stmt_bind_param ($stmt,"sssss",$coupon,$id,$bill_id,$discount_bill,$bill);
            if (mysqli_stmt_execute($stmt)) {
                setStatRoom($room,0);
                header("location: payment.php?status=success&id=".$id);
            } else{
                header("location: payment.php?status=error");

            }
            mysqli_stmt_close($stmt);
        }
    }
?>