<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/product.css">
  <link rel="stylesheet" href="css/loginpagestyle.css" type="text/css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

</head>

<body>


  <?php
    session_start();
    require_once('./header.php');
  ?>


  <?php

    if (!isset($_SESSION["user_id"]))
    {
      header("Location: login.php");
    }

    if (isset($_POST["logout"]))
    {
      session_unset();
      session_destroy();

      header("Location: index.php");
    }

  ?>

<div class ="container-all-login-register">
  <form action="" method="POST">
    <button class="autentificare-buton" 
      type="submit" 
      name="logout">
      Deconectare
    </button>
  </form>
</div>
  


</body>

</html>