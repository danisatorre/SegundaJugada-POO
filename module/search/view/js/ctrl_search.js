function load_tipo(){
    return ajaxPromise('index.php?module=search&op=tipo', 'POST', 'JSON')
        .then(function(data){
            // console.log("load_tipo data: ", data)
            // return false
            $('#tipo_producto').empty();
            $('#tipo_producto').append('<option value="0">Tipo</option>');
            for(row in data){
                $('#tipo_producto').append('<option value = "' + data[row].id_tipo + '">' + data[row].tipo + '</option>');
            }
        }).catch(function(data){
            console.error('load_tipo (data == undefined) ERROR al cargar los tipos en el controlador del buscador de js');
            return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        })
} // load_categoria

function load_categoria(data){
    if(data == undefined){
        // console.log("load_categoria data(undefined)");
        return ajaxPromise('index.php?module=search&op=categoria', 'POST', 'JSON')
            // console.log("load_categoria data undefined: ", data)
            .then(function(categoria) {
                // console.log('load_categoria data == undefined\n' + categoria);
                // return false;
                $('#categoria_producto').empty();
                $('#categoria_producto').append('<option value = "0">Categoria</option>');
                for (row in categoria) {
                    $('#categoria_producto').append('<option value = "' + categoria[row].id_categoria + '">' + categoria[row].categoria + '</option>');
                }
            }).catch(function() {
                console.error("load_categoria ERROR al cargar las categorias en el controlador del buscador de js");
                return false;
                window.location.href = "index.php?module=ctrl_exceptions&op=503";
            });
    }else{
        // console.log("load_categoria data(defined)");
        return ajaxPromise('index.php?module=search&op=categoria', 'POST', 'JSON', data)
            // console.log("load_categoria data defined: ", data)
            .then(function(categoria) {
                // console.log('load_categoria data != undefined\n' + categoria);
                // return false;
                $('#categoria_producto').empty();
                $('#categoria_producto').append('<option value = "0">Categoria</option>');
                for (row in categoria) {
                    $('#categoria_producto').append('<option value = "' + categoria[row].id_categoria + '">' + categoria[row].categoria + '</option>');
                }
            }).catch(function() {
                console.error("load_categoria ERROR al cargar las categorias en el controlador del buscador de js");
                return false;
                window.location.href = "index.php?module=ctrl_exceptions&op=503";
            });
    }
} // load_tipo

function load_buscador(){
    Promise.all([load_tipo(), load_categoria()]).then(() =>{
        highlight_buscador();
    }); // cargar el highligth despues de cargar los datos de los select
    // load_tipo();
    // load_categoria();
    // highlight_buscador();
    $('#tipo_producto').on('change', function(){
        let tipo = $(this).val();
        if(tipo === 0){
            load_categoria();
        }else{
            load_categoria({tipo});
        }
        // highlight_buscador();
    });

    // $('#categoria_producto').on('change', function(){
    //     highlight_buscador();
    // });
} // load_buscador

function autocompletar(){
    $("#autocompletar").on("keyup", function() {
        let sdata = { completar: $(this).val() };

        // if ($('#tipo_producto').val() != '0') {
        //     sdata.tipo_producto = $('#tipo_producto').val();
        // }
        // if ($('#categoria_producto').val() != '0') {
        //     sdata.categoria_producto = $('#categoria_producto').val();
        // }

        sdata.tipo_producto = $('#tipo_producto').val() || '0';
        sdata.categoria_producto = $('#categoria_producto').val() || '0';
        
        ajaxPromise('index.php?module=search&op=autocompletar', 'POST', 'JSON', sdata)
            .then(function(data) {
                // console.log("autocompletar: ", data);
                // return false;
                if(data != "error"){
                    $('#buscar_producto').empty();
                    $('#buscar_producto').fadeIn(10000000);
                    for (row in data) {
                        $('<div></div>').appendTo('#buscar_producto').html(data[row].ciudad).attr({ 'class': 'buscarElemento', 'id': data[row].ciudad });
                    }
                    $(document).on('click', '.buscarElemento', function() {
                        $('#autocompletar').val(this.getAttribute('id'));
                        $('#buscar_producto').fadeOut(900);
                    });
                    $(document).on('click scroll', function(event) {
                        if (event.target.id !== 'autocompletar') {
                            $('#buscar_producto').fadeOut(1000);
                        }
                    });
                }else if(data === "error"){
                    $('#buscar_producto').empty();
                    $('#buscar_producto').fadeIn(10000000);
                    $('<div></div>').appendTo('#buscar_producto').html(
                        "<div class='buscarElemento'>" +
                        "<a>No se encontraron ciudades</a>"
                    )
                    $(document).on('click scroll', function(event) {
                        if (event.target.id !== 'autocompletar') {
                            $('#buscar_producto').fadeOut(1000);
                        }
                    });
                }
            }).catch(function(error) {
                console.error("autocompletar ERROR ajaxPromise: ", error);
                $('#buscar_producto').fadeOut(500);
            });
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#autocompletar, #buscar_producto').length) {
            $('#buscar_producto').fadeOut(300);
        }
    });

    $("#autocompletar").on("focus", function () {
        if ($('#buscar_producto').children().length > 0) {
            $('#buscar_producto').fadeIn(300);
        }
    });
} // autocompletar

