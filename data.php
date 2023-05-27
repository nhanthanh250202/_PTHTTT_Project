<?php

/**********************************
 *@      QUẢN LÍ TÀI KHOẢN
 **********************************/ 
    function checkAccount($user, $pass){
        include "condb.php";
        $sql = "SELECT * FROM `nhanvien` WHERE `MANV` = '$user' AND `PASSWORD` = '$pass'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function getInforUser($user){
        include "condb.php";

        $sql = "SELECT * FROM `nhanvien` WHERE `MANV` = '$user'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function updatePassword($user, $pass){
        include "condb.php";
        $sql = "UPDATE `nhanvien` SET `PASSWORD`= ? WHERE `MANV` = ?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "ss",$param_pass, $param_id);
            $param_id = $user;
            $param_pass = $pass;
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
            else{
                return false;
            }
        }     
    }
    function checkAdminRole(){
        if (!isset($_SESSION['name'])&&!isset($_SESSION['user'])&&!isset($_SESSION['role'])) {
           return false;
        }
        if($_SESSION['role']==1){
            return false;
        }
        return true;
    }
    function checkStaffRole(){
        if (!isset($_SESSION['name'])&&!isset($_SESSION['user'])&&!isset($_SESSION['role'])) {
           return false;
        }
        if($_SESSION['role']==0){
            return false;
        }
        return true;
    }
/*********************************
 *@       QUẢN LÝ NHÂN VIÊN
 **********************************/ 

    function selectAllStaff(){
        include "condb.php";
        $sql = "SELECT * FROM `nhanvien` WHERE `CHUCVU`=1 ";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style='width: 10%'>" .$row['MANV'] . "</td>";
                        echo "<td style='width: 25%'>" .$row['TENNV'] . "</td>";
                        if ($row['GIOITINH']==0) {
                            $gender = "Nữ";
                        }else{
                            $gender = "Nam";
                        }
                        echo "<td style='width: 5%'>" .$gender . "</td>";
                        $bdate=date_create($row['NGAYSINH']);
                        echo "<td style='width: 10%'>" .date_format($bdate,"d/m/Y") . "</td>";
                        echo "<td style='width: 25%; text-align: left'>" .$row['DIACHI'] . "</td>";
                        echo "<td style='width: 10%;'>" .$row['SDTNV'] . "</td>";
                        $wdate=date_create($row['NGAY']);
                        echo "<td style='width: 10%'>" .date_format($wdate,"d/m/Y") . "</td>";
                        echo "<td style = 'width: 5% ; text-align: center'>";
                            echo "<a href='hrmanager.php?update=".$row['MANV']."' title = 'Update' data-toggle = 'tooltip'><i class='ri-edit-circle-fill'></i></a> ";
                            echo "<a href='hrmanager.php?delete=".$row['MANV']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '8'>Hiện tại không có nhân viên</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }
    function deleteStaff($id){
        include "condb.php";
        $sql = "DELETE FROM `nhanvien` WHERE `MANV` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return true;

            }
            else{
                mysqli_close($conn);
                return false;
            }
        }
        
        
    } 


