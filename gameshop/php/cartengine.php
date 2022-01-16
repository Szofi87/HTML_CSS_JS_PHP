<?php

    session_start();

    function checkGameId($gameId) {
    
        require 'database.php';

        $result = mysqli_query($dbCon, "SELECT id FROM game WHERE id=$gameId");
        return mysqli_num_rows($result) == 1;
    }

    
    if(isset($_GET['task'])) {
        $task = $_GET['task'];

       
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

           
            if($task == 'increase') {
               
                if(isset($_SESSION['cart'])) {
                  
                    if(isset($_SESSION['cart'][$id])) {
                       
                        if($_SESSION['cart'][$id] < 3) {
                           
                            $_SESSION['cart'][$id]++;
                        }
                    } else {
                       
                        if(checkGameId($id)) {
                            
                            $_SESSION['cart'][$id] = 1;
                        }
                    }
                } else {
                   
                    if(checkGameId($id)) {
                        
                        $_SESSION['cart'] = array();
                       
                        $_SESSION['cart'][$id] = 1;
                    }
                }
            }

            if($task == 'decrease') {
                
                if(isset($_SESSION['cart'][$id])) {
                    
                    if($_SESSION['cart'][$id] > 1) {
                        
                        $_SESSION['cart'][$id]--;
                    } else {
                        
                        unset($_SESSION['cart'][$id]);
                    }
                }
            }

            
            if($task == 'delete') {
                
                if(isset($_SESSION['cart'][$id])) {
                    
                    unset($_SESSION['cart'][$id]);
                }
            }

        }

       
        if($task == 'empty') {
           
            if(isset($_SESSION['cart'])) {
                
                unset($_SESSION['cart']);
            }
        }

    }

  
    if(empty($_SESSION['cart'])) {
      
        unset($_SESSION['cart']);
    }
    header('Location: ../cart.php');

?>