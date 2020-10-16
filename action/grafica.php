<?php
include '../config/conexion.php';

if(!empty($_POST)){

//Graficar ventas
        if($_POST['action'] == 'searchGraphic'){
            if(!empty($_POST['fecha_de']) && !empty($_POST['fecha_a'])){
                //echo print_r($_POST);
                $fecha_de = $_POST['fecha_de'];
                $fecha_a = $_POST['fecha_a'];

                $query =mysqli_query($conection, "SELECT COUNT(nofactura) AS ventas, DATE_FORMAT(fecha, '%y-%m-%d')
                                                    AS fecha1 FROM factura WHERE fecha BETWEEN '$fecha_de' AND '$fecha_a' AND estatus = 1
                                                    GROUP BY DATE_FORMAT(fecha, '%y-%m-%d')");
    
                $result = mysqli_num_rows($query);
    
                if($result > 0){
                        $data = array();
                        foreach($query as $row){
                            $data[] = $row;
                        }
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                }else{
                    echo 'error';
                }
                mysqli_close($conection);

                exit;
    
            }
        }
    }

        /*mysqli_close($conection);

        $result = mysqli_num_rows($query);
        if($result > 0){
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            exit;
        }
        
        echo 'error';
        exit;*/
?>