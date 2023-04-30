<?php
  $product_id = $_GET['id'];
  echo "ID Produs: $product_id";
  // ...
  require_once("./db_config.php");
  ?>
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


  <div class="container-all">

    <?php 
      //Note: the following code  allows you to connect to the database
      $conn = new PDO("mysql:host=$servername;", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->exec("USE $database");
    ?>
    <?php 
    //note: here we 'should' take from produse database THE PRODUCT WICH HAVE THE ID=PRODUCT_ID 
      $select_products_query = "SELECT * FROM $product_table_name WHERE id=$product_id";
      $smt = $conn->prepare($select_products_query);
      $smt->execute();
      $product = $smt->fetch();
    ?>
    <?php 
      $select_product_images_query = "
        SELECT * FROM $product_image_table_name
        WHERE produs_id = ?
      ";
      $smt = $conn->prepare($select_product_images_query);
      $smt->execute([$product["id"]]);
      $images = $smt->fetchAll();
    ?>
    
    <div class="product-image"> 
    <img
        src="./media/produse/killian/<?php echo $images[0]["url"]?>" 
        alt="">
    </div>

    <div class="product-brand"> 
      <?php echo $product["brand"] ?>
    </div> <br>

    <div class="product-name"> 
      <?php echo $product["nume"]?>
    </div><br>

    <div class="product-pentru"> 
      <?php echo $product["pentru"]?>
    </div><br>

    <div class="product-cantitate"> 
      <?php echo $product["cantitate"]?>
    </div><br>

    <div class="product-price"> 
      <?php echo round($product["pret"])?>
    </div><br>

    <div class="add-to-shopping-cart"> 
      
    </div><br>

    <div class="product-description"> 
      <?php echo $product["descriere"]?>
    </div><br>

  <div>
</body