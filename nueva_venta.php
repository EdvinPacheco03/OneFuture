<?php

//creamos la sesión
session_start();

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
    <link rel="icon" href="img/onefuture.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Nueva Venta</title>
</head>
<body>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/func.js"></script>
    <script src="js/bootstrap.js"></script>
    <?php
        include 'config/conexion.php';
        include 'nav.php';
    ?>
    <section id="container">
        <div class="title_page">
            <h1> Nueva Venta</h1>
        </div>
        
        <div class="datos_cliente ">
            <div class="action_tit">
                <h4>Datos del Cliente</h4>
                <a href="#" class="btn_new_cliente">Nuevo Cliente</a>
            </div>
            <form id="form_new_cliente_venta" name="form_new_cliente_venta" action="" class="form-horizontal cl">
                <input type="hidden" name="action" value="addCliente">
                <input type="hidden" id="idcliente" name="idcliente" value="" requiered>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="" class="control-label">Nit</label>
                        <input class="input-sm" type="text" name="nit_cliente" id="nit_cliente">
                    </div>
                    <div class="col-md-3">
                        <label for="" >Nombre</label>
                        <input  type="text" name="nom_cliente" id="nom_cliente" disabled required>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="control-label">Telefono</label>
                        <input class="input-sm" type="number" name="tel_cliente" id="tel_cliente" disabled required>  
                    </div>
                </div>
                <div class=" form-group  wd100">
                        <label for="">Direccion</label>
                        <input class="wd100" type="text" name="dir_cliente" id="dir_cliente" disabled required>
                </div>
                <div id="div_registro_cliente" class="col-md-3 wd100">
                    <button type="submit" class="btn_save"> Guardar</button>
                </div>
            </form>
        </div>
        <div class="datos_venta">
            <h4 width: 100px >Datos de La Venta</h4>
            <div class=" datos">
                <div class="wd50">
                    <label class=""><strong>VENDEDOR</strong></label>
                    <p><?php echo $_SESSION['nombre']; ?></p>
                </div>
                <div class="wd50">
                    <label for="#">ACCIONES</label>
                    <div class="men" id="acciones_venta">
                        <a href="" class="btn_anular" id="btn_anular_venta" >Anular</a>
                        <a href="" id="btn_facturar_venta" style="display: none;">Procesar</a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover tbl_venta">
            <thead role="rowgroup">
                <tr>
                    <th width="100px">Codigo</th>
                    <th>Descripcion</th>
                    <th>Existencias</th>
                    <th width="100px">Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th>acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr role="row">
                    <td data-th="Codigo" ><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                    <td id="txt_descripcion" data-th="Descripcion">..</td>
                    <td id="txt_existencia" data-th="Existencia">..</td>
                    <td data-th="Cantidad"><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled> </td>
                    <td id="txt_precio" data-th="Precio U."> 0.00</td>
                    <td id="txt_precio_total" data-th="Precio T."> 0.00</td>
                    <td data-th="Agregar"><a href="#" id="add_product_venta">Agregar</a> </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-hover tbl_venta">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th colspan="2">Descripcion</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="detalle_venta" role="rowgroup">
                <!--CONTENDIDO CARGADO MEDIANTE AJAX -->
            </tbody>  
            <tfoot id="detalle_totales" role="rowgroup">
                <!--CONTENIDO CARGADO MEDIANTE AJAX -->
            </tfoot> 
        </table>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            var usuarioid = '<?php echo $_SESSION['iduser']; ?>';
            searchForDetalle(usuarioid);
 
        });
    </script>
    <div class="modal fade" id="formeditpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformpass">
            
        </div>
    </div>
</body>
</html>
