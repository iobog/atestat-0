<?php 
  //require_once("../db_config.php");

  // $conn = new PDO("mysql:host=$servername;", $username, $password);
  // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // $conn->exec("USE $database");

  function format_name($name)
  {
    $name = strtolower($name);
    $name = str_replace(array(' ', '-'), '_', $name);
    return $name;
  }

  function product_exists($name)
  {
    global $conn;
    global $product_table_name;

    $query = "
      SELECT * FROM $product_table_name where nume = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$name]);
    if ($smt->rowCount() > 0) return true;

    return false;
  }

  function get_product_by_id($id)
  {
    global $conn;
    global $product_table_name;

    $query = "
      SELECT * FROM $product_table_name
      WHERE id = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$id]);
    return $smt->fetch();
  }

  function get_all_products()
  {
    global $conn;
    global $product_table_name;

    $query = "
      SELECT * FROM $product_table_name
    ";
    $smt = $conn->prepare($query);
    $smt->execute();

    return $smt->fetchAll();
  }

  function upload_product_images($images, $directory)
  {
    $image_paths = [];

    $length = isset($images['name']) ? count($images['name']) : 0;

    for ($index = 0; $index < $length; $index++)
    {
      $image_name = format_name($images['name'][$index]);
      $image_tmp = $images['tmp_name'][$index];
      // $image_size = $images['size'][$index];
      // $image_error = $images['error'][$index];

      $destination = "../media/produse/$directory";

      if (!is_dir($destination))
      {
        if (!mkdir($destination, 0755, true))
        {
          die('Nu s-a putut crea directorul: '.$destination);
        }
      }

      $destination .= "/$image_name";
      if (!move_uploaded_file($image_tmp, $destination)) 
      {
        die('Nu s-a putu incarca imaginea: '.$destination);
      }

      array_push($image_paths, "$directory/$image_name");
    }

    return $image_paths;
  }

  function create_product_image($product_id, $image_url)
  {
    global $conn;
    global $product_image_table_name;

    $query = "
      INSERT INTO $product_image_table_name (produs_id, url)
      VALUES (?, ?)
    ";
    $smt = $conn->prepare($query);
    return $smt->execute([$product_id, $image_url]);
  }

  function create_product($name, $description, $brand, $price, $gender, $size, $stock, $image_urls)
  {
    global $conn;
    global $product_table_name;

    $query = "
      INSERT INTO $product_table_name (nume, pret, descriere, brand, gen, marime, stoc)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $smt = $conn->prepare($query);
    $smt->execute([
      $name, $price, $description, $brand, $gender, $size, $stock
    ]);

    $product_id = $conn->lastInsertId();

    // Note: Create product images.
    foreach ($image_urls as $image_url)
    {
      create_product_image($product_id, $image_url);
    }

    return $product_id;
  }

  function update_product($id, $name, $description, $brand, $price, $gender, $size, $stock)
  {
    global $conn;
    global $product_table_name;

    $query = "
      UPDATE $product_table_name
      SET nume = ?, pret = ?, descriere = ?, brand = ?, gen = ?, marime = ?, stoc = ?
      WHERE id = ?
    ";
    $smt = $conn->prepare($query);
    return $smt->execute([
      $name, $price, $description, $brand, $gender, $size, $stock, $id
    ]);
  }

  function get_product_images($product_id)
  {
    global $conn;
    global $product_image_table_name;

    $query = "
      SELECT * FROM $product_image_table_name
      WHERE produs_id = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$product_id]);

    return $smt->fetchAll();
  }