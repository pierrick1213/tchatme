<?php

session_start();
require_once 'dao.php';
$idTchatRoom = filter_input(INPUT_POST, 'idTchatRoom');
$message = filter_input(INPUT_POST, 'message');
$today = date("Y-m-d H:i:s");

sendMessage($_SESSION['idUtilisateurConnecte'], $idTchatRoom, $message, $today);
