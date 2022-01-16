<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        $sql_gameData = 
        "SELECT category.name AS category, game.name, game.price, game.platform, game.language, game.age_group, game.description, game.img 
        FROM game INNER JOIN category ON category.id=game.category
        WHERE game.id=$id";
        $result_gameData = mysqli_query($dbCon, $sql_gameData);

        if(mysqli_num_rows($result_gameData) == 1) {
            
            $gameData = mysqli_fetch_assoc($result_gameData);
        } else {
            
            header('Location: games.php');
        }

    } else {
        header('Location: games.php');
    }

   
    $title = $gameData['name'];
    require_once 'components/htmlstart.php';

    
    require_once 'components/navbar.php';

?>


<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>

        <div class="col-12 col-md-6 text-center mb-4">
            <img src="img/<?=$gameData['img']?>" alt="<?=$gameData['name']?> borítókép" title="<?=$gameData['name']?>" class="img-fluid shadow">
        </div>

        <div class="col-12 col-md-6 mb-4">
            <table class="table table-light table-striped table-borderless shadow mb-5">
                <tr>
                    <td>Kategória:</td>
                    <td><?=$gameData['category']?></td>
                </tr>
                <tr>
                    <td>Platform:</td>
                    <td><?=$gameData['platform']?></td>
                </tr>
                <tr>
                    <td>Nyelv:</td>
                    <td><?=$gameData['language']?></td>
                </tr>
                <tr>
                    <td>Korhatár:</td>
                    <td><?=$gameData['age_group']?>+</td>
                </tr>
            </table>
            
            <h3 class="text-center mb-5"><?=number_format($gameData['price'],0,'',' ')?> Ft</h3>

            <div class="text-center">
                <a href="php/cartengine.php?task=increase&id=<?=$id?>" class="btn btn-success btn-lg">Kosárba</a>
            </div>

        </div>

        <div class="col-12">
            <div class="bg-white shadow mb-4 px-3 pt-3 pb-1">
                <?=$gameData['description']?>
            </div>
        </div>

    </div>
</div>


<?php

    require_once 'components/htmlend.php';

?>