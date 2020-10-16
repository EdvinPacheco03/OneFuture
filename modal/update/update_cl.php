<?php

    include '../../config/conexion.php';
    

    $nombre = mysqli_real_escape_string($conection, $_POST['nombre']);
    $nit = mysqli_real_escape_string($conection, $_POST['nit']);
    $tel = mysqli_real_escape_string($conection, $_POST['telefono']);
    $direc = mysqli_real_escape_string($conection, $_POST['direccion']);
    
if($_REQUEST['accion'] == "actualizar"){
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idcl = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE cliente SET nombre = '$nombre', nit = '$nit',
                                                telefono = '$tel', direccion = '$direc'
                                                WHERE idcliente = $idcl");
    
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
    $idcl = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE cliente SET estado = 0 WHERE idcliente = $idcl");
    
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