 
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
        <link rel="stylesheet" href="css/loginpagestyle.css" type="text/css>
      <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

  </head>
  <body>
    <!-- header and navigation -->
    <div class="header">
      <div class="header-logo">Magazinul</div>
      <div class="header-cart">
        <i class="fa-solid fa-bag-shopping" style="color: #15322f;"></i> 0 lei
      </div>
    </div>
    <div class="container-all-login-register">
      <h1 class="conectare-title">Conectare</h1>

      <form action="login.php" method="post">
          
        <div class="email">E-mail</div><br>
        <input type="email" name="email" required placeholder="Introduceti e-mail">

        <div class="parola-container">
          <div class="parola">Parolă</div><br>
          <input type="password" name="password"  required placeholder="Introduceti parola">
        </div><br>
        <input class ="autentificare-buton" type="submit" value="Autentificare">

      </form>
      <div class="footer-registration-wrapper">Nu aveți cont?  <a class="autentificare-link" href="register.php"> Inregistrare</a></div>

    </div>
    <?php 
      require_once("./db_config.php");
      //Note: the following code  allows you to connect to the database
      $conn = new PDO("mysql:host=$servername;", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->exec("USE $database");



      if(isset($_POST["username"])&&isset($_POST["password"]))
      {
        $email=$_POST['email'];
        $password=$_POST['password'];  
        //note: here we 'should' take from produse database THE PRODUCT WICH HAVE THE ID=PRODUCT_ID 
        $user_querry = "SELECT * FROM $user_table_name WHERE 'email'=$email and 'parola'=$password";
        $smt = $conn->prepare($user_querry);
        $smt->execute();
        $user = $smt->fetch();
        if($user==0){
          ?>
          <script type="text/javascript">
              alert("Acest cont nu exista");
          </script>

          <?php
        }
        else{
          header("location:index.php");
          exit();
        }
      
         
      }
      
    ?>

  </body>
</html>