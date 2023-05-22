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

  $MESSAGE = '';

  if (isset($_POST['save']))
  {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $stock = $_POST['stock'];

    $images = isset($_FILES['images']) ? $_FILES['images'] : [];

    if (!product_exists($name))
    {
      // Note: Create a new directory based on
      // BRAND name and try to upload the images there.
      $directory = format_name($_POST['brand']);
      $image_urls = upload_product_images($images, $directory);

      // Note: Create the product.
      create_product($name, $description, $brand, $price, $gender, $size, $stock, $image_urls);
      
      $MESSAGE = "<div><b>Succes:</b> Produs salvat!</div>";
    }
    else
    {
      $MESSAGE = "<div><b>Eroare:</b> Exista deja un produs cu numele ".$name."</div>";
    }
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

  <div class="page-title">Produs nou</div>
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
        <input type="text" placeholder="Nume produs" name="name" required>
      </div>
      <br>

      <div class="form-field">
        <label for="description">Descriere</label>
        <textarea name="description" rows="3" placeholder="Descriere" required></textarea>
      </div>
      <br>

      <div class="form-field">
        <label for="brand">Brand</label>
        <input type="text" placeholder="Brand" name="brand" required>
      </div>
      <br>

      <div class="form-field">
        <label for="price">Pret</label>
        <input type="number" placeholder="Pret" name="price" min="0" required>
      </div>
      <br>

      <div class="form-field">
        <label for="gender">Pentru</label>
        <select name="gender" required>
          <option value="barbati">Barbati</option>
          <option value="femei">Femei</option>
          <option value="unisex">Unisex</option>
        </select>
      </div>
      <br>

      <div class="form-field">
        <label for="size">Marime (ml)</label>
        <input type="number" placeholder="Marime" name="size" min="0" required>
      </div>
      <br>

      <div class="form-field">
        <label for="stock">Stoc</label>
        <input type="number" placeholder="Stoc" name="stock" required>
      </div>
      <br>

      <div class="form-field">
        <label for="images[]">Imagini</label>
        <input type="file" multiple placeholder="Imagini" name="images[]" required>
      </div>
      <br>

      <button 
        type="submit" 
        name="save"
        value="">
        Salveaza
      </button>

    </form> 

  </body>

</html>