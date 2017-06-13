<?php
require_once 'function.php';
verifConnecte();
verifTchatRoom();
$idTchatRoom = $_GET['idTchat_room'];
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Page pour l'affichage d'une tchat room avec son contenu">
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
        echo navBar(0);
        echo tchatRoom();
        echo footer();
        ?>
    <script type="text/javascript">
            $(document).ready(function () {
                readMessage(<?php echo $idTchatRoom;?>);
            });
            setInterval(function(){ readMessage(<?php echo $idTchatRoom;?>); }, 3000);
            
        </script>
    </body>
</html>

