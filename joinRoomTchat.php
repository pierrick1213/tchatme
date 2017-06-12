<?php
require_once 'function.php';
verifConnecte();
require_once 'dao.php';
$idTchat_room = $_GET['idTchat_room'];

addUserInTchatRoom($idTchat_room, $_SESSION['idUtilisateurConnecte']);
header('location: roomTchat.php?idTchat_room='.$_GET['idTchat_room']);
