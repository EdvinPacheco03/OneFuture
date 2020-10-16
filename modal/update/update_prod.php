<?php

    include '../../config/conexion.php';
    

    $descr = mysqli_real_escape_string($conection, $_POST['nombre']);
    $proveedor = mysqli_real_escape_string($conection, $_POST['proveedor']);
    $precio = mysqli_real_escape_string($conection, $_POST['precio']);
    $existencia = mysqli_real_escape_string($conection, $_POST['existencia']);
    
if($_REQUEST['accion'] == "actualizar"){
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    $idprod = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE producto SET descripcion = '$descr', idproveedor = '$proveedor',
                                                precio = '$precio', existencia = '$existencia'
                                                WHERE idproducto = $idprod");
    
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
    $idprod = $_REQUEST['id'];
    $resultt = mysqli_query($conection,"UPDATE producto SET estatus = 0 WHERE idproducto = $idprod");
    
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