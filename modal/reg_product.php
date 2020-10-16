<?php



if(!empty($_POST)){
    $alert='';
    //se capturan los datos enviados
    if(empty($_POST['nombre']) || empty($_POST['proveedor']) || empty($_POST['precio']) || empty($_POST['existencia']))
        {
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
        }else{

            include "config/conexion.php";

            //los datos capturados se almacenan en variables
            $descripcion = $_POST['nombre'];
            $proveedor = $_POST['proveedor'];
            $precio = $_POST['precio'];
            $existencia = $_POST['existencia'];
            $usuario_id  = $_SESSION['iduser'];
             
                 /*se realiza una consulta en la cual se 
                * insertaran los datos enviados desde el formulario en la BD
                */
                $query_insert = mysqli_query($conection, "INSERT INTO producto(descripcion, idproveedor, precio, existencia, idusuario)
                VALUES('$descripcion','$proveedor','$precio','$existencia','$usuario_id')");
                mysqli_close($conection);
                    if($query_insert){
                        header('location:listar_producto.php');
                    }
                }    
        
}

?>
<div class="modal fade" id="miModallP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						        <input type="text" name="nombre"  class="form-control" required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Proveedor</label>
					        <div class="col-sm-8">
                                    <br>
                                    <?php
                                        include "config/conexion.php";

                                        $query_prov = mysqli_query($conection,"SELECT * FROM proveedor");
                                        mysqli_close($conection);
                                        $result_prov = mysqli_num_rows($query_prov);
                                    ?>

                                    <select class="form-control" name="proveedor" id="proveedor">
                                    <?php
                                            echo $option;
                                            if($result_prov > 0){
                                                while($prov = mysqli_fetch_array($query_prov)){
                                        ?>
                                            <option value="<?php echo $prov["idproveedor"]; ?>"><?php echo $prov["nombre"] ?></option>
                                        <?php
                                                }
                                            }
                                    ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Precio</label>
					        <div class="col-sm-8">
						        <input type="tel" name="precio"  class="form-control"  required>
					        </div>
                        </div>
                        <div class="form-group">
					        <label class="col-sm-3 control-label">Existencia</label>
					        <div class="col-sm-8">
						        <input type="text" name="existencia"  class="form-control" required>
					        </div>
                        </div>
                            
                            <input type="submit" value="Crear Producto" class="btn btn-primary ">
             </form>
			</div>
		</div>
	</div>
</div>
