<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de login pour l'utilisateur">
    <meta name="author" content="Pierrick Antenen">
    <link rel="icon" href="../../favicon.ico">

    <title>login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

        <form class="form-signin" action="login.traitement.php" method="post">
        <h2 class="form-signin-heading">Connexion</h2>
        <?php
        if (isset($_GET["reussi"])) {
            if ($_GET["reussi"] == true) {
                echo '<p>Votre compte a bien été créé</p>';
            }
        }
        ?>
        <label for="inputPseudo" class="sr-only">Pseudo</label>
        <input name="pseudo" type="text" id="inputPseudo" class="form-control" placeholder="Pseudo" required autofocus>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
        <button id="registerButton" class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
        <a href="register.php" class="btn btn-lg btn-primary btn-block">S'enregistrer</a>
      </form>

    </div>
    
  </body>
</html>
