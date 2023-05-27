<?php
    session_start();
    ob_start();
    include "../condb.php";
    include "../data.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        $staff = $_SESSION['user']   ;   
        $name  = $_POST['name'];
        $number  = $_POST['number'];
        $ortime  = $_POST['ortime'];
        $intime  = $_POST['intime'];
        
        $premo  = (int) str_replace(',','',$_POST['premo']) ;
        $id  = $staff . "-" . time();
        
        $note = $_POST['note'];
        if (!isset($_POST['room'])) {
            header("location: dashboard.php?status=empty-room");
            exit();
        }else{
            $room  = $_POST['room'];
        }
        if( $_POST['type-of-room'] == 1){
            $type_room  = "_VIP";
        }else{
            $type_room  = "_NOR";
        };


        $id_customer =getIdCustomer($name,$number);

        if ($id_customer != false) {
            $sql = "INSERT INTO `phieudat`(`index`, `MAPD`, `MANV`, `MAKH`, `MAPHONG`, `MADV`, `GIODAT`, `GIOVAO`, `GIORA`, `SOTIENCOC`, `GHICHU`) VALUES ('',?,?,?,?,?,?,?,'',?,?)";
            if ($stmt = mysqli_prepare($conn,$sql)) {
                mysqli_stmt_bind_param ($stmt,"sssssssss",$id,$staff,$id_customer,$room,$type_room,$ortime,$intime,$premo,$note);

                if (mysqli_stmt_execute($stmt)) {
                    if ($_POST['ortime'] ==  $_POST['intime']) {
                        if(setStatRoom($_POST['room'], 1)){
                            header("location: dashboard.php?status=success");
                        }else
                        {
                            header("location: dashboard.php?status=error");
                        }
                    }else{
                        header("location: dashboard.php?status=success");
                    }
                } else{
                    header("location: dashboard.php?status=error");
                    exit();
                }
                mysqli_stmt_close($stmt);
            }
        }

    }
?>