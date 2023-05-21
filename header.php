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
  <div class="header-content">
    <a class="header-logo" href="index.php">Magazinul</a>
    <div class="header-menu">
      <a href="index.php?">Toate</a>
      <a href="index.php?gen=barbati">Pentru barbati</a>
      <a href="index.php?gen=femei">Pentru femei</a>
      <a href="index.php?gen=unisex">Unisex</a>
      <a href="about.php">Despre noi</a>
    </div>
  </div>
  <a class="header-link" href="account.php">
      <i class="fa-solid fa-user"></i>
      <?php echo $user; ?>
    </a>
    <a class="header-link" href="cart.php">
      <i class="fa-solid fa-bag-shopping"></i>
      <?php echo $total; ?> lei
    </a>
</div>