/**********************************
 *@        QUẢN LÝ PHÒNG          
 **********************************/ 
    function getInforRoom($id){
        include "condb.php";

        $sql = "SELECT * FROM `phong` WHERE `MAPHONG` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function selectAllRoom(){
        include "condb.php";
        $sql = "SELECT * FROM `phong`";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td>" .$row['MAPHONG'] . "</td>";
                        echo "<td>" .$row['TENPHONG'] . "</td>";
                        switch ($row['LOAIPHONG']) {
                            case '1':
                                $type = "VIP";
                                break;
                            
                            case '2':
                                $type = "Thường";
                                break;
                            
                            case '3':
                                $type = "BigSize";
                                break;
                            
                            default:
                                break;
                        }
                        echo "<td>" .$type . "</td>";
                        echo "<td style = 'width: 5% ; text-align: center'>";
                            echo "<a href='svmanager.php?delete=".$row['MAPHONG']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '4'>Hiện tại không có phòng</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }
    function deleteRoom($id){
        include "condb.php";
        $sql = "DELETE FROM `phong` WHERE `MAPHONG` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                return true;

            }
            else{
                return false;
            }
        }
        
        
    }
    function selectFreeRoom($type,$time){
        include "condb.php";
        $sql = "SELECT * FROM `phong` WHERE IF( '$time' < ADDTIME(CURRENT_TIMESTAMP,'4:0:0'),TRANGTHAI = 0,1) AND LOAIPHONG = $type ORDER BY `phong`.`LOAIPHONG` ASC;";

        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<option value=''>--Chọn phòng--</option>";
                while ($row = mysqli_fetch_array($result)) {
                    if(strtotime($time) >= strtotime(getCurrentTime('Y-m-d H:i:s'))+12*3600){
                        echo "<option value='".$row['MAPHONG']."'>".$row['MAPHONG']." - ".$row['TENPHONG']."</option>";
                    }else{
                        if (canOrderNow($row['MAPHONG'],$time)) {
                            echo "<option value='".$row['MAPHONG']."'>".$row['MAPHONG']." - ".$row['TENPHONG']."</option>";
                        }
                        
                    }
                }
                mysqli_free_result($result);

            }
            else{
                echo "<option value=''>Hiện tại đã hết phòng</option>";
            }
        }
        else{
            echo "<option value=''Lỗi truy vấn</option>";
        }
        
    }
    function renderAllRoom(){
        include "condb.php";
        $sql = "SELECT * FROM `phong` ORDER BY `phong`.`LOAIPHONG` ASC";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td style='width: 25%'>" .$row['MAPHONG'] . "</td>";
                    echo "<td style='width: 25%'>" .$row['TENPHONG'] . "</td>";
                    if($row['LOAIPHONG'] == 1){
                        $type = "VIP";
                    }else{
                        $type = "Thường";
                    }
                    echo "<td style='width: 25%'>" . $type. "</td>";
                    if($row['TRANGTHAI'] == 0){
                        $color = "green";
                        $sts = "Trống";
                    }else{
                        $color = "red";
                        $sts = "Đang sử dụng";
                    }
                    echo "<td style='width: 25%; color:".$color."' >" . $sts. "</td>";
                    echo "</tr>";
                }
                mysqli_free_result($result);

            }
            else{
                echo "<tr> <td>Hiện chưa có phòng</td></tr>";
            }
        }
        else{
            echo "<tr> <td>Lỗi truy vấn</td></tr>";
        }
    }
    function isPreorder($select_time,$preorder_time){
        if (strtotime($select_time) > (strtotime($preorder_time)+ 60*60))
        {
            //! Đặt phòng sau thời gian người khác đặt 1 tiếng
            return true;
        }
        else{
            //! Không thể đặt phòng!
            return false;
        }
    }

    function canOrderNow($id,$time){
        include "condb.php";
        $sql = "SELECT * FROM `phieudat` WHERE `MAPHONG` ='$id'" ;

        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                
                while ($row = mysqli_fetch_array($result)) {
                    if (strtotime($time)<= (strtotime($row['GIOVAO'])-120*60)) {
                        continue;
                    }else{
                        if (!isPreorder($time,$row['GIOVAO'])) {
                            //!Không thể đặt phòng này
                            return false;
                        }
                    }
                }
                mysqli_free_result($result);
                //!Có thể đặt
                return true;
            }
            else{
                return true;
            }
        }
        else{
           return -1;
        }

    }
    function setStatRoom($id,$tag)
    {   
        //TODO $tag: 0 - set phòng trống, 1 - set phòng bận 
        include "condb.php";

        $sql = "UPDATE `phong` SET `TRANGTHAI`= ? WHERE `MAPHONG`= ?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "ss",$param_stat, $param_id);
            $param_id = $id;
            $param_stat = $tag;
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
            else{
                return false;
            }
        }  
    }
    function getStatRoom($id)
    {   
        include "condb.php";
        $sql = "SELECT * FROM `phong` WHERE `MAPHONG` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row['TRANGTHAI'];
        }
        else{
            return false;
        }
    }


