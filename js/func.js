var loader = "<div class=\"cargando\">\n" +
    "                <div class=\"spinner-border text-dark\" role=\"status\">\n" +
    "                    <span class=\"sr-only\">Loading...</span>\n" +
    "                </div>\n" +
    "             </div>";

$(document).ready(function(){


		//Activa Campos para Registrar Cliente
		$('.btn_new_cliente').click(function(e){
			e.preventDefault();
			$('#nom_cliente').removeAttr('disabled');
			$('#tel_cliente').removeAttr('disabled');
			$('#dir_cliente').removeAttr('disabled');

			$('#div_registro_cliente').slideDown();
		});

		//Buscar Cliente
		$('#nit_cliente').keyup(function(e){
			e.preventDefault();

			var cl = $(this).val();
			var action = 'searchCliente';

			$.ajax({
				url: 'action/ajax.php',
				type: "POST",
				async : true,
				data: {action:action,cliente:cl},

				success: function(response)
				{
					if(response == 0){
						$('#idcliente').val('');
						$('#nom_cliente').val('');
						$('#tel_cliente').val('');
						$('#dir_cliente').val('');
						//Mostrar Boton Agregar
						$('.btn_new_cliente').slideDown();
					}else{
						var data = $.parseJSON(response);
						$('#idcliente').val(data.idcliente);
						$('#nom_cliente').val(data.nombre);
						$('#tel_cliente').val(data.telefono);
						$('#dir_cliente').val(data.direccion);
						//Ocultar Boton agregar
						$('.btn_new_cliente').slideUp();

						//Bloque De campos
						$('#nom_cliente').attr('disabled','disabled');
						$('#tel_cliente').attr('disabled','disabled');
						$('#dir_cliente').attr('disabled','disabled');

						//Oculta Boton guardar
						$('.btn_new_cliente').slideUp();
					}
					
				},
				error: function(error) {

				}
				
			});
		});

		//Crear Clientes - Ventas
		$('#form_new_cliente_venta').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'action/ajax.php',
				type: "POST",
				async : true,
				data: $('#form_new_cliente_venta').serialize(),

				success: function(response)
				{
					if(response != 'error'){
						//Agregar id al input hiden
						$('#idcliente').val(response);
						//Bloqueo de Campos
						$('#nom_cliente').attr('disabled','disabled');
						$('#tel_cliente').attr('disabled','disabled');
						$('#dir_cliente').attr('disabled','disabled');
						//Ocultar Boton agregar
						$('.btn_new_cliente').slideUp();
						//Oculta Boton guardar
						$('#div_registro_cliente').slideUp();
					}
					
				},
				error: function(error) {

				}
				
			});
		});

		//Buscar Producto - Venta
		$('#txt_cod_producto').keyup(function(e){
			e.preventDefault();
			
			var producto = $(this).val();
			var action = 'infoProducto';
			if(producto != ''){
				$.ajax({
					url: 'action/ajax.php',
					type: "POST",
					async : true,
					data: {action:action,producto:producto},
	
					success: function(response)
					{
						if(response != 'error'){
							var info = JSON.parse(response);
							$('#txt_descripcion').html(info.descripcion);
							$('#txt_existencia').html(info.existencia);
							$('#txt_cant_producto').val('1');
							$('#txt_precio').html(info.precio);
							$('#txt_precio_total').html(info.precio);

							//Activar Cantidad
							$('#txt_cant_producto').removeAttr('disabled');

							//Mostrar Boton Agregar
							$('#add_product_venta').slideDown();

						/*}else if(response = null){
							$('#txt_descripcion').html('-');
							$('#txt_existencia').html('_');
							$('#txt_cant_producto').val('0');
							$('#txt_precio').html(0.00);
							$('#txt_precio_total').html(0.00);

							//Desactivar Cantidad
							$('#txt_cant_producto').attr('disabled','disabled');

							//Mostrar Boton Agregar
							$('#add_product_venta').slideUp();*/

						}else{
							$('#txt_descripcion').html('-');
							$('#txt_existencia').html('_');
							$('#txt_cant_producto').val('0');
							$('#txt_precio').html(0.00);
							$('#txt_precio_total').html(0.00);

							//Desactivar Cantidad
							$('#txt_cant_producto').attr('disabled','disabled');

							//Mostrar Boton Agregar
							$('#add_product_venta').slideUp();
						}
						
					},
					error: function(error) {
	
					}
					
				});
			}
		});

		//Validar la cantidad de Producto
		$('#txt_cant_producto').keyup(function(e){
			e.preventDefault();

			var precio_total = $(this).val() * $('#txt_precio').html();
			var  existencia = parseInt($('#txt_existencia').html());
			$('#txt_precio_total').html(precio_total);

			//Ocultar el boton agregar si la cantidad es menor a 1
			if(  ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia) ){
				$('#add_product_venta').slideUp();
			}else{
				$('#add_product_venta').slideDown();
			}
		});  

		//Agregar Producto al detalle
		$('#add_product_venta').click(function(e){
			e.preventDefault();

			if($('#txt_cant_producto').val() > 0){
				
				var codproducto  = $('#txt_cod_producto').val();
				var cantidad     = $('#txt_cant_producto').val();
				var action       = 'addProductoDetalle';

				$.ajax({
					url: 'action/ajax.php',
					type: "POST",
					async : true,
					data: {action:action,producto:codproducto,cantidad:cantidad},

					success: function(response)
					{
						if(response != 'error'){
							var info = JSON.parse(response);
							$('#detalle_venta').html(info.detalle);
							$('#detalle_totales').html(info.totales);
							
							//Limpiar campos luego de agregar Producto
							$('#txt_cod_producto').val('');
							$('#txt_descripcion').html('-');
							$('#txt_existencia').html('-');
							$('#txt_cant_producto').val('0');
							$('#txt_precio').html('0.00');
							$('#txt_precio_total').html('0.00');
							
							//Bloquear campo de cantidad
							$('#txt_cant_producto').attr('disabled', 'disabled');

							//Ocultar Boton Agregar
							$('#add_product_venta').slideUp();

						}else{
							console.log('No Hay Datos V:');
						}
						viewProcesar();
					},
					error: function(error) {

					}
					
				});
			}
		});

		//Anular venta
		$('#btn_anular_venta').click(function(e){
			e.preventDefault();

			var rows = $('#detalle_venta tr').length;
			if(rows > 0){
				
				var action = 'anularVenta';

				$.ajax({
					url: 'action/ajax.php',
					type: "POST",
					async : true,
					data: {action:action},

					success: function(response)
					{
						if(response != 'error'){
							location.reload();
						}
					},
					error: function(error) {

					}
					
				});
			}
		});

		//Facturar venta
		$('#btn_facturar_venta').click(function(e){
			e.preventDefault();

			var rows = $('#detalle_venta tr').length;
			if(rows > 0){  
				
				var action = 'procesarVenta';
				var codcliente = $('#idcliente').val();

				$.ajax({
					url: 'action/ajax.php',
					type: "POST",
					async : true,
					data: {action:action,codcliente:codcliente},

					success: function(response)
					{

						 if(response != 'error'){
							var info = JSON.parse(response);
							//console.log(info);

							generarPDF(info.idcliente,info.nofactura)
							location.reload();

						 }else{
							console.log('NO Hay Datos papu');
						 }
					},
					error: function(error) {

					}
					
				});
			}
		});

		//actualiza y elimina el proveedor con la informacion obtenida del formulario modal form_edit_delete
		$('.btn_actualizarprov').click(function(){
			var form = $('#formularioprov').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/update_prov.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
					alert('Lo Logro Cñor');
					location.reload();	
					}else{
						alert('No c Pudo')
						location.reload();
					}
				},
				error: function(error) {

				}	
			});
		});
		
		//actualiza y elimina el usurio con la informacion obtenida del formulario modal form_edit_delete
		$('.btn_actualizarusu').click(function(){
			var form = $('#formulariousu').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/update_usu.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
						alert('Lo Logro Cñor');
						location.reload();	
						}else{
							alert('No c Pudo')
							location.reload();
						}
				},
				error: function(error) {

				}
				
				
			});
		});

		//actualiza y elimina el cliente con la informacion obtenida del formulario modal form_edit_delete
		$('.btn_actualizarcl').click(function(){
			var form = $('#formulariocl').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/update_cl.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
						alert('Lo Logro Cñor');	
						location.reload();
						}else{
							alert('No c Pudo')
							
						}
				},
				error: function(error) {

				}
				
				
			});
		});

		//actualiza y elimina el producto con la informacion obtenida del formulario modal form_edit_delete
		$('.btn_actualizarprod').click(function(){
			var form = $('#formularioprod').serialize();
			alert(form);
			$.ajax({
				type: "POST",
				url: "modal/update/update_prod.php",
				data: form,

				success: function (res) {
					alert(res);
					if(res = "actualizado"){
						alert('Lo Logro Cñor');	
						location.reload();
						}else{
							alert('No c Pudo')
							
						}
				},
				error: function(error) {

				}
				
				
			});
		});

		//actualiza los el nombre de usuario y contraseña de usuario en el modal form_update_pass
		$('.btn_actualizarpass').click(function(){
			var form = $('#formulariopass').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/update_pass.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
						location.reload();	
						}else{
							alert('No c Pudo')
							location.reload();
						}
				},
				error: function(error) {

				}
				
				
			});
		});

		//actualiza el estado del boton que permite visualizar el modal de datos de logueo de usuario
		$('.btn_actbtn').click(function(){
			var form = $('#formularioact').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/update_btn.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
						location.reload();	
						}else{
							alert('No se Pudo')
							location.reload();
						}
				},
				error: function(error) {

				}
				
				
			});
		});

		//actualiza el estado del boton que permite visualizar el modal de datos de logueo de usuario
		$('.btn_anularfac').click(function(){
			var form = $('#formularioanular').serialize();
			$.ajax({
				type: "POST",
				url: "modal/update/anular_fac.php",
				data: form,
				
				success: function (res) {
					if(res = "actualizado"){
						location.reload();	
						}else{
							alert('No se Pudo')
							location.reload();
						}
				},
				error: function(error) {

				}
				
			});
		});

		//Ver Factura
		$('.btn_view').click(function(e){
			e.preventDefault();
			var idcliente = $(this).attr('cl');
			var codfactura = $(this).attr('f');

			generarPDF(idcliente, codfactura);
			
		});

}); //end ready


