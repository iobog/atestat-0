<?php
require_once("./db_config.php");

$conn = new PDO("mysql:host=$servername;", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec("USE $database");

function create_cart($user_id)
{
  global $conn;
  global $cart_table_name;

  $create_cart_query = "
    INSERT INTO $cart_table_name(total, utilizator_id)
    VALUES (?, ?)
  ";
  $smt = $conn->prepare($create_cart_query);
  $smt->execute([0, $user_id]);
}

function get_cart($user_id)
{
  global $conn;
  global $cart_table_name;

  $get_cart_query = "
    SELECT * FROM $cart_table_name
    WHERE utilizator_id = ?
  ";
  $smt = $conn->prepare($get_cart_query);
  $smt->execute([$user_id]);
  $cart = $smt->fetch();

  if ($cart === false)
  {
    create_cart($user_id);

    $smt = $conn->prepare($get_cart_query);
    $smt->execute([$user_id]);
    $cart = $smt->fetch();
  }

  return $cart;
}

// function get_cart_total($user_id)
// {
//   $cart = get_cart($user_id);
//   return $cart["total"];
// }

function update_cart_total($user_id)
{
  global $conn;
  global $cart_table_name;
  global $cart_item_table_name;

  $cart = get_cart($user_id);
  if ($cart === false)
  {
    create_cart($user_id);
    $cart = get_cart($user_id);
    return;
  }

  $get_cart_items_query = "
    SELECT SUM(cantitate * pret) FROM $cart_item_table_name
    WHERE cos_id = ?
  ";
  $smt = $conn->prepare($get_cart_items_query);
  $smt->execute([$cart["id"]]);
  $total = $smt->fetch();
  $total = $total[0];
  
  $update_cart_total_query = "
    UPDATE $cart_table_name
    SET total = ?
    WHERE id = ?
  ";

  $smt = $conn->prepare($update_cart_total_query);
  $smt->execute([$total, $cart["id"]]);

}

function add_to_cart($user_id, $product, $quantity = 1)
{
  global $conn;
  global $cart_item_table_name;

  $cart = get_cart($user_id);

  // Note: If the product is already in the cart,
  // then we just update the quantity. Else
  // we have to create the item in the cart.
  $get_cart_item_query = "
    SELECT * FROM $cart_item_table_name
    WHERE cos_id = ? and produs_id = ?
  ";
  $smt = $conn->prepare($get_cart_item_query);
  $smt->execute([$cart["id"], $product["id"]]);
  $cart_item = $smt->fetch();

  // Note: The product is not in the cart,
  // we have to create it.
  if ($cart_item === false)
  {
    $add_cart_item_query = "
      INSERT INTO $cart_item_table_name(cantitate, pret, produs_id, cos_id)
      VALUES (?, ?, ?, ?)
    ";

    $smt = $conn->prepare($add_cart_item_query);
    $smt->execute([$quantity, $product["pret"], $product["id"], $cart["id"]]);
  }
  // Note: Product is already in the cart,
  // we just update the quantity.
  else
  {
    $update_cart_item_query = "
      UPDATE $cart_item_table_name
      SET cantitate = ?, pret = ?
      WHERE id = ?
    ";
    $smt = $conn->prepare($update_cart_item_query);
    $smt->execute([$cart_item["cantitate"] + $quantity, $product["pret"], $cart_item["id"]]);
  }

  // Note: Update the cart total.
  update_cart_total($user_id);
}

function remove_from_cart($user_id, $cart_item_id)
{
  global $conn;
  global $cart_item_table_name;

  $delete_cart_item_query = "
    DELETE FROM $cart_item_table_name
    WHERE id = ?
  ";
  $smt = $conn->prepare($delete_cart_item_query);
  $smt->execute([$cart_item_id]);

  // Note: Update the cart total.
  update_cart_total($user_id);
}

function get_cart_items($cart_id)
{
  global $conn;
  global $cart_item_table_name;
  global $product_table_name;
  global $product_image_table_name;

  $get_cart_items_query = "
    SELECT 
      $cart_item_table_name.id as cos_element_id,
      $cart_item_table_name.*,
      $product_table_name.*
    FROM $cart_item_table_name
    JOIN $product_table_name
    ON $cart_item_table_name.produs_id = $product_table_name.id
    WHERE cos_id = ?
  ";
  $smt = $conn->prepare($get_cart_items_query);
  $smt->execute([$cart_id]);
  $cart_items = $smt->fetchAll();

  // echo "<pre>";
  // var_dump($cart_items);
  // echo "</pre>";

  return $cart_items;
}
