
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
      <h1 class="conectare-title">Înregistrare</h1> 

      <div class="container-all-items">
        <form action="register.php" method="post">
          
          <div class="email-container">
              <div class="email">E-mail</div><br>
              <input type="email" name="email" required>
          </div>

          <div class="parola-container">
            <div class="parola">Parolă</div><br>

            <input  class="input-informations" type="password" name="password" required>

          </div><br>
          <div class="termeni-si-conditii">
            <input type="checkbox" name="conditii" required>
            <a class="conditions"href="#">Declar că am luat cunoștință de  Principiile prelucrării datelor cu caracter personalși de termeni și condiții, 
              așadar doresc să mă înregistrez și să mă alătur clubului Fregrance.</a>
          </div>
            <input class ="autentificare-buton" type="submit" value="Inregistrare">

        </form>
      </div>
    </div>
    

  </body>
</html>