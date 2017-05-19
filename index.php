<?php
require_once 'fonction.php';
verifConnecte();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Page de login pour l'utilisateur">
        <meta name="author" content="Pierrick Antenen">
        <link rel="icon" href="../logo.png">

        <title>login</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

        <script src="js/jquery-3.2.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
            <?php
           echo navBar();
           ?>
        <div class="container">
        <h2>Vos salles de tchat :</h2><br>
            <table class="table table-bordered">
                <tr>
                    <th>logo</th>
                    <th>Nom de la salle</th>
                    <th>Descritpion</th>
                    <th>Durée de vie</th>
                </tr>
                <?php
           echo participeTchat();
           ?>
                </table></div>
                <?php
           echo footer();
            ?>
        
    </body>
</html>
