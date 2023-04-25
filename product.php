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
    <div class="product-image"> </div>
    <div class="product-brand"> </div>
    <div class="product-description"> </div>
    <div class="product-price"> </div>
    
      

  <div>
</body