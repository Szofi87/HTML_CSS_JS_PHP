<?php

    require_once 'php/admincheck.php';
  
    $title = 'Főoldal';
  
    require_once 'components/htmlstart.php';

?>

<div class="container">
    <div class="row">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5 mx-auto mt-4 p-3 shadow bg-light rounded text-center">
            <h4>GameShop Adminisztráció</h4>

            <a href="newgame.php" class="btn btn-lg btn-dark d-block mt-5">Új játék felöltése</a>

            <a href="php/logout.php" class="btn btn-outline-danger d-block mt-4">Kijelentkezés</a>

        </div>
    </div>
</div>

<?php
  
    require_once 'components/htmlend.php';

?>