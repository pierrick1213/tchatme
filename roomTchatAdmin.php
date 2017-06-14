<?php
require_once 'function.php';
verifConnecte();
if (!verifAdmin()) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Page  qui affiche toutes les tchatsRooms (pour l'administrateur)">
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
           echo navBar(1);
           echo listTchatRoom();
           echo footer();
            ?>
        <script type="text/javascript">
            $(document).ready(function () {
                searchTchatRoom();
            });
        </script>
    </body>
</html>