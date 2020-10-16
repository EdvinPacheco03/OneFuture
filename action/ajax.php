<?php
session_start();
include '../config/conexion.php';

    if(!empty($_POST)){

        //Buscar Producto - Venta
        if($_POST['action'] == 'infoProducto'){

                $producto_id = $_POST['producto'];

                $query = mysqli_query($conection,"SELECT idproducto, descripcion, existencia, precio
                                                  FROM producto WHERE idproducto LIKE
                                                   '$producto_id' and estatus = 1");

                mysqli_close($conection);

                $result = mysqli_num_rows($query);
                if($result > 0){
                    $data = mysqli_fetch_assoc($query);
                    echo json_encode($data,JSON_UNESCAPED_UNICODE);
                    exit;
                }
                
                echo 'error';
                exit;
             
        }

        //Buscar Cliente
        if($_POST['action'] == 'searchCliente'){
            if(!empty($_POST['cliente'])){

                $nit = $_POST['cliente'];
                $query = mysqli_query($conection,"SELECT * FROM cliente WHERE nit LIKE '$nit' and estado = 1"
                );
                mysqli_close($conection);
                $result = mysqli_num_rows($query);

                $data = '';
                if($result > 0){
                    $data = mysqli_fetch_assoc($query);
                }else{
                    $data = 0;
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            exit; 

        }

        //Registrar Cliente-Ventas 
        if($_POST['action'] == 'addCliente'){
           $nit         = $_POST['nit_cliente'];
           $nombre      = $_POST['nom_cliente'];
           $telefono    = $_POST['tel_cliente'];
           $direccion   = $_POST['dir_cliente'];
           $usuario_id  = $_SESSION['iduser'];

           $query_insert = mysqli_query($conection, "INSERT INTO cliente(nit, nombre, telefono, direccion, idusuario, estado)
                                                    VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id', 1)");
                                                    
            if($query_insert){
                $codCliente = mysqli_insert_id($conection);
                $smg = $codCliente;
            }else{
                $smg = 'error';
            }
            mysqli_close($conection);
            echo $smg;
            exit;

        }

        //Agregar Producto al detalle Temporal
        if($_POST['action'] == 'addProductoDetalle'){
           if(empty($_POST['producto']) || empty($_POST['cantidad'])){
               echo 'error';
           }else{
               $codproducto   = $_POST['producto'];
               $cantidad      = $_POST['cantidad'];
               $token         = md5($_SESSION['iduser']);

               $query_iva = mysqli_query($conection,"SELECT iva FROM configuracion");
               $result_iva = mysqli_num_rows($query_iva);

               $query_detalle_temp   = mysqli_query($conection, "CALL add_detalle_temp($codproducto, $cantidad, '$token')");
               $result  = mysqli_num_rows($query_detalle_temp);

               $detalleTabla = '';
               $sub_total  = 0;
               $iva        = 0;
               $total      = 0;
               $arrayData  = array();

               if($result > 0){
                   if($result_iva > 0){
                       $info_iva = mysqli_fetch_assoc($query_iva);
                       $iva = $info_iva['iva'];
                   }
                   
                   while ($data = mysqli_fetch_assoc($query_detalle_temp)){
                       $precioTotal = round($data['cantidad'] * $data['precioventa'], 2);
                       $sub_total   = round($sub_total + $precioTotal, 2);
                       $total       = round($total + $precioTotal, 2);

                       $detalleTabla .= '<tr data="row">
                                            <td data-th="Codigo">'.$data['idproducto'].'</td>
                                            <td colspan="2" data-th="Descripcion">'.$data['descripcion'].'</td>
                                            <td data-th="Cantidad">'.$data['cantidad'].'</td>
                                            <td data-th="Precio Venta">'.$data['precioventa'].'</td>
                                            <td data-th="Precio Total">'.$precioTotal.'</td>
                                            <td class="" data-th="Eliminar">
                                                <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                                del_pruduct_detalle('.$data['correlativo'].')"></a>
                                            </td>
                                        </tr>';
                   }

                   $impuesto    = round($sub_total * ($iva / 100), 2);
                   $tl_sniva    = round($sub_total - $impuesto, 2);
                   $total       = round($tl_sniva + $impuesto, 2);

                   $detalleTotales = '<tr>
                                        <td colspan="5">Subtotal Q.</td>
                                        <td>'. $tl_sniva.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">IVA ('.$iva.'%)</td>
                                        <td>'. $impuesto.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Total Q.</td>
                                        <td>'. $total.'</td>
                                    </tr>';

                  $arrayData['detalle'] = $detalleTabla;
                  $arrayData['totales'] = $detalleTotales;
                  
                  echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

               }else{
                   echo 'error';
               }
               mysqli_close($conection);
           }
           exit;
        }

        //Extrae Datos del detalle_temp
         if($_POST['action'] == 'searchForDetalle'){
            if(empty($_POST['user'])){
                echo 'error';
            }else{
                
                $token   = md5($_SESSION['iduser']);

                $query = mysqli_query($conection,"SELECT tmp.correlativo,
                                                         tmp.tokenuser,
                                                         tmp.cantidad,
                                                         tmp.precioventa,
                                                         p.idproducto,
                                                         p.descripcion
                                                         FROM detalletemp tmp
                                                         INNER JOIN producto p
                                                         ON tmp.idproducto = p.idproducto
                                                         WHERE tokenuser = '$token'");

                $result  = mysqli_num_rows($query);

 
                $query_iva = mysqli_query($conection,"SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);
 
                
 
                $detalleTabla = '';
                $sub_total  = 0;
                $iva        = 0;
                $total      = 0;
                $arrayData  = array();
 
                if($result > 0){
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                    }
                    
                    while ($data = mysqli_fetch_assoc($query)){
                        $precioTotal = round($data['cantidad'] * $data['precioventa'], 2);
                        $sub_total   = round($sub_total + $precioTotal, 2);
                        $total       = round($total + $precioTotal, 2);
 
                        $detalleTabla .= '<tr>
                                             <td data-th="Codigo">'.$data['idproducto'].'</td>
                                             <td colspan="2" data-th="Descripcion">'.$data['descripcion'].'</td>
                                             <td data-th="Cantidad">'.$data['cantidad'].'</td>
                                             <td data-th="Precio Venta">'.$data['precioventa'].'</td>
                                             <td data-th="Precio Total">'.$precioTotal.'</td>
                                             <td class="" data-th="Eliminar">
                                                 <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                                 del_pruduct_detalle('.$data['correlativo'].')"></a>
                                             </td>
                                         </tr>';
                    }
 
                    $impuesto    = round($sub_total * ($iva / 100), 2);
                    $tl_sniva    = round($sub_total - $impuesto, 2);
                    $total       = round($tl_sniva + $impuesto, 2);
 
                    $detalleTotales = '<tr>
                                         <td colspan="5">Subtotal Q.</td>
                                         <td>'. $tl_sniva.'</td>
                                     </tr>
                                     <tr>
                                         <td colspan="5">IVA ('.$iva.'%)</td>
                                         <td>'. $impuesto.'</td>
                                     </tr>
                                     <tr>
                                         <td colspan="5">Total Q.</td>
                                         <td>'. $total.'</td>
                                     </tr>';
 
                   $arrayData['detalle'] = $detalleTabla;
                   $arrayData['totales'] = $detalleTotales;
                   
                   echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
 
                }else{
                    echo 'error';
                }
                mysqli_close($conection);
            }
            exit;
         }

        //Accion de Eliminar registros del detalle de la factura
         if($_POST['action'] == 'delProductoDetalle'){
            if(empty($_POST['id_detalle']) ){
                echo 'error';
            }else{

                $id_detalle    = $_POST['id_detalle'];
                $token         = md5($_SESSION['iduser']);

                

 
                $query_iva = mysqli_query($conection,"SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);
 
                $query_detalle_temp = mysqli_query($conection,"CALL del_detalle_temp($id_detalle, '$token')");
                $result = mysqli_num_rows($query_detalle_temp);
 
                $detalleTabla = '';
                $sub_total  = 0;
                $iva        = 0;
                $total      = 0;
                $arrayData  = array();
 
                if($result > 0){
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                    }
                    
                    while ($data = mysqli_fetch_assoc($query_detalle_temp)){
                        $precioTotal = round($data['cantidad'] * $data['precioventa'], 2);
                        $sub_total   = round($sub_total + $precioTotal, 2);
                        $total       = round($total + $precioTotal, 2);
 
                        $detalleTabla .= '<tr role="row">
                                             <td data-th="ID">'.$data['idproducto'].'</td>
                                             <td data-th="Descripcion" colspan="2">'.$data['descripcion'].'</td>
                                             <td data-th="Cantidad">'.$data['cantidad'].'</td>
                                             <td data-th="Precio Venta">'.$data['precioventa'].'</td>
                                             <td data-th="Precio Total">'.$precioTotal.'</td>
                                             <td class="">
                                                 <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                                 del_pruduct_detalle('.$data['correlativo'].')"></a>
                                             </td>
                                         </tr>';
                    }
 
                    $impuesto    = round($sub_total * ($iva / 100), 2);
                    $tl_sniva    = round($sub_total - $impuesto, 2);
                    $total       = round($tl_sniva + $impuesto, 2);
 
                    $detalleTotales = '<tr>
                                         <td colspan="5">Subtotal Q.</td>
                                         <td data-th="Subtotal">'. $tl_sniva.'</td>
                                     </tr>
                                     <tr>
                                         <td colspan="5">IVA ('.$iva.'%)</td>
                                         <td data-th="Impuesto">'. $impuesto.'</td>
                                     </tr>
                                     <tr>
                                         <td colspan="5">Total Q.</td>
                                         <td data-th="Total">'. $total.'</td>
                                     </tr>';
 
                   $arrayData['detalle'] = $detalleTabla;
                   $arrayData['totales'] = $detalleTotales;
                   
                   echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
 
                }else{
                    echo 'error';
                }
                mysqli_close($conection);
            }
            exit;
         }

         //Anular Venta
         if($_POST['action'] == 'anularVenta'){
            
            $token     = md5($_SESSION['iduser']);
            $query_del = mysqli_query($conection,"DELETE FROM detalletemp where tokenuser = '$token'");
            mysqli_close($conection);
            if($query_del){
                echo 'Lo Logro señor v:';
            }else{
                echo 'error';
            }
            exit;
         }

          //Procesar Venta
          if($_POST['action'] == 'procesarVenta'){
              if(empty($_POST['codcliente'])){
                  $codcliente = 1;
              }else{
                  $codcliente = $_POST['codcliente'];
              }

              $token = md5($_SESSION['iduser']);
              $usuario = $_SESSION['iduser'];

              $query = mysqli_query($conection,"SELECT * FROM detalletemp WHERE tokenuser = '$token' ");
              $result = mysqli_num_rows($query);

              if($result > 0){
                  $query_procesar = mysqli_query($conection,"CALL procesar_venta($usuario, $codcliente, '$token')");
                  $result_detalle = mysqli_num_rows($query_procesar);

                  if($result_detalle > 0){
                      $data = mysqli_fetch_assoc($query_procesar);
                      echo json_encode($data,JSON_UNESCAPED_UNICODE);
                  }else{
                      echo "error";
                  }
              }else{
                  echo "error"; 
              }
              mysqli_close($conection);
              exit;
          }
       
    }  

    exit;

    
?>
