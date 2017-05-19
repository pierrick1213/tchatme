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

        <form class="form-signin" action="register.traitement.php" method="post" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Enregistrement</h2>
        <label for="inputPrenom" class="sr-only">Prénom</label>
        <input name="prenom" type="text" id="inputPrenom" class="form-control" placeholder="Prénom" required autofocus>
        <label for="inputNom" class="sr-only">Nom</label>
        <input name="nom" type="text" id="inputNom" class="form-control" placeholder="Nom" required>
        <label for="inputPseudo" class="sr-only">Pseudo</label>
        <input name="pseudo" type="text" id="inputPseudo" class="form-control" placeholder="Pseudo" required>
        <?php
        if (isset($_GET['erreur'])) {
            if ($_GET['erreur'] == "pseudoExist") {
            echo '<p id="erreurRegister">le pseudo indiqué est déja inscrit dans la base</p>';
        }
        }
        ?>
        <label for="inputEmail" class="sr-only">Email</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required>
        <?php
        if (isset($_GET['erreur'])) {
            if ($_GET['erreur'] == "emailExist") {
            echo '<p id="erreurRegister">l\'émail indiqué est déja inscrit dans la base</p>';
        }
        }
        ?>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input name="password1" type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
        <?php
        if (isset($_GET['erreur'])) {
            if ($_GET['erreur'] == "notSameMdp") {
            echo '<p id="erreurRegister">les mots de passe ne correspondent pas</p>';
        }
        }
        ?>
        <label for="inputPassword2" class="sr-only">Mot de passe</label>
        <input name="password2" type="password" id="inputPassword2" class="form-control" placeholder="Répéter le mot de passe" required>
        <label for="inputAvatar" class="sr-only">Avatar</label>
        <input name="avatar" type="file" id="inputAvatar" class="form-control" placeholder="Avatar" accept="image/*" required>
        <?php
        if (isset($_GET['erreur'])) {
            if ($_GET['erreur'] == "failAvatar") {
            echo '<p id="erreurRegister">Il y  a eu une erreur avec votre avatar. Veuillez changer d\'image</p>';
        }
        }
        ?>
        <button id='registerButton' class="btn btn-lg btn-primary btn-block" type="submit">S'enregistrer</button>
        <a href="login.php" class="btn btn-lg btn-primary btn-block">Se connecter</a>
      </form>

    </div>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
