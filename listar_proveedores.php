<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="img/onefuture.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de  Usuario</title>
</head>

<?php
//creamos la sesión
session_start();

    include("modal/reg_proveed.php");
    
//validamos si se ha hecho o no el inicio de sesión correctamente
//si no se ha hecho la sesión nos regresará a index.php
if(!isset($_SESSION['user'])) 
{
  header('Location: index.php'); 
  exit();
}
include 'config/conexion.php';

 ?>
<body>
    <?php
    include 'nav.php';
    ?>
    
    <div id="tbl" class="container">
		<div class="content">
            <h2>Lista de Proveedores</h2>
            <br />
            <div class="form_search">
                <label for="caja_busquedap">Buscar:</label>
                <input type="text" name="caja_busquedap" id="caja_busquedap">
            </div>
        </div>
        <?php if($_SESSION['rol'] == 1){ ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModalP">
                Crear Nuevo Proveedor
            </button>
        <?php } ?>
        <div id="datosp">
            <!--DATOS CARGADOS MEDIANTE AJAX-->
            
        </div>
	    </div>
    </div>
    <div class="modal fade" id="formeditprov" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformprov">
            
        </div>
    </div>

    <div class="modal fade" id="formeditpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformpass">
            
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js" crossorigin="anonymous"></script>
<script src="js/func.js"></script>
</body>
</html>