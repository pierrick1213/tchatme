<?php
session_start();
require_once 'dao.php';
$pseudo = filter_input(INPUT_POST, 'nameNoFriend');

$toDisplay = '';
foreach(readUserNoFriend($pseudo, $_SESSION['idUtilisateurConnecte'])->fetchAll() as $user)
{
    $toDisplay .= "<tr>";
    $toDisplay .= "<td><img width='50' height='50' src='img/avatar/".$user["avatarUtilisateur"]."'></td>";
    $toDisplay .= "<td>".$user['pseudoUtilisateur']."</td>";
    $toDisplay .= '<td><a href="javascript:sendInvitText('.$user['idUtilisateur'].')" class="btn btn-primary">Ajouter</a></td>';
    $toDisplay .= "</tr>"; 
}
echo $toDisplay;


