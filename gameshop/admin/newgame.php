<?php

    require_once 'php/admincheck.php';

    require_once 'php/dbwebshop.php';

    $msgArray = array();

    if(isset($_POST['upload'])) {

        if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name'])) {
        
            if($_FILES['img']['type'] == 'image/jpeg') {

        
                $img = $adminId.time().'.jpg';

                if(!file_exists('../img/'.$img)) {

                    if(!move_uploaded_file($_FILES['img']['tmp_name'], '../img/'.$img)) {
                        $msgArray[] = 'Hiba! Borítókép feltölése sikertelen!';
                    }

                } else {
                    $msgArray[] = 'Hiba! Képnév ütközés. Próbáld újra!';
                }

            } else {
                $msgArray[] = 'A borítókép nem jpeg formátumú!';
            }
        } else {
            $msgArray[] = 'Borítókép tallózása sikertelen!';
        }

    
        if(empty($msgArray)) {

            $name = $_POST['name'];
            $category = $_POST['category'];
            $price = $_POST['price'];
            $platform = $_POST['platform'];
            $language = $_POST['language'];
            $age_group = $_POST['age_group'];
            $description = $_POST['description'];

            if(strlen($name) < 4 || strlen($name) > 100) {
                $msgArray[] = 'A név hossza nem megfelelő!';
            }

            if($price < 1) {
                $msgArray[] = 'Az ár nem lehet kisebb, mint 1!';
            }

            if(strlen($platform) < 3 || strlen($platform) > 20) {
                $msgArray[] = 'A platform hossza nem megfelelő!';
            }

            if(strlen($language) < 5 || strlen($language) > 50) {
                $msgArray[] = 'A nyelv hossza nem megfelelő!';
            }

            if($age_group < 0 || $age_group > 99) {
                $msgArray[] = 'A megadott kor nem megfelelő!';
            }

            if(empty($description)) {
                $msgArray[] = 'A leírás megadása kötelező!';
            }

        }

    
        if(empty($msgArray)) {

           
            $sql_newGame = 
            "INSERT INTO game(name, category, price, platform, language, age_group, description, img) 
            VALUES 
            ('$name', '$category', '$price', '$platform', '$language', '$age_group', '$description', '$img')";

            if(mysqli_query($dbWebshop, $sql_newGame)) {
                $msgArray[] = 'Új játék sikeresen feltöltve!';
            } else {
                $msgArray[] = 'Sikertelen feltöltés! (SQL)';
            }

        }

    }

    $title = 'Új játék feltöltése';

    require_once 'components/htmlstart.php';

?>

<div class="container bg-light">
    <div class="row">
        <div class="col-3">
            <a href="index.php" class="btn btn-sm btn-dark mt-3">Vissza</a>
        </div>
        <h1 class="col-6 text-center my-3"><?=$title?></h1>
    </div>

    <div class="row">
        <?php
        
            if(count($msgArray) > 0) {
                ?>
                <div class="col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 mx-auto text-center bg-white shadow p-3 mb-4">
                    <ul>
                    <?php
                        foreach($msgArray as $msg) {
                            echo '<li>'.$msg.'</li>';
                        }
                    ?>
                    </ul>
                </div>
                <div class="col-12"></div>
                <?php
            }
        ?>

        <form action="" method="post" class="form-group text-center bg-white shadow p-3 mb-4 col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 mx-auto" enctype="multipart/form-data">

            <label>Játék neve:</label>
            <input type="text" name="name" minlength="4" maxlength="100" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Kategória:</label>
            <select name="category" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8">
                <?php
                
                    $result_catOptions = mysqli_query($dbWebshop, "SELECT * FROM category");
                    while($catOption = mysqli_fetch_assoc($result_catOptions)) {
                        echo ' <option value="'.$catOption['id'].'">'.$catOption['name'].'</option> ';
                    }

                ?>
            </select>

            <label>Ár:</label>
            <input type="number" name="price" min="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Platform:</label>
            <input type="text" name="platform" minlength="3" maxlength="20" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Nyelv:</label>
            <input type="text" name="language" minlenght="5" maxlength="50" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Korhatár:</label>
            <input type="number" name="age_group" min="0" max="99" step="1" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <label>Leírás:</label>
            <textarea name="description" rows="5" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required></textarea>

            <label>Borítókép:</label>
            <input type="file" name="img" accept="image/jpeg" class="form-control mb-3 mx-auto col-12 col-md-10 col-lg-8" required>

            <button type="submit" name="upload" class="btn btn-dark">Feltöltés</button>

        </form>
    </div>

</div>

<?php

    require_once 'components/htmlend.php';

?>