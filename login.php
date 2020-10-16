<?php

$alert = '';
session_start();
//si la sesion esta activa se redirige a index1.php
if(!empty($_SESSION['active'])){
    header('location: principal.php');
}else{
    //si no hay sesion iniciada se reciben los datos del formulario
    if(!empty($_POST)){
        //se captura el usuario y contraseña enviados del formulario
        if (empty($_POST['user']) || empty($_POST['pass'])){
            $alert = "Ingrese su usuario y su clave";
        }else{
            require_once "config/conexion.php";
            //se almacenan los datos capturados en variables
            $user = mysqli_real_escape_string($conection,$_POST['user']);
            $pass =md5(mysqli_real_escape_string($conection,$_POST['pass']));
            /*se verifica si el usuario y contraseña
            * enviados coinciden con los registrados 
            * en la BD
            */
            $query = mysqli_query($conection,"SELECT * FROM usuario where user = '$user' and pass = '$pass'");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);
            //se recorren los datos del usuario que se esta logueando
            if($result > 0){

                $data = mysqli_fetch_array($query);
                
                $_SESSION['active'] = true;
                $_SESSION['iduser'] = $data['id_usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['user'] = $data['user'];
                $_SESSION['rol'] = $data['rol'];
                //si los datos son correctos se redirige a principal.php
                header('location:principal.php');
            }else{
                
                $alert = "El usuario o la clave son incorrectos";
                session_destroy();
            }

        }
    } 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="img/onefuture.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/style_log.css">
  <link rel="stylesheet" href="css/estilo.css">
  <title>Formulario Registro</title>
</head>
<body>
  <form class="form-register" action="" method="POST" autocomplete="off">
  <img src="img/OneFuture.png" id="profile-img" class="profile-img-card">
    <h3>Inicio De Sesion</h3>
    <input class="controls" type="text" name="user" id="correo" placeholder="Ingrese su Usuario">
    <input class="controls" type="password" name="pass" id="correo" placeholder="Ingrese su Contraseña">
    <input class="botons" type="submit" value="Iniciar Sesion">
</form>
</body>
</html>
