<?php
    include "../condb.php";
    include "../data.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        switch ($_POST['action']) {
            case 'device':
                $name = $_POST['name'];
        
                $id  = $_POST['id'];
            
                $sql = "INSERT INTO `thietbi`(`MATB`, `TENTB`) VALUES (?,?)";
                if ($stmt = mysqli_prepare($conn,$sql)) {
                    mysqli_stmt_bind_param ($stmt,"ss",$id,$name);
                    if (mysqli_stmt_execute($stmt)) {
                        header("location: fcmanager.php?device=success");
                    } else{
                        header("location: fcmanager.php?device=error");
                    }
                    mysqli_stmt_close($stmt);
                }
                break;
            case 'rdevice':
                $room = $_POST['room'];
                $device  = $_POST['device'];
                $amount  = $_POST['amount'];
                $note  = $_POST['note'];
            
                $sql = "INSERT INTO `thuoc`(`MAPHONG`, `MATB`, `TINHTRANG`, `GHICHUTB`) VALUES (?,?,?,?)";
                // echo $room, $device,$amount,$note;
                if ($stmt = mysqli_prepare($conn,$sql)) {
                    mysqli_stmt_bind_param ($stmt,"ssis",$room,$device,$amount,$note);
                    if (mysqli_stmt_execute($stmt)) {
                        header("location: fcmanager.php?device=success");
                    } else{
                        header("location: fcmanager.php?device=error");
                    }
                    mysqli_stmt_close($stmt);
                }
                break;
            
            default:
                break;
        }


    }
    if (isset($_GET['deletedevice'])) {
        $id = trim($_GET['deletedevice']);
        deleteDevice($id);
        header("location: fcmanager.php");
    }
    if (isset($_GET['del'])&& isset($_GET['room'])) {
        $device = $_GET['del'];
        $room = $_GET['room'];
        deleteDeviceInRoom($device,$room);
        header("location: fcmanager.php");
    }
?>