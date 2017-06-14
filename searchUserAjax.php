<?php
session_start();
require_once 'dao.php';
$nom = filter_input(INPUT_POST, 'nameUser');

$toDisplay = '';
foreach(readUserSearch($nom) as $user)
{
    $toDisplay .= "<tr>";
    $toDisplay .= "<td><img width='50' height='50' src='img/avatar/".$user["avatarUtilisateur"]."'></td>";
    $toDisplay .= '<td><a href="profil.php?idUtilisateur=' . $user['idUtilisateur'] . '">'.$user['pseudoUtilisateur'].'</a></td>';
    $toDisplay .= '<td>'.$user['prenomUtilisateur'].'</td>';
    $toDisplay .= '<td>'.$user['nomUtilisateur'].'</td>';
    $toDisplay .= '<td>'.$user['emailUtilisateur'].'</td>';
    $toDisplay .= '<td><a href="javascript:deleteUser('.$user['idUtilisateur'].')" class="btn btn-danger">Supprimer</a></td>';
    $toDisplay .= "</tr>"; 
}
echo $toDisplay;