/**********************************
 *@        QUẢN LÍ KHUYẾN MÃI
 **********************************/ 

    function countCoupon(){
        include "condb.php";
        $sql = "SELECT COUNT(MAKM) as 'RESULT' FROM `khuyenmai`" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row['RESULT']+1;
        }
        else{
            return false;
        }

    }
    function selectAllCoupon(){
        include "condb.php";
        $sql = "SELECT * FROM `khuyenmai` WHERE NOT LOAIKM = 0";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style = 'width: 30%'>" .$row['TENKM'] . "</td>";
                        $sdate=date_create($row['NGAYBATDAU']);
                        echo "<td style = 'width: 20%'>" .date_format($sdate,"d/m/Y");
                        $sdate=date_create($row['NGAYKETTHUC']);
                        echo " - " .date_format($sdate,"d/m/Y") . "</td>";

                        switch ($row['LOAIKM']) {
                            case '1':
                                $type = "% vào ngày thường";
                                break;
                            
                            case '2':
                                $type = "% vào cuối tuần";
                                break;
                            
                            case '3':
                                $type = "%";
                                break;
                            case '4':
                                $type = " đồng";
                                break;
                            
                            default:
                                break;
                        }
                        echo "<td style = 'width: 40%'>Giảm <b style= 'font-size: 1em; color: black;'>" .$row['GIATRIKM'] .$type . " </b>cho hóa đơn từ ". number_format($row['DIEUKIEN'])."đ</td>";
                        echo "<td style = 'width: 10% ; text-align: center'>";
                            echo "<a href='svmanager.php?deletecoupon=".$row['MAKM']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '4'>Hiện tại không có khuyến mãi</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }
    function selectValidCoupon($value){
        include "condb.php";
        $sql = "SELECT * FROM `khuyenmai` WHERE `NGAYKETTHUC`>= CURRENT_DATE AND `NGAYBATDAU`<= CURRENT_DATE AND `DIEUKIEN` <= '$value' AND IF (DAYOFWEEK(CURRENT_DATE) = '7' OR DAYOFWEEK(CURRENT_DATE) = '1',NOT `LOAIKM` = 1 ,NOT `LOAIKM` =2)";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<option value = 'KM000000000'>--Chọn khuyến mãi--</option>";
                while ($row = mysqli_fetch_array($result)) {
                    switch ($row['LOAIKM']) {
                        case '1':
                            $type =  $row['GIATRIKM'] . "% vào ngày thường";
                            break;
                        
                        case '2':
                            $type = $row['GIATRIKM'] . "% vào cuối tuần";
                            break;
                        
                        case '3':
                            $type = $row['GIATRIKM'] . "%";
                            break;
                        case '4':
                            $type = formatCurrency($row['GIATRIKM']);
                            break;
                        
                        default:
                            break;
                    }
                    echo "<option value = '".$row['MAKM']. "'> ".$row['TENKM']." - Giảm <b style= 'font-size: 1em; color: black;'>"  .$type . " </b>cho hóa đơn từ ". number_format($row['DIEUKIEN'])."đ</option>";
                }
                mysqli_free_result($result);
            }
            else{
                echo "<option value = 'KM000000000'>Hiện tại không có khuyến mãi</option>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }




    function deleteCoupon($id){
        include "condb.php";
        $sql = "DELETE FROM `khuyenmai` WHERE `MAKM` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                return true;

            }
            else{
                return false;
            }
        }
        
        
    }
    function getInforCoupon($id){
        include "condb.php";

        $sql = "SELECT * FROM `khuyenmai` WHERE `MAKM` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }

/**********************************
 *@         QUẢN LÍ PHỤ THU
 **********************************/ 
    function selectAllService(){
        include "condb.php";
        $sql = "SELECT * FROM `loaidichvu` ORDER BY `loaidichvu`.`MADV` DESC";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style = 'width: 20%'>" .$row['MADV'] . "</td>";
                        echo "<td style = 'width: 40%'>" .$row['TENDV'] . "</td>";
                        echo "<td style = 'width: 20%'>" . number_format($row['DONGIADV']). "</td>";
                
                        echo "<td style = 'width: 20% ; text-align: center'>";
                            echo "<a href='svmanager.php?deleteservice=".$row['MADV']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '4'>Hiện tại không có phụ thu</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }
    function deleteService($id){
        include "condb.php";

        $sql = "DELETE FROM `loaidichvu` WHERE `MADV` = ?;";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                return true;

            }
            else{
                return false;
            }
        }     
    }
    function getInforService($id){
        include "condb.php";

        $sql = "SELECT * FROM `loaidichvu` WHERE `MADV` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function countService(){
        include "condb.php";
        $sql = "SELECT COUNT(MADV) as 'RESULT' FROM `loaidichvu`" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row['RESULT']+1;
        }
        else{
            return false;
        }

    }
    function selectService(){
        include "condb.php";
        $sql = "SELECT * FROM `loaidichvu` WHERE MADV != '_VIP' AND MADV !='_NOR' ORDER BY `loaidichvu`.`MADV` DESC";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                $number = 1;
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style = 'width: 10%'>" .$number . "</td>";
                        echo "<td style = 'width: 30%'>" .$row['TENDV'] . "</td>";
                        echo "<td id='price-".$number."' style = 'width: 30%'>" . number_format($row['DONGIADV']). "</td>";
                        echo "<td style='width: 20%'><input id='amount-".$number."' type='number' name='amount[]' class='amount-input' value='0'></td>";
                        echo "<td style='width: 10%'><input id='check-".$number."' type='checkbox' name='select[]' class='service-selector' value='".$row['MADV']."'></td>";
                    echo "</tr>";
                    $number++;
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '4'>Hiện tại không có phụ thu</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);

    }
