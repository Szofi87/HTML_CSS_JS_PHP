<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    $sql_games = "SELECT id, name, price, img FROM game";
    
    $result_games = mysqli_query($dbCon, $sql_games);

    $title = 'Játékok';
    require_once 'components/htmlstart.php';

    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>
    </div>
    <div class="row">
        <?php
        
            while($gameData = mysqli_fetch_assoc($result_games)) {
                ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="bg-white p-3 shadow text-center mb-3 gameBox">
                        <h5 class="mb-0"><?=$gameData['name']?></h5>
                        <div>
                            <img 
                            src="img/<?=$gameData['img']?>" 
                            alt="<?=$gameData['name']?> borító" 
                            title="<?=$gameData['name']?>">
                        </div>
                        <h4 class="mt-2"><?=number_format($gameData['price'], 0, '', ' ')?> Ft</h4>
                        <a href="datasheet.php?id=<?=$gameData['id']?>" class="btn btn-primary btn-sm">Adatlap</a>
                        <a href="php/cartengine.php?task=increase&id=<?=$gameData['id']?>" class="btn btn-success btn-sm">Kosárba</a>
                    </div>
                </div>
                <?php
            }

        ?>
    </div>
</div>

<?php
    require_once 'components/htmlend.php';

?>