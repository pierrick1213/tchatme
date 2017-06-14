<?php
session_start();
require_once 'dao.php';
$idTchatRoom = filter_input(INPUT_POST, 'idTchatRoom');
$toDisplay = '';
$oldDate = NULL;
foreach (readMessageByIdTchatRoom($idTchatRoom) as $message){
    $dateMessage = explode(" ", $message['dateMessage']);
                                $toDisplay.='<div class="row">';
                                if ($oldDate != $dateMessage[0]) {
                                    $toDisplay.='<div class="col-lg-12">
                                        <p class="text-center text-muted small">'.$dateMessage[0].'</p>
                                    </div>';
                                }                
                                $toDisplay.='</div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="media">
                                            <a class="pull-left" href="profil.php?idUtilisateur='.$message['idUtilisateur'].'">
                                                <img class="media-object img-circle" src="img/avatar/'.$message['avatarUtilisateur'].'" width="50" height="50" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">'.$message['pseudoUtilisateur'].'
                                                    <span class="small pull-right">'.$dateMessage[1].'</span>
                                                </h4>
                                                <p>'.$message['message'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>';
                                $oldDate = $dateMessage[0];
                             }
                             $toDisplay.='<div id="down"></div>';
                             echo $toDisplay;
