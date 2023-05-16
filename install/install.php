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
      brand NVARCHAR(128),
      pentru NVARCHAR(128),
      cantitate INT(4)
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
      "bărbați",
      100,
      array(
        "killian_dark_lord.jpg",
        "killian_dark_lord_02.jpg"
      )
    ),
    array(
      "MUSK OUD",
      1610,
      "Superb, măiestrit, epic, întocmai ca un bun western vechi. Și, ca în orice western, tema lui centrală este dreptatea. Și MUSK OUD mizează pe cartea justiției, dar este mai degrabă o justiție poetică a trandafirului. Acțiunea se desfășoară într-un prelung acord răvășitor de oud, în timp ce paciuli și moscul ancorează introducerea amețitoare marcată de rom. Într-o curgere lină, pe cât de dulce, pe atât de seducătoare, o nouă pagină se scrie pentru oud-ul antic și o explozie mătăsoasă de petale și mosc se derulează în fața simțurilor tale.",
      "KILIAN PARIS",
      "bărbați",
      100,
      array(
        "killian_musk_oud.jpg"
      ) 
    ),
    array(
      "BACK TO BLACK",
      1130,
      "Negru. Miroase a noapte fără sfârșit, a dorință neastâmpărată, a atingere de catifea, a gând necuviincios, a amintire năvalnică ce te face să roșești, a afrodiziac, a BACK TO BLACK. Acest parfum trece printr-o paletă colorată de bergamotă, zmeură, șofran, vanilie, mușețel albastru și paciuli care, combinate astfel de inimitabilul Kilian Paris, ajung să miroasă precum negrul, un negru care te prinde cu siguranță. ",
      "KILIAN PARIS",
      "bărbați",
      100,
      array(
        "killian_back_to_black.jpg"
      )
    ),
    array(
      "GOOD GIRL GONE BAD BY KILIAN",
      1130,
      "Ei bine, în acest caz, „rău” nu este opusul lui „bun”, deoarece această formă de „rău” e doar pasul care desparte o imaginație senzuală de o minte insolentă. GOOD GIRL GONE BAD e opulent floral, delicios feminin, plăcere consumată și tensiune făcută palpabilă de Kilian Paris. Dar, știi tu, uneori trebuie să păstrezi cele mai bune momente doar pentru tine.",
      "KILIAN PARIS",
      "bărbați",
      100,
      array(
        "killian_good_girl_gone_bad.jpg"
      )
    ),
    array(
      "SICILIAN LEATHER",
      1325,
      "Se spune că oamenii nu cred în vulcani până nu le ajunge lava la picioare. La fel stau lucrurile și cu această călătorie olfactivă în adâncurile memoriei. SICILIAN LEATHER e un parfum temperamental despre insula Sicilia și caracterul ei vulcanic, o poveste spusă într-un acord suculent de portocală-lămâie, energic de coriandru-violetă, eruptiv de guaiac-piele. Într-adevăr, este un fenomen aparte, fenomenul unic prin care apa, focul și pielea se întâlnesc într-un parfum.",
      "MEMO PARIS",
      "femei",
      100,
      array(
        "memo_paris_scilian_leather_0.jpg",
        "memo_paris_scilian_leather_1.jpg",
        "memo_paris_scilian_leather_2.jpg"
      )
    ),
    array(
      "TIGER'S NEST",
      1325,
      "E momentul să te „absintezi” și să te „tămâiezi”. Dacă emoțiile de catifea și acțiunile interzise sunt ceea ce te stârnește, vei adora să te simți TIGER NEST. Acest parfum este o creație uluitoare Memo Paris care se naște din ceea ce este sacru și totuși interzis, pentru a escalada muntele Bhutan unde limeta, papirusul, vanilia, trandafirul, șofranul și balsamul de Tolu alunecă și se împletesc ca limbile unui foc interior pe care nu îl poți ignora și pe care nu te poți abține să-l atingi.",
      "MEMO PARIS",
      "femei",
      100,
      array(
        "memo_paris_tigers_nest_0.jpg",
        "memo_paris_tigers_nest_1.jpg",
        "memo_paris_tigers_nest_2.jpg"
      )
    ),
    array(
      "FLAM",
      1325,
      "Când nu poți să explici cum te simți, poți găsi un parfum care să o facă în locul tău. FLAM va inflama inima persoanei iubite cu farmecul lui hipnotic. Memo Paris a luat amintirea înghețatelor țărmuri nordice, de-a lungul cărora navele vikinge alunecă pe ape cristaline, și a transformat-o într-un mariaj maiestuos de portocală amară, bergamotă, iasomie, ambră, vanilie, mosc și salvie, o promisiune îndeplinită.",
      "MEMO PARIS",
      "bărbați",
      100,
      array(
        "memo_paris_flam_0.jpg",
        "memo_paris_flam_1.jpg",
        "memo_paris_flam_2.jpg"
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
        INSERT INTO $product_table_name (nume, pret, descriere, brand, pentru, cantitate)
        VALUES (:name, :price, :description, :brand, :pentru, :cantitate)
      ";
      $smt = $conn->prepare($create_product_query);
      $smt->bindParam(':name', $product[0]);
      $smt->bindParam(':price', $product[1]);
      $smt->bindParam(':description', $product[2]);
      $smt->bindParam(':brand', $product[3]);
      $smt->bindParam(':pentru', $product[4]);
      $smt->bindParam(':cantitate', $product[5]);
      $smt->execute();

      // Note: Get the product ID of the inserted product
      $last_product_id = $conn->lastInsertId();

      // Note: Create the product images.
      $product_images = $product[6];
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

  // Note: Create 'utilizator' table if not exists.
  $create_user_table_query = "
    CREATE TABLE IF NOT EXISTS $user_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username NVARCHAR(30),
      password NVARCHAR(30)
    )
  ";
  $conn->exec($create_user_table_query);
  
  // Note: Add test user.
  $user = "test@test";
  $pass = "test";

  $create_user_query = "
    INSERT INTO $user_table_name (username, password)
    VALUES (?, ?)
  ";
  $smt = $conn->prepare($create_user_query);
  $smt->execute([
    $user,
    $pass
    //password_hash($pass, PASSWORD_DEFAULT)
  ]);

  // Note: Create 'Cart' table.
  $create_cart_table_query = "
    CREATE TABLE IF NOT EXISTS $cart_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      total DECIMAL(10,4),
      utilizator_id INT(6) UNSIGNED NOT NULL,

      FOREIGN KEY (utilizator_id) REFERENCES $user_table_name(id)
    )
  ";
  $conn->exec($create_cart_table_query);

  // Note: Create 'CartItem' table.
  $create_cart_item_table_query = "
    CREATE TABLE IF NOT EXISTS $cart_item_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      cantitate INT(6) UNSIGNED,
      pret DECIMAL(10,4),
      produs_id INT(6) UNSIGNED NOT NULL,
      cos_id INT(6) UNSIGNED NOT NULL,

      FOREIGN KEY (produs_id) REFERENCES $product_table_name(id),
      FOREIGN KEY (cos_id) REFERENCES $cart_table_name(id)
    )
  ";
  $conn->exec($create_cart_item_table_query);


  $conn = null;
  
  header('Location: ./../index.php');