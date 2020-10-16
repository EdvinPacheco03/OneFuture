<?php
include '../config/conexion.php';

if(!empty($_POST)){

        $idinfo = $_REQUEST['id'];
        
        $query = mysqli_query($conection, "SELECT * FROM configuracion WHERE id = $idinfo");
        
        $result =  mysqli_num_rows($query);

        if ($result > 0) {
            $row = mysqli_fetch_array($query);
        }
    }


    ?>
        <form class="infoedit" action="">
            <input type="hidden" name="id" value="<?php echo $idinfo; ?>">
            <div class="form-group">
                <label for="">Nombre</label>
                <input name="nombre" value="<?php echo $row['nombre'];?>" type="text" class="form-control" id="nombre">
            </div>
            <div class="form-group">
                <label for="">NIT</label>
                <input name="nit" value="<?php echo $row['nit'];?>" type="text" class="form-control" id="nit" >
            </div>
            <div class="form-group">
                <label for="">Telefono</label>
                <input name="telefono" value="<?php echo $row['telefono'];?>" type="tel" class="form-control" id="telefono">
            </div>
            <div class="form-group">
                <label for="">Correo</label>
                <input name="correo" value="<?php echo $row['email'];?>" type="email" class="form-control" id="correo" >
            </div>
            <div class="form-group">
                <label for="">Direccion</label>
                <input name="direccion" value="<?php echo $row['direccion'];?>" type="text" class="form-control" id="direccion">
            </div>
            <div class="form-group">
                <label for="">IVA</label>
                <input name="iva" value="<?php echo $row['iva'];?>" type="text" class="form-control" id="iva" >
            </div>
            <button id="ocultar" type="submit" class="btn btn-warning btn-sm">Cancelar</button>
            <button id="ocultar" type="submit" class="btn btn-primary btn-sm btn_editinfo">Guardar</button>
        </form>
    <script src="js/jquery.min.js"></script>
    <script src="js/principal.js"></script>
