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
  <div class="cart-title">Elimina Produse</div>
  
  <div class="cart">
    
    <form action="delete-product.php" method="post">

      <?php
        $conn = new PDO("mysql:host=$servername;", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("USE $database");
        $q="SELECT * FROM produs" ;
        $smt = $conn->prepare($q);
        $smt->execute();
        $products = $smt->fetchAll(); 
      ?>      
      <select name="ELiminaT" required>
        <?php  foreach($products as $product):?>
         <option value="<?php echo($product['id']) ?>"><?php echo($product['nume']);  ?></option>
         <?php  endforeach?>
      </select>

      <button 
        type="submit" 
        name="delete"
        value="delete">
        Delete
      </button>

    </form>        
        
    <?php
    if (isset($_POST['delete'])){
      $pour_id = $_POST['ELiminaT'];
      
     

      $query = "
        SELECT * FROM $cart_item_table_name where produs_id = $pour_id
      ";
      $smt = $conn->prepare($query);
      $smt->execute();
      if ($smt->rowCount() > 0){
        echo("<div class=\"alert\" > 
        Produsul este existet în cosul unuli client!!! Modificati stocul sa fie 0.
      </div>");
      exit();
      }
      $querry_delete="DELETE FROM $product_image_table_name WHERE produs_id=$pour_id";
      $smt=$conn->prepare($querry_delete);
      $smt->execute();
      // trebuie sa i dau delete daca exista si din baaza de date cos_elemetn
      $querry_delete="DELETE FROM $product_table_name WHERE id=$pour_id";
      $smt=$conn->prepare($querry_delete);
      $smt->execute();
      echo("<div class=\"alert\" > 
        Produsul a fost eliminat!!
      </div>");
    }
  ?>

  </div>

  </body>

</html>