/**********************************
 *@        QUẢN LÍ THIẾT BỊ        
 **********************************/ 
    function countDevice($type){
        include "condb.php";
        $sql = "SELECT COUNT(MATB) as 'RESULT' FROM `thietbi` WHERE SUBSTRING(MATB,1,3) = '$type' " ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row['RESULT'];
        }
        else{
            return false;
        }

    }
    function selectAllDevice(){
        include "condb.php";
        $sql = "SELECT * FROM `thietbi`" ;
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style = 'width: 40%'>" .$row['MATB'] . "</td>";
                        echo "<td style = 'width: 40%'>" . $row['TENTB']. "</td>";
                
                        echo "<td style = 'width: 20% ; text-align: center'>";
                            echo "<a href='fcmanager.php?deletedevice=".$row['MATB']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '3'>Hiện tại không có thiết bị</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);
    }
    function getInforDevice($id){
        include "condb.php";

        $sql = "SELECT * FROM `thietbi` WHERE `MATB` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function deleteDevice($id){
        include "condb.php";
        $sql = "DELETE FROM `thietbi` WHERE `MATB` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = $id;
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
            else{
                return false;
            }
        }     
    }

    function selectAllDeviceInRoom($id){
        include "condb.php";
        $sql = "SELECT * FROM `thuoc` INNER JOIN `thietbi` ON thuoc.MATB = thietbi.MATB INNER JOIN `phong` ON thuoc.MAPHONG = phong.MAPHONG WHERE thuoc.MAPHONG = '$id'" ;
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                        echo "<td style = 'width: 20%'>" .$row['TENTB'] . "</td>";
                        echo "<td style = 'width: 20%'>" . $row['TINHTRANG']. "</td>";
                        echo "<td style = 'width: 40%'>" . $row['GHICHU']. "</td>";
                
                        echo "<td style = 'width: 20% ; text-align: center'>";
                            echo "<a href='fcmanager.php?del=".$row['MATB']."&room=".$id."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i></a> </td>";
                    echo "</tr>";
                }
                mysqli_free_result($result);
            }
            else{
                echo "<tr>";
                echo "<td colspan = '4'>Hiện tại không có thiết bị</td>";
                echo "</tr>";
            }
        }
        else{
            
        }
        mysqli_close($conn);
    }
    function deleteDeviceInRoom($id,$room){
        include "condb.php";
        $sql = "DELETE FROM `thuoc` WHERE `MATB` = ? AND `MAPHONG` = ? ";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_id,$param_room);
            $param_id = $id;
            $param_room = $room;
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
            else{
                return false;
            }
        }     
    }

