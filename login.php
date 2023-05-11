<?php
session_start();

require_once("./db_config.php");

$conn = new PDO("mysql:host=$servername;", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec("USE $database");

//var_dump($_POST);

$message = null;

if (isset($_POST["login"])) 
{
  $username = $_POST["email"];
  $password = $_POST["password"];

  // var_dump($_POST);
  // echo "<br>";

  $smt = $conn->prepare("SELECT * FROM $user_table_name WHERE username = ?");
  $smt->execute([$username]);
  $user = $smt->fetch();
  //var_dump($user);

  // echo "<br>";
  // echo "pass: ".$user["password"];
  // echo "<br>";
  // echo "hash: ".password_hash($password, PASSWORD_DEFAULT);
  // echo "<br>";

  // var_dump(password_verify($password, $user["password"]));

  // echo "<br>";

  //if ($user === false || password_hash($password, PASSWORD_DEFAULT) != $user["password"])
  if ($user === false || $password != $user["password"])
  {
    $message = "Nepermis! Date invalide";
  }
  else
  {
    $message = "Succes!";

    session_unset();
    session_destroy();
    session_start();

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];

    if (isset($_GET["add_product"]))
    {
      $product_id = $_GET["add_product"];
      header("Location: product.php?id=$product_id&action=add");
    }
    else
    {
      header("Location: index.php");
    }

  }
}

$action_url = "login.php?".http_build_query($_GET);
//echo $action_url;
?>

<?php if ($message != null): ?>
  <div>
    <?php echo $message; ?>
  </div>
<?php endif; ?>

<link rel="stylesheet" type="text/css" href="css/loginpagestyle.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<div class="container-all-login-register">
      <h1 class="conectare-title">Conectare</h1>

      <form action="<?php echo $action_url; ?>" method="post">
          
        <div class="email">E-mail</div><br>
        <input type="email" name="email" required placeholder="Introduceti e-mail">

        <div class="parola-container">
          <div class="parola">Parolă</div><br>
          <input type="password" name="password"  required placeholder="Introduceti parola">
        </div><br>
        <input class ="autentificare-buton" type="submit" name="login" value="Autentificare">

      </form>
      <div class="footer-registration-wrapper">Nu aveți cont?  <a class="autentificare-link" href="register.php"> Inregistrare</a></div>

</div>