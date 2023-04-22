<?php

  require_once("./../db_config.php");

  // $servername = "localhost";
  // $username = "root";
  // $password = "";

  // $database = "atestat_1";
  // $product_table_name = "produs";
  // $product_image_table_name = "produs_imagine";

  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $create_db_qurey = "CREATE DATABASE IF NOT EXISTS $database";
  $conn->exec($create_db_qurey);

  $conn->exec("USE $database");

  // Note: Create 'Product' table if not exists.
  $create_product_table_query = "
    CREATE TABLE IF NOT EXISTS $product_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      nume NVARCHAR(30),
      pret DECIMAL(10,4),
      descriere NVARCHAR(1024),
      brand NVARCHAR(128)
    )
  ";

  $conn->exec($create_product_table_query);

  // Note: Create 'ProductImage' table if not exists.
  $create_product_image_table_query = "
      CREATE TABLE IF NOT EXISTS $product_image_table_name(
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        produs_id INT(6) UNSIGNED NOT NULL,
        url NVARCHAR(2048) NOT NULL,
        FOREIGN KEY (produs_id) REFERENCES $product_table_name(id)
      )
  ";

  $conn->exec($create_product_image_table_query);


  $products = array(
    array(
      "DARK LORD",
      1130,
      "A început cu Oscar Wilde și cuvintele lui: „Domn este acela care nu rănește sentimentele nimănui în mod neintenționat.” Și continuă acum cu DARK LORD „EX TENEBRIS LUX”, un domn al nopții care stă la pândă în adâncul ființei tale. În acest întuneric vei găsi stil, manieră fină, precum și lumină căreia pielea, romul și piperul de Sichuan îi dau greutate.",
      "KILIAN PARIS",
      array(
        "killian_dark_lord.jpg"
      )
    ),
    array(
      "MUSK OUD",
      1610,
      "Superb, măiestrit, epic, întocmai ca un bun western vechi. Și, ca în orice western, tema lui centrală este dreptatea. Și MUSK OUD mizează pe cartea justiției, dar este mai degrabă o justiție poetică a trandafirului. Acțiunea se desfășoară într-un prelung acord răvășitor de oud, în timp ce paciuli și moscul ancorează introducerea amețitoare marcată de rom. Într-o curgere lină, pe cât de dulce, pe atât de seducătoare, o nouă pagină se scrie pentru oud-ul antic și o explozie mătăsoasă de petale și mosc se derulează în fața simțurilor tale.",
      "KILIAN PARIS",
      array(
        "killian_musk_oud.jpg"
      )
    ),
    array(
      "BACK TO BLACK",
      1130,
      "Negru. Miroase a noapte fără sfârșit, a dorință neastâmpărată, a atingere de catifea, a gând necuviincios, a amintire năvalnică ce te face să roșești, a afrodiziac, a BACK TO BLACK. Acest parfum trece printr-o paletă colorată de bergamotă, zmeură, șofran, vanilie, mușețel albastru și paciuli care, combinate astfel de inimitabilul Kilian Paris, ajung să miroasă precum negrul, un negru care te prinde cu siguranță. ",
      "KILIAN PARIS",
      array(
        "killian_back_to_black.jpg"
      )
    ),
    array(
      "GOOD GIRL GONE BAD BY KILIAN",
      1130,
      "Ei bine, în acest caz, „rău” nu este opusul lui „bun”, deoarece această formă de „rău” e doar pasul care desparte o imaginație senzuală de o minte insolentă. GOOD GIRL GONE BAD e opulent floral, delicios feminin, plăcere consumată și tensiune făcută palpabilă de Kilian Paris. Dar, știi tu, uneori trebuie să păstrezi cele mai bune momente doar pentru tine.",
      "KILIAN PARIS",
      array(
        "killian_good_girl_gone_bad.jpg"
      )
    ),
  );

 

  foreach($products as $product) {

    // Note: Check if the product already exists.
    $smt = $conn->prepare("SELECT COUNT(*) from $product_table_name where nume = :name");
    $smt->bindParam(":name", $product[0]);
    $smt->execute();
    $count = $smt->fetchColumn();

    if ($count == 0) {
      // Note: Create the product.
      $create_product_query = "
        INSERT INTO $product_table_name (nume, pret, descriere, brand)
        VALUES (:name, :price, :description, :brand)
      ";
      $smt = $conn->prepare($create_product_query);
      $smt->bindParam(':name', $product[0]);
      $smt->bindParam(':price', $product[1]);
      $smt->bindParam(':description', $product[2]);
      $smt->bindParam(':brand', $product[3]);
      $smt->execute();

      // Note: Get the product ID of the inserted product
      $last_product_id = $conn->lastInsertId();

      // Note: Create the product images.
      $product_images = $product[4];
      foreach ($product_images as $product_image) {
        $create_product_image_query = "
          INSERT INTO $product_image_table_name (produs_id, url)
          VALUES (:product_id, :url)
        ";
        $smt = $conn->prepare($create_product_image_query);
        $smt->bindParam(':product_id', $last_product_id);
        $smt->bindParam(':url', $product_image);
        $smt->execute();
      }
    }
  }

  $conn = null;