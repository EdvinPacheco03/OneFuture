<?php
include '../../config/conexion.php';


if ($_REQUEST['accion'] == "update_prod") {
    
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "update_book"
     * Esta funcion devolvera un formulario con la informacion del libro correpondiente
     * La funcion de este este formulario es actualizar la informacion del libro
     */

     //consulta para mostrar los datos

    $idprod = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT p.descripcion, pv.idproveedor, p.precio, p.existencia, pv.nombre
                                            FROM producto p
                                            INNER JOIN proveedor pv
                                            ON p.idproveedor = pv.idproveedor
                                        WHERE idproducto = $idprod");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Eliminar Producto</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioprod" action="" >
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $idprod; ?>">
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Nombre</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="nombre" value="<?php echo $row['descripcion'];?>"  class="form-control" placeholder="Nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Proveedor</strong></label>
                <div class="col-sm-8">
                    <select  class="form-control" name="proveedor">
                        <?php
                        $sql2 = mysqli_query($conection, "SELECT * FROM proveedor");
                        while ($fila2 = mysqli_fetch_array($sql2)) { ?>
                            <option value="<?php echo $fila2['idproveedor']; ?>"><?php echo $fila2['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Precio</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="precio" value="<?php echo $row['precio'];?>"  class="form-control" placeholder="Telefono" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Existencia</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="existencia" value="<?php echo $row['existencia'];?>"  class="form-control" placeholder="Direccion" required>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarprod" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
 </div>
<?php 
}elseif ($_REQUEST['accion'] == "delete_prod") {
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "delete_cl"
     * Esta funcion devolvera un formulario con la informacion del cliente correpondiente
     * La funcion de este este formulario es actualizar la informacion del cliente
     */

    $idprod = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM producto WHERE idproducto = $idprod");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Eliminar Producto</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioprod" action="">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $idprod; ?>">
            <Label><strong>Realmente Desea Eliminar el Producto:</strong></Label>
            <center><h2><?php echo $row['descripcion'];?></h2></center>
            <button type="button" class="close btn-warning" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarprod" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php }?>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>