//Funcion para ajustar la ventana que muestra la factura
function generarPDF(cliente,factura){
	var ancho = 1000;
	var alto = 800;
	//Calcular la pocision x,y para centrar la ventana
	var x = parseInt((window.screen.width/2) - (ancho / 2));
	var y = parseInt((window.screen.height/2) - (alto / 2));

	$url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
	window.open($url,"Factura","left="+x+",height="+alto+",widht="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

//Eliminar Producto del detalle
function del_pruduct_detalle(correlativo){
	var action = 'delProductoDetalle';
	var id_detalle = correlativo;

	$.ajax({
		url: 'action/ajax.php',
		type: "POST",
		async : true,
		data: {action:action,id_detalle:id_detalle},

		success: function(response)
		{
			if(response != 'error'){
				var info = JSON.parse(response);
				$('#detalle_venta').html(info.detalle);
				$('#detalle_totales').html(info.totales);
				
				//Limpiar campos luego de agregar Producto
				$('#txt_cod_producto').val('');
				$('#txt_descripcion').html('-');
				$('#txt_existencia').html('-');
				$('#txt_cant_producto').val('0');
				$('#txt_precio').html('0.00');
				$('#txt_precio_total').html('0.00');
				
				//Bloquear campo de cantidad
				$('#txt_cab nt_producto').attr('disabled', 'disabled');

				//Ocultar Boton Agregar
				$('#add_producto_venta').slideUp();

			}else{
				$('detalle_venta').html('');
				$('detalle_totales').html('');
			}
			viewProcesar();
		},
		error: function(error) {

		}
		
	});
}

//Mostrar/Ocultar boton procesar
function viewProcesar(){
	if($('#detalle_venta tr').length > 0){
		$('#btn_facturar_venta').show();
	}else{
		$('#btn_facturar_venta').hide();
	}
}

//Mostrar el detalle de la tabla temporal al recargar
function searchForDetalle(id){
	var action = 'searchForDetalle';
	var user = id;

	$.ajax({
		url: 'action/ajax.php',
		type: "POST",
		async : true,
		data: {action:action,user:user},

		success: function(response)
		{
			if(response != 'error'){
				var info = JSON.parse(response);

				$('#detalle_venta').html(info.detalle);
				$('#detalle_totales').html(info.totales);
				
			}else{
				console.log('NO HAY DATOS');
			}
			viewProcesar();
		}, 
		error: function(error) {

		}
		
	});
}

$(buscar_datos());

//Buscador para la tabla Clientes
function buscar_datos(consulta){
	$.ajax({
		url: 'action/cliente.php',
		type: "POST",
		async : true,
		dataType: 'html',
		data: {consulta: consulta}
	})
	.done(function(response){
		$("#datos").html(response);
	})
	.fail(function(){
		console.log("Error");
	});

	
}
//Realizar la busqueda a la db de Clientes
$(document).on('keyup', '#caja_busqueda', function(){
	var valor = $(this).val();
	if(valor != ""){
		buscar_datos(valor);
	}else{
		buscar_datos();
	}
});
/************ */


$(buscar_datosp());

//Buscador para la tabla Proveedores
function buscar_datosp(consultap){
	$.ajax({
		url: 'action/proveedores.php',
		type: "POST",
		async : true,
		dataType: 'html',
		data: {consultap: consultap}
	})
	.done(function(response){
		$("#datosp").html(response);
	})
	.fail(function(){
		console.log("Error");
	});

	
}
//Realizar Busqueda de Proveedores
$(document).on('keyup', '#caja_busquedap', function(){
	var valor = $(this).val();
	if(valor != ""){
		buscar_datosp(valor);
	}else{
		buscar_datosp();
	}
});
/************** */


$(buscar_datoslp());

//Buscador para la tabla Producto
function buscar_datoslp(consultalp){
	$.ajax({
		url: 'action/producto.php',
		type: "POST",
		async : true,
		dataType: 'html',
		data: {consultalp: consultalp}
	})
	.done(function(response){
		$("#datoslp").html(response);
	})
	.fail(function(){
		console.log("Error");
	});

	
}
//Realizar Busqueda de Producto
$(document).on('keyup', '#caja_busquedalp', function(){
	var valor = $(this).val();
	if(valor != ""){
		buscar_datoslp(valor);
	}else{
		buscar_datoslp();
	}
});
/************** */

//Funcion para el nav en version movil
$(document).ready(main);
 
var contador = 1;
 
function main(){
	$('.menu_bar').click(function(){
		// $('nav').toggle(); 
 
		if(contador == 1){
			$('nav').animate({
				left: '0'
			});
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		}
 
	});
 
};

//Funcion para que se ejecuta al hacer click el boton de editar, y recibe y envia id y accion de proveedor
function load_formulario_prov(accion, idproveedor){
    $.ajax({
        type: "POST",
		url: "modal/update/form_edit_delete_prov.php",
		async : true,
		data: {accion:accion, id:idproveedor},
		
        beforeSend: function() {
            $("#modalformprov").html(loader);
        },
        success: function (res) {
			$("#modalformprov").html(res);
			
        }
    });
}

//Funcion para que se ejecuta al hacer click el boton de editar, y recibe y envia id y accion de usuario
function load_formulario_usu(accion, id_usuario){
	console.log(accion, id_usuario);
    $.ajax({
        type: "POST",
        url: "modal/update/form_edit_delete_usu.php",
		data: {accion:accion, id:id_usuario},
        beforeSend: function() {
            $("#modalformusu").html(loader);
        },
        success: function (res) {
			$("#modalformusu").html(res);
			
        }
    });
}

//Funcion para que se ejecuta al hacer click el boton de editar, y recibe y envia id y accion de cliente
function load_formulario_cl(accion, idcliente){
	console.log(accion, idcliente);
    $.ajax({
        type: "POST",
        url: "modal/update/form_edit_delete_cl.php",
		data: {accion:accion, id:idcliente},
        beforeSend: function() {
            $("#modalformcl").html(loader);
        },
        success: function (res) {
			$("#modalformcl").html(res);
			
        }
    });
}

//Funcion para que se ejecuta al hacer click el boton de editar, y recibe y envia id y accion de producto
function load_formulario_prod(accion, idproducto){
	console.log(accion, idproducto);
    $.ajax({
        type: "POST",
        url: "modal/update/form_edit_delete_prod.php",
		data: {accion:accion, id:idproducto},
        beforeSend: function() {
            $("#modalformprod").html(loader);
        },
        success: function (res) {
			$("#modalformprod").html(res);
			
        }
    });
}

//Funcion para el cambio de Usuario y contraseña de Usuario
function update_pass(iduser){
	$.ajax({
        type: "POST",
        url: "modal/update/form_edit_pass.php",
		data: {id:iduser},
        beforeSend: function() {
            $("#modalformpass").html(loader);
        },
        success: function (res) {
			$("#modalformpass").html(res);
			
        }
    });
}

//Funcion para el cambio de estatus del boton config
function active_button(action,id){
	console.log(action, id)
	$.ajax({
        type: "POST",
        url: "modal/update/form_act.php",
		data: {action:action, id:id},
        beforeSend: function() {
            $("#modalact").html();
        },
        success: function (res) {
			$("#modalact").html(res);
			
        }
    });
}

//Funcion para el cambio de Usuario y contraseña de Usuario
function anular_fac(nofactura){
	$.ajax({
        type: "POST",
        url: "modal/update/form_anular_fac.php",
		data: {nofactura:nofactura},
        beforeSend: function() {
            $("#modalformanu").html();
        },
        success: function (res) {
			$("#modalformanu").html(res);
			
        }
    });
}