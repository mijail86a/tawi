<?php
require_once('../lib/functions.lib.php');
$datos = new libreria();
$datos->login_existe();
?>
<!DOCTYPE html>
<html>
    <head>
<?php
    require_once ("plantilla/header.php");
?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dynatable/0.3.1/jquery.dynatable.min.css" integrity="sha256-lxcbK1S14B8LMgrEir2lv2akbdyYwD1FwMhFgh2ihls=" crossorigin="anonymous" />
		<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css">
	    <style type="text/css">
	        .dynatable-active-page{
	            background-color: #26373A!important;
	        }
	        td{
	            vertical-align: middle!important;
	        }
	        .tw-bg-a::first-letter{
	            text-transform: uppercase;
	        }
	    </style>
    </head>
    <body>
<?php
    require_once ("plantilla/header-navbar-x.php");
?>
        <div class="container-fluid p-3 tw-aa">
			<div class="row">
				<div class="col-1">Desde:</div><div class="col-2"><input id="datetimepicker-start" type="text" value="<?php echo date("Y-m-d")." 00:00:00";?>"></div>
				<div class="col-1">Hasta:</div><div class="col-2"><input id="datetimepicker-end" type="text" value="<?php echo date("Y-m-d")." 23:59:59";?>"></div>
				<div class="col-2"><input type="button" id="table-buscar" class="btn btn-sm btn-block btn-primary" value="BUSCAR"></div>
				<div class="col-12 pt-1">
					<table id="table-report" class="table table-bordered">
					  	<thead>
					    	<th class="text-white tw-bg-a">codigo</th>
					    	<th class="text-white tw-bg-a">creado</th>
					    	<th class="text-white tw-bg-a">telefono</th>
					    	<th class="text-white tw-bg-a">nombre</th>
					    	<th class="text-white tw-bg-a">estado</th>
					    	<th class="text-white tw-bg-a">total</th>
					  	</thead>
					  	<tbody>
					  	</tbody>
					</table>
				</div>
			</div>
        </div>
<?php
    require_once ("plantilla/footer.php");
?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dynatable/0.3.1/jquery.dynatable.min.js" integrity="sha256-/kLSC4kLFkslkJlaTgB7TjurN5TIcmWfMfaXyB6dVh0=" crossorigin="anonymous"></script>
	<script src="js/jquery.datetimepicker.full.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$.datetimepicker.setLocale('es');
			$.dynatableSetup({
                inputs: {
                    recordCountPlacement: 'after',
                    paginationLinkPlacement: 'after',
                    paginationPrev: 'Anterior',
                    paginationNext: 'Siguiente',
                    searchPlacement: 'before',
                    perPagePlacement: 'before',
                    perPageText: 'Ver: ',
                    processingText: 'Procesando ...',
                    recordCountText: 'Vistos del ',
                    recordCountPageBoundTemplate: '{pageLowerBound} al {pageUpperBound} de',
                    recordCountPageUnboundedTemplate: '{recordsShown} de',
                    recordCountTotalTemplate: '{recordsQueryCount} {collectionName}',
                    recordCountFilteredTemplate: ' (filtered from {recordsTotal} total records)',
                    recordCountTextTemplate: '{text} {pageTemplate} {totalTemplate} {filteredTemplate}',
                    searchText: "Buscar: ",
                    pageText: "Pagina:",
                },  
                params: {
                    page: 'Pagina',
                    perPage: 'por pagina',
                    records: 'Registros'
                }
            });
			var url = DOMINIO + ADMIN + DIRECTORIO_AJAX + "ajax.lib.php",
				dp_start = $("#datetimepicker-start"),
				dp_end = $("#datetimepicker-end"),
				table = $("#table-report"),
				buscar = $("#table-buscar");
			dp_start.datetimepicker({
				format:'Y-m-d H:m:s',
				onShow:function( ct ){
					this.setOptions({
						maxDate:dp_end.val()?dp_end.val():false
					});
				},
			});
			dp_end.datetimepicker({
				format:'Y-m-d H:m:s',
				onShow:function( ct ){
					this.setOptions({
						minDate:dp_start.val()?dp_start.val():false
					});
				},
			});
			buscar.on('click', function () {
				var start = dp_start.val(),
					end = dp_end.val();
				envia = inicaAjax(url, { origen: "reporte", start: start, end: end, "estado" : 0 });
				envia.done(function(data) {
					if(data.estado){
						var dynatable = table.dynatable({
					      	dataset: {
					        	records: data.records
					      	},
				      		writers:{
								estado: function(el) {
	                                var boton;
	                                switch (parseInt(el.estado)) {
	                                    case parseInt(1):
	                                        boton = "<button type=\"button\" class=\"btn btn-secondary btn-block\">Por aprobar</button>";
	                                        break;
	                                    case parseInt(2):
	                                        boton = "<button type=\"button\" class=\"btn btn-warning btn-block\">Pendiente de pago</button>";
	                                        break;
	                                    case parseInt(3):
	                                        boton = "<button type=\"button\" class=\"btn btn-success btn-block\">Pagado</button>";
	                                        break;
	                                    case parseInt(4):
	                                        boton = "<button type=\"button\" class=\"btn btn-danger btn-block\">Rechazado</button>";
	                                        break;
	                                    default:
	                                        boton = "<button type=\"button\" class=\"btn btn-dark btn-block\">Sin identificar</button>";
	                                        break;
	                                }
	                                return boton;
	                            },
	                            total: function(el) {
	                                //console.log(el.id, el);
	                                return "S/ "+(el.total/100).toFixed(2);
	                            }
                            }
				    	}).data("dynatable");
				    	dynatable.settings.dataset.originalRecords =  data.records;
	    				dynatable.process();
					}
				});
			});
			reporte();
		});
		var reporte = function(){
			envia = inicaAjax(url, { origen: "reporte-automatico", "estado" : 0 });
			envia.done(function(data) {
				if(data.estado){
					table.dynatable({
				      	dataset: {
				        	records: data.records
				      	}
			    	});
				}
			});
		};
/*
$.getJSON("AjaxEngine/AddPayment.aspx", { sender: "seller-factor", id: obj.val() }, 
    function (data) {
	    var dynatable = $('#factors-table').dynatable({
	    	dataset: { records: data.Factors }
		},{
			features: { pushState: false }
		}).data("dynatable");
	    dynatable.settings.dataset.originalRecords =  data.Factors;
	    dynatable.process();
	}
);
*/
	</script>
    </body>
</html>