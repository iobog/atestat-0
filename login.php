
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/loginpagestyle.css">

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
    <div class="container-all-items-login">
      <h1 class="conectare-title">Connectare</h1>
      <form action="login.php" method="post">
        <div>
            <div>Email</div><br>
            <input type="text" name="username" required>
        </div>
        <div>
            <div>Parolă</div><br>
            <input type="password" name="password" required>
        </div>
        <div  class ="autentificare-buton"><br>
            <input type="submit" value="Autentificare">
        </div>
      </form>
    </div>
    

  </body>
</html>