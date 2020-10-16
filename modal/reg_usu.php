<?php



if(!empty($_POST)){
    $alert='';
    //se capturan los datos enviados
    if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{

            include "config/conexion.php";

            //los datos capturados se almacenan en variables
            $nombre = $_POST['nombre'];
            $email = $_POST['correo'];
            $tel = $_POST['telefono'];
            $direc = $_POST['direccion'];
            $user = $_POST['usuario'];
            $clave = md5($_POST['clave']);
            $rol = $_POST['rol'];
             
                 /*se realiza una consulta en la cual se 
                * insertaran los datos enviados desde el formulario en la BD
                */
                $query_insert = mysqli_query($conection, "INSERT INTO usuario(nombre, correo, telefono, direccion, user, pass, rol, estatus)
                VALUES('$nombre','$email','$tel','$direc','$user','$clave','$rol')");
                mysqli_close($conection);
                    if($query_insert){
                        header('location:lista_usuarios.php');
                    }
                }    
        
}

?>
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Usuario</h4>
		  </div>
			<div class="modal-body">
            <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
					        <label class="col-sm-3 control-label"><strong>Nombre</strong></label>
					        <div class="col-sm-8">
						        <input type="text" name="nombre"  class="form-control" placeholder="Nombre" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label"><strong>Correo</strong></label>
					        <div class="col-sm-8">
						        <input type="email" name="correo"  class="form-control" placeholder="Correo" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label"><strong>Telefono</strong></label>
					        <div class="col-sm-8">
						        <input type="tel" name="telefono"  class="form-control" placeholder="Telefono" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label"><strong>Direccion</strong></label>
					        <div class="col-sm-8">
						        <input type="text" name="direccion"  class="form-control" placeholder="Direccion" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-6 control-label"><strong>Nombre de Usuario</strong></label>
					        <div class="col-sm-8">
						        <input type="text" name="usuario"  class="form-control" placeholder="Usuario" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label"><strong>Contraseña</strong></label>
					        <div class="col-sm-8">
						        <input type="password" name="clave"  class="form-control" placeholder="Contraseña" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-6 control-label" for="rol"><strong>Tipo de Usuario</strong></label>
                                <div class="col-sm-8">
                                    <br>
                                    <?php
                                        include "config/conexion.php";
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
				        </div>
                            
                            <input type="submit" value="Crear usuario" class="btn btn-primary ">
             </form>
			</div>
		</div>
	</div>
</div>
