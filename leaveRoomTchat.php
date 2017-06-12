<?php
require_once 'function.php';
verifConnecte();
require_once 'dao.php';
$idTchat_room = $_GET['idTchat_room'];

deleteUserInTchatRoom($idTchat_room, $_SESSION['idUtilisateurConnecte']);
header('location: index.php');
