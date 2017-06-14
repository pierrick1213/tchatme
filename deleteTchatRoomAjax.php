<?php
session_start();
require_once 'dao.php';
$idTchatRoom = filter_input(INPUT_POST, 'idTchatRoom');
DeleteTchatRoomById($idTchatRoom);

