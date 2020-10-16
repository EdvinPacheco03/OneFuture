<?php
include '../../config/conexion.php';


if ($_REQUEST['accion'] == "update_prov") {
    
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "update_book"
     * Esta funcion devolvera un formulario con la informacion del libro correpondiente
     * La funcion de este este formulario es actualizar la informacion del libro
     */

     //consulta para mostrar los datos

    $idprov = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM proveedor WHERE idproveedor = $idprov");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Proveedor</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioprov" action="" >
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $idprov; ?>">
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Nombre</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="nombre" value="<?php echo $row['nombre'];?>"  class="form-control" placeholder="Nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Correo</strong></label>
                <div class="col-sm-8">
                    <input type="email" name="contacto" value="<?php echo $row['contacto'];?>"  class="form-control" placeholder="Correo" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Telefono</strong></label>
                <div class="col-sm-8">
                    <input type="tel" name="telefono" value="<?php echo $row['telefono'];?>"  class="form-control" placeholder="Telefono" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Direccion</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="direccion" value="<?php echo $row['direccion'];?>"  class="form-control" placeholder="Direccion" required>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarprov" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php 
}elseif ($_REQUEST['accion'] == "delete_prov") {
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "update_book"
     * Esta funcion devolvera un formulario con la informacion del libro correpondiente
     * La funcion de este este formulario es actualizar la informacion del libro
     */

    $idprov = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM proveedor WHERE idproveedor = $idprov");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Eliminar Proveedor</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioprov" action="" >
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $idprov; ?>">
            <Label><strong>Realmente Desea Eliminar el Proveedor:</strong></Label>
            <center><h2><?php echo $row['nombre'];?></h2></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cancelar</button>
            <button type="button" class="btn btn-success btn_actualizarprov" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php }?>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>