/*********************************
 *@        QUẢN LÍ KHÁCH HÀNG
 *********************************/
    function getInforCustomer($id){
        include "condb.php";

        $sql = "SELECT * FROM `khachhang` WHERE `MAKH` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function lookUpCustomer($number){
        //! Trả về ID NẾU TÌM ĐƯỢC
        //! Trả về -1 nếu không tìm được và 0 khi không có số điện thoại
        include "condb.php";
        if ($number!= "") {
            $sql = "SELECT * FROM `khachhang` WHERE `SDTKH` LIKE '$number'" ;
            $query = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($query);
            if ($num ==1){
                $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
                return $row['MAKH'];
            }
            else{
                return -1;
            }
        }else{
            return 0;
        }
    }
    function getIdCustomer($name, $number){
        include "condb.php";

        $id = lookUpCustomer($number);
        if ($id == 0 || $id == -1)
        {
            if ($number != "") {
                $id = "KH". $number;
            }else{
                $id = "KH" . time();
            }
            $sql = "INSERT INTO `khachhang`(`MAKH`, `TENKH`, `SDTKH`) VALUES (?,?,?)";
            if ($stmt = mysqli_prepare($conn,$sql)) {
                mysqli_stmt_bind_param ($stmt,"sss",$id,$name,$number);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    return $id;
                } else{
                    return -1;
                }
            }

        }else{
            return $id;
        }
    }
/**********************************
 * @        QUẢN LÍ PHIẾU ĐẶT
 **********************************/
    function selectAllOrder(){
        include "condb.php";
    
         $sql = "SELECT * FROM `phieudat` INNER JOIN `khachhang` ON `phieudat`.`MAKH` = `khachhang`.`MAKH` LEFT JOIN `thanhtoan` ON `phieudat`.`MAPD` = `thanhtoan`.`MAPD` WHERE `phieudat`.GIODAT != '0' ORDER BY `phieudat`.`index` DESC";
        if($result = mysqli_query($conn,$sql)){
            if (mysqli_num_rows($result)>0){
                $count = 1;
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {

                    if ($row['MAHD'] == "") {
                        echo "<tr>";
                            echo "<td style='width:5%'>" .$count . "</td>";
                            echo "<td style='width:30%'>" .$row['TENKH'] . "</td>";
                            echo "<td style='width:10%'>" .$row['MAPHONG'] . "</td>";
                            if ($row['SDTKH'] == ""){
                                echo "<td style='width:15%'> - </td>";
                            }else{
                                echo "<td style='width:15%'>" .$row['SDTKH'] . "</td>";
                            }
                            $ordate=date_create($row['GIODAT']);
                            echo "<td style='width:10%'>" .date_format($ordate,"H:i d/m") . "</td>";
                            $indate=date_create($row['GIOVAO']);
                            echo "<td style='width:10%'>" .date_format($indate,"H:i d/m") . "</td>";
                            if ($row['SOTIENCOC'] == 0){
                                echo "<td style='width:20%' >Không</td>";
                            }else{
                                echo "<td style='width:20%'>" . formatCurrency($row['SOTIENCOC'])  . "</td>";
                            }
                            echo "<td style = 'text-align: center ; width:10%'>";
                                echo "<label class='hamburger'>
                                <input id='action-menu' type='checkbox'>
                                <svg viewBox='0 0 32 32'>
                                  <path class='line line-top-bottom' d='M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22'></path>
                                  <path class='line' d='M7 16 27 16'></path>
                                </svg>
                                <div> ";
                                if ($row['GIODAT'] != $row['GIOVAO'] && getStatRoom($row['MAPHONG'])== 0) {
                                    echo "<a href='payment.php?update=".$row[1]."' title = 'Xác nhận' data-toggle = 'tooltip'><i class='ri-contract-right-fill'></i> Xác nhận giao phòng</a> ";
                                }
                                echo "<a href='payment.php?pay=".$row[1]."' title = 'Thanh Toán' data-toggle = 'tooltip'><i class='ri-paypal-fill'></i> Thanh toán</a>";
                                echo "<a href='payment.php?delete=".$row[1]."' title = 'Xóa phiếu' data-toggle = 'tooltip'><i class='ri-delete-bin-2-fill'></i> Xóa phiếu</a> </div> </label> </td>";
                        echo "</tr>";
                        $count++;
                    }

                }
                if ($count == 1) {
                    echo "<tr>";
                    echo "<td colspan = '8'>Hiện tại không có phòng được đặt</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            }
            else{
                echo "<tr>";
                echo "<td colspan = '8'>Hiện tại không có phòng được đặt</td>";
                echo "</tr>";
            }
            mysqli_free_result($result);

        }

    }
    function getInforOrder($id){
        include "condb.php";
        $sql = "SELECT * FROM `phieudat` INNER JOIN `khachhang` ON `phieudat`.`MAKH` = `khachhang`.`MAKH` WHERE `MAPD` = '$id' ORDER BY `MADV` DESC" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function deleteOrder($id){
        include "condb.php";
        $sql = "DELETE FROM `phieudat` WHERE `MAPD` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return true;

            }
            else{
                mysqli_close($conn);
                return false;
            }
        }
        
        
    } 
    function setTimeIn($id){
        include "condb.php";
        $sql = "UPDATE `phieudat` SET `GIOVAO`=? WHERE `MAPD` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "ss",$param_time, $param_id);
            $param_time = getCurrentTime('Y-m-d H:i:s');
            $param_id = $id;


            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return true;

            }
            else{
                mysqli_close($conn);
                return false;
            }
        }
        
        
    } 
    function setTimeOut($id){
        include "condb.php";
        $sql = "UPDATE `phieudat` SET `GIORA`=? WHERE `MAPD` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "ss",$param_time, $param_id);
            $param_time = getCurrentTime('Y-m-d H:i:s');
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                return true;

            }
            else{
                return false;
            }
        }
    }
