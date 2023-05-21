<?php
  session_start();
  require_once("../db_config.php");

  if (!isset($_SESSION['rol']) || strcmp($_SESSION['rol'], 'admin') !== 0)
  {
    $return_url = urlencode("admin/");
    header("Location: ./../login.php?return=$return_url");
    exit();
  }

  if (!isset($_GET['id']))
  {
    header("Location: index.php");
    exit();
  }

  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $conn->exec("USE $database");

  require_once('../product_logic.php');

  $product = get_product_by_id($_GET['id']);

  if ($product === false)
  {
    header("Location: index.php");
    exit();
  }

  $MESSAGE = '';

  if (isset($_POST['save']))
  {
    $id = $_GET['id'];

    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $stock = $_POST['stock'];

    // Note: Update the product.
    update_product($id, $name, $description, $brand, $price, $gender, $size, $stock);
    
    $MESSAGE = "<div><b>Succes:</b> Produs salvat!</div>";

    // Note: Just to show the updated
    // product in the form.
    $product = get_product_by_id($_GET['id']);
  }

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

  <div class="page-title">Modifica produs</div>
  <div class="page-main">


    <?php if(!empty($MESSAGE)): ?>
      <div class="alert">
        <?php echo $MESSAGE; ?>
      </div>
      <br>
    <?php endif; ?>
    
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-field">
        <label for="name">Nume</label>
        <input type="text" placeholder="Nume produs" name="name" required value="<?php echo $product['nume'] ?>">
      </div>
      <br>

      <div class="form-field">
        <label for="description">Descriere</label>
        <textarea name="description" rows="3" placeholder="Descriere"><?php echo $product['descriere'] ?>
        </textarea>
      </div>
      <br>

      <div class="form-field">
        <label for="brand">Brand</label>
        <input type="text" placeholder="Brand" name="brand" required value="<?php echo $product['brand'] ?>">
      </div>
      <br>

      <div class="form-field">
        <label for="price">Pret</label>
        <input type="number" placeholder="Pret" name="price" min="0" required value="<?php echo $product['pret'] ?>">
      </div>
      <br>

      <div class="form-field">
        <label for="gender">Pentru</label>
        <select name="gender" required value="<?php echo $product['gen'] ?>">
          <option value="barbati">Barbati</option>
          <option value="femei">Femei</option>
          <option value="unisex">Unisex</option>
        </select>
      </div>
      <br>

      <div class="form-field">
        <label for="size">Marime (ml)</label>
        <input type="number" placeholder="Marime" name="size" min="0" required value="<?php echo $product['marime'] ?>">
      </div>
      <br>

      <div class="form-field">
        <label for="stock">Stoc</label>
        <input type="number" placeholder="Stoc" name="stock" required value="<?php echo $product['stoc'] ?>">
      </div>
      <br>

      <!-- <div class="form-field">
        <label for="images[]">Imagini</label>
        <input type="file" multiple placeholder="Imagini" name="images[]" required>
      </div>
      <br> -->

      <button 
        type="submit" 
        name="save"
        value="">
        Salveaza
      </button>

    </form> 

  </body>

</html>