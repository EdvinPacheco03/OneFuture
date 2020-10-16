<?php 

include '../config/conexion.php';
session_start();

//Busqueda para los proveedores

$salida = "";
$query = mysqli_query($conection,"SELECT p.idproducto, p.descripcion, pv.idproveedor, p.precio, p.existencia, pv.nombre
                                                FROM producto p
                                                INNER JOIN proveedor pv
                                                ON p.idproveedor = pv.idproveedor WHERE p.estatus = 1");

if(isset($_POST['consultalp'])){
    $q = mysqli_real_escape_string($conection,$_POST['consultalp']);
    $query = mysqli_query($conection,"SELECT idproducto, descripcion, precio, existencia FROM producto
                                      WHERE descripcion LIKE '%".$q."%' OR precio LIKE '%".$q."%' AND estatus = 1");
}

$resultado = mysqli_num_rows($query);

if($resultado > 0){

    $salida.="<table class='table table-striped table-hover'>
                <thead role='rowgroup'>
                    <tr role='row'>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Proveedor</th>
                        <th>Precio</th>
                        <th>Existencia</th>";
                        if ($_SESSION['rol'] == 1){
                            
                        $salida.="<th>Acciones</th>";
                        }
                    $salida.="</tr>
                </thead>";
                
    while($fila = mysqli_fetch_array($query)){
    $salida.="<tbody role='rowgroup'>
                <tr role='row'>
                    <td data-th='ID'>".$fila['idproducto']."</td>
                    <td data-th='Nombre'>".$fila['descripcion']."</td>
                    <td data-th='Proveedor'>".$fila['nombre']."</td>
                    <td data-th='Precio'>Q.".$fila['precio']."</td>
                    <td data-th='Existencia'>".$fila['existencia']."</td>";
                    if ($_SESSION['rol'] == 1 ){
                       $salida.="<td data-th='Acciones'>
                       <a class='btn btn-warning btn-sm' data-toggle='modal' data-target='#formeditprod'  onclick=". "load_formulario_prod('update_prod',".$fila["idproducto"].") ".">
                            Editar
                        </a>
                        <a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#formeditprod'  onclick=". "load_formulario_prod('delete_prod',".$fila["idproducto"].") ".">
                            Eliminar
                        </a>
                        </td>";
                    }
                $salida.="</tr></tbody>";
    }
    $salida.="</table>";
    
}else{
    $salida.="<img  src='img/OneFuture.png' width='200px;' height='200px'>";
}
echo $salida;
mysqli_close($conection);

?>



