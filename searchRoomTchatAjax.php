<?php
session_start();
require_once 'dao.php';
$name = filter_input(INPUT_POST, 'nameTchatRoom');

$toDisplay = "";
    foreach (readTchatRoom($name) as $tchatRoom) {
        $toDisplay .= '<tr>
                         <td><img width="50" height="50" src="img/vignette/' . $tchatRoom['vignetteTchat_room'] . '"></td>
                         <td><a href="roomTchat.php?idTchat_room=' . $tchatRoom['idTchat_room'] . '">' . $tchatRoom['nomTchat_room'] . '</a></td>
                         <td>' . $tchatRoom['descritpionTchat_room'] . '</td>
                         <td>' . $tchatRoom['dureeVieTchat_room'] . '</td>
                         <td><a href="javascript:deleteTchatRoom('.$tchatRoom['idTchat_room'].')" class="btn btn-danger">Supprimer la salle</a></td>
                        </tr>';
    }
    echo $toDisplay;