/*********************************
 *@          Các hàm khác
 ********************************/
    function getCurrentTime($format){
        //* định dạng 'Y-m-d H:i:s'
        date_default_timezone_set('Asia/Bangkok');
        $now = new DateTime();
        return $now->format($format);   
    }

    function notCheckForeginKey(){
        include "condb.php";
        $sql = "SELECT * FROM `loaidichvu` SET foreign_key_checks = 0" ;
        if (mysqli_query($conn,$sql)){
            return true;
        }
        else{
            return false;
        }
    }
    function formatCurrency($currency)
    {
        return number_format(sprintf('%0f', preg_replace("/[^0-9.]/", "", $currency)),0, '.', '.') . " đ";
    }

    function printUsingTime($id){
        $time_in = strtotime(getInforOrder($id)['GIOVAO']);
        $time_out = strtotime(getInforOrder($id)['GIORA']); 
        $hour= floor(abs($time_out - $time_in)/3600);
        $minute= round((abs($time_out - $time_in)/3600 - $hour)*60); 

        return $hour ." tiếng " . $minute." phút";
    }
    function calculatePriceRoom($id){
        $time_in = strtotime(getInforOrder($id)['GIOVAO']);
        $time_out = strtotime(getInforOrder($id)['GIORA']); 
        $room_service =  getInforOrder($id)['MAPHONG'];
        $room_type =  getInforRoom($room_service)['LOAIPHONG'];
        if ($room_type ==1 ) {
            $room_price =  getInforService('_VIP')['DONGIADV'];
        }else{
            $room_price =  getInforService('_NOR')['DONGIADV'];
        }
        $time_using= round(abs($time_out - $time_in)/3600,2); 
        $using_price = $time_using*$room_price;
        return $using_price;
    }

    function getBill($id){
        include "condb.php";
        $sql = "SELECT * FROM `thanhtoan` WHERE `MAPD` = '$id'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }

?>