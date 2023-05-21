<html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
      include_once('./header.php');
    ?>

    <div class="breadcrumb-container">
      <a href="index.php" class="breadcrumb-element">Produse</a>
      <div class="breadcrumb-separator">/</div>

      <?php if (isset($_GET['gen'])): ?>
        <?php
          $text = '--';
          if ($_GET['gen'] == 'barbati') $text = "Pentru barbati";
          if ($_GET['gen'] == 'femei') $text = "Pentru femei";
          if ($_GET['gen'] == 'unisex') $text = "Unisex";
        ?>
        <a 
          href="index.php?gen=<?php echo $_GET['gen']; ?>" 
          class="breadcrumb-element">
          <?php echo $text; ?>
        </a>
      <?php endif; ?>
    </div>

    <div class="product-card-container">
      <?php

        require_once("./db_config.php");

        $conn = new PDO("mysql:host=$servername;", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec("USE $database");

        $query = isset($_GET['gen']) ? "SELECT * FROM $product_table_name WHERE gen = ?" : "SELECT * FROM $product_table_name";
        $params = isset($_GET['gen']) ? [$_GET['gen']] : [];

        // Note: select all products.
        $smt = $conn->prepare($query);
        $smt->execute($params);
        $products = $smt->fetchAll();

        ?>

        <?php foreach($products as $product): ?>
          <?php 
            $select_product_images_query = "
              SELECT * FROM $product_image_table_name
              WHERE produs_id = ?
            ";

            $smt = $conn->prepare($select_product_images_query);
            $smt->execute([$product["id"]]);
            $images = $smt->fetchAll();
          ?>

          <a class="product-card" href="./product.php?id=<?php echo $product["id"] ?>">
            <?php if ($product["stoc"] == 0): ?>
              <div class="product-card-label">
                Stoc epuizat
              </div>
            <?php endif ?>
            <div class="product-card-image">
              <img
                src="./media/produse/<?php echo $images[0]["url"]?>" 
                alt="">
            </div>
            <div class="product-card-brand">
              <?php echo $product["brand"]?>
            </div>
            <div class="product-card-name">
              <?php echo $product["nume"]?>
            </div>
            <div class="product-card-price">
              <?php echo round($product["pret"], 2)?> lei
            </div>
          </a>

          
        <?php endforeach ?>

    </div>

  </body>

</html>