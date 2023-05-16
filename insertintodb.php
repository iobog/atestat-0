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

          <p><label for="cantitate">Cantiatte</label></p>
            <input type="number" name="cantiatte" required placeholder="Cantiatte"><br>

          <p><label for="pret">Pret</label></p>
            <input type="number" name="pret" required placeholder="Pret"> <br>

          <p><label for="pentru">Sex</label></p>
            <select name="pentru" >
              <option value="femei">Femei</option>
              <option value="bărbați">Bărbați</option>
            </select>




          <p><label for="descriere">Descriere:</label></p>
          <textarea  name="descriere" rows="20" cols="50"></textarea><br>

          <label for="files">Select files:</label>
            <input type="file"name="imagini_produs[]" multiple><br>

          <input class ="autentificare-buton" type="submit" name="button"value="Inserare">

        </form>

      </div>
    </div>
    <?php  
       if(isset($_POST["button"]))
       {

          require_once("./db_config.php");

          $nume=$_POST['name'];
          $brand=$_POST['brand'];
          $cantitate=$_POST['cantitate'];
          $pentru=$_POST['pentru'];
          $descriere=$_POST['descriere'];
          

          $conn = new PDO("mysql:host=$servername;", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
          $conn->exec("USE $database");
          $smt = $conn->prepare("SELECT COUNT(*) from $user_table_name where username = :name");
          $smt->bindParam(":name", $email);
          $smt->execute();
          $count = $smt->fetchColumn();
          if($count==0)
          {
            $user_table_querry = "
              INSERT INTO $user_table_name (username, password)
              VALUES (:email, :parola)
            ";
            $smt = $conn->prepare($user_table_querry);
            $smt->bindParam(':email', $email);
            $smt->bindParam(':parola', $parola);
            $smt->execute();

            ?>
            <script>
              history.go(-2);
            </script>

            <?php            
            exit();

          } 
           else{  ?>
            <script type="text/javascript">
              history.go(-1);
              alert("Email deja folosi");
            </script>
            
          <?php
          }

       }
    ?>

  </body>
</html>
