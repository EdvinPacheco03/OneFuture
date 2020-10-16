<?php
    //creamos la sesión
    session_start();
    //validamos si se ha hecho o no el inicio de sesión correctamente
    //si no se ha hecho la sesión nos regresará a index.php
    if(!isset($_SESSION['user'])) 
    {
    header('Location: index.php'); 
    exit();
    }
    include 'config/conexion.php';

    $busqueda = '';
    $fecha_de = '';
    $fecha_a = '';

    if(isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] == ''){
        header("location: ventas.php");
    }

    if(isset($_REQUEST['fecha_de']) || isset($_REQUEST['fecha_a'])){
        if($_REQUEST['fecha_de'] == '' || $_REQUEST['fecha_a'] == ''){
            header("location: ventas.php");
        }
    }

    if(!empty($_REQUEST['busqueda'])){
        if(!is_numeric($_REQUEST['busqueda'])){
            header("location: ventas.php");
        }
        $busqueda = strtolower($_REQUEST['busqueda']);
        $where = "nofactura = $busqueda";
        $buscar = "busqueda = $busqueda";
    }

    if(!empty($_REQUEST['fecha_de']) && !empty($_REQUEST['fecha_a'])){
        $fecha_de = $_REQUEST['fecha_de'];
        $fecha_a = $_REQUEST['fecha_a'];

        $buscar = '';

        if($fecha_de > $fecha_a){
            header("location: ventas.php");

        }else if($fecha_de == $fecha_a){
            $where = "fecha LIKE '$fecha_de%'";
            $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
        
        }else{
            $f_de = $fecha_de.' 00:00:00';
            $f_a = $fecha_a.' 23:59:59';
            $where = "fecha BETWEEN '$f_de' AND '$f_a' ";
            $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a"; 
        }
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
    <title>Listado de Ventas</title>
</head>
<body>
    <?php
    include 'nav.php';
    ?>
    <section id="tbl">
        <div class="action_tit">
            <h2>Listado de Facturas</h2>
            <br />
            <button type="button" class="btn btn-primary" style="margin-left: 10px;">
                <a href="nueva_venta.php" style="color: white;">Crear Nueva Factura</a>
            </button>
        </div>
        <div class="sear fom-group">
                <form action="buscar_ventas.php" method="get" class="form_search">
                    <input class="form-control inp" type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" placeholder="Buscar">
                    <button type="submit" value="Buscar" class="btn_busc"><img width="30px" src="img/loupe.png" alt=""></button>
                </form>
        </div>
        <h5 class="h5">Buscador por Fecha</h5>
        <form class="form_group cl" action="buscar_ventas.php" method="get">
            <div class="row">
                <div class="busc col-sm-4 fom-group">
                    <label class="control-label" for=""><strong>De: </strong></label>
                    <input class="form-control" type="date" name="fecha_de" id="fecha_de" value="<?php echo $fecha_de; ?>" required>
                </div>
                <div class="busc col-sm-4 form-group">
                    <label class="control-label" for=""><strong>A</strong></label>
                    <input class="form-control" type="date" name="fecha_a" id="fecha_a" value="<?php echo $fecha_a; ?>" required>
                </div>
                <button class="btn_btn" type="submit"><img width="30px" src="img/loupe.png" alt=""></button>
            </div>
        </form>
            <div class="">
                <table class="table table-striped table-hover">
                    <thead role='row'>
                    <tr >
                        <th>No. Factura</th>
                        <th>Fecha</th>
                        <th >Cliente</th>
                        <th>Vendedor</th>
                        <th>Estado</th>
                        <th>Total de Factura</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                        <?php
                            $sql_registe =  mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM factura WHERE $where");
                            $result_register = mysqli_fetch_array($sql_registe);
                            $total_registro = $result_register['total_registro'];

                            $por_pagina = 5;

                        if(empty($_GET['pagina']))
                        {
                            $pagina = 1;
                        }else{
                            $pagina = $_GET['pagina'];
                        }

                        $desde = ($pagina-1) * $por_pagina;
                        $total_paginas = ceil($total_registro / $por_pagina);

                        //se crea una variable donde se le pasa la variable de conexion y la consulta
                            $sql = mysqli_query($conection,"SELECT f.nofactura, f.fecha, f.totalfactura, f.idcliente, f.estatus,
                                                                                                u.nombre as vendedor, 
                                                                                                cl.nombre as cliente
                                                                                                FROM factura f
                                                                                                INNER JOIN usuario u 
                                                                                                ON f.usuario = u.id_usuario
                                                                                                INNER JOIN cliente cl 
                                                                                                ON f.idcliente = cl.idcliente 
                                                                                                WHERE $where AND f.estatus != 10 
                                                                                                ORDER BY f.fecha DESC LIMIT $desde, $por_pagina");
                                mysqli_close($conection);
                            
                                $result = mysqli_num_rows($sql);
                                if($result > 0){
                                while($row = mysqli_fetch_array($sql)){
                                    if($row["estatus"] == 1){
                                        $estatus = '<span class="pagada">Pagada<span>';
                                    }else{
                                        $estatus = '<span class="anulada">Anulada<span>';
                                    }
                        ?>
                        <tbody role='row'>
                        <tr id="row_<?php echo $row["nofactura"]; ?>">
                            <td data-th='No.Factura'><?php echo $row["nofactura"]; ?></td>
                            <td data-th='Fecha'><?php echo $row["fecha"]; ?></td>
                            <td data-th='Cliente'><?php echo $row["cliente"]; ?></td>
                            <td data-th='Vendedor'><?php echo $row["vendedor"]; ?></td>
                            <td data-th='Estatus'><?php echo $estatus?></td>
                            <td data-th='Total'><span>Q.<span><?php echo $row["totalfactura"]; ?></span></span></td>
                            <td data-th='Acciones'>

                                <a class="btn_view" type="button" cl="<?php echo $row["idcliente"]; ?>" f="<?php echo $row["nofactura"]; ?>" href="#">view</a>
                                <?php if($_SESSION['rol'] == 1){
                                    if($row["estatus"] == 1){

                                    
                                ?>
                                <a class="btn_anular anular_factura" type="button" cl="<?php echo $row["idcliente"]; ?>" data-toggle='modal' data-target='#formanulfac' onclick="anular_fac(<?php echo $row['nofactura']; ?> )">anu</a>
                                    <?php
                                    }else{

                                    ?>
                                <a class="btn_anular inactive" type="button" cl="<?php echo $row["idcliente"]; ?>" f="<?php echo $row["nofactura"]; ?>" href="#">anu</a>
                                <?php } 
                                      }

                                ?>

                            </td>
                        </tr>
                        </tbody>
                        <?php
                        }
                        }
                        ?>
                </table>
                <div class="paginador">
                    <ul>
                    <?php 
                        if($pagina != 1)
                        {
                    ?>
                        <li><a href="?pagina=<?php echo 1; ?>&<?php echo $buscar; ?>">|<</a></li>
                        <li><a href="?pagina=<?php echo $pagina-1; ?>&<?php echo $buscar; ?>"><<</a></li>
                    <?php 
                        }
                        for ($i=1; $i <= $total_paginas; $i++) { 
                            # code...
                            if($i == $pagina)
                            {
                                echo '<li class="pageSelected">'.$i.'</li>';
                            }else{
                                echo '<li><a href="?pagina='.$i.'&'.$buscar.'">'.$i.'</a></li>';
                            }
                        }

                        if($pagina != $total_paginas)
                        {
                    ?>
                        <li><a href="?pagina=<?php echo $pagina + 1; ?>&<?php echo $buscar; ?>">>></a></li>
                        <li><a href="?pagina=<?php echo $total_paginas; ?>&<?php echo $buscar; ?> ">>|</a></li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="formeditpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformpass">
            
        </div>
    </div>
    <div class="modal fade" id="formanulfac" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformanu">
            
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js" crossorigin="anonymous"></script>
<script src="js/func.js"></script>
</body>
</html>






