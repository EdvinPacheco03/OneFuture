<?php 

include '../config/conexion.php';
session_start();

//Busqueda para los proveedores

$salida = "";
$query = mysqli_query($conection,"SELECT * FROM proveedor WHERE estatus = 1");

if(isset($_POST['consultap'])){
    $q = mysqli_real_escape_string($conection,$_POST['consultap']);
    $query = mysqli_query($conection,"SELECT idproveedor, nombre, contacto, telefono, direccion FROM proveedor
                                      WHERE nombre LIKE '%".$q."%' OR telefono LIKE '%".$q."%' AND estatus = 1");
}

$resultado = mysqli_num_rows($query);

if($resultado > 0){

    $salida.="<table class='table table-striped table-hover'>
                <thead role='rowgroup'>
                    <tr role='row'>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Telefono</th>
                        <th>Direccion</th>";
                        if ($_SESSION['rol'] == 1){
                            
                        $salida.="<th>Acciones</th>";
                        }
                    $salida.="</tr>
                </thead>";
                
    while($fila = mysqli_fetch_array($query)){
    $salida.="<tbody role='rowgroup'>
                <tr role='row'>
                    <td data-th='ID'>".$fila['idproveedor']."</td>
                    <td data-th='Nombre'>".$fila['nombre']."</td>
                    <td data-th='Nit'>".$fila['contacto']."</td>
                    <td data-th='Telefono'>".$fila['telefono']."</td>
                    <td data-th='Direccion'>".$fila['direccion']."</td>";
                    if($_SESSION['rol'] ==  1){
                    $salida.="<td data-th='Acciones'>
                        <a class='btn btn-warning btn-sm' data-toggle='modal' data-target='#formeditprov'  onclick=". "load_formulario_prov('update_prov',".$fila["idproveedor"].") ".">
                            Editar
                        </a>
                        <a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#formeditprov'  onclick=". "load_formulario_prov('delete_prov',".$fila["idproveedor"].") ".">
                            Eliminar
                        </a>
                    </td>";
                }   
                $salida.="</tr></tbody>";
    }
    $salida.="</table>";

}else{
    $salida.="<video src='video/Hijole.mp4' controls autoplay></video>";
}
echo $salida;
mysqli_close($conection);

?>

<style>
    video{
        margin-top: 20px;
    }
</style>

