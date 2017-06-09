<?php
session_start();
require_once 'function.php';
verifConnecte();
require_once 'dao.php';
$idUtilisateur = filter_input(INPUT_POST, 'idUtilisateur');

RefuseInvit($_SESSION['idUtilisateurConnecte'], $idUtilisateur);
