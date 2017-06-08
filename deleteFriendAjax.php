<?php
session_start();
require_once 'dao.php';
$idUtilisateur = filter_input(INPUT_POST, 'idUtilisateur');
DeleteFriend($_SESSION['idUtilisateurConnecte'], $idUtilisateur);






