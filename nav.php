<header>
    <div class="menu_bar">
			<a href="#" class="bt-menu"><img class="btn-warning" style="width: 50px; padding: 4px" src="img/menu.png" alt=""></a>
        </div>
        
        <nav>
		<ul>
                <li><a href="principal.php"><span class="icon-house"></span>Inicio</a></li>
                <?php if ($_SESSION['rol'] == 1 /* || $_SESSION['rol'] == 3*/){  ?>
                <li><a href="lista_usuarios.php"><span class="icon-user"></span>Usuarios</a></li>
                <?php } ?>
                <li><a href="listar_clientes.php"><span class="icon-mail"></span>Clientes</a></li>
                <li><a href="listar_proveedores.php"><span class="icon-mail"></span>Proveedores</a></li>
                <li><a href="listar_producto.php"><span class="icon-mail"></span>Producto</a></li>
                <li><a href="nueva_venta.php"><span class="icon-mail"></span>Ventas</a></li>
                <li><a href="ventas.php"><span class="icon-mail"></span>Listado de Ventas</a></li>
               <!-- <li class="principal">
					<a href="#">Facturas</a>
					<ul>
                        <li><a href="nueva_venta.php"><span class="icon-mail"></span>Nueva Factura</a></li>
                        <li><a href="ventas.php"><span class="icon-mail"></span>Listado de Ventas</a></li>
					</ul>
                </li>-->
                <li><a href="salir.php" title="Salir"><span class="icon-close"></span><img width="30px" src="img/salir.png" alt=""></a></li>
                <div class="user">
                    <?php 
                    //include 'conexion.php';
                    $query = mysqli_query($conection, "SELECT * FROM button");
                                
                    $resulta = mysqli_num_rows($query);
                    if($resulta > 0){
                    while($fila = mysqli_fetch_array($query)){

                        if($fila["estatus"] != "inactivo"){
                    ?>
                    <li style="border: none; color: #fff; padding-top: 15px">
                        <a class='btn btn-warning btn-sm btn_updapass' title="Cambiar Nombre de Usuario Y Contraseña" data-toggle='modal' data-target='#formeditpass' onclick="update_pass(<?php echo $_SESSION['iduser']; ?> )">
                            <img style="width: 30px;" src="img/settings.png" alt="">
                        </a>
                    </li>
                    <?php 
                    }   
                    } 
                    } 
                ?>
                    <li  style="border: none; color: #fff"><a title="Usuario Logueado"><?php echo $_SESSION['user'] . ' | ' . $_SESSION['rol']; ?></a></li>
                </div>
            </ul>
            
        </nav>
    </header>
    