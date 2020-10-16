<?php

    include '../../config/conexion.php';
    
    /**
     * @Anular Factura
     * Se ejecutara al darle click al boton de Anular en listado de facturas 
     * y desabilirara la factura dejandola anulada y devolviendo los productos al stock
     */
    if(!empty($_POST['id'])){
        $nofactura = $_REQUEST['id'];
        $resultt = mysqli_query($conection,"CALL anular_factura($nofactura)");
        
        mysqli_close($conection);
        
        if($resultt){
            echo "actualizado";
        }else{
            echo "erroractualizar";
        }
    }
    

?>