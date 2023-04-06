<?php 

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    date_default_timezone_set("Asia/Phnom_Penh");

    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('index.php');
    }

    if(isset($_POST['pay_now'])){
        
        //Insert payment data into database

        $ORDER_ID = 'ORD_'.$_SESSION['uID'].random_int(11111,99999);

        $frm_data = filteration($_POST);
        
        $query1 = "INSERT INTO `booking_order`(`user_id`,`room_id`,`check_in`,`check_out`,`order_id`) VALUES (?,?,?,?,?)";
        
        $values1 = [$_SESSION['uID'],$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ORDER_ID];

        insert($query1,$values1,'issss');

        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `booking_details` (`booking_id`,`room_name`,`price`,`total_pay`,`user_name`,`phonenum`,`address`) VALUES (?,?,?,?,?,?,?)";

        $values2 = [$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$_SESSION['room']['payment'],$frm_data['name'],$frm_data['phonenum'],$frm_data['address']];

        insert($query2,$values2,'issssss');
        
        $total_pay = $_SESSION['room']['payment'];

        unset($_SESSION['room']);

        function regenerate_session($uid){
            $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uid],'i');
            $user_fetch = mysqli_fetch_assoc($user_q);

            $_SESSION['login'] = true;
            $_SESSION['uID'] = $user_fetch['id'];
            $_SESSION['uName'] = $user_fetch['name'];
            $_SESSION['uPic'] = $user_fetch['profile'];
            $_SESSION['uPhone'] = $user_fetch['phonenum'];
            
        }

        $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$ORDER_ID'";

        $slct_res = mysqli_query($con,$slct_query);

        if(mysqli_num_rows($slct_res)==0){
            redirect('index.php');
        }

        $slct_fetch = mysqli_fetch_assoc($slct_res);

        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            regenerate_session($slct_fetch['user_id']);
        }

        $upd_query = "UPDATE `booking_order` SET `booking_status`='booked', `total_pay`='$total_pay' WHERE `booking_id` = '$slct_fetch[booking_id]' ";

        mysqli_query($con,$upd_query);

        redirect('pay_status.php?order='.$ORDER_ID);


    }   

?>