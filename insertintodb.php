<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/loginpagestyle.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">

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
    <div class="container-all-login-register">
      <h1 class="conectare-title">Inserare Produse </h1> 

      <div class="container-all-items">

        <form action="register.php" method="post">
          
          <div class="email">Nume</div><br>
          <input type="text" name="name" required placeholder="Nume">

          <div class="parola-container">Brand</div><br>
          <input type="text" name="brand" required placeholder="Brand">

          <div class="parola-container">Cantiate</div><br>
          <input type="text" name="cantiatte" required placeholder="Cantiatte">

          <div class="parola-container">Nume</div><br>
          <input type="text" name="email" required placeholder="Nume">

          <div class="parola-container">Nume</div><br>
          <input type="text" name="email" required placeholder="Nume">

          <div class="parola-container">Nume</div><br>
          <input type="text" name="email" required placeholder="Nume">

          <div class="parola-container">Nume</div><br>
          <input type="text" name="email" required placeholder="Nume">



          </div><br>
          <div class="termeni-si-conditii">
            Declar că am luat cunoștință de  Principiile prelucrării datelor cu caracter personal și de <a class="linker" href="termeni_si_conditii.html">termeni și condiții</a>, așadar doresc să mă înregistrez.
          </div>
            <input class ="autentificare-buton" type="submit" name="button"value="Inregistrare">

        </form>

      </div>
    </div>
    <?php  
       if(isset($_POST["button"]))
       {

          require_once("./db_config.php");

          $email=$_POST['email'];
          $parola=$_POST['password'];

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
