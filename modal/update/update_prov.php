<?php

    include '../../config/conexion.php';
    
    print_r($_POST);

    $nombre = mysqli_real_escape_string($conection, $_POST['nombre']);
    $email = mysqli_real_escape_string($conection, $_POST['contacto']);
    $tel = mysqli_real_escape_string($conection, $_POST['telefono']);
    $direc = mysqli_real_escape_string($conection, $_POST['direccion']);
    
if($_REQUEST['accion'] == "actualizar"){
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idprov = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE proveedor SET nombre = '$nombre', contacto = '$email',
                                                telefono = '$tel', direccion = '$direc'
                                                WHERE idproveedor = $idprov");
    
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
    $idprov = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE proveedor SET estatus = 0 WHERE idproveedor = $idprov");
    
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