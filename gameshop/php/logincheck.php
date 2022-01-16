<?php

    session_start();

    $login = false;

  
    if(isset($_SESSION['userId'])) {
        
        $loginUserId = $_SESSION['userId'];
        $login = true;
    }

?>