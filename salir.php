<?php
//si existe una sesion se destruye
session_start();
session_destroy();
//se redirije al index.php
header('location: login.php');

?>