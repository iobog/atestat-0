<?php

  session_start();
  session_unset();
  session_destroy();

  require_once("./../db_config.php");

  $conn = new PDO("mysql:host=$servername;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $drop_db_query = "DROP DATABASE IF EXISTS $database";
  $conn->exec($drop_db_query);

  $create_db_qurey = "CREATE DATABASE IF NOT EXISTS $database";
  $conn->exec($create_db_qurey);

  $conn->exec("USE $database");

  require_once('../product_logic.php');
  require_once('../user_logic.php');

  // Note: Create 'Product' table if not exists.
  $create_product_table_query = "
    CREATE TABLE IF NOT EXISTS $product_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      nume NVARCHAR(30),
      pret DECIMAL(10,4),
      descriere NVARCHAR(1024),
      brand NVARCHAR(128),
      gen NVARCHAR(20),
      marime NVARCHAR(20),
      stoc INT(6) 
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
        "killian/killian_dark_lord.jpg",
        "killian/killian_dark_lord_02.jpg"
      ),
      "barbati",
      "50",
      5
    ),
    array(
      "MUSK OUD",
      1610,
      "Superb, măiestrit, epic, întocmai ca un bun western vechi. Și, ca în orice western, tema lui centrală este dreptatea. Și MUSK OUD mizează pe cartea justiției, dar este mai degrabă o justiție poetică a trandafirului. Acțiunea se desfășoară într-un prelung acord răvășitor de oud, în timp ce paciuli și moscul ancorează introducerea amețitoare marcată de rom. Într-o curgere lină, pe cât de dulce, pe atât de seducătoare, o nouă pagină se scrie pentru oud-ul antic și o explozie mătăsoasă de petale și mosc se derulează în fața simțurilor tale.",
      "KILIAN PARIS",
      array(
        "killian/killian_musk_oud.jpg"
      ),
      "barbati",
      "50",
      5
    ),
    array(
      "BACK TO BLACK",
      1130,
      "Negru. Miroase a noapte fără sfârșit, a dorință neastâmpărată, a atingere de catifea, a gând necuviincios, a amintire năvalnică ce te face să roșești, a afrodiziac, a BACK TO BLACK. Acest parfum trece printr-o paletă colorată de bergamotă, zmeură, șofran, vanilie, mușețel albastru și paciuli care, combinate astfel de inimitabilul Kilian Paris, ajung să miroasă precum negrul, un negru care te prinde cu siguranță. ",
      "KILIAN PARIS",
      array(
        "killian/killian_back_to_black.jpg"
      ),
      "barbati",
      "50",
      6
    ),
    array(
      "GOOD GIRL GONE BAD BY KILIAN",
      1130,
      "Ei bine, în acest caz, „rău” nu este opusul lui „bun”, deoarece această formă de „rău” e doar pasul care desparte o imaginație senzuală de o minte insolentă. GOOD GIRL GONE BAD e opulent floral, delicios feminin, plăcere consumată și tensiune făcută palpabilă de Kilian Paris. Dar, știi tu, uneori trebuie să păstrezi cele mai bune momente doar pentru tine.",
      "KILIAN PARIS",
      array(
        "killian/killian_good_girl_gone_bad.jpg"
      ),
      "femei",
      "50",
      8
    ),
    array(
      "SICILIAN LEATHER",
      1325,
      "Se spune că oamenii nu cred în vulcani până nu le ajunge lava la picioare. La fel stau lucrurile și cu această călătorie olfactivă în adâncurile memoriei. SICILIAN LEATHER e un parfum temperamental despre insula Sicilia și caracterul ei vulcanic, o poveste spusă într-un acord suculent de portocală-lămâie, energic de coriandru-violetă, eruptiv de guaiac-piele. Într-adevăr, este un fenomen aparte, fenomenul unic prin care apa, focul și pielea se întâlnesc într-un parfum.",
      "MEMO PARIS",
      array(
        "memo_paris/memo_paris_scilian_leather_0.jpg",
        "memo_paris/memo_paris_scilian_leather_1.jpg",
        "memo_paris/memo_paris_scilian_leather_2.jpg"
      ),
      "unisex",
      "75",
      4
    ),
    array(
      "TIGER'S NEST",
      1325,
      "E momentul să te „absintezi” și să te „tămâiezi”. Dacă emoțiile de catifea și acțiunile interzise sunt ceea ce te stârnește, vei adora să te simți TIGER NEST. Acest parfum este o creație uluitoare Memo Paris care se naște din ceea ce este sacru și totuși interzis, pentru a escalada muntele Bhutan unde limeta, papirusul, vanilia, trandafirul, șofranul și balsamul de Tolu alunecă și se împletesc ca limbile unui foc interior pe care nu îl poți ignora și pe care nu te poți abține să-l atingi.",
      "MEMO PARIS",
      array(
        "memo_paris/memo_paris_tigers_nest_0.jpg",
        "memo_paris/memo_paris_tigers_nest_1.jpg",
        "memo_paris/memo_paris_tigers_nest_2.jpg"
      ),
      "unisex",
      "75",
      6
    ),
    array(
      "FLAM",
      1325,
      "Când nu poți să explici cum te simți, poți găsi un parfum care să o facă în locul tău. FLAM va inflama inima persoanei iubite cu farmecul lui hipnotic. Memo Paris a luat amintirea înghețatelor țărmuri nordice, de-a lungul cărora navele vikinge alunecă pe ape cristaline, și a transformat-o într-un mariaj maiestuos de portocală amară, bergamotă, iasomie, ambră, vanilie, mosc și salvie, o promisiune îndeplinită.",
      "MEMO PARIS",
      array(
        "memo_paris/memo_paris_flam_0.jpg",
        "memo_paris/memo_paris_flam_1.jpg",
        "memo_paris/memo_paris_flam_2.jpg"
      ),
      "unisex",
      "75",
      0
    ),
  );

  
  foreach($products as $product) {

    if (product_exists($product[0])) continue;

    create_product(
      name: $product[0],
      description: $product[2],
      brand: $product[3],
      price: $product[1],
      gender: $product[5],
      size: $product[6],
      stock: $product[7],
      image_urls: $product[4]
    );
  }

  // Note: Create 'User' table.
  $create_user_table_query = "
    CREATE TABLE IF NOT EXISTS $user_table_name(
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username NVARCHAR(30) NOT NULL,
      password NVARCHAR(30) NOT NULL,
      rol NVARCHAR(30)
    )
  ";
  $conn->exec($create_user_table_query);
  
  // Note: Add test user.
  $user = "test@test";
  $pass = "test";
  create_user($user, $pass, "user");

  // Note: Add admin user.
  $user = "admin@admin";
  $pass = "admin";
  create_user($user, $pass, "admin");


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