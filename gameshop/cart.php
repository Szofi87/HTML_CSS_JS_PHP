<?php

   
    require_once 'php/database.php';
    require_once 'php/logincheck.php';

    $title = 'Kosár';
    require_once 'components/htmlstart.php';

    require_once 'components/navbar.php';

?>
<div class="container bg-light">
    <div class="row">
        <h1 class="col-12 text-center my-4"><?=$title?></h1>
        <?php
           
            if(isset($_SESSION['cart'])) {
               
                
                ?>
                <table class="table table-light table-borderless table-striped col-12 col-md-10 mx-auto mb-4 shadow">
                    <thead class="table-dark">
                        <tr>
                            <th>Játék</th>
                            
                            <th class="text-center" colspan="3">Db</th>
                            
                            <th class="text-right">Egységár</th>
                            <th class="text-right">Összeg</th>
                            <th></th>
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
                                <td>
                                    <a href="php/cartengine.php?task=decrease&id=<?=$gameId?>" class="btn btn-dark btn-sm cartBtn">-</a>
                                </td>
                                <td class="text-center"><?=$qty?></td>
                                <td class="text-right">
                                    <a href="php/cartengine.php?task=increase&id=<?=$gameId?>" class="btn btn-dark btn-sm cartBtn">+</a>
                                </td>
                                <td class="text-right"><?=number_format($cartItemData['price'],0,'',' ')?> Ft</td>
                                <td class="text-right"><?=number_format($subTotal,0,'',' ')?> Ft</td>
                                <td class="text-center">
                                    <a href="php/cartengine.php?task=delete&id=<?=$gameId?>" class="btn btn-dark btn-sm">Törlés</a>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                        <tr class="font-weight-bold">
                            <td colspan="5">Összesen:</td>
                            <td class="text-right"><?=number_format($total,0,'',' ')?> Ft</td>
                            <td class="text-center">
                                <a href="php/cartengine.php?task=empty" class="btn btn-dark btn-sm">Kosár ürítése</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-12"></div>
                <?php

                if($login) {
                    ?>
                    <a href="order.php" class="btn btn-primary btn-lg mx-auto mb-4">Megrendelés</a>
                    <?php
                } else {
                    ?>
                    <h4 class="col-12 text-center mb-3">A megrendeléshez jelentkezz be!</h4>
                    <a href="reglogin.php" class="btn btn-primary btn-lg mx-auto mb-4">Bejelentkezés</a>
                    <?php
                }


            } else {
               
                ?>
                <h2 class="col-12 text-center mb-3">A kosár üres!</h2>
                <a href="games.php" class="btn btn-lg btn-primary mx-auto mb-4">Tovább a játékokhoz!</a>
                <?php
            }
        ?>

    </div>
</div>

<?php

    require_once 'components/htmlend.php';

?>