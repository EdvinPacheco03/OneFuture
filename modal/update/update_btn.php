<?php

    include '../../config/conexion.php';
    /**
     * @Actualizar Lector
     * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
     * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
     */
    if($_REQUEST['accion'] == "activar"){
        /**
         * @Actualizar Lector
         * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
         * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
         */
        $id = $_REQUEST['id'];
        $resultt = mysqli_query($conection,"UPDATE button SET estatus = 'activo'
                                                    WHERE id = $id");
        
        mysqli_close($conection);
        
        if($resultt){
            echo "actualizado";
        }else{
            echo "erroractualizar";
        }
    }elseif($_REQUEST['accion'] == "desactivar"){
        /**
         * @Actualizar Lector
         * Se ejecutara siempre y cuando el valor del parametro "accion" sea => "actualizar"
         * Esta funcion ejecutara una sentencia SQL update con los valores POST obtenidos
         */
        $id = $_REQUEST['id'];
        $resultt = mysqli_query($conection,"UPDATE button SET estatus = 'inactivo'
                                                    WHERE id = $id");
        
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
    