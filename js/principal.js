$(document).ready(function(){
    /*
    *Funcion para mostrar el formulario de editar
    *informacion de la empresa
    */
    $("#mostrar").click(function(e){
        e.preventDefault();
     $('#edit').show(2000, function(){

        });
     });

     /*
    *Funcion para ocultar el formulario de editar
    *informacion de la empresa
    */
    $("#ocultar").click(function(){
        $('#edit').hide(3000, function(){
            
        });
     });




     //actualiza los datos de informacion de la empresa
		$('.btn_editinfo').click(function(e){
            e.preventDefault();
            var form = $('.infoedit').serialize();
            console.log(form);
			$.ajax({
				type: "POST",
				url: "modal/update/update_info.php",
				data: form,
				
				success: function (res) {
                    console.log(res)
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


   });//end ready

   //Furncion que recibe el id para editar info de la empresa
    function send_id(id){
        console.log(id)
    $.ajax({
        type: "POST",
		url: "action/principal.php",
		async : true,
		data: {id:id},
		
        beforeSend: function(response) {
            $("#info").html(response);
        },
        success: function (res) {
			$("#info").html(res);
			
        }
    });
}