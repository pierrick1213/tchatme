<?php
session_start();
require_once 'dao.php';
$nom = filter_input(INPUT_POST, 'nameFriend');

$toDisplay = '';
foreach(readUserFriend($nom, $_SESSION['idUtilisateurConnecte'])->fetchAll() as $user)
{
    $toDisplay .= "<tr>";
    $toDisplay .= "<td><img width='50' height='50' src='img/avatar/".$user["avatarUtilisateur"]."'></td>";
    $toDisplay .= '<td><a href="profil.php?id=' . $user['idUtilisateur'] . '">'.$user['pseudoUtilisateur'].'</a></td>';
    $toDisplay .= '<td><a href="deleteFriend.php?idUtilisateur=' . $user['idUtilisateur'] . '" class="btn btn-danger">Supprimer</a></td>';
    $toDisplay .= "</tr>"; 
}
echo $toDisplay;
