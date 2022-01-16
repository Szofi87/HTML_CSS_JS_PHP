<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    if($login) {
        header('Location: index.php');
    }

    $regMsg = array();

   
    if(isset($_POST['reg'])) {

        
        $username = $_POST['username'];
        if(strlen($username) < 4) {
            $regMsg[] = 'A felhasználónév rövid! (min 4 karakter)';
        } else if(strlen($username) > 10) {
            $regMsg[] = 'A felhasználónév hosszú! (max 10 karakter)';
        } else {
            
            $result_checkUser = mysqli_query($dbCon, "SELECT id FROM client WHERE username LIKE '$username'");
            if(mysqli_num_rows($result_checkUser) > 0) {
                $regMsg[] = 'A választott felhasználónév foglalt!';
            }
        }

        
        $email = $_POST['email'];
        if(strlen($email) > 50) {
            $regMsg[] = 'Az e-mail cím hosszú! (max 50 karakter)';
        } else {
            
            $result_checkEmail = mysqli_query($dbCon, "SELECT id FROM client WHERE email LIKE '$email'");
            if(mysqli_num_rows($result_checkEmail) > 0) {
                $regMsg[] = 'A választott e-mail címmel már regisztráltak!';
            }
        }

        
        $password = $_POST['password'];
        $again = $_POST['again'];
        if(strlen($password) < 6) {
            $regMsg[] = 'A jelszó túl rövid! (min 6 karakter)';
        } else if(strlen($password) > 100) {
            $regMsg[] = 'A jelszó túl hosszú! (max 100 karakter)';
        } else if($password != $again) {
            $regMsg[] = 'A jelszó és a megerősítés nem egyezik!';
        }

       
        $bill_name = $_POST['bill_name'];
        if(empty($bill_name)) {
            $bill_name = "NULL";
        } else if(strlen($bill_name) > 100) {
            $regMsg[] = 'A számlázási név hosszú! (max 100 karakter)';
        } else {
            $bill_name = "'".$bill_name."'";
        }

        
        $bill_address = $_POST['bill_address'];
        if(empty($bill_address)) {
            $bill_address = "NULL";
        } else if(strlen($bill_address) > 100) {
            $regMsg[] = 'A számlázási cím hosszú! (max 100 karakter)';
        } else {
            $bill_address = "'".$bill_address."'";
        }

        
        $delivery_address = $_POST['delivery_address'];
        if(empty($delivery_address)) {
            $delivery_address = "NULL";
        } else if(strlen($delivery_address) > 100) {
            $regMsg[] = 'A szállítási cím hosszú! (max 100 karakter)';
        } else {
            $delivery_address = "'".$delivery_address."'";
        }

        
        if(empty($regMsg)) {

            
            require_once 'php/functions.php';
            $hash_salt = generateRandomString(10);
            $hash_password = hashPassword($password, $hash_salt);

            
            $sql_newClient =
            "INSERT INTO client(username, hash_password, hash_salt, email, bill_name, bill_address, delivery_address)
            VALUES
            ('$username', '$hash_password', '$hash_salt', '$email', $bill_name, $bill_address, $delivery_address)";

            
            if(mysqli_query($dbCon, $sql_newClient)) {
                
                $regMsg[] = 'Sikeres regisztráció! Most már bejelentkezhetsz.';
            } else {
                
                $regMsg[] = 'A regisztráció sikertelen! Kérjük forduljon az oldal üzemeltőjéhez!';
            }

        }

    }

    $loginMsg = '';

    
    if(isset($_POST['login'])) {

        $userOrEmail = $_POST['userOrEmail'];
        $password = $_POST['password'];

        $sql_userData = 
        "SELECT id, hash_password, hash_salt FROM client WHERE username LIKE '$userOrEmail' OR email LIKE '$userOrEmail'";
        $result_userData = mysqli_query($dbCon, $sql_userData);

        if(mysqli_num_rows($result_userData) == 1) {

            
            $userData = mysqli_fetch_assoc($result_userData);

            require_once 'php/functions.php';

            if($userData['hash_password'] == hashPassword($password, $userData['hash_salt'])) {

                
                $_SESSION['userId'] = $userData['id'];
                
                header('Location: index.php');

            } else {
                $loginMsg = '<h5 class="text-danger">A megadott jelszó hibás!</h5>';
            }


        } else {
           
            $loginMsg = '<h5 class="text-danger">A megadott felhasználónévvel/e-mail címmel még nem regisztráltak!</h5>';
        }

    }

    
    $title = 'Bejelentkezés';
    require_once 'components/htmlstart.php';

    
    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        
        
        <div class="col-12 col-lg-6 mt-4">
            <form action="" method="post" class="form-group bg-white shadow p-3 text-center">
                <h3 class="mb-3">Regisztráció</h3>

                <?php
                   
                    if(!empty($regMsg)) {
                        echo '<div class="col-12 col-sm-9 col-md-7 col-lg-10 col-xl-9 mx-auto rounded mb-3 bg-white shadow border border-dark text-left p-3"><ul class="mb-0">';

                            foreach($regMsg as $msg) {
                                echo '<li>'.$msg.'</li>';
                            }

                        echo '</ul></div>';
                    }
                ?>
                
                <label>Felhasználónév:</label>
                <input type="text" name="username" minlength="4" maxlength="10" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <label>e-mail cím:</label>
                <input type="email" name="email" maxlength="50" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <label>Jelszó:</label>
                <input type="password" name="password" minlength="6" maxlength="100" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <label>Jelszó megerősítése:</label>
                <input type="password" name="again" minlength="6" maxlength="100" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <h6 class="mt-4">Opcionális adatok</h6>

                <label>Számlázási név:</label>
                <input type="text" name="bill_name" maxlength="100" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6">

                <label>Számlázási cím:</label>
                <input type="text" name="bill_address" maxlength="100" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6">

                <label>Szállítási cím:</label>
                <input type="text" name="delivery_address" maxlength="100" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6">

                <button type="submit" class="btn btn-dark" name="reg">Regisztráció</button>

            </form>
        </div>

        
        <div class="col-12 col-lg-6 mt-4">
            <form action="" method="post" class="form-group bg-white shadow p-3 text-center">
                
                <h3 class="mb-3">Bejelentkezés</h3>
                <?=$loginMsg?>

                <label>Felhasználónév vagy e-mail:</label>
                <input type="text" name="userOrEmail" minlength="4" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <label>Jelszó:</label>
                <input type="password" name="password" minlength="6" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-5 col-lg-8 col-xl-6" required>

                <button class="btn btn-dark" type="submit" name="login">Bejelentkezés</button>

            </form>
        </div>

    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>