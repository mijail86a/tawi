<?php
    require_once('lib/functions.lib.php');
    require_once('lib/carrito.lib.php');
    $datos = new libreria();
    //$id_usuario = isset($_COOKIE["id_cliente"]) || !empty($_COOKIE["id_cliente"])?$_COOKIE["id_cliente"]:0;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
<?php
    include_once 'plantilla/header.php';
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dynatable/0.3.1/jquery.dynatable.min.css" integrity="sha256-lxcbK1S14B8LMgrEir2lv2akbdyYwD1FwMhFgh2ihls=" crossorigin="anonymous" />
    <style type="text/css">
        .dynatable-active-page{
            background-color: #175e90!important;
        }
        .dynatable-pagination-links{
            margin-bottom: 0.5rem;
            padding: 0;
            text-align: center;
            width: 100%;
        }
        .table .btn{
            font-size: .7rem;
        }
        td{
            font-size: .8rem;
            vertical-align: middle!important;
            white-space: nowrap;
        }
        .tw-bg-e::first-letter{
            text-transform: uppercase;
        }
        .table td, .table th{
            padding: .50rem;
        }
        @media only screen and (max-width: 414px) {
            .dynatable-search, .dynatable-per-page{
                float: left;
                margin-bottom: 10px;
            }
        }
        .dynatable-per-page select{
            height: 30px;
        }
    </style>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-7 col-lg-4 m-auto h-100">
                <div id="tw-cabezera" class="d-flex justify-content-between align-items-center my-2">
                    <a href="/"><img class="img-fluid lazy" data-src="<?php echo STATIC2 . DIRECTORIO . IMG . "logo-tawi.png"; ?>" alt="logo"></a>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn tw-btn-b"><?php echo $_COOKIE["nombre_cliente"];?></button>
                        <button id="btnGroupDrop1" type="button" class="btn tw-btn-b dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="historial.php"><i class="fas fa-list"></i>&nbsp;Historial de pedidos</a>
                            <a id="tw-salir" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>&nbsp;Salir</a>
                        </div>
                    </div>
                </div>
                <h4 class="tw-color text-center font-weight-bold">Historial de pedidos</h4>
                <div class="w-100 overflow-auto">
                    <table id="table-report" class="table table-borderless table-hover text-center">
                        <thead class="tw-bg-e">
                            <th class="text-white tw-bg-e">código</th>
                            <th class="text-white tw-bg-e">nombre</th>
                            <th class="text-white tw-bg-e">creado</th>
                            <th class="text-white tw-bg-e">estado</th>
                            <th class="text-white tw-bg-e">acción</th>
                            <th class="text-white tw-bg-e">total</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="w-100 mt-3 tw-bg-e" style="height: 4rem;"></div>
            </div>
        </div>
<?php
    include_once 'plantilla/footer.php';
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dynatable/0.3.1/jquery.dynatable.min.js" integrity="sha256-/kLSC4kLFkslkJlaTgB7TjurN5TIcmWfMfaXyB6dVh0=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function() {
            $(".lazy").lazyload();
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
            reporte();
        });
        var reporte = function(){
            var url = "https://tawi.com.pe/ajax/ajax.lib.php",
                table = $("#table-report");
            envia = inicaAjax(url, { origen: "reporte-cliente", "estado" : 0 });
            envia.done(function(data) {
                if(data.estado){
                    table.dynatable({
                        dataset: {
                            records: data.records
                        },
                        writers:{
                            código: function(el) {
                                return "<a class=\"btn tw-btn-b btn-block\" href=\"revisar.php?repetir=1&codigo="+el.id+"\">"+el.código+"</a>";
                            },
                            estado: function(el) {
                                var boton, repeticua;
                                switch (parseInt(el.estado)) {
                                    case parseInt(1):
                                        boton = "<button type=\"button\" class=\"btn btn-secondary btn-block\">Por aprobar</button>";
                                        break;
                                    case parseInt(2):
                                        boton = "<a class=\"btn btn-warning btn-block\" href=\"terminar.php?codigo="+el.id+"\">Pendiente de pago</a>";
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
                            acción: function(el) {
                                switch (parseInt(el.estado)) {
                                    case parseInt(3):
                                        repeticua = "<a class=\"btn tw-btn-b btn-block\" href=\"revisar.php?repetir=2&codigo="+el.id+"\">Repeticua</a>";
                                        break;
                                    default:
                                        repeticua = "";
                                }
                                return repeticua;
                            },
                            total: function(el) {
                                //console.log(el.id, el);
                                return "S./ "+(el.total/100).toFixed(2);
                            }
                        }
                    });
                }
            });
        };
        var inicaAjax = function(url, data) {
            return $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: 'json',
            }).fail(function(jqXHR, textStatus) {
                console.log("Request failed: " + textStatus);
            });
        };
    </script>    
    </body>
</html>