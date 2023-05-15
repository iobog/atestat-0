<?php
require_once('./cart_logic.php');
$total = 0;
$user = "Utilizator";

if (isset($_SESSION["user_id"])) {
  $cart = get_cart($_SESSION["user_id"]);
  $total = $cart["total"];
  $user = $_SESSION["username"];
}

$total = round($total, 2);


?>

<div class="header">
  <a class="header-logo" href="index.php">Fregrance</a>
  <a class="header-link" href="account.php">
    <i class="fa-solid fa-user"></i>
    <?php echo $user; ?>
  </a>
  <a class="header-link" href="cart.php">
    <i class="fa-solid fa-bag-shopping"></i>
    <?php echo $total; ?> lei
  </a>
</div>


<div class="navigation">
      <a class="navigation-buttons" href="female.php">
        <div class="">Parfumuri Dama</div>
      </a>
      <a class="navigation-buttons" href="male.php">
        <div class="">Parfumuri Barbati</div>
      </a>
      <a class="navigation-buttons" href="about.php">
        <div class="">Despre noi</div>
      </a>
</div>