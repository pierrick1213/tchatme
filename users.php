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
        <meta name="description" content="Page users qui affichent les membres du sites et nos amis">
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
        echo membresAffichage();
        echo footer();
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                searchNoFriend();
                searchFriend();
            });
            function searchNoFriend() {
                var nameNoFriend = $('#rechercheNonAmis').val();
                $.ajax({
                    type: 'POST',
                    url: 'searchAjaxNoFriend.php',
                    data: {'nameNoFriend': nameNoFriend},
                    dataType: 'html',
                    success: function (data) {
                        $('#resultNonAmis').html(data);
                    },
                    error: function (jqXHR) {
                        $('#resultNonAmis').html(jqXHR.toString());
                    }
                });
            }

            function searchFriend() {
                var nameFriend = $('#rechercheAmis').val();
                $.ajax({
                    type: 'POST',
                    url: 'searchAjaxFriend.php',
                    data: {'nameFriend': nameFriend},
                    dataType: 'html',
                    success: function (data) {
                        $('#resultAmis').html(data);
                    },
                    error: function (jqXHR) {
                        $('#resultAmis').html(jqXHR.toString());
                    }
                });
            }

            function sendInvitText(idUtilisateur) {

                var texteDemande = prompt("Veuillez indiquer la raison de votre demande d'amitié (laissez vide si aucune raison)");
                if (texteDemande !== null) {
                    $.ajax({
                    type: 'POST',
                    url: 'sendInvitAjax.php',
                    data: {'idUtilisateur': idUtilisateur, 'texteDemande': texteDemande},
                    dataType: 'html',
                    success: function () {
                        searchNoFriend();
                    },
                    error: function (jqXHR) {
                        
                    }
                });
                }
            }
        </script>
    </body>
</html>
