<?php
    
    include '../../config/conexion.php';

    if(!empty($_POST)){

        $idcon = $_REQUEST['id'];


        $nombre = mysqli_real_escape_string($conection, $_POST['nombre']);
        $nit = mysqli_real_escape_string($conection, $_POST['nit']);
        $telefono = mysqli_real_escape_string($conection, $_POST['telefono']);
        $correo = mysqli_real_escape_string($conection, $_POST['correo']);
        $direccion = mysqli_real_escape_string($conection, $_POST['direccion']);
        $iva = mysqli_real_escape_string($conection, $_POST['iva']);


            $resultt = mysqli_query($conection,"UPDATE configuracion SET nit = '$nit', nombre = '$nombre',
                                                        telefono = '$telefono', email = '$correo', direccion = '$direccion', iva = '$iva'
                                                        WHERE id = $idcon");
            
            mysqli_close($conection);
            
            if($resultt){
                echo "actualizado";
            }else{
                echo "erroractualizar";
            }
    }
    

?>