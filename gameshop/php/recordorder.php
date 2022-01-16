<?php

    require_once 'database.php';

   
    require_once 'logincheck.php';

    $error = (!$login || !isset($_SESSION['cart']));

    if(!$error) {
        $error = 
        (!isset($_POST['bill_name']) 
        || !isset($_POST['bill_address']) 
        || !isset($_POST['payment_mode']) 
        || !isset($_POST['delivery_address']) 
        || !isset($_POST['delivery_mode']));
    }
    
    if(!$error) {
        $bill_name = $_POST['bill_name'];
        $bill_address = $_POST['bill_address'];
        $payment_mode = $_POST['payment_mode'];
        $delivery_address = $_POST['delivery_address'];
        $delivery_mode = $_POST['delivery_mode'];

        $error =
        (strlen($bill_name) > 100 
        || strlen($bill_address) > 100
        || strlen($payment_mode) > 20
        || strlen($delivery_address) > 100
        || strlen($delivery_mode) > 20);
    }

    if(!$error) {
        
        do {
            
            $order_number = $loginUserId.time();

            
            $result_checkOrderNumber = mysqli_query($dbCon, "SELECT `id` FROM `order` WHERE `order_number` LIKE '$order_number'");

          

        } while(mysqli_num_rows($result_checkOrderNumber) != 0);
        

        

        $sql_recordOrder = 
        "INSERT INTO `order`(`order_number`, `client`, `bill_name`, `bill_address`, `payment_mode`, `delivery_address`, `delivery_mode`)
        VALUES('$order_number', $loginUserId, '$bill_name', '$bill_address', '$payment_mode', '$delivery_address', '$delivery_mode')";

      
        $error = !mysqli_query($dbCon, $sql_recordOrder);

    }

    
    if(!$error) {
        
        $result_orderId = mysqli_query($dbCon, "SELECT `id` FROM `order` WHERE `order_number` LIKE '$order_number'");
        $orderId = mysqli_fetch_assoc($result_orderId);
        $orderId = $orderId['id'];

        
        foreach($_SESSION['cart'] as $gameId => $qty) {
           
            $result_gamePrice = mysqli_query($dbCon, "SELECT price FROM game WHERE id=$gameId");
            $gamePrice = mysqli_fetch_assoc($result_gamePrice);
            $gamePrice = $gamePrice['price'];

            
            $sql_recordItem =
            "INSERT INTO `order_item`(`order`, `game`, `order_price`, `qty`) VALUES ($orderId, $gameId, $gamePrice, $qty)";
           
            if(!mysqli_query($dbCon, $sql_recordItem)) {
                $error = true;
            }

        }

    }

    
    if(!$error) {
        
        unset($_SESSION['cart']);
       
        header('Location: ../orderrespond.php?order=success&id='.$orderId);
    } else {
        
        header('Location: ../orderrespond.php?order=error');
    }

    

    

?>