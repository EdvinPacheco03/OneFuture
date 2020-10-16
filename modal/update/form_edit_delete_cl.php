<?php
include '../../config/conexion.php';


if ($_REQUEST['accion'] == "update_cl") {
    
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "update_book"
     * Esta funcion devolvera un formulario con la informacion del libro correpondiente
     * La funcion de este este formulario es actualizar la informacion del libro
     */

     //consulta para mostrar los datos

    $idcl = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente = $idcl");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Cliente</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formulariocl" action="" >
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $idcl; ?>">
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Nombre</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="nombre" value="<?php echo $row['nombre'];?>"  class="form-control" placeholder="Nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Nit</strong></label>
                <div class="col-sm-8">
                    <input type="email" name="nit" value="<?php echo $row['nit'];?>"  class="form-control" placeholder="Correo" required>
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
            <button type="button" class="btn btn-success btn_actualizarcl" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php 
}elseif ($_REQUEST['accion'] == "delete_cl") {
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "delete_cl"
     * Esta funcion devolvera un formulario con la informacion del cliente correpondiente
     * La funcion de este este formulario es actualizar la informacion del cliente
     */

    $idcl = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente = $idcl");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Eliminar Cliente</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formulariocl" action="" >
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $idcl; ?>">
            <Label><strong>Realmente Desea Eliminar el Cliente:</strong></Label>
            <center><h2><?php echo $row['nombre'];?></h2></center>
            <button type="button" class="close btn-warning" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarcl" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php }?>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>
