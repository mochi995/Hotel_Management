<?php 

    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    require('../inc/sendgrid/sendgrid-php.php');
    date_default_timezone_set("Asia/Phnom_Penh");
    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('index.php');
    }

    if(isset($_POST['cancel_booking'])){
        $frm_data = filteration($_POST);
        
        $qeury = "UPDATE `booking_order` SET `booking_status`=?, `refund`=?
            WHERE `booking_id`=? AND `user_id`=?";

        $values = ['cancelled',0,$frm_data['id'],$_SESSION['uID']];

        $result = update($qeury,$values,'siii');

        echo $result;

    }


?>