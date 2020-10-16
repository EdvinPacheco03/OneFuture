<?php

    include '../../config/conexion.php';
    
    $nombre = mysqli_real_escape_string($conection, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conection, $_POST['correo']);
    $tel = mysqli_real_escape_string($conection, $_POST['telefono']);
    $direc = mysqli_real_escape_string($conection, $_POST['direccion']);
    $user = mysqli_real_escape_string($conection, $_POST['user']);
    $pass = mysqli_real_escape_string($conection, $_POST['pass']);
    $rol = mysqli_real_escape_string($conection, $_POST['rol']);
    
if($_REQUEST['accion'] == "actualizar"){
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idusu = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre', correo = '$correo',
                                                telefono = '$tel', direccion = '$direc', user = '$user',
                                                pass = MD5('$pass'), rol = '$rol'
                                                WHERE id_usuario = $idusu");
    
    mysqli_close($conection);
    
    if($resultt){
        echo "actualizado";
    }else{
        echo "erroractualizar";
    }
    
 }elseif($_REQUEST['accion'] == "eliminar"){
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idusu = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE usuario SET estatus = 0 WHERE id_usuario = $idusu");
    
    mysqli_close($conection);
    
    if($resultt){
        echo "actualizado";
    }else{
        echo "erroractualizar";
    }
}else{
     /**
     * Parametro accion @Desconocido
     * Se ejecutara siempre y cuando el valor del parametro "accion" no sea => "nuevo" o "actualizar"
     * Unicamente devolvera un mensaje
     */
    echo "error_desconocido";
}
?>