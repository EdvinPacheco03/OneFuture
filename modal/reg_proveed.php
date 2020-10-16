<?php


if(!empty($_POST)){
    $alert='';
    //se capturan los datos enviados
    if(empty($_POST['nombre']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{

            include "config/conexion.php";

            //los datos capturados se almacenan en variables
            $nombre = $_POST['nombre'];
            $email = $_POST['contacto'];
            $tel = $_POST['telefono'];
            $direc = $_POST['direccion'];
            $usuario_id  = $_SESSION['iduser'];
             
                 /*se realiza una consulta en la cual se 
                * insertaran los datos enviados desde el formulario en la BD
                */
                $query_insert = mysqli_query($conection, "INSERT INTO proveedor(nombre, contacto, telefono, direccion, idusuario)
                VALUES('$nombre','$email','$tel','$direc','$usuario_id')");
                mysqli_close($conection);
                    if($query_insert){
                        header('location:listar_proveedores.php');
                    }
                }    
        
}

?>
<div class="modal fade" id="miModalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Proveedor</h4>
		  </div>
			<div class="modal-body">
            <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Nombre</label>
					        <div class="col-sm-8">
						        <input type="text" name="nombre"  class="form-control" placeholder="Nombre" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Correo</label>
					        <div class="col-sm-8">
						        <input type="email" name="contacto"  class="form-control" placeholder="Correo" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Telefono</label>
					        <div class="col-sm-8">
						        <input type="tel" name="telefono"  class="form-control" placeholder="Telefono" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Direccion</label>
					        <div class="col-sm-8">
						        <input type="text" name="direccion"  class="form-control" placeholder="Direccion" required>
					        </div>
                        </div>
                            
                            <input type="submit" value="Crear Proveedor" class="btn btn-primary ">
             </form>
			</div>
		</div>
	</div>
</div>
