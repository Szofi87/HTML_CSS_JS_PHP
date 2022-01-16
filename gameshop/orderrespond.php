<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

   
    $title = 'Rendelés eredménye';
    require_once 'components/htmlstart.php';


    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>

        <?php
        
            if(isset($_GET['order']) && isset($_GET['id']) && $_GET['order'] == 'success' && !empty($_GET['id'])) {
               
                ?>
                <h3 class="col-12 text-center mb-3">A rendelés leadása sikeres volt.</h3>
                <a href="games.php" class="btn btn-lg btn-secondary ml-auto mb-4 mr-2">Vissza a játékokhoz</a>
                <a href="ordersummary.php?id=<?=$_GET['id']?>" class="btn btn-lg btn-primary mr-auto mb-4">Rendelés részletei</a>
                <?php

            } else {
                
                ?>
                <h3 class="col-12 text-center mb-3">A rendelés leadása sikertelen volt!</h3>
                <p class="col-12 mb-3 text-center">Kérlek, minél hamarabb vedd fel a kapcsolatot az oldal üzemeltetőjével!</p>
                <a href="contact.php" class="btn btn-primary btn-lg mx-auto mb-4">Kapcsolat</a>
                <?php
            }

        ?>

    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>