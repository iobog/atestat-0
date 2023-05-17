<html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/breadcrumb.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet">

    <script src="https://kit.fontawesome.com/401ef7ae9e.js" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php 
      session_start();
      include_once('./header.php');
    ?>
    
    <div class="header">
    <a class="header-link" href="insertintodb.php">Introduce Produs</a>
    <a class="header-link" href="cart.php">
      Elimina Produs
    </a>
    </div>
  </body>

</html>