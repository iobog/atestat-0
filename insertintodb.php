<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/loginpagestyle.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/insertintodbcss.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="css/loginpagestyle.css" type="text/css">
      <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

  </head>
  <body>
    <!-- header and navigation -->
    <
    <div class="container-insert-elements">

      <h1 class="conectare-title">Inserare Produse </h1> 

      <div class="container-inputs">

        <form action="insertintodb.php" method="post">
          <!-- 
              brand
              nume
              pret
              descriere
              brand
              pentru
              cantitate
              GetLastID-> img 
              -->
          <p><label for="nume">Nume</label></p>
            <input type="text" name="name" required placeholder="Nume"><br>

          <p><label for="brand">Brand</label></p>
            <input type="text" name="brand" required placeholder="Brand"><br>

        
            <p><label for="cantitate">Cantitate</label></p>
            <select name="cantitate" >
              <option value="100">100</option>
            </select>

          <p><label for="pret">Pret</label></p>
            <input type="number" name="pret" required placeholder="Pret"> <br>

          <p><label for="pentru">Sex</label></p>
            <select name="pentru" >
              <option value="femei">Femei</option>
              <option value="bărbați">Bărbați</option>
            </select>




          <p><label for="descriere">Descriere:</label></p>
          <textarea  name="descriere" rows="20" cols="50"></textarea><br>
          <input class ="autentificare-buton" type="submit" name="button-product-informations"value="Inserare produs">

        </form>


        <form action="insertintodb.php" method="post" enctype="multipart/form-data">

            <label for="files">Select files:</label>

            <input type="file" id="files" name="Pictures[]" multiple>

            <input class ="autentificare-buton" type="submit" name="button-product-imagine"value="Inserare imagine produs">

        </form>

      </div>
    </div>
    <?php
      require_once("./db_config.php");

      $conn = new PDO("mysql:host=$servername;", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $conn->exec("USE $database");

       if(isset($_POST["button-product-informations"]))
       {
          $nume=$_POST['name'];
          $brand=$_POST['brand'];
          $pret=$_POST['pret'];
          $cantitate=$_POST['cantitate'];
          $pentru=$_POST['pentru'];
          $descriere=$_POST['descriere'];

          $smt = $conn->prepare("SELECT COUNT(*) from $product_table_name where nume = :name");
          $smt->bindParam(":name", $nume);
          $smt->execute();
          $count = $smt->fetchColumn();
      
          if ($count == 0) {
            // Note: Create the product.
            $create_product_query = "
              INSERT INTO $product_table_name (nume, pret, descriere, brand, pentru, cantitate)
              VALUES (:name, :price, :description, :brand, :pentru, :cantitate)
            ";
            $smt = $conn->prepare($create_product_query);
            $smt->bindParam(':name', $nume);
            $smt->bindParam(':price', $pret);
            $smt->bindParam(':description', $descriere);
            $smt->bindParam(':brand', $brand);
            $smt->bindParam(':pentru', $pentru);
            $smt->bindParam(':cantitate', $cantitate);
            $smt->execute();
      
            // Note: Get the product ID of the inserted product
            $last_product_id = $conn->lastInsertId();
            
            ?><script type="text/javascript">
								alert("Ati introdus cu succes produsul <br> Acum intorduceti imaginilie!");
 				      </script>
             <?php 

            if(isset($_FILES['produse']['name']) && !empty($_FILES['produse']['name'])) {
              $numeFisiere = $_FILES['produse']['name'];
              // Note: Create the product images.   
              foreach($numeFisiere as $picture) {
                echo" $picture <br>";
                $smt = $conn->prepare("SELECT COUNT(*) from $product_table_name where url = :name");
                $smt->bindParam(":name", $picture);
                $smt->execute();
                $count = $smt->fetchColumn();
                if($count==0){
                  $create_product_image_query = "
                    INSERT INTO $product_image_table_name (produs_id, url)
                    VALUES (:product_id, :url)
                  ";
                  $smt = $conn->prepare($create_product_image_query);
                  $smt->bindParam(':product_id', $last_product_id);
                  $smt->bindParam(':url', $picture );
                  $smt->execute();
                }
              }
            }
          }
          
          } 
           else{  ?>
    
            
          <?php
          }

       
    ?>

  </body>
</html>
