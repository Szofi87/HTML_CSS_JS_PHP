<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    
    $error = ( !$login || !isset($_GET['id']) || empty($_GET['id']) );

    
    if(!$error) {
        $orderId = $_GET['id'];

        $result_clientCheck = mysqli_query($dbCon, "SELECT `client` FROM `order` WHERE `id`=$orderId");

        if(mysqli_num_rows($result_clientCheck) == 1) {
           
            $clientCheck = mysqli_fetch_assoc($result_clientCheck);
            $clientCheck = $clientCheck['client'];
            $error = $loginUserId != $clientCheck;

        } else {
            
            $error = true;
        }

    }

   
    $title = 'Rendelés részletei';
    require_once 'components/htmlstart.php';
    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>

        <?php
        
            if(!$error) {

                ?>
                
                <div class="col-12 col-lg-4">
                <?php

                    $result_orderData = mysqli_query($dbCon, 
                    "SELECT `order_number`, `order_date`, `bill_name`, `bill_address`, `payment_mode`, `delivery_address`, `delivery_mode`
                    FROM `order` WHERE `id`=$orderId");
                    $orderData = mysqli_fetch_assoc($result_orderData);
                ?>
                    <table class="table table-light table-striped table-borderless shadow">
                        <tr>
                            <td>Rendelésszám:</td>
                            <td><?=number_format($orderData['order_number'],0,'','-')?></td>
                        </tr>
                        <tr>
                            <td>Rendelés ideje:</td>
                            <td><?=date('Y.m.d H:i', strtotime($orderData['order_date']))?></td>
                        </tr>
                        <tr>
                            <td>Számlázási név:</td>
                            <td><?=$orderData['bill_name']?></td>
                        </tr>
                        <tr>
                            <td>Számlázási cím:</td>
                            <td><?=$orderData['bill_address']?></td>
                        </tr>
                        <tr>
                            <td>Fizetési mód:</td>
                            <td><?=$orderData['payment_mode']?></td>
                        </tr>
                        <tr>
                            <td>Szállítási cím:</td>
                            <td><?=$orderData['delivery_address']?></td>
                        </tr>
                        <tr>
                            <td>Szállítási mód:</td>
                            <td><?=$orderData['delivery_mode']?></td>
                        </tr>
                    </table>

                </div>

                <div class="col-12 col-lg-8">
                    <?php
                        $result_orderItems = mysqli_query($dbCon, 
                        "SELECT `game`.`name`, `order_item`.`order_price`, `order_item`.`qty`
                        FROM `order_item` INNER JOIN `game` ON `order_item`.`game`=`game`.`id`
                        WHERE `order_item`.`order`=$orderId");
                    ?>
                    <table class="table table-light table-striped table-borderless shadow">
                        <thead class="table-dark">
                            <tr>
                                <th>Játék</th>
                                <th class="text-right">db</th>
                                <th class="text-right">Egységár</th>
                                <th class="text-right">Részösszeg</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                            while($itemData = mysqli_fetch_assoc($result_orderItems)) {
                                $subTotal = $itemData['order_price']*$itemData['qty'];
                                $total += $subTotal;

                                ?>
                                <tr>
                                    <td><?=$itemData['name']?></td>
                                    <td class="text-right"><?=$itemData['qty']?> db</td>
                                    <td class="text-right"><?=number_format($itemData['order_price'],0,'',' ')?> Ft</td>
                                    <td class="text-right"><?=number_format($subTotal,0,'',' ')?> Ft</td>
                                </tr>
                                <?php
                            }
                        ?>
                            <tr class="font-weight-bold">
                                <td colspan="3">Rendelés összege:</td>
                                <td class="text-right"><?=number_format($total,0,'',' ')?> Ft</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php

            } else {
              
                ?>
                <h3 class="col-12 text-center mb-3">Hiba!</h3>
                <p class="col-12 text-center mb-3">A rendelés azonosító hibás vagy nem vagy bejelentkezve!</p>
                <a href="games.php" class="btn btn-lg btn-secondary ml-auto mr-2 mb-4">Vissza a játékokhoz</a>
                <a href="reglogin.php" class="btn btn-lg btn-primary mr-auto mb-4">Tovább a bejelentkezésre</a>
                <?php
            }
        
        ?>

    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>