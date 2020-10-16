<?php
include '../../config/conexion.php';
if ($_REQUEST['action'] == "act_btn") {
$id = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM button WHERE id = $id");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioact" action="">
            <input type="hidden" name="accion" value="activar">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <Label><strong>Realmente Desea Activar el boton de editar Datos de Usuario:</strong></Label>
            <p class="text-center text-muted">Todos los usuarios podran cambiar sus nombres de Usuario y Contraseña!!!</p>
            <h4 class="text-center">Estado Actual:</h4>
            <center><h2 style="color: blue;"><?php echo $row['estatus'];?></h2></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actbtn" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php
 }elseif ($_REQUEST['action'] == "des_btn") {

    $id = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM button WHERE id = $id");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i></h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioact" action="">
            <input type="hidden" name="accion" value="desactivar">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <Label><strong>Realmente desea Desactivar el boton de editar Datos de Usuario:</strong></Label><br>
            <h4 class="text-center">Estado Actual:</h4>
            <center><h2 style="color: blue;"><?php echo $row['estatus'];?></h2></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actbtn" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php } ?>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>