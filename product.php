<html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/product.css">
    <link rel="stylesheet" type="text/css" href="css/breadcrumb.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet">

    <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

  </head>

  <body>
    
    
    <?php 
      session_start();
      require_once('./header.php');
      require_once './cart_logic.php';
    ?>

    <?php

      require_once("./db_config.php");

      $conn = new PDO("mysql:host=$servername;", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $conn->exec("USE $database");

      $product_id = $_GET['id'];

      // Note: select all products. 
      $select_products_query = "SELECT * FROM $product_table_name WHERE id = ?";
      $smt = $conn->prepare($select_products_query);
      $smt->execute([$product_id]);
      $products = $smt->fetchAll();

      $product = $products[0];

      $select_product_images_query = "
        SELECT * FROM $product_image_table_name
        WHERE produs_id = ?
      ";

      $smt = $conn->prepare($select_product_images_query);
      $smt->execute([$product["id"]]);
      $images = $smt->fetchAll();

      // var_dump($product);
      //var_dump($images);

    ?>

    <div class="breadcrumb-container">
      <a href="index.php" class="breadcrumb-element">Produse</a>
      <div class="breadcrumb-separator">/</div>
      <a href="product.php?id=<?php echo $product_id; ?>" class="breadcrumb-element">
        <?php echo $product["nume"]; ?>
      </a>
    </div>

    <div class="product-page">
      <div class="product-images">
        <?php foreach($images as $image): ?>
          <img
            src="./media/produse/<?php echo $image["url"]?>" 
            alt="">
        <?php endforeach ?> 
      </div>
      <div class="product-details">
        <div class="product-details-container">
          <div class="product-brand">
            <?php echo $product["brand"]?>
          </div>
          <div class="product-name">
            <?php echo $product["nume"]?>
          </div>
          <div class="product-size">
            Potrivit <?php echo $product["gen"]?>
            <?php echo $product["marime"]?> ml
          </div>
          <div class="product-price">
            <?php echo round($product["pret"], 2)?> lei
          </div>
          <div class="description">
          <p class="descriere-titlu"> Descriere <?php echo $product["brand"] ?> <?php echo $product["nume"] ?></p>
          <div class="product-description"> 
            <?php echo $product["descriere"]?>
          </div>
        </div>

          <?php if ($product["stoc"] > 0): ?>
            <form action="" method="POST">
              <button 
                class="add-to-cart-button"
                type="submit" 
                name="add_to_cart"
                value="<?php echo $product_id ?>">
                Adaugă în coș
              </button>
            </form>
          <?php else: ?>
            <button
              disabled="true"
              class="add-to-cart-button">
              Stoc epuizat
            </button>
          <?php endif; ?>

        </div>
      
      </div>
    </div>

    <?php 
      if (isset($_POST["add_to_cart"]) || 
      (isset($_GET["action"]) && $_GET["action"] == "add")) 
      {
        if (!isset($_SESSION["user_id"]))
        {
          $return_url = urlencode("product.php?id=$product_id&action=add");
          header("Location: login.php?return=$return_url");
        }
        
        $user_id = $_SESSION["user_id"];
        add_to_cart($user_id, $product);

        header("Location: cart.php");

        // Note: Refresh the page
        // in order to see the new 
        // total.
        //header("Location: product.php?id=$product_id");
      }

    ?>

  </body>

</html>