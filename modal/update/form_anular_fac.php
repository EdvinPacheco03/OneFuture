<?php 
    include '../../config/conexion.php';
 /**
     *comentarios xd
     */

if(!empty($_REQUEST)){

    $nofactura = $_REQUEST['nofactura'];
    $query =  mysqli_query($conection,"SELECT * FROM factura WHERE nofactura = $nofactura AND estatus = 1");
    
    $result =  mysqli_num_rows($query);

    if ($result > 0) {
        $row = mysqli_fetch_array($query);
    }
     ?>
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Anular Factura</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="formularioanular" action="">
            <input type="hidden" name="id" value="<?php echo $nofactura; ?>">
            <Label><strong>Realmente Desea anular la factura:</strong></Label>
            <p class="text-center">No. factura:</p>
            <center><h6 style="color: blue;"><?php echo $row['nofactura'];?></h6></center>
            <p class="text-center">Fecha de Creacion:</p>
            <center><h6 style="color: blue;"><?php echo $row['fecha'];?></h6></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <button type="button" class="btn btn-success btn_anularfac" data-dismiss="modal" data-accion="anular">Guardar</button>
        </form>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/func.js"></script>

<?php } ?>
