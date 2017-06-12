<?php
require_once 'function.php';
verifConnecte();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Page  qui affiche les tchatsRooms auquels les utilisateurs ne participent pas">
        <meta name="author" content="Pierrick Antenen">
        <link rel="icon" href="../logo.png">

        <title>login</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

        <script src="js/jquery-3.2.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script src="function.js"></script>
    </head>
    <body>
            <?php
           echo navBar(2);
           ?>
        <div class="container">
            <h1 style="display: inline">Salles disponibles :</h1> <a href="newRoomTchat.php" style="float: right" type="button" class="btn btn-primary btn-lg">+</a>
            <table class="table table-bordered">
                <tr>
                    <th>logo</th>
                    <th>Nom de la salle</th>
                    <th>Descritpion</th>
                    <th>Date d'échéance</th>
                    <th>Rejoindre</th>
                </tr>
                <?php
           echo noParticipeTchat();
           ?>
                </table></div>
                <?php
           echo footer();
            ?>
        
    </body>
</html>