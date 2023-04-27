<html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet">

    <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <div class="header">
      <div class="header-logo">Magazinul</div>
      <div class="header-cart">
        <i class="fa-solid fa-bag-shopping" style="color: #15322f;"></i> 0 lei
      </div>
    </div>
    <div class="navigation">
      <a class="navigation-buttons" href="#0">
        <div class="">Parfumuri Dama</div>
      </a>
      <a class="navigation-buttons" href="#0">
        <div class="">Parfumuri Barbati</div>
      </a>
      <a class="navigation-buttons" href="#0">
        <div class="">Despre noi</div>
      </a>
      
    </div>

    <div class="product-card-container">
      <?php

        require_once("./db_config.php");

        // $servername = "localhost";
        // $username = "root";
        // $password = "";

        // $database = "atestat_0";
        // $product_table_name = "produs";
        // $product_image_table_name = "produs_imagine";
        
        $conn = new PDO("mysql:host=$servername;", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec("USE $database");

        // Note: select all products.
        $select_products_query = "SELECT * FROM $product_table_name";
        $smt = $conn->prepare($select_products_query);
        $smt->execute();
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
            <div class="product-card-image">
              <img
                src="./media/produse/killian/<?php echo $images[0]["url"]?>" 
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

        <!-- <?php

        // foreach ($products as $product) {

        //   // Note: select product images.
        //   $select_product_images_query = "
        //     SELECT * FROM $product_image_table_name
        //     WHERE produs_id = ?
        //   ";

        //   $smt = $conn->prepare($select_product_images_query);
        //   $smt->execute([$product["id"]]);
        //   $images = $smt->fetchAll();
          
          
        //   // echo "
        //   //   <div class=\"product-card\">
        //   //     <div>
        //   //       <img 
        //   //         class=\"product-card-image\"
        //   //         src=\"./media/produse/killian/".$images[0]['url']."\">
        //   //     </div>
        //   //     <div class=\"product-card-brand\">"
        //   //       .$product['brand'].
        //   //     "</div>
        //   //     <div class=\"product-card-name\">"
        //   //       .$product['nume'].
        //   //     "</div>
        //   //     <div class=\"product-card-price\">"
        //   //       .round($product['pret'], 2)." lei
        //   //     </div>
        //   //   </div>
        //   // ";
        // }
        ?> -->
    </div>

  </body>

</html>