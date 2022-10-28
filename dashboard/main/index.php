<?php
include('../settings.php');
session_start();
if(!isset($_SESSION['connected']))
{

if(isset($_POST['connect']))
{


  if(!empty($_POST['username']) && !empty($_POST['password']))
  {


          $uname = htmlspecialchars($_POST['username']);
    $pword = htmlspecialchars($_POST['password']);

    
    $base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

      $stmt = $base->prepare("SELECT * FROM admin WHERE Username=?");
      $stmt->execute([$uname]);


      if($stmt->rowCount() === 1)
      {

          $user = $stmt->fetch();

          $user_id = htmlspecialchars($user['Id']);
          $user_username = htmlspecialchars($user['Username']);
           $user_password = htmlspecialchars($user['Password']);
          

           if(password_verify(htmlspecialchars($pword), htmlspecialchars($user_password)))
           {
            $_SESSION['connected'] = htmlspecialchars($user_username);
            header('Location: dashboard.php');
           }
           else{
           $_GET['error'] = "Nom d'utilisateur ou mot de passe incorrect";

         }
      }
      else{
        $_GET['error'] = "Cet utilisateur n'existe pas";
    }



     

  
    
  }

  else{

  }
}
else{



}


?>


<!doctype html>
<html lang="en" style="overflow: hidden;">
  <head>
      <script src="https://kit.fontawesome.com/6bec8a6ed4.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CONNEXION AU PANEL</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="css/app-light.css" id="lightTheme" disabled>
    <link rel="stylesheet" href="css/app-dark.css" id="darkTheme">
  </head>
  <body class="dark ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="" method="POST">
          <img style="width: 150px;" src="../img/logo-nobg.png">
          <bold><h1 class="h6 mb-3">CONNEXION</h1></bold>

          <?php 
          if(isset($_GET['account']))
          {
            echo '<div class="alert alert-success" role="alert">
                        '.$_GET['account'].' </div>';
          }
          else{



          if(isset($_GET['error'])){echo '<div class="alert alert-danger" role="alert">
                        '.$_GET['error'].' </div>'; }

                        }
                         ?>
          
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Nom d'utilisateur</label>
            <input name="username" type="usernaùe" id="inputEmail" class="form-control form-control-lg" placeholder="Nom d'utilisateur" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Mot de passe</label>
            <input name="password"type="password" id="inputPassword" class="form-control form-control-lg" placeholder="Mot de passe" required="">
          </div>
          <div class="checkbox mb-3">
            <bold><a href="register.php"><h1 class="h6 mb-3">Je n'ai pas de compte</h1></a></bold>
          </div>
          <button name="connect" class="btn btn-lg btn-primary btn-block" type="submit">Acces au panel</button>
          <p class="mt-5 mb-3 text-muted">CRUSIX BOARD V 1.0 (Tiny Dashboard THEME) </p>
        </form>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/simplebar.min.js"></script>
    <script src='js/daterangepicker.js'></script>
    <script src='js/jquery.stickOnScroll.js'></script>
    <script src="js/tinycolor-min.js"></script>
    <script src="js/config.js"></script>
    <script src="js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
</body>
</html>

<?php 
}else{
  header('Location: dashboard.php');
}

?>