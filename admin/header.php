<?php 
$user = "Utilizator";

if (isset($_SESSION["user_id"])) {
  $user = $_SESSION["username"];
}
?>

<div class="header">
  <div class="header-content">
    <a class="header-logo" href="index.php">Administrator</a>
    <div class="header-menu">
      <a href="../index.php?" target="_blank">Magazin</a>
      <a href="index.php?">Produse</a>
    </div>
  </div>
  <a class="header-link" href="account.php">
    <i class="fa-solid fa-user"></i>
    <?php echo $user; ?>
  </a>
</div>