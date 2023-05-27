<?php
    include "../condb.php";
    include "../data.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {        
        switch ($_POST['action']) {
            case 'room':
                $name = $_POST['name'];
                $type = $_POST['type'];     
                $id =  $_POST['id']; 
                $sql = "INSERT INTO `phong`(`MAPHONG`, `TENPHONG`, `LOAIPHONG`,`TRANGTHAI`) VALUES (?,?,?,'0')";
                if ($stmt = mysqli_prepare($conn,$sql)) {
        
                    mysqli_stmt_bind_param ($stmt,"sss",$id,$name,$type);
                    if (mysqli_stmt_execute($stmt)) {

                        header("location: svmanager.php?room=success");
                    } else{
                        if (mysqli_errno($conn) == 1062)
                        {
                            header("location: svmanager.php?room=fail");
                        }else{
                            header("location: svmanager.php?room=error");
                        } 
                    }
                    mysqli_stmt_close($stmt);
                }
                break;

            case 'coupon':
                    $name = $_POST['name'];
                    $sday = $_POST['sday'];
                    $eday = $_POST['eday'];
                    $vlue = (float) str_replace(',','',$_POST['vlue']);
                    $type = $_POST['type'];
                    $condit = (int) str_replace(',','',$_POST['condition']);
                    $id = "KM".countCoupon().date_format(date_create($sday),"dm").date_format(date_create($eday),"dm");
                    $sql = "INSERT INTO `khuyenmai`(`MAKM`, `TENKM`, `NGAYBATDAU`, `NGAYKETTHUC`, `GIATRIKM`, `LOAIKM`, `DIEUKIEN`) VALUES (?,?,?,?,?,?,?)";

                    if ($stmt = mysqli_prepare($conn,$sql)) {
                        
                        mysqli_stmt_bind_param ($stmt,"sssssss",$id,$name,$sday,$eday,$vlue,$type,$condit);
                        if (mysqli_stmt_execute($stmt)) {
                            header("location: svmanager.php?coupon=success");
                        } else{
                            header("location: svmanager.php?coupon=error");

                        }
                        mysqli_stmt_close($stmt);
                    }
                    break;
            case 'service':
                $name = $_POST['name'];
                $id = $_POST['id'];
                $price = (float) str_replace(',','',$_POST['price']);

                $sql = "INSERT INTO `loaidichvu`(`MADV`, `TENDV`, `DONGIADV`) VALUES (?,?,?)";
                if ($stmt = mysqli_prepare($conn,$sql)) {
        
                    mysqli_stmt_bind_param ($stmt,"sss",$id,$name,$price);
                    if (mysqli_stmt_execute($stmt)) {
                        header("location: svmanager.php?service=success");
                    } else{
                        if (mysqli_errno($conn) == 1062)
                        {
                            header("location: svmanager.php?service=fail");
                        }else{
                            header("location: svmanager.php?service=error");
                        }
                    }
                    mysqli_stmt_close($stmt);
                }
                break;
            default:
                echo $_POST['action'];
                exit();
                break;
        }
    

    }
    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);
        deleteRoom($id);
        header("location: svmanager.php");
    }
    if (isset($_GET['deletecoupon'])) {
        $id = trim($_GET['deletecoupon']);
        deleteCoupon($id);
        header("location: svmanager.php");
    }
    if (isset($_GET['deleteservice'])) {
        $id = trim($_GET['deleteservice']);
        deleteService($id);
        header("location: svmanager.php");
    }
?>
