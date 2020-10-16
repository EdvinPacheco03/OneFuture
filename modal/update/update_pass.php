<?php

    include '../../config/conexion.php';
    
    $user = mysqli_real_escape_string($conection, $_POST['user']);
    $pass = mysqli_real_escape_string($conection, $_POST['pass']);
    
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idusu = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE usuario SET user = '$user',
                                                pass = MD5('$pass')
                                                WHERE id_usuario = $idusu");
    
    mysqli_close($conection);
    
    if($resultt){
        echo "actualizado";
    }else{
        echo "erroractualizar";
    }
    

?>