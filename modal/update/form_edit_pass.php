<?php 
    include '../../config/conexion.php';
 /**
     *comentarios xd
     */

    $iduser = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT * FROM usuario WHERE id_usuario = $iduser");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Actualizar Datos de Usuario</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formulariopass" action="">
            <input type="hidden" name="accion" value="update">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
            <div class="form-group">
                <label class="col-sm-6 control-label"><strong>Nombre de Usuario</strong></label>
                <div class="">
                    <input type="text" name="user" value="<?php echo $row['user'];?>" class="form-control" placeholder="Ingrese su Nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><strong>Contraseña</strong></label>
                <div class="">
                    <input type="password" name="pass" class="form-control" required>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarpass" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>