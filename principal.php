<?php

//creamos la sesión
session_start();
include 'config/conexion.php';
//validamos si se ha hecho o no el inicio de sesión correctamente
//si no se ha hecho la sesión nos regresará a login.php
if(!isset($_SESSION['user'])) 
{
  header('Location: login.php'); 
  exit();
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="img/onefuture.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Principal</title>
</head>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>
<script src="js/bootstrap.js"></script>
<body>
    <header>
    <?php
    include 'nav.php';
    ?>
    </header>
    <div><h1  id="tbl"><img src="img/logo1.png" style="margin-left: 30px;" alt=""></h1></div>
    <?php 

        include 'config/conexion.php';
        if($_SESSION['rol'] == 1){
        
        //Consulta para contar el numero de usuarios registrados
        $sql1 = mysqli_query($conection, "SELECT COUNT(id_usuario) AS numusu FROM usuario WHERE estatus = 1");

        $result1 = mysqli_num_rows($sql1);
        if($result1 > 0){
            $row1 = mysqli_fetch_assoc($sql1);
        }


        //Consulta para contar el numero de clientes registrados
        $sql2 = mysqli_query($conection, "SELECT COUNT(idcliente) AS numcl FROM cliente WHERE estado = 1");

        $result2 = mysqli_num_rows($sql1);
        if($result2 > 0){
            $row2 = mysqli_fetch_assoc($sql2);
        }


        //Consulta para contar el numero de proveedores registrados
        $sql3 = mysqli_query($conection, "SELECT COUNT(idproveedor) AS numprov FROM proveedor WHERE estatus = 1");

        $result3 = mysqli_num_rows($sql3);
        if($result3 > 0){
            $row3 = mysqli_fetch_assoc($sql3);
        }


        //Consulta para contar el numero de productos registrados
        $sql4 = mysqli_query($conection, "SELECT COUNT(idproducto) AS numprod FROM producto WHERE estatus = 1");

        $result4 = mysqli_num_rows($sql4);
        if($result4 > 0){
            $row4 = mysqli_fetch_assoc($sql4);
        }

        
    ?>
    <div class="row carts">
        <div class="card text-white bg-primary mb-3 views" style="max-width: 18rem;">
            <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title">Numero de Usuarios Registrados</h5>
                    <h2><?php echo $row1['numusu'] ?></h2> 
                </div>
        </div>
        <div class="card text-white bg-danger mb-3 views" style="max-width: 18rem;">
            <div class="card-header">Clientes</div>
                <div class="card-body">
                    <h5 class="card-title">Numero de Usuarios Registrados</h5>
                    <h2><?php echo $row2['numcl'] ?></h2>
                </div>
        </div>
        <div class="card text-white bg-success mb-3 views" style="max-width: 18rem;">
            <div class="card-header">Proveedores</div>
                <div class="card-body">
                    <h5 class="card-title">Numero de Proveedores registrados</h5>
                    <h2><?php echo $row3['numprov'] ?></h2>
                </div>
        </div>
        <div class="card text-white bg-warning mb-3 views" style="max-width: 18rem;">
            <div class="card-header">Productos</div>
                <div class="card-body">
                    <h5 class="card-title">Numero de productos Registrados</h5>
                    <h2><?php echo $row4['numprod'] ?></h2>
                </div>
        </div>
    </div>
<?php 
    $query = mysqli_query($conection, "SELECT * FROM configuracion WHERE id = 1");

    $resultt = mysqli_num_rows($query);

    if($resultt > 0){
        $col = mysqli_fetch_assoc($query);
    }
?> 
    <div class="container">
        <div class="row">
            <div class="col-sm-6 cont">
                <div class="card">
                    <div class="card-body">
                        <form id="infoform" method="">
                            <h3 class="form-text text-muted">Informacion De la Empresa</h3>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for=""><Strong>Nombre de La empresa</Strong></label>
                                <p><?php echo $col['nombre'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for=""><strong>NIT</strong></label>
                                <p><?php echo $col['nit'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for=""><strong>Telefono</strong></label>
                                <p><?php echo $col['telefono'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for=""><strong>Email</strong></label>
                                <p><?php echo $col['email'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for=""><strong>Direccion</strong></label>
                                <p><?php echo $col['direccion'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for=""><strong>IVA</strong></label>
                                <p><?php echo $col['iva'] ?>%</p>
                            </div>
                            <br>
                            <br>
                            <button id="mostrar" type="submit" class="btn btn-primary" onclick="send_id(<?php echo $col['id']; ?>)">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 cont" id="edit" style="display: none;">
                <div class="card">
                    <h3 class="card-title" style="text-align: center;">Editar informacion de la Empresa</h5>
                    <div class="card-body"  id="info">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h5 class="h5">Graficar ventas por rango de Fecha</h5>
        <form class="form_group cl" id="search_graphic" action="">
        <input type="hidden" name="action" value="searchGraphic">
            <div class="row">
                <div class="busc col-sm-4 fom-group">
                    <label class="control-label" for=""><strong>De: </strong></label>
                    <input class="form-control" type="date" name="fecha_de" id="fecha_de" required>
                </div>
                <div class="busc col-sm-4 form-group">
                    <label class="control-label" for=""><strong>A</strong></label>
                    <input class="form-control" type="date" name="fecha_a" id="fecha_a" required>
                </div>
                <button class="btn_btn" type="submit"><img width="30px" src="img/loupe.png" alt=""></button>
            </div>
        </form>
    </div>
    <div class="resultado" style="width: 98%; height: 80vh">
        <canvas id="grafico"><!-- GRAFICA CARGADA MEDIANTE CHART Y JQUERY--></canvas>
    </div> 
    <div class="modal fade" id="formeditpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformpass">
            
        </div>
    </div>
    <style>
        p{
            text-align: center !important;
        }
    </style>
    <?php } ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/Chart.js"></script>
    <script src="js/grafica.js"></script>
    <script src="js/principal.js"></script>
<body>
</html>

<!-- Consulta para obtener el total de ventas por dia xd

SELECT COUNT(nofactura) AS ventas, DATE_FORMAT(fecha, '%y-%m-%d')
 AS fecha1 FROM `factura` GROUP BY DATE_FORMAT(fecha, '%y-%m-%d')


Otra forma en la cual se puede implementar para un rango de fechas

SELECT COUNT(nofactura) AS ventas, DATE_FORMAT(fecha, '%y-%m-%d')
 AS fecha1 FROM `factura` WHERE fecha BETWEEN '2020-08-04' AND '2020-09-09'
  GROUP BY DATE_FORMAT(fecha, '%y-%m-%d');-->