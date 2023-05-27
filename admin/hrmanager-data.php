<?php

    include "../condb.php";
    include "../data.php";
    $name = $_POST['name'];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }else{
        $id = $_GET['update'];
    }
    
    $gender = $_POST['gender'];     
    $bday = $_POST['bday'];     
    $number = $_POST['number'];     
    $address = $_POST['address'];  
    $wdate = $_POST['wdate']; 
    $role = 1;
    $password  = 'Abcd@123';
    if (isset($_GET['update'])) {
        $sql = "UPDATE `nhanvien` SET `PASSWORD`=?,`TENNV`=?,`CHUCVU`=?,`NGAYSINH`=?,`GIOITINH`=?,`DIACHI`=?,`SDTNV`=?,`NGAY`=? WHERE `MANV`=?";
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param ($stmt,"ssisissss",$password,$name,$role,$bday,$gender,$address,$number,$wdate,$id);
            if (mysqli_stmt_execute($stmt)) {
                header("location: hrmanager.php?status=update-success");
            } else{
                header("location: hrmanager.php?status=update-error");
            }
            mysqli_stmt_close($stmt);
        }
    }
    else{
        $sql = "INSERT INTO `nhanvien`(`MANV`, `PASSWORD`, `TENNV`, `CHUCVU`, `NGAYSINH`, `GIOITINH`, `DIACHI`, `SDTNV`, `NGAY`) VALUES (?,?,?,?,?,?,?,?,?)";
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param ($stmt,"sssisisss",$id,$password,$name,$role,$bday,$gender,$address,$number,$wdate);
            if (mysqli_stmt_execute($stmt)) {
                header("location: hrmanager.php?status=success");
            } else{
                if (mysqli_errno($conn) == 1062)
                {
                    header("location: hrmanager.php?status=fail");
                }else{
                    header("location: hrmanager.php?status=error");
                } 
            }
            mysqli_stmt_close($stmt);
        }
    }
    if (isset($_GET['delete'])) {
        $id = trim($_GET['delete']);
        deleteStaff($id);
        header("location: hrmanager.php");
    }

?>
