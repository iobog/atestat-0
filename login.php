<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/cart.css">
  <link rel="stylesheet" type="text/css" href="css/input.css">
  <link rel="stylesheet" type="text/css" href="css/page.css">

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
require_once("./db_config.php");

$conn = new PDO("mysql:host=$servername;", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec("USE $database");

$message = NULL;

require_once('./user_logic.php');

if (isset($_POST['user']) && isset($_POST['pass']))
{
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $account = get_user_by_email_and_pass($user, $pass);

  if ($account === false)
  {
    $message = "<div><b>Eroare:</b> Date invalide!</div>";
  }
  else
  {
    session_unset();
    session_destroy();
    session_start();

    $_SESSION['user_id'] = $account['id'];
    $_SESSION['username'] = $account['username'];
    $_SESSION['rol'] = $account['rol'];
    
    if (isset($_GET['return']))
    {
      $return_url = urldecode($_GET['return']);
      header("Location: $return_url");
      exit();
    }

    header("Location: index.php");
    exit();
  }
}

$login_url = 'login.php?'.http_build_query($_GET);
$register_url = 'register.php?'.http_build_query($_GET);

?>


  <div class="page-title">Autentificare</div>
  <div class="page-main">
    <?php if ($message != null): ?>
      <div class="alert">
        <?php echo $message; ?>
      </div>
      <br>
    <?php endif; ?>

    <form action="<?php echo $login_url; ?>" method="post">

      <div class="form-field">
        <label for="user">Email</label>
        <input type="text" name="user" placeholder="Email" required>
      </div>

      <div class="form-field">
        <label for="pass">Parola</label>
        <input type="password" name="pass" placeholder="Parola" required>
      </div>

      <br>

      <button 
        type="submit" 
        name="login"
        value="">
        Autentificare
      </button>

    </form>
    <br>
    <p>
      Nu aveți încă cont? <a href="<?php echo $register_url; ?>">Înregistrare</a>
    </p>

  </div>


</body>

</html>


