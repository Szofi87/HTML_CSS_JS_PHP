<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    
    if(!$login || !isset($_SESSION['cart'])) {
        header('Location: cart.php');
    }

    $title = 'Rendelés leadása';
    require_once 'components/htmlstart.php';

    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>

        <table class="table table-light table-borderless table-striped col-12 col-md-10 mx-auto mb-4 shadow">
            <thead class="table-dark">
                <tr>
                    <th>Játék</th>
                    
                    <th class="text-center">Db</th>
                    
                    <th class="text-right">Egységár</th>
                    <th class="text-right">Összeg</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
                $total = 0;
                foreach($_SESSION['cart'] as $gameId => $qty) {
                    $result_cartItemData = mysqli_query($dbCon, "SELECT name, price FROM game WHERE id=$gameId");
                    $cartItemData = mysqli_fetch_assoc($result_cartItemData);
                    $subTotal = $cartItemData['price'] * $qty;

                    $total += $subTotal;

                    ?>
                    <tr>
                        <td><?=$cartItemData['name']?></td>
                        
                        <td class="text-center"><?=$qty?></td>
                        
                        <td class="text-right"><?=number_format($cartItemData['price'],0,'',' ')?> Ft</td>
                        <td class="text-right"><?=number_format($subTotal,0,'',' ')?> Ft</td>
                        
                    </tr>
                    <?php

                }
                ?>
                <tr class="font-weight-bold">
                    <td colspan="3">Összesen:</td>
                    <td class="text-right"><?=number_format($total,0,'',' ')?> Ft</td>
                    
                </tr>
            </tbody>
        </table>

    </div>

    <?php
    
        $result_UserData = mysqli_query($dbCon, "SELECT bill_name, bill_address, delivery_address FROM client WHERE id=$loginUserId");
        $userData = mysqli_fetch_assoc($result_UserData);
    
    ?>

    <div class="row">
        <h3 class="col-12 text-center my-3">Megrendelés adatai</h3>
        <form action="php/recordorder.php" method="post" class="col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6 mx-auto mb-4 form-group shadow bg-white p-3 text-center">
            <h5>Kérlek, add meg az alábbi adatokat!</h5>

            <label>Számlázási név:</label>
            <input type="text" name="bill_name" value="<?=$userData['bill_name']?>" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-6" maxlength="100" required>

            <label>Számlázási cím:</label>
            <input type="text" name="bill_address" value="<?=$userData['bill_address']?>" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-6" maxlength="100" required>

            <label>Fizetési mód:</label>
            <select name="payment_mode" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-6">
                <option value="Utánvét">Utánvét</option>
                <option value="Banki átutalás">Banki átutalás</option>
                <option value="Csekkbefizetés">Csekkbefizetés</option>
            </select>

            <label>Szállítási cím:</label>
            <input type="text" name="delivery_address" value="<?=$userData['delivery_address']?>" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-6" maxlength="100" required>

            <label>Szállítási mód:</label>
            <select name="delivery_mode" class="form-control mb-3 mx-auto col-10 col-sm-7 col-md-6">
                <option value="Személyes átvétel">Személyes átvétel</option>
                <option value="Postai csomag">Postai csomag</option>
                <option value="Futárszolgálat">Futárszolgálat</option>
            </select>

            <button type="submit" class="btn btn-dark">Megrendelés leadása</button>

        </form>
    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>