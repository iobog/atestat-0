<?php
  session_start();
  require_once("../db_config.php");

  if (!isset($_SESSION['rol']) || strcmp($_SESSION['rol'], 'admin') !== 0)
  {
    $return_url = urlencode("admin/");
    header("Location: ./../login.php?return=$return_url");
    exit();
  }

  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $conn->exec("USE $database");

  require_once('../product_logic.php');

  $products = get_all_products();

  ?>

<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/cart.css">
  <link rel="stylesheet" type="text/css" href="../css/input.css">
  <link rel="stylesheet" type="text/css" href="../css/page.css">
  <link rel="stylesheet" type="text/css" href="../css/breadcrumb.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

</head>

<body>

  <?php require_once("header.php"); ?>

  <div class="page-title">Produse</div>
  <div class="page-actions">
    <a class="button-primary" href="create-product.php">+ Produs nou</a>
  </div>

  <div class="page-main">

    <table>
      <colgroup>
        <col width="100px">
        <col width="60%">
        <col width="15%">
        <col width="15%">
        <col width="15%">
      </colgroup>
      <tbody>
        <tr>
          <th>Nume</th>
          <th></th>
          <th>Stoc</th>
          <th>Pret</th>
          <th>Actiuni</th>
        </tr>
        <?php foreach ($products as $product) : ?>
          <tr>
            <td>
              <img class="cart-item-image" src="../media/produse/<?php echo get_product_images($product['id'])[0]['url']; ?>" alt="Imagine produs">
            </td>
            <td>
              <a class="cart-item-name" href="../product.php?id=<?php echo $product["id"]; ?>">
                <span>
                  <?php echo $product["brand"]; ?>
                </span>
                <b>
                  <?php echo $product["nume"]; ?>
                </b>
              </a>
              <div class="cart-item-description">
                  Potrivit
                  <?php echo $product["gen"]; ?>
                  <?php echo $product["marime"]; ?> ml
              </div>
            </td>
            <td>
              <?php echo $product["stoc"]; ?> buc.
            </td>
            <td>
              <?php echo round($product["pret"], 2); ?> lei
            </td>
            <td>
              <form action="cart.php" method="POST">
                <div>
                  <a class="button-primary" href="update-product.php?id=<?php echo $product['id']; ?>">
                    Modifica
                  </a>
                </div>
                <!-- <div>
                  <button type="submit" name="remove_cart_item" value="">
                    Sterge
                  </button>
                </div> -->
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>

  </body>

</html>