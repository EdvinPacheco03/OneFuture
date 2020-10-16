
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="img/onefuture.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de  Usuario</title>
</head>

<?php
//creamos la sesión
session_start();
 
include("modal/reg_usu.php");
//validamos si se ha hecho o no el inicio de sesión correctamente
//si no se ha hecho la sesión nos regresará a index.php
if($_SESSION['rol'] != 1)
	{
		header("location: principal.php");
	}

if(!isset($_SESSION['user'])) 
{
  header('Location: index.php'); 
  exit();
}
include 'config/conexion.php';
 ?>
<body>
    <?php
    include 'nav.php';
    ?>
    <style>
       /* .btn_updapass{
            display: none;
        }*/

        .btn_updausu{
            margin-left: 20px;
        }
    </style>
    <div id="tbl" class="container">
		<div class="content">
			<h2>Lista de empleados</h2>
            <br />
                <div class="row">
                    <div class="col-s3">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#miModal">
                            Crear Nuevo Usuario
                        </button>
                    </div>
                    <div class="col-s3">
                        
                        <?php 
                            $query = mysqli_query($conection, "SELECT * FROM button");

                            $result = mysqli_num_rows($query);
                            if($result > 0){
                            while($fil = mysqli_fetch_array($query)){
                                if($fil["estatus"] != "activo"){
                            ?>
                                <a class='btn btn-warning btn-sm btn_updausu' title="Activar boton Modal del Navbar para editar datos de usuario" data-toggle='modal' data-target='#formact' onclick="active_button('act_btn', <?php echo $fil['id']; ?> )">
                                    activar
                                </a>
                            <?php }else{ ?>
                                <a class='btn btn-danger btn-sm btn_updausu' title="Desactivar boton Modal del Navbar para editar datos de usuario" data-toggle='modal' data-target='#formact' onclick="active_button('des_btn', <?php echo $fil['id']; ?> )">
                                    Desactivar
                                </a>
                            <?php 
                                }   
                                } 
                                } 
                                ?>
                    </div>
                </div>
			    <div class="table-responsive">
			        <table class="table table-striped table-hover">
                        <thead>
                        <tr role='row'>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                            <?php
                            //se crea una variable donde se le pasa la variable de conexion y la consulta
                                $sql = mysqli_query($conection,"SELECT u.id_usuario, u.nombre, u.correo, u.telefono, u.direccion, u.user, u.estatus, r.rol 
                                                                FROM usuario u 
                                                                INNER JOIN rol r on u.rol = r.id_rol 
                                                                WHERE estatus = 1
                                                                ORDER BY u.id_usuario ASC");
                                    mysqli_close($conection);
                                
                                    $result = mysqli_num_rows($sql);
                                    if($result > 0){
                                    while($row = mysqli_fetch_array($sql)){
                            ?>
                            <tbody>
                                <tr role='row'>
                                    <td data-th='ID'><?php echo $row["id_usuario"]; ?></td>
                                    <td data-th='Nombre'><?php echo $row["nombre"]; ?></td>
                                    <td data-th='Correo'><?php echo $row["correo"]; ?></td>
                                    <td data-th='Telefono'><?php echo $row["telefono"]; ?></td>
                                    <td data-th='Direccion'><?php echo $row["direccion"]; ?></td>
                                    <td data-th='Usuario'><?php echo $row["user"]; ?></td>
                                    <td data-th='Acciones'>
                                        <a class='btn btn-warning btn-sm btn_updausu' data-toggle='modal' data-target='#formeditusu' onclick="load_formulario_usu('update_usu', <?php echo $row['id_usuario']; ?> )">
                                        Editar
                                        </a>
                                        <?php 
                                            if($row["rol"] != "Administrador"){
                                        ?>
                                        
                                        |
                                        <a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#formeditusu' onclick='load_formulario_usu("delete_usu", <?php echo $row["id_usuario"]; ?> )'>
                                            Eliminar
                                        </a>
                                        <?php }?>
                                    </td>
                                </tr>
                            </tbody>
						    <?php
                            }
                            }
				            ?>
			        </table>
			    </div>
	    </div>
    </div>
    <div class="modal fade" id="formeditusu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformusu">
            
        </div>
    </div>
    <div class="modal fade" id="formeditpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalformpass">
            
        </div>
    </div>
    <div class="modal fade" id="formact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="modalact">
            
        </div>
    </div>
    <!--<a class="boto btn btn-warning" onclick='holi(<?php echo $_SESSION["nombre"]; ?> )'>
        Prueba
    </a>-->
    <!--<script>
        function holi(){
            //console.log(nombre);
            //var name = nombre.val();
            //alert("Yo soy "+name);
            alert("gsfsg")
        }
    </script>-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js" ></script>
<script src="js/func.js"></script>
</body>
</html>



