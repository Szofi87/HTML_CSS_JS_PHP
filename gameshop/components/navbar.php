<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container px-0">
    <a class="navbar-brand" href="index.php">GameShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="games.php">Játékok</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Kosár</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Kapcsolat</a>
        </li>

        <?php
          
          if($login) {
           
            $result_username = mysqli_query($dbCon, "SELECT username FROM client WHERE id=$loginUserId");
            $username = mysqli_fetch_assoc($result_username);
            $username = $username['username'];

           
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=$username?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="clientorders.php">Rendelések</a>
                <a class="dropdown-item" href="php/logout.php">Kijelentkezés</a>
              </div>
            </li>
            <?php

          } else {
            
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Fiók
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="reglogin.php">Bejelentkezés</a>
              </div>
            </li>
            <?php
          }

        ?>

      </ul>
    </div>
  </div>
</nav>