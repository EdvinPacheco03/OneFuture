<?php
include '../../config/conexion.php';


if ($_REQUEST['accion'] == "update_usu") {
    
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "update_book"
     * Esta funcion devolvera un formulario con la informacion del libro correpondiente
     * La funcion de este este formulario es actualizar la informacion del libro
     */

     //consulta para mostrar los datos

    $iduser = $_REQUEST['id'];
    $query =  mysqli_query($conection,"SELECT usuario.id_usuario, usuario.nombre, usuario.correo, usuario.telefono, usuario.direccion, usuario.user, 
                                        usuario.rol, rol.rol FROM usuario INNER JOIN rol 
                                        on usuario.rol = rol.id_rol WHERE id_usuario= $iduser");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Usuario</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formulariousu" action="">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
                <div class="form-group">
                    <label class="col-sm-6 control-label"><strong>Nombre</strong></label>
                    <div class="">
                        <input type="text" name="nombre" value="<?php echo $row['nombre'];?>" class="form-control" placeholder="Ingrese su Nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><strong>Correo</strong></label>
                    <div class="">
                        <input type="email" name="correo" value="<?php echo $row['correo'];?>" class="form-control" placeholder="ejemplo@gmail.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><strong>Telefono</strong></label>
                    <div class="">
                        <input type="num" name="telefono" value="<?php echo $row['telefono'];?>" class="form-control" placeholder="Ingrese su Telefono" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><strong>Direccion</strong></label>
                    <div class="">
                        <input type="text" name="direccion" value="<?php echo $row['direccion'];?>" class="form-control" placeholder="Ingrese su Direccion" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label"><strong>Nombre de Usuario</strong></label>
                    <div class="">
                        <input type="text" name="user" value="<?php echo $row['user'];?>" class="form-control" placeholder="Nombre de usuario" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><strong>Contraseña</strong></label>
                    <div class="">
                        <input type="password" name="pass"  class="form-control" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label" for="rol"><strong>Tipo de Usuario</strong></label>
                        <?php
                            include "../../config/conexion.php";
                            $query_rol = mysqli_query($conection,"SELECT * FROM rol");
                            mysqli_close($conection);
                            $result_rol = mysqli_num_rows($query_rol);
                        ?>

                        <select class="form-control" name="rol" id="rol">
                            <?php
                                echo $option;
                                if($result_rol > 0){
                                    while($rol = mysqli_fetch_array($query_rol)){
                            ?>
                                <option value="<?php echo $rol["id_rol"]; ?>"><?php echo $rol["rol"] ?></option>
                            <?php
                                }
                                }
                            ?>
                        </select>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <input type="submit" value="Actualizar usuario" class="btn btn-primary btn_actualizarusu">
        </form>
    </div>
 </div>
<?php 
}elseif ($_REQUEST['accion'] == "delete_usu") {
    /**
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "delete_cl"
     * Esta funcion devolvera un formulario con la informacion del cliente correpondiente
     * La funcion de este este formulario es actualizar la informacion del cliente
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
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Eliminar Usuario</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formulariousu" action="">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
            <Label><strong>Realmente Desea Eliminar el Usuario:</strong></Label>
            <center><h2><?php echo $row['nombre'];?></h2></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_actualizarusu" data-dismiss="modal" data-accion="crear">Guardar</button>
        </form>
    </div>
</div>
<?php }?>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>