function boton_buscar(){
    $('#boton_buscar').on('click', function(){
        var buscar = [];

        if($('#autocompletar').val() == ""){
            localStorage.setItem('filtro_ciudad', '0');
            localStorage.setItem('filtro_tipo', $('#tipo_producto').val());
            localStorage.setItem('filtro_categoria', $('#categoria_producto').val());

            buscar.push({"filtro_ciudad": '0'});
            buscar.push({"filtro_tipo": $('#tipo_producto').val()});
            buscar.push({"filtro_categoria": $('#categoria_producto').val()});
        }else{
            localStorage.setItem('filtro_ciudad', $('#autocompletar').val());
            localStorage.setItem('filtro_tipo', $('#tipo_producto').val());
            localStorage.setItem('filtro_categoria', $('#categoria_producto').val());

            buscar.push({"filtro_ciudad": $('#autocompletar').val()});
            buscar.push({"filtro_tipo": $('#tipo_producto').val()});
            buscar.push({"filtro_categoria": $('#categoria_producto').val()});
        }

        eliminar_filtros_buscar();

        localStorage.setItem('buscar', JSON.stringify(buscar));
        // highlight_buscador();
        // return false;
        // console.log("Valores almacenados en localStorage: ", localStorage.getItem('buscar'));
        window.location.href = 'index.php?module=shop';
    });
} // boton_buscar

function eliminar_filtros_buscar(){
    localStorage.removeItem('filtro');
    localStorage.removeItem('filtro_precio');
    localStorage.removeItem('filtro_equipo');
    localStorage.removeItem('filtro_marca');
    localStorage.removeItem('pagina');
}

function highlight_buscador(){
    console.log("hola highlight buscador")
    // return false;

    // rellenar buscador con filtros aplicados desde el buscador

    var buscador_filtros = JSON.parse(localStorage.getItem('buscar'));

    if(buscador_filtros){
        var ciudad = (buscador_filtros[0]['filtro_ciudad']);
        var tipo = (buscador_filtros[1]['filtro_tipo']);
        var categoria = (buscador_filtros[2]['filtro_categoria']);

        // console.log(ciudad)
        // console.log(tipo)
        // console.log(categoria)
        // return false;

        if(tipo != '0'){
            document.getElementById('tipo_producto').value = tipo;
        }
        
        if(categoria != '0'){
            document.getElementById('categoria_producto').value = categoria;
        }

        if(ciudad != '0'){
            document.getElementById('autocompletar').value = ciudad;
        }
    }

    // rellenar opciones con filtros aplicados desde el shop

    var filtro_tipo = localStorage.getItem('filtro_tipo');
    var filtro_categoria = localStorage.getItem('filtro_categoria');
    var filtro_ciudad = localStorage.getItem('filtro_ciudad');

    // if(filtro_tipo && filtro_tipo != '0'){
    //     document.getElementById('tipo_producto').value = filtro_tipo;
    // }

    if (filtro_tipo && filtro_tipo != '0') {
        if ($('#tipo_producto').val() != filtro_tipo) {
            $('#tipo_producto').val(filtro_tipo);
        }
    }

    if (filtro_categoria && filtro_categoria != '0') {
        if ($('#categoria_producto').val() != filtro_categoria) {
            $('#categoria_producto').val(filtro_categoria);
        }
    }

    if(filtro_ciudad && filtro_ciudad != '0'){
        if($('#autocompletar').val() != filtro_ciudad){
            $('#autocompletar').val(filtro_ciudad);
        }
    }

    // if(filtro_categoria && filtro_categoria != '0'){
    //     document.getElementById('categoria_producto').value = filtro_categoria;
    // }
}

$(document).ready(function() {
    load_buscador();
    autocompletar();
    boton_buscar();
    // highlight_buscador();
});