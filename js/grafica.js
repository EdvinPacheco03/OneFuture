$(document).ready(function(){

    //Graficar Ventas
		$('.btn_btn').click(function(e){
			e.preventDefault();
			var form = $('#search_graphic').serialize();
			//console.log(form);
			
			$.ajax({
				url: 'action/grafica.php',
				type: "POST",
				async : true,
				data: $('#search_graphic').serialize(),
				
				success: function(response)
				{
					
					if(response != 'error'){
                        var data = JSON.parse(response);
                        var valores = eval(data);

                        var ventas = [];
                        var fecha = [];
                        
                        for(var i in data){
                            ventas.push(data[i].ventas);
                            fecha.push(data[i].fecha1);
                        }
                        var datos = {
                            labels : fecha,
                            datasets : [
                                {
                                    label: 'Numero de Ventas Realizadas por dia',
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',

                                     /*backgroundColor: 'rgb(24 230 21)',
                                     borderColor: 'rgb(37 232 223)',*/
                                    /*hoverBackroundColor: 'rgb(255, 99, 132)',
                                    hoverBorderColor: 'rgb(255, 99, 132)',*/
                                    data: ventas

                                }
                            ]  
                        };

                        var graphTarget = $('#grafico');
                        var barGraph = new Chart(graphTarget, { 
                            type: 'bar',
                            data: datos,
                            options:{
                                responsive: true,
                                maintainAspectRatio: false,
                            }
                            });
                    
	
					 }else{
						console.log('NO HAY DATOS');
					 }  
				}
			});
		
		});
})