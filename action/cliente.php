<?php 
include '../config/conexion.php';
session_start();

    $salida = "";
    $query = mysqli_query($conection,"SELECT * FROM cliente WHERE estado = 1 ORDER BY idcliente");

    if(isset($_POST['consulta'])){
        $q = mysqli_real_escape_string($conection,$_POST['consulta']);
        $query = mysqli_query($conection,"SELECT idcliente, nombre, nit, telefono, direccion FROM cliente
                                          WHERE nombre LIKE '%".$q."%' OR telefono LIKE '%".$q."%' AND estado = 1");
    }

    $resultado = mysqli_num_rows($query);

    if($resultado > 0){

        $salida.="<table class='table table-striped table-hover'>
                    <thead role='rowgroup'>
                        <tr role='row'>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Nit</th>
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
                        <td data-th='ID'>".$fila['idcliente']."</td>
                        <td data-th='Nombre'>".$fila['nombre']."</td>
                        <td data-th='Nit'>".$fila['nit']."</td>
                        <td data-th='Telefono'>".$fila['telefono']."</td>
                        <td data-th='Direccion'>".$fila['direccion']."</td>";
                        if($_SESSION['rol'] == 1 ){
                        $salida.="<td data-th='Acciones'>
                            <a class='btn btn-warning btn-sm' data-toggle='modal' data-target='#formeditcl'  onclick=". "load_formulario_cl('update_cl',".$fila["idcliente"].") ".">
                                Editar
                            </a>
                            <a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#formeditcl'  onclick=". "load_formulario_cl('delete_cl',".$fila["idcliente"].") ".">
                                Eliminar
                            </a>
                        </td>";
                        }
                    $salida.="</tr></tbody>";
        }
        $salida.="</thead></table>";

        
    }else{
        $salida.="No hay Datos V,:";
    }

    echo $salida;
    mysqli_close($conection);

    
?>
