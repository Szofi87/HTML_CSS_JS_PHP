<?php

    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    if(!$login) {
        header('Location: index.php');
    }

    $title = 'Korábbi rendelések';
    require_once 'components/htmlstart.php';

    require_once 'components/navbar.php';

?>

<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>

        <?php
            $sql_clientOrders = 
            "SELECT `order`.`id`, `order`.`order_number`, `order`.`order_date`, SUM(`order_item`.`order_price` * `order_item`.`qty`) AS osszeg
            FROM `order` INNER JOIN `order_item` ON `order`.`id`=`order_item`.`order`
            WHERE `order`.`client`=$loginUserId
            GROUP BY `order`.`id`";
            $result_clientOrders = mysqli_query($dbCon, $sql_clientOrders);
            
            ?>
            <table class="table table-light table-striped table-borderless shadow col-12 mb-4">
                <thead>
                    <tr>
                        <th>Rendelésszám</th>
                        <th>Időpont</th>
                        <th class="text-right">Összeg</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
            
                while($clientOrder = mysqli_fetch_assoc($result_clientOrders)) {
                    ?>
                    <tr>
                        <td><?=number_format($clientOrder['order_number'],0,'','-')?></td>
                        <td><?=date('Y.m.d H:i', strtotime($clientOrder['order_date']))?></td>
                        <td class="text-right"><?=number_format($clientOrder['osszeg'],0,'',' ')?> Ft</td>
                        <td class="text-center">
                            <a href="ordersummary.php?id=<?=$clientOrder['id']?>" class="btn btn-sm btn-primary">Részletek</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            

    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>