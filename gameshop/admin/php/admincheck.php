<?php

    session_start();

   
    if(isset($_SESSION['adminId'])) {
       
        $adminId = $_SESSION['adminId'];
    } else {
      
        header('Location: login.php');
    }

?>