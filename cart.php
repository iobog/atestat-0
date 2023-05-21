<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/cart.css">
  <link rel="stylesheet" type="text/css" href="css/input.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

</head>

<body>

  <?php
  session_start();
  require_once("./db_config.php");
  require_once('./header.php');
  require_once './cart_logic.php';
  ?>


  <?php
  if (!isset($_SESSION["user_id"])) 
  {
    header("Location: login.php");
  }

  $user_id = $_SESSION["user_id"];

  $cart = get_cart($user_id);
  $cart_items = get_cart_items($cart["id"]);
  ?>

  <div class="cart-title">Coș de cumpărături</div>
  <div class="cart">
    <table>
      <colgroup>
        <col width="100px">
        <col width="60%">
        <col width="15%">
        <col width="15%">
        <col width="15%">
      </colgroup>
      <tbody>
        <?php foreach ($cart_items as $cart_item) : ?>
          <tr>
            <td>
              <img class="cart-item-image" src="media/produse/<?php echo get_cart_item_image($cart_item["cos_element_id"]); ?>" alt="Imagine produs">
            </td>
            <td>
              <a class="cart-item-name" href="product.php?id=<?php echo $cart_item["produs_id"]; ?>">
                <span>
                  <?php echo $cart_item["brand"]; ?>
                </span>
                <b>
                  <?php echo $cart_item["nume"]; ?>
                </b>
              </a>
              <div class="cart-item-description">
                  Potrivit
                  <?php echo $cart_item["gen"]; ?>
                  <?php echo $cart_item["marime"]; ?> ml
              </div>
            </td>
            <td>
              <?php echo $cart_item["cantitate"]; ?> buc.
            </td>
            <td>
              <?php echo round($cart_item["pret"], 2); ?> lei
            </td>
            <td>
              <form action="cart.php" method="POST">
                <button 
                  class="cart-remove-button" 
                  type="submit" name="remove_cart_item" 
                  value="<?php echo $cart_item["cos_element_id"]; ?>">
                  Elimină
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php if (count($cart_items) == 0): ?>
      <div class="cart-no-items">
        Fara produse in cos
      </div>
    <?php endif; ?>




    <div class="cart-total">
      <b>TOTAL </b>
      <span>
        <?php echo round($cart["total"], 2); ?> lei
      </span>
    </div>
  </div>



  <?php
  // Note: Remove item from cart.
  if (isset($_POST["remove_cart_item"])) {
    $cart_item_id = $_POST["remove_cart_item"];
    remove_from_cart($user_id, $cart_item_id);

    header("Location: cart.php");
  }
  ?>

</body>

</html>