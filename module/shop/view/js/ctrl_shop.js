// console.log("hola ctrl shop js");
// return false;

function loadShop(total_productos, items_por_pagina){
    // console.log("hola loadShop");
    // console.log(total_productos)
    // return false;
    var verificar_filtros = localStorage.getItem('filtro') || false;
    var buscador_filtros = localStorage.getItem('buscar') || false;
    var details_home = localStorage.getItem('details_home') || false;
    var like = localStorage.getItem('redirect_like') || false;
    // console.log("loadShop verificar_filtros: ", verificar_filtros);
    // console.log("loadShop buscador_filtros: ", buscador_filtros);
    // console.log("loadShop details_home id producto: ", details_home);
    // return false;
    if(like != false){
        redirect_login_like();
    }else if(verificar_filtros != false){
        // console.log("loadShop verificar_filtros");
        getall(total_productos, items_por_pagina);
        highlight();
    }else if(buscador_filtros != false){
        // console.log("loadShop buscador_filtros");
        load_buscador_shop(total_productos, items_por_pagina);
    }else if(details_home != false) {
        // console.log("loadShop details_home");
        $('#paginacion').empty();
        loadProductoDetails(details_home);
    }else{
        // console.log("loadshop else (url...getall)");
        ajaxForSearch('index.php?module=shop&op=getall');
    }
} // end loadShop (controlador del controlador)

function ajaxForSearch(url, filtro = null, total_productos = 0, items_por_pagina = 3) {
    // console.log("hola ajaxForSearch");
    // console.log("AFS filtros: ", filtro);
    // console.log("AFS url: ", url);
    // console.log("AFS total_productos: ", total_productos);
    // console.log("AFS items_por_pagina: ", items_por_pagina);
    // return false;

    if (total_productos != 0) {
        localStorage.setItem('total_prod', total_productos);
    } else {
        if (localStorage.getItem('total_prod')) {
            total_productos = localStorage.getItem('total_prod');
        } else {
            total_productos = 0;
        }
    }

    const pagina = localStorage.getItem('pagina') || 1;
    const offset = (pagina - 1) * items_por_pagina;

    const sdata = filtro 
        ? { 'filtro': filtro, 'offset': offset, 'limit': items_por_pagina } 
        : { 'offset': offset, 'limit': items_por_pagina };
    
    ajaxPromise(url, 'POST', 'JSON', sdata)
        .then(function (shop) {
            // console.log("Datos shop: ", shop);
            // return false;
            $(".container-productos").empty();
            if(shop != "error"){
                // console.log("ajaxForSearch shop.id");
                try{
                    for (row in shop) {
                        $("#nofiltros").empty();
                        $("#texto-nofiltros").empty();
                        $(".nofiltrosdiv").empty();
                        $('<div></div>').attr('class', "producto").attr({'id': shop[row].id_producto}).appendTo('.container-productos')
                            .html(
                                "<div class='click-producto' id='" + shop[row].id_producto + "'>" +
                                    "<img src = "+ PRODUCT_IMAGES + shop[row].img_producto + " alt='foto' </img> " +
                                    "<div class='inf-producto'>" +
                                    "<h3>" + shop[row].nom_prod + "</h5>" +
                                    "<p class='precio'>" + shop[row].precio + "€</p>" +
                                    "</div>" + // end .inf-producto
                                "</div>" + // end .click-producto
                                "<a class='list_like' id='" + shop[row].id_producto + "'>" + 
                                    "<i id=" + shop[row].id_producto + " class='fa-solid fa-heart fa-lg'></i>" + 
                                "</a>" + // end .details_like
                                "<span class='count-likes'>" + shop[row].likes + "</span>"
                            ); // end .html
                    }
                    paginacion();
                    leafleft(shop, 6);
                    highlight();
                    botones_filtros();
                    load_likes_user();
                    // animacion del producto al que se da like cuando no estas logeado
                    if(localStorage.getItem('id_producto')){
                        var id = "#" + localStorage.getItem('id_producto');
                        $("html, body").animate({scrollTop: $(id).offset().top}, 1000, function(){
                            $(id).animate({ marginTop: "-20px" }, 200)
                                .animate({ marginTop: "0px" }, 200);
                        });
                        localStorage.removeItem('id_producto');
                    }
                } catch (error){
                    console.log("ERROR al pintar productos filtrados");
                }
                
            }else{
                console.log("ajaxForSearch else shop.id");
                $(".container-productos").empty();
                $("#nofiltros").empty();
                $("#texto-nofiltros").empty();
                $(".nofiltrosdiv").empty();
                $(".imgnofdiv").empty();
                $('<div></div>').appendTo('.container-shop-list')
                .html(
                    "<div class='nofiltrosdiv'>" +
                    "<img class='imgnofdiv' src="+ ICONS_IMG +"'no_productos.png'>" +
                    "<h1 id='nofiltros'>No se han encontrado productos con los filtros especificados</h1>" +
                    "<br>" +
                    "<p id='texto-nofiltros'>Pulse el boton 'remover filtros' para volver a la busqueda</p>" +
                    "</div>" // end .nofiltrosdiv
                );
            }
        }).catch(function (e) {
            console.log("ajaxForSearch catch");
            $(".container-productos").empty();
            $(".nofiltrosdiv").empty();
            $('<div></div>').appendTo('.container-shop-list')
                .html(
                    "<div class='nofiltrosdiv'>" +
                    "<h1 id='nofiltros'>¡UPS! Ha ocurrido un error al buscar productos😓</h1>" +
                    "<br>" +
                    "<p id='texto-nofiltros'>Pulse el boton 'remover filtros' para volver a la busqueda</p>" +
                    "</div>" // end .nofiltrosdiv
                );
        });
} // end ajaxForSearch (cargar los productos del list del shop)

function loadProductos(){
    // console.log("hola loadProductos");
    // return false;
    ajaxPromise('index.php?module=shop&op=getall', 'GET', 'JSON')
    .then(function(data){
        // console.log(data);
        // return false;
        primera_entrada();
        for (row in data){
            $('<div></div>').attr('class', "producto").attr({'id': data[row].id_producto}).appendTo('.container-productos')
                .html(
                    "<img src = "+ + PRODUCT_IMAGES + data[row].img_producto + " alt='foto' </img> " +
                    "<div class='inf-producto'>" +
                    "<h3>" + data[row].nom_prod + "</h5>" +
                    "<p class='precio'>" + data[row].precio + "€</p>" +
                    "</div>"
                ) // end .html
        } // end row in data
    }).catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadProductos

function primera_entrada(){
    localStorage.removeItem('filtro');
    localStorage.removeItem('filtro_tipo');
    localStorage.removeItem('filtro_categoria');
    localStorage.removeItem('filtro_precio');
    localStorage.removeItem('filtro_equipo');
    $("#nofiltros").empty();
    $("#texto-nofiltros").empty();
} // end primera_entrada

function loadEquipos() {
    // console.log("hola loadEquipos");
    // return false;
    ajaxPromise('index.php?module=shop&op=filtro_equipos', 'POST', 'JSON')
    .then(function(equipos){
        // console.log(equipos);
        // return false;
        $('.checkbox-equipo').empty();
        for (row in equipos){
            $('.checkbox-equipo').append(
                '<input type="checkbox" value="' + equipos[row].id_team + '" id="' + equipos[row].id_team + '" class="filtro_equipo" name="equipo">' + equipos[row].nom_team + '</br>'
            );
        } // end row in data
        // Restore the selected checkboxes from localStorage
        if(localStorage.getItem('filtro_equipo')){
            var equipo = JSON.parse(localStorage.getItem('filtro_equipo'));
            $.each(equipo, function(index, value) {
                $("input[class='filtro_equipo'][value='" + value + "']").prop('checked', true);
            });
        }
    }).catch(function(error){
        console.error('Error al cargar los equipos:', error);
    });
} // end loadEquipos (llenar los checkboxes de equipo dinamicamente desde la base de datos)

function print_filtros() {
    $('<div class="div-filtros"></div>').appendTo('.container-filtros')
        .html(
            // select tipo
            '<div class="f_tipo">' +
                '<h4 class="desplegable-tipo">Tipos⬇️</h4>' +
                '<div class="options-tipo" style="display: none;">' +
                    '<select class="filtro_tipo" name="select_tipo" id="select_tipo">' +
                        '<optgroup label="Tipos">' +
                            '<option value ="0" disabled selected>Selecciona un tipo</option>' +
                            '<option value="1">Cancha</option>' +
                            '<option value="2">Calle</option>' +
                            '<option value="3">Zapatos</option>' +
                            '<option value="4">Gorras</option>' +
                            '<option value="5">Balones</option>' +
                            '<option value="6">Pantalones</option>' +
                            '<option value="7">Camisetas</option>' +
                            '<option value="8">Accesorios</option>' +
                            '<option value="9">Sudaderas</option>' +
                            '<option value="10">Chaquetas</option>' +
                        '</optgroup>' +
                    '</select>' +
                '</div>' + // end .options-tipo
            '</div>' +
            // select categoria
            '<div class="f_categoria">' +
                '<h4 class="desplegable-categoria">Categorias⬇️</h4>' +
                '<div class="options-categoria" style="display: none;">' +
                    '<select class="filtro_categoria" name="select_categoria" id="select_categoria">' +
                        '<optgroup label="Categorias">' +
                            '<option value="0" disabled selected>Selecciona una categoria</option>' +
                            '<option value="1">Hombre</option>' +
                            '<option value="2">Mujer</option>' +
                            '<option value="3">Niños</option>' +
                            '<option value="4">Adolescentes</option>' +
                            '<option value="5">Bebes</option>' +
                        '</optgroup>' +
                    '</select>' +
                '</div>' + // end .options-categoria
            '</div>' +
            // radiobutton precio / popularidad
            '<div class="f_orderby">' +
                '<h4 class="desplegable-orderby">Ordenar⬇️</h4>' +
                '<div class="radio-precio" style="display: none;">' +
                    '<b>Ordenar por precio</b> <br>' +
                    '<input type="radio" name="orderby" value="maymen" class="filtro_precio">De mayor a menor precio</br>' +
                    '<input type="radio" name="orderby" value="menmay" class="filtro_precio">De menor a mayor precio</br>' +
                '</div>' + // end .radio-precio
                '<div class="radio-visitas" style="display: none;">' +
                    '<br> <b>Ordenar por popularidad</b> <br>' +
                    '<input type="radio" name="orderby" value="maymen" class="filtro_visitas">De mayor a menor popularidad</br>' +
                    '<input type="radio" name="orderby" value="menmay" class="filtro_visitas">De menor a mayor popularidad</br>' +
                '</div>' + // end .radio-visitas
            '</div>' +
            // checkbox equipo (dinamico)
            '<div class="f_equipo">' +
                '<h4 class="desplegable-equipo">Equipo⬇️</h4>' +
                '<div class="checkbox-equipo" style="display: none;">' +
                    // checkboxes pintados dinamicamente en la función loadEquipos
                '</div>' + // end .checkbox-equipo
            '</div>' + // end .f_equipo
            // select marca
            '<div class="f_marca">' +
                '<h4 class="desplegable-marca">Marca⬇️</h4>' +
                '<div class = "options-marca">' +
                    '<select class="filtro_marca" name="select_marca" id="select_marca">' +
                        '<optgroup label="Marcas">' +
                            '<option value="0" disabled selected>Selecciona una marca</option>' +
                            '<option value="1">Puma</option>' +
                            '<option value="2">Adidas</option>' +
                            '<option value="3">Nike</option>' +
                            '<option value="4">Jordan</option>' +
                            '<option value="5">Reebok</option>' +
                            '<option value="6">Luanvi</option>' +
                            '<option value="7">Spalding</option>' +
                            '<option value="8">Wilson</option>' +
                            '<option value="9">Tenth</option>' +
                            '<option value="10">Joma</option>' +
                            '<option value="11">Under Armour</option>' +
                            '<option value="12">Molten</option>' +
                            '<option value="13">New Era</option>' +
                            '<option value="1200">Kipsta</option>' +
                            '<option value="1201">New Balance</option>' +
                            '<option value="1202">Champion</option>' +
                            '<option value="1203">Hummel</option>' +
                        '</optgroup>' +
                    '</select>' +
                '</div>' + // end .select_marca
            '</div>' + // end .f_marca
            // select ciudad
            '<div class="f_ciudad">' +
                '<h4 class="desplegable-ciudad">Ciudad⬇️</h4>' +
                '<div class = "options-ciudad">' +
                    '<select class="filtro_ciudad" name="select_ciudad" id="select_ciudad">' +
                        '<optgroup label="Ciudades">' +
                            '<option value="0" disabled selected>Selecciona una ciudad</option>' +
                            '<option value="Ontinyent, Valencia">Ontinyent, Valencia</option>' +
                            '<option value="Vallada, Valencia">Vallada, Valencia</option>' +
                            '<option value="Madrid">Madrid</option>' +
                            '<option value="Barcelona">Barcelona</option>' +
                            '<option value="Sevilla">Sevilla</option>' +
                            '<option value="Valencia">Valencia</option>' +
                            '<option value="A Coruna, La Coruna">A Coruna, La Coruna</option>' +
                            '<option value="Malaga">Malaga</option>' +
                            '<option value="Palma, Mallorca">Palma, Mallorca</option>' +
                            '<option value="Santa Cruz de Tenerife">Santa Cruz de Tenerife</option>' +
                            '<option value="Maspalomas, Canarias">Maspalomas, Canarias</option>' +
                            '<option value="Cordoba">Cordoba</option>' +
                            '<option value="Alicante, Valencia">Alicante, Valencia</option>' +
                            '<option value="Vigo">Vigo</option>' +
                            '<option value="Murcia">Murcia</option>' +
                            '<option value="Zaragoza">Zaragoza</option>' +
                            '<option value="Salamanca">Salamanca</option>' +
                            '<option value="Albacete">Albacete</option>' +
                            '<option value="La Colilla">La Colilla</option>' +
                            '<option value="Bilbao">Bilbao</option>' +
                            '<option value="Granada">Granada</option>' +
                            '<option value="Toledo">Toledo</option>' +
                            '<option value="Monaco">Monaco</option>' +
                        '</optgroup>' +
                    '</select>' +
                '</div>' + // end .options-ciudad
            '</div>' + // end .f_ciudad
            '<div id="overlay">' +
            '<div class= "cv-spinner" >' +
            '<span class="spinner"></span>' +
            '</div >' +
            '</div > ' +
            '</div>' +
            '</div>' +
            '<p> </p>' +
            '<button class="boton_filtrar button_spinner" id="Button_filter">Filtrar</button>' +
            '<button class="boton_remover" id="Remove_filter">Remover filtros</button>' +
            '<button class="boton_mapa" id="goToMap"> Viajar al mapa de productos </button>'
        
        );
    // funciones de clic en los botones y titulos

    // boton filtrar
    $(document).on('click', '.boton_filtrar', function() {
        botones_filtros();
    });
    // boton remover filtros
    $(document).on('click', '.boton_remover', function() {
        eliminar_filtros();
    });
    // boton para desplazarse al mapa
    $(document).on('click', '.boton_mapa', function() {
        document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
    });
    // desplegable tipo
    $(document).on('click', '.desplegable-tipo', function(){
        $('.options-tipo').slideToggle();
    });
    // desplegable categoria
    $(document).on('click', '.desplegable-categoria', function(){
        $('.options-categoria').slideToggle();
    });
    // desplegable precio
    $(document).on('click', '.desplegable-orderby', function(){
        $('.radio-precio').slideToggle();
        $('.radio-visitas').slideToggle();
    });
    // desplegable equipo
    $(document).on('click', '.desplegable-equipo', function(){
        $('.checkbox-equipo').slideToggle();
    });
    // desplegable marca
    $(document).on('click', '.desplegable-marca', function(){
        $('.options-marca').slideToggle();
    });
    // desplegable ciudad
    $(document).on('click', '.desplegable-ciudad', function(){
        $('.options-ciudad').slideToggle();
    });
    // desplegable popularidad
    $(document).on('click', '.desplegable_visitas', function(){
        $('.radio-visitas').slideToggle();
    });
} // end print_filtros (mostrar los filtros en la página)

function eliminar_filtros() {
    localStorage.removeItem('filtro');
    localStorage.removeItem('filtro_tipo');
    localStorage.removeItem('filtro_categoria');
    localStorage.removeItem('filtro_precio');
    localStorage.removeItem('filtro_equipo');
    localStorage.removeItem('filtro_marca');
    localStorage.removeItem('buscar');
    localStorage.removeItem('filtro_ciudad');
    localStorage.removeItem('pagina');
    localStorage.removeItem('items');
    localStorage.removeItem('filtro_visitas');
    $("#nofiltros").empty();
    $("#texto-nofiltros").empty();
    location.reload();
    if(!localStorage.getItem('filtro')){
        ajaxForSearch("index.php?module=shop&op=getall");
        highlight();
    }
} // end eliminar_filtros (se ejecuta al pulsar en el boton remover filtros)

function eliminar_filtros_filtrar(){
    localStorage.removeItem('filtro');
    localStorage.removeItem('filtro_tipo');
    localStorage.removeItem('filtro_categoria');
    localStorage.removeItem('filtro_precio');
    localStorage.removeItem('filtro_equipo');
    localStorage.removeItem('filtro_marca');
    localStorage.removeItem('buscar');
    localStorage.removeItem('filtro_ciudad');
    localStorage.removeItem('pagina');
    localStorage.removeItem('items');
    localStorage.removeItem('filtro_visitas');
} // end eliminar_filtros_filtrar

function getall(total_productos, items_por_pagina) {
    var filtro = JSON.parse(localStorage.getItem('filtro'));
    // console.log("getall filtros: " + filtro)
    // console.log("getall total_productos: ", total_productos)
    // console.log("getall items por pagina: ", items_por_pagina)
    // return false;
    if (filtro) { // cargar list del shop con los filtros seleccionados
        // console.log("getall yes filtro")
        var filtroequipo = filtro.find(f => f[0] === 'equipo');
        if (filtroequipo && filtroequipo[1].length === 0) {
            filtro = filtro.filter(f => f[0] !== 'equipo');
            localStorage.setItem('filtro', JSON.stringify(filtro));
        }
        ajaxForSearch("index.php?module=shop&op=filtrar", filtro, total_productos, items_por_pagina);
    } else { // cargar list del shop sin filtros
        // console.log("getall no filtro")
        ajaxForSearch("index.php?module=shop&op=getall");
    }
} // end getall

function highlight(){
    // console.log("hola highlight");

    var all_filtros = JSON.parse(localStorage.getItem('filtro'));

    if (all_filtros) {
        for (var i = 0; i < all_filtros.length; i++) {
            var filtroTipo = all_filtros[i][0];
            var filtroValor = all_filtros[i][1];

            if (filtroTipo === 'tipo' && filtroValor != '*') {
                document.getElementById('select_tipo').value = filtroValor;
            }

            if (filtroTipo === 'categoria' && filtroValor != '*') {
                document.getElementById('select_categoria').value = filtroValor;
            }

            if (filtroTipo === 'precio' && filtroValor != '*') {
                document.querySelector(`input[name="orderby"][value="${filtroValor}"]`).setAttribute('checked', true);
            }

            if (filtroTipo === 'equipo' && filtroValor.length > 0) {
                for (var j = 0; j < filtroValor.length; j++) {
                    document.getElementById(filtroValor[j]).setAttribute('checked', true);
                }
            }

            if (filtroTipo === 'marca' && filtroValor != '*') {
                document.getElementById('select_marca').value = filtroValor;
            }

            if (filtroTipo === 'ciudad' && filtroValor != '*') {
                document.getElementById('select_ciudad').value = filtroValor;
            }

            if (filtroTipo === 'visitas' && filtroValor != '*') {
                document.querySelector(`input[name="orderby"][value="${filtroValor}"]`).setAttribute('checked', true);
            }
        }
    }
} // end highlight (dejar marcados los filtros aplicados)

function botones_filtros(){
    // filtros de tipos
    $('.filtro_tipo').change(function (){
        localStorage.setItem('filtro_tipo', this.value);
    });
    if(localStorage.getItem('filtro_tipo')){
        // console.log(localStorage.getItem('filtro_tipo'));
        // return false;
        $('.filtro_tipo').val(localStorage.getItem('filtro_tipo'));
    }
    // filtro de categoria
    $('.filtro_categoria').change(function (){
        localStorage.setItem('filtro_categoria', this.value);
    });
    if(localStorage.getItem('filtro_categoria')){
        $('.filtro_categoria').val(localStorage.getItem('filtro_categoria'));
        // console.log($('.filtro_categoria').val(localStorage.getItem('filtro_categoria')))
        // return false;
    }
    // filtro de precio
    $('.filtro_precio').change(function (){
        localStorage.removeItem('filtro_visitas'); // eliminar filtro de visitas para evitar conflictos con el highlight
        localStorage.setItem('filtro_precio', this.value);
    });
    if(localStorage.getItem('filtro_precio')){
        $('.filtro_precio').each(function() {
            if ($(this).val() === localStorage.getItem('filtro_precio')) {
                $(this).prop('checked', true);
            }
        });
    }
    // filtro de equipo
    $(document).on('change', '.filtro_equipo', function(){
        var equipo = [];
        $.each($("input[class='filtro_equipo']:checked"), function() {
            equipo.push($(this).val());
        });
        localStorage.setItem('filtro_equipo', JSON.stringify(equipo));
    });
    if(localStorage.getItem('filtro_equipo')){
        var equipo = JSON.parse(localStorage.getItem('filtro_equipo'));
        $.each(equipo, function(index, value) {
            $("input[class='filtro_equipo'][value='" + value + "']").prop('checked', true);
        });
    }
    // filtros de marca
    $('.filtro_marca').change(function (){
        localStorage.setItem('filtro_marca', this.value);
    });
    if(localStorage.getItem('filtro_marca')){
        // console.log(localStorage.getItem('filtro_marca'));
        // return false;
        $('.filtro_marca').val(localStorage.getItem('filtro_marca'));
    }
    // filtros de ciudad
    $('.filtro_ciudad').change(function (){
        localStorage.setItem('filtro_ciudad', this.value);
    });
    if(localStorage.getItem('filtro_ciudad')){
        // console.log(localStorage.getItem('filtro_ciudad'));
        // return false;
        $('.filtro_ciudad').val(localStorage.getItem('filtro_ciudad'));
    }
    // filtro de popularidad
    $('.filtro_visitas').change(function (){
        localStorage.removeItem('filtro_precio'); // eliminar filtro de precio para evitar problemas con el highlight
        localStorage.setItem('filtro_visitas', this.value);
    });
    if(localStorage.getItem('filtro_visitas')){
        $('.filtro_visitas').each(function() {
            if ($(this).val() === localStorage.getItem('filtro_visitas')) {
                $(this).prop('checked', true);
            }
        });
    }

    $(document).on('click', '.boton_filtrar', function(){

        // eliminar filtros si su valor es 0 para evitar conflictos al filtrar

        // categoria
        if(localStorage.getItem('filtro_categoria') === '0'){
            localStorage.removeItem('filtro_categoria');
        }
        // tipo
        if(localStorage.getItem('filtro_tipo') === '0'){
            localStorage.removeItem('filtro_tipo');
        }
        // ciudad
        if(localStorage.getItem('filtro_ciudad') === '0'){
            localStorage.removeItem('filtro_ciudad');
        }

        // almacenar filtros seleccionados en localstorage

        var filtro = [];
        // tipo
        if(localStorage.getItem('filtro_tipo')){
            filtro.push(['tipo', localStorage.getItem('filtro_tipo')])
        }
        // categoria
        if(localStorage.getItem('filtro_categoria')){
            filtro.push(['categoria', localStorage.getItem('filtro_categoria')])
        }
        // precio
        if(localStorage.getItem('filtro_precio')){
            filtro.push(['precio', localStorage.getItem('filtro_precio')])
        }
        // equipo
        if(localStorage.getItem('filtro_equipo')){
            var equipo = JSON.parse(localStorage.getItem('filtro_equipo'));
            if (equipo.length > 0) {
                filtro.push(['equipo', equipo]);
            } else {
                localStorage.removeItem('filtro_equipo');
            }
        }
        // marca
        if(localStorage.getItem('filtro_marca')){
            filtro.push(['marca', localStorage.getItem('filtro_marca')])
        }
        // ciudad
        if(localStorage.getItem('filtro_ciudad')){
            filtro.push(['ciudad', localStorage.getItem('filtro_ciudad')])
        }
        // popularidad
        if(localStorage.getItem('filtro_visitas')){
            filtro.push(['visitas', localStorage.getItem('filtro_visitas')])
        }

        localStorage.setItem('filtro', JSON.stringify(filtro));
        localStorage.removeItem('pagina');

        if(filtro.length > 0){
            paginacion();
            ajaxForSearch("index.php?module=shop&op=filtrar", filtro);
        }else{
            paginacion();
            ajaxForSearch("index.php?module=shop&op=getall");
        }

        highlight();
        highlight_buscador(); // funcion en ctrl_search.js
    });
} // end botones_filtros (aplicar los filtros al pulsar sobre el boton filtrar)

function update_visitas(id_producto){
    // console.log("hola update_visitas")
    // console.log("update_visitas: id_producto:\n", id_producto)
    // return false;
    ajaxPromise('index.php?module=shop&op=update_visitas', 'POST', 'JSON', {'id_producto': id_producto})
        // .then(function(id){
        //     console.log("update_visitas id ctrl php:\n", id);
        // });
} // end update_visitas (sumar una visita al entrar al details de un producto)

function update_rating(id_producto, rating){
    // console.log("hola update_rating")
    // console.log("update_rating: id_producto:\n", id_producto)
    // console.log("update_rating: rating seleccionado:\n", rating)
    // return false;
    ajaxPromise('index.php?module=shop&op=update_rating', 'POST', 'JSON', {'id_producto': id_producto, 'rating': rating})
        // .then(function(rating){
        //     console.log("update_rating valor del ctrl php:\n", rating);
        // });
}

function update_visitas_categoria(id_categoria){
    // console.log("hola update_visitas_categoria")
    // console.log("update_visitas_categoria: categoria seleccionada:\n", id_categoria)
    // return false;
    var filtro = [];
    ajaxPromise('index.php?module=shop&op=update_visitas_categoria', 'POST', 'JSON', {'id_categoria': id_categoria})
        // .then(function(rating){
        //     console.log("update_rating valor del ctrl php:\n", rating);
        // });
    setTimeout(function(){
        eliminar_filtros_filtrar();
        localStorage.setItem('filtro_categoria', id_categoria);
        if(localStorage.getItem('filtro_categoria')){
            filtro.push(['categoria', localStorage.getItem('filtro_categoria')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));
        window.location.href = friendlyURL("?module=shop");
        // botones_filtros();
        // location.reload();
        // loadShop();
    }, 1000);
} // end update_visitas_categoria

function update_visitas_tipo(id_tipo){
    // console.log("hola update_visitas_tipo")
    // console.log("update_visitas_tipo: tipo seleccionado:\n", id_tipo)
    // return false;
    var filtro = [];
    ajaxPromise('index.php?module=shop&op=update_visitas_tipo', 'POST', 'JSON', {'id_tipo': id_tipo})
        // .then(function(rating){
        //     console.log("update_rating valor del ctrl php:\n", rating);
        // });
    setTimeout(function(){
        eliminar_filtros_filtrar();
        localStorage.setItem('filtro_tipo', id_tipo);
        if(localStorage.getItem('filtro_tipo')){
            filtro.push(['tipo', localStorage.getItem('filtro_tipo')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));
        window.location.href = friendlyURL("?module=shop");
        // botones_filtros();
        // location.reload();
        // loadShop();
    }, 1000);
} // end update_visitas_tipo

function loadProductoDetails(id_producto){
    // console.log("hola loadProductoDetails");
    localStorage.removeItem('details_home');
    localStorage.removeItem('id_producto');
    // return false;
    update_visitas(id_producto);
    localStorage.removeItem('items');
    ajaxPromise('index.php?module=shop&op=details', 'POST', 'JSON', {'id_producto': id_producto})
    .then(function(shop){
        $('.container-productos').empty(); // vaciar todos los productos para dejar la web vacia y pintar el details
        $('.container-filtros').empty(); // vaciar los filtros para que no aparezcan en el details
        $('.pimg').empty();
        $('.inf-producto').empty();
        $('#paginacion').empty();
        $('.down-details').empty();
        // console.log(shop);
        // return false;
        leafleft(shop[0][0], 16);
        for (row in shop[1][0]) {
            $('<div></div>').attr({ 'id': shop[1][0].id_pimg, class: 'pimg' }).appendTo('.productos_img')
                .html(
                    "<div class='content-img-details'>" +
                    "<img src= '"+ PRODUCT_IMAGES + shop[1][0][row].pimage_route + "'" + "</img>" +
                    "</div>" // end .content-img-details
                )
        }

        // Owl Carousel
        $('.productos_img').owlCarousel({
            items: 1,
            nav :true,
            navText: [
                '<button class="owl-prev">⟨</button>',
                '<button class="owl-next">⟩</button>'
            ]
        });

        $('<div></div>').attr({ class: 'cat_tip_details' }).appendTo('.down-details')
                .html(
                    "<a class='text-cat_tip' style='color:green; font-weight:bolder;'>Relacionado con este producto</a>" +
                    "<br>" +
                    "<a class='cat_rel_details' style='cursor:pointer;'>" + shop[0][0].categoria + "</a>" +
                    "<br>" +
                    "<a class='tipo_rel_details' style='cursor:pointer;'>" + shop[0][0].tipo + "</a>"
                );

        // console.log(shop[0][0]);
        // return false;
        let extra_entrega = "";
        if(shop[0][0].entrega === 'domicilio'){
            extra_entrega = "<i class='fa-solid fa-truck fa-2xl extra-icons' style='color: #077bd5;'></i>";
        }else if(shop[0][0].entrega === 'persona'){
            extra_entrega = "<i class='fa-solid fa-person fa-2xl' style='color: #077bd5;'></i>";
        } // pintar el camion si la entrega es a domicilio, o la persona si la entrega es en persona
        let nom_equipo = "";
        if (shop[0][0].nom_team !== null) {
            nom_equipo = "<p class='team-details'>" + shop[0][0].nom_team + "</p>";
        } // si el producto tiene equipo lo pinta, de lo contrario no pinta nada
            $('<div></div>').attr({'id': shop[0][0].id_producto, class: 'inf-producto-details'}).appendTo('.inf-details')
                .html(
                    "<style>" +
                    "#map{margin-top:3%;}" +
                    "</style>" +
                    "<div class='inf-prod'>" +
                    // estrellas de valoración
                    "<div class='estrellas-rating'>" +
                        "<div class='estrella'>★</div>" +
                        "<div class='estrella'>★</div>" +
                        "<div class='estrella'>★</div>" +
                        "<div class='estrella'>★</div>" +
                        "<div class='estrella'>★</div>" +
                    "</div>" + // end .estrellas-rating
                    // end estrellas de valoración
                    "<div class='user_details'>" +
                        "<img class='img_user_details' src='" + shop[0][0].avatar + ">" +
                        "<a class='nom_user_details'>" + shop[0][0].username + "</a>" +
                    "</div>" + // end .user_details
                    "<h3>" + shop[0][0].nom_prod + "</h3>" +
                    "<a class='details_like' id='" + shop[0][0].id_producto + "'>" + 
                        "<i id=" + shop[0][0].id_producto + " class='fa-solid fa-heart fa-lg'></i>" + 
                    "</a>" + // end .details_like
                    "<span class='count-likes'>" + shop[0][0].likes + "</span>" +
                    "<p class='precio-details'>" + shop[0][0].precio + "€</p>" +
                    "<p class='marca-details'>" + shop[0][0].nom_marca + "</p>" +
                    "<p class='sexo-details'>" + shop[0][0].sexo_prod + "</p>" +
                    "<p class='tipo-details'>" + shop[0][0].tipo + "</p>" +
                    nom_equipo +
                    "<p class='talla-details'>" + shop[0][0].talla + "</p>" +
                    "<b class='letrero-condicion-details'>Condición del producto</b>" +
                    "<a class='condicion-details'> &nbsp;" + shop[0][0].condicion + "</a>" +
                    "<p class='color-details'>" + shop[0][0].color + "</p>" +
                    "<p class='desc-details'>" + shop[0][0].descripcion + "</p>" +
                    "<p class='stock-details'>Hay " + shop[0][0].stock + " unidades disponibles</p>" +
                    "<p class='entrega-details'>" + shop[0][0].entrega + "</p>" +
                    "<br>" +
                    // "<p class='rating-details'>" +
                    //     "<a class='text-rating' style='color:green; font-weight:bolder;'>Evalua este producto del 1 al 5 siendo 5 lo mejor y 1 lo peor</a>" +
                    //     "<br>" +
                    //     '<select class="rating_select" name="select_rating" id="select_rating">' +
                    //     '<optgroup label="Valoración">' +
                    //         '<option value="1">1</option>' +
                    //         '<option value="2">2</option>' +
                    //         '<option value="3">3</option>' +
                    //         '<option value="4">4</option>' +
                    //         '<option value="5">5</option>' +
                    //     '</optgroup>' +
                    // '</select>' +
                    // "</p>" + // end .rating-details
                    "<div class='extras-details'>" +
                    "<div class='icon-container-details'>" +
                    "<p class='entrega-icon-details'>" + extra_entrega + "</p>" +
                    "</div>" + // end .icon-container (truck)
                    "<div class='icon-container-details'>" +
                    "<p class='paypal-icon-details'> <i class='fa-brands fa-paypal fa-2xl' style='color: #077bd5;'></i> </p>" +
                    "</div>" + // end .icon-container (paypal)
                    "<div class='icon-container-details'>" +
                    "<p class='creditcard-icon-details'> <i class='fa-solid fa-credit-card fa-2xl' style='color: #077bd5;'></i> </p>" +
                    "</div>" + // end .icon-container (credit-card)
                    "<div class='icon-container-details'>" +
                    "<p class='gpay-icon-details'> <i class='fa-brands fa-google-pay fa-2xl' style='color: #077bd5;'></i> </p>" +
                    "</div>" + // end .icon-container (google-pay)
                    "<div class='icon-container-details'>" +
                    "<p class='applepay-icon-details'> <i class='fa-brands fa-apple-pay fa-2xl' style='color: #077bd5;'></i> </p>" +
                    "</div>" + // end .icon-container (apple-pay)
                    "<div class='icon-container-details-location'>" +
                    "<p class='location-icon-details'> <i class='fa-solid fa-location-dot fa-2xl' style='color: #077bd5;'></i>" + shop[0][0].ciudad + "</p>" +
                    "</div>" + // end .icon-container (location)
                    "</div>" + // end .extras-details
                    "</div>" // end .inf-prod
                ) // end .html
            // console.log("loadProductoDetails:\nTipo: ", shop[0][0].id_tipo)
            // return false;
            // console.log('loadProductoDetails despues del html dinámico');
            // return false;
            mas_productos_relacionados(shop[0][0].id_tipo, id_producto);

            // $('.rating_select').change(function (){
            //     update_rating(id_producto, this.value);
            // });

            $(document).on("click", '.cat_rel_details', function(){
                update_visitas_categoria(shop[0][0].id_categoria);
            });

            $(document).on("click", '.tipo_rel_details', function(){
                update_visitas_tipo(shop[0][0].id_tipo);
            });

            pintar_estrellas(shop[0][0].rating);

            estrellas_rating(id_producto);

            load_likes_user();
    }).catch(function(){
        console.error('ERROR loadProductoDetails');
        return false;
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadProductoDetails (vista del detalle de los productos)

function pintar_estrellas(rating) {
    var estrellas = document.querySelectorAll('.estrella');
    estrellas.forEach(function (estrella, i) {
        if (i < rating) {
            estrella.style.color = 'orangered'; // pintar hasta la estrella que tenga el atributo rating
        } else {
            estrella.style.color = 'black'; // dejar las demas estrellas de color negro
        }
    });
} // end pintar_estrellas

function estrellas_rating(id_producto) {
    var estrellas = document.querySelectorAll('.estrella');
    var estrella_click = -1; // última estrella seleccionada

    var clickHandler = function () {
        var index = Array.from(estrellas).indexOf(this); // obtener la estrella pulsada
        estrella_click = index; // guardar la estrella pulsada
        estrellas.forEach(function (estrella, i) {
            if (i <= index) {
                estrella.style.color = 'orangered'; // pintar de naranja de la primera hasta la estrella pulsada
            } else {
                estrella.style.color = 'black'; // pintar de negro las estrellas no pulsadas
            }
        });
        update_rating(id_producto, index + 1); // guardar la estrella pulsada como rating en la bd (se suma uno ya que el indice empieza por 0)
    };

    var mouseOverHandler = function () { // manejar el puntero sobre una estrella
        var index = Array.from(estrellas).indexOf(this); // obtener en que estrella esta el puntero
        estrellas.forEach(function (estrella, i) {
            if (i <= index) {
                estrella.style.color = 'orangered'; // pintar desde la primera estrella hasta la pulsada
            } else {
                estrella.style.color = 'black'; // pintar de negro las estrellas no seleccionadas
            }
        });
    };

    var mouseLeaveHandler = function () { // manejar cuando el puntero sale de las estrellas
        estrellas.forEach(function (estrella, i) {
            if (i <= estrella_click) {
                estrella.style.color = 'orangered'; // pintar de naranja las estrellas seleccionadas
            } else {
                estrella.style.color = 'black'; // pintar de negro las estrellas no seleccionadas
            }
        });
    };

    estrellas.forEach(function (estrella) {
        estrella.addEventListener('click', clickHandler);
        estrella.addEventListener('mouseover', mouseOverHandler);
        estrella.addEventListener('mouseleave', mouseLeaveHandler);
    });
} // end estrellas_rating (controlar las estrellas de las valoraciones del details)

function productos_relacionados(loadeds = 0, total_productos, tipo, id_producto){
    // console.log("hola productos relaconados")
    // console.log("productos_relacionados id producto: ", id_producto)
    // return false;
    let prelacionados_visibles = 3;
    let loaded = loadeds;
    let tipo_producto = tipo;
    let total_producto = total_productos;
    // console.log("productos relacionados:\nPrelacionados_visibles: ", prelacionados_visibles +"\nLoaded: ", loaded + "\nTipo_producto: ", tipo_producto + "\nTotal_producto: ", total_producto)
    // return false;

    ajaxPromise("index.php?module=shop&op=productos_relacionados", 'POST', 'JSON', { 'tipo_producto': tipo_producto, 'loaded': loaded, 'items': prelacionados_visibles, 'id_producto': id_producto })
        .then(function(data) {
            // console.log("productos relacionads data:\n", data)
            // return false;
            if (loaded == 0) { // cargar los primeros 3 productos relacionados
                $('<div></div>').attr({ 'id': 'productos_relacionados', class: 'productos_relacionados' }).appendTo('.titulo-productos-relacionados')
                    .html(
                        '<h2 class="title-prelacionados">Productos relacionados</h2>'
                    ) // añadir el titulo de productos relacionados
                for (row in data) { // cargar los productos relacionados
                        if (data[row].id_producto != undefined) {
                            $('<div></div>').attr({ 'id': data[row].id_producto, 'class': 'producto_relacionado' }).appendTo('.cargar-prelacionados')
                                .html(
                                    "<li class='prelacionado-producto'>" +
                                    "<div class='prelacionado-item'>" +
                                    "<div class='prelacionado-img'>" +
                                    "<img src = "+ PRODUCT_IMAGES + data[row].img_producto + " alt='imagen producto' </img> " +
                                    "</div>" +
                                    "<h5> <b>" + data[row].nom_marca + "</b> <br><br> " + data[row].nom_prod + "</h5>" +
                                    "<h5><a class='prelacionado-precio'>" + data[row].precio + "€</a></h5>" +
                                    "</div>" +
                                    "</li>"
                                )
                        }
                }
                $('<div></div>').attr({ 'id': 'mas_productos_boton', 'class': 'mas_productos_boton' }).appendTo('.boton-cargar-mas-productos')
                    .html(
                        '<button class="cargar_mas_productos" id="load_more_button">Cargar mas productos</button>'
                    )
            }
            if (loaded >= 3) { // cargar los demas productos al darle al boton de cargar mas productos relacionados
                for (row in data) { // cargar los productos relacionados
                        if (data[row].id_producto != undefined) {
                            $('<div></div>').attr({ 'id': data[row].id_producto, 'class': 'producto_relacionado' }).appendTo('.cargar-prelacionados')
                                .html(
                                    "<li class='prelacionado-producto'>" +
                                    "<div class='prelacionado-item'>" +
                                    "<div class='prelacionado-img'>" +
                                    "<img src = "+ PRODUCT_IMAGES + data[row].img_producto + " alt='imagen producto' </img> " +
                                    "</div>" +
                                    "<h5> <b>" + data[row].nom_marca + "</b> <br><br> " + data[row].nom_prod + "</h5>" +
                                    "<h5><a class='prelacionado-precio'>" + data[row].precio + "€</a></h5>" +
                                    "</div>" +
                                    "</li>"
                                )
                        }
                }
                var total_prod = total_producto - 3;
                if (total_prod <= loaded) {
                    $('.mas_productos_boton').empty();
                    $('<div></div>').attr({ 'id': 'mas_productos_boton', 'class': 'mas_productos_boton' }).appendTo('.boton-cargar-mas-productos')
                        .html(
                            "</br><button class='no_mas_productos' id='no_mas_productos'>No hay mas productos para cargar</button>"
                        ) // añadir el boton de que no hay más productos para cargar
                } else {
                    $('.mas_productos_boton').empty();
                    $('<div></div>').attr({ 'id': 'mas_productos_boton', 'class': 'mas_productos_boton' }).appendTo('.boton-cargar-mas-productos')
                        .html(
                            '<button class="cargar_mas_productos" id="load_more_button">Cargar más productos</button>'
                        ) // añadir el boton de cargar más productos
                }
            }
        }).catch(function() {
            console.error("productos_relacionados ERROR productos_relacionados");
            return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end productos_relacionados (cargar los productos relacionados)

function mas_productos_relacionados(tipo, id_producto){
    // console.log("hola mas productos relacionados")
    // console.log(tipo)
    // console.log("mas_productos_relacionados id producto: ", id_producto)
    // return false;
    var tipo_producto = tipo;
    let items = 0;
    ajaxPromise("index.php?module=shop&op=count_productos_relacionados", "POST", "JSON", {"tipo": tipo_producto, "id_producto": id_producto})
        .then(function(data){
            // console.log("mpr id: ", data)
            // return false;
            var total_productos = data[0].contador;
            // console.log("Mas productos relacionados:\nTotal_productos: ", total_productos, "\nTipo: ", tipo_producto)
            // return false;
            productos_relacionados(0, total_productos, tipo, id_producto);

            $(document).off("click", ".cargar_mas_productos"); // eliminar eventos anteriores

            $(document).on("click", '.cargar_mas_productos', function(){
                items += 3;
                localStorage.setItem('items', items);
                // $('.mas_productos_boton').empty();
                productos_relacionados(items, total_productos, tipo, id_producto);
            });
        }).catch(function(){
            console.error("mas_productos_relacionados ERROR total_productos");
            return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        })
} // end mas_productos_relacionados (calcular el nº de productos relacionados)

function loadDetails() {
    // cargar details desde el producto
    $(document).on("click", ".click-producto", function() {
        var id_producto = this.getAttribute('id');
        loadProductoDetails(id_producto);
    });
    // cargar details desde el mapa
    $(document).on("click", ".product_popup", function() {
        var id_producto = this.getAttribute('id');
        loadProductoDetails(id_producto);
    });
    // cargar details desde productos relacionados
    $(document).on("click", ".producto_relacionado", function(){
        console.log("click producto relacionado")
        // return false;
        localStorage.removeItem('items'); // eliminar el items de localstorage para que al hacer click en cargar más productos solamente cargue 3 productos
        var id_producto = this.getAttribute('id');
        $('.productos_img').owlCarousel('destroy'); // destruir owl carousel para volver a cargar el nuevo
        $('.titulo-productos-relacionados').empty();
        $('.cargar-prelacionados').empty();
        $('.boton-cargar-mas-productos').empty();
        $('.inf-details').empty();
        $('.productos_img').empty();
        loadProductoDetails(id_producto);
    });
} // end loadDetails (cargar la vista del details al pulsar sobre uno de los lugares especificados)

function leafleft(shop, zoom){
    // console.log("leafleft shop: ", shop);
    // return false;

    // console.log("leafleft map");
    
    $('#map').remove();
    $('<div id="map"></div>').appendTo('.mapLeafleft');
    
    // if (!document.getElementById('map')) {
    //     console.log("leafleft NO ID MAP");
    //     return false;
    // } else {
    //     console.log("leafleft SI ID MAP");
    // }

    try{
        // var map = L.map('map').setView([38.821, -0.610547], 15);
        var map = L.map('map').setView([shop.altitud || 40.41664790865264, shop.longitud || -3.70093721305357], zoom);
    }catch (error){
        console.error("ERROR AL INICIALIZAR EL MAPA");
        return false;
    }
    console.log("leafleft mapa inicializado")

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    
    if(Array.isArray(shop)){ // cargar el mapa si lo que llega es un array (list del shop)
        console.log("leafleft ARRAY");
        // return false;
        for (row in shop){
            var mapicon = L.icon({ // añadir la imagen del marcador
                iconUrl: WEB_LOGO_IMG + 'favicon.png',
                iconSize: [50, 50],
                iconAnchor: [50, 50],
                popupAnchor: [20, 20]
            });
            var marker = L.marker([shop[row].altitud, shop[row].longitud], {icon: mapicon}).addTo(map); // añadir la localización de cada producto
            var popup = marker.bindPopup( // añadir la información del popup para cada producto
                "<div class='product_popup' id='" + shop[row].id_producto + "'>" +
                "<p>" + shop[row].nom_prod + "</p>" +
                "<img src = '"+ PRODUCT_IMAGES + shop[row].img_producto + "' class='img_popup'>" +
                "</div>");
        }
    }else{ // cargar el mapa si lo que llega es solo un producto en vez de un array (details)
        console.log("leafleft NO ARRAY");
        // return false;
        var mapicon = L.icon({ // añadir la imagen del marcador
            iconUrl: WEB_LOGO_IMG + 'favicon.png',
            iconSize: [50, 50],
            iconAnchor: [50, 50],
            popupAnchor: [20, 20]
        });
        var marker = L.marker([shop.altitud, shop.longitud], {icon: mapicon}).addTo(map); // añadir la localización del producto
        var popup = marker.bindPopup( // añadir la informacion del popup para el producto
            "<div class='product_popup' id='" + shop.id_producto + "'>" +
            "<p>" + shop.nom_prod + "</p>" +
            "<img src = '"+ PRODUCT_IMAGES + shop.img_producto + "' class='img_popup'>" +
            "</div>"
        );
    }
} // end leafleft (mapa)

function load_buscador_shop(total_productos = 0, items_por_pagina = 3){
    // console.log("hola load_buscador");
    // console.log(total_productos);
    // console.log(items_por_pagina);
    // return false;
    var buscar = JSON.parse(localStorage.getItem('buscar'));
    // console.log({'datos buscador shop': buscar});
    // return false;
    if (total_productos != 0) {
        localStorage.setItem('total_prod', total_productos);
    } else {
        if (localStorage.getItem('total_prod')) {
            total_productos = localStorage.getItem('total_prod');
        } else {
            total_productos = 0;
        }
    }

    const pagina = localStorage.getItem('pagina') || 1;
    const offset = (pagina - 1) * items_por_pagina;

    const sdata = buscar 
        ? { 'buscar': buscar, 'offset': offset, 'limit': items_por_pagina } 
        : { 'offset': offset, 'limit': items_por_pagina };

    ajaxPromise('index.php?module=shop&op=filtro_buscador', 'POST', 'JSON', sdata)
        .then(function(buscador){
            // console.log(buscador)
            // return false;
            $('.container-productos').empty();
            $("#nofiltros").empty();
            $("#texto-nofiltros").empty();
            
            if(buscador == "error"){
                // console.log("load_buscador error")
                $('<div></div>').appendTo('.container-productos')
                    .html(
                        "<div class='nofiltrosdiv'>" +
                        "<img class='imgnofdiv' src="+ ICONS_IMG +"'no_productos.png'>" +
                        "<h1 id='nofiltros'>No se han encontrado productos con los filtros especificados</h1>" +
                        "<br>" +
                        "<p id='texto-nofiltros'>Pulse el boton 'remover filtros' para volver a la busqueda</p>" +
                        "</div>" // end .nofiltrosdiv
                    );
            }else{
                // console.log("load_buscador no error")
                    for (row in buscador) {
                        $("#nofiltros").empty();
                        $("#texto-nofiltros").empty();
                        $('.imgnofdiv').empty();
                        $('.nofiltrosdiv').empty();
                        $('<div></div>').attr('class', "producto").attr({'id': buscador[row].id_producto}).appendTo('.container-productos')
                            .html(
                                "<div class='click-producto' id='" + buscador[row].id_producto + "'>" +
                                    "<img src = "+ PRODUCT_IMAGES + buscador[row].img_producto + " alt='foto' </img> " +
                                    "<div class='inf-producto'>" +
                                        "<h3>" + buscador[row].nom_prod + "</h5>" +
                                        "<p class='precio'>" + buscador[row].precio + "€</p>" +
                                    "</div>" + // end .inf-producto
                                "</div>" + // end .click-producto
                                "<a class='list_like' id='" + buscador[row].id_producto + "'>" + 
                                    "<i id=" + buscador[row].id_producto + " class='fa-solid fa-heart fa-lg'></i>" + 
                                "</a>" + // end .details_like
                                "<span class='count-likes'>" + buscador[row].likes + "</span>"
                            ); // end .html
                    }
                    paginacion();
                    click_buscador();
                    leafleft(buscador, 6);
                    highlight();
                    botones_filtros();
                    load_likes_user();
                    // animacion del producto al que se da like cuando no estas logeado
                    if(localStorage.getItem('id_producto')){
                        var id = "#" + localStorage.getItem('id_producto');
                        $("html, body").animate({scrollTop: $(id).offset().top}, 1000, function(){
                            $(id).animate({ marginTop: "-20px" }, 200)
                                .animate({ marginTop: "0px" }, 200);
                        });
                        localStorage.removeItem('id_producto');
                    }
            }
        }).catch(function(){
            console.error('ERROR load_buscador_shop');
            return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end load_buscador_shop (cargar los productos del list del shop al filtrar por el buscador)

function click_buscador(){
    $(document).on('click', '#boton_buscar', function(){
        paginacion();
    });
} // end click_buscador (calcular nº paginas al filtrar por el buscador)

function scrollOnTop(){
    $('.sot').append(
        '<button class="sotButton">Volver arriba</button>'
    )
    $(document).on("click", ".sotButton", function() {
        window.scrollTo(0, 0);
    });
} // end scrollOnTop (situarse en la parte de arriba del todo de la página)

function paginacion() {
    console.log("hola paginacion")
    // return false;
    let url = '';
    let sdata = {};

    if (localStorage.getItem('filtro')) {
        const filtro = JSON.parse(localStorage.getItem('filtro'));
        url = 'index.php?module=shop&op=count_productos_filtros';
        sdata = { 'filtro': filtro };
    } else if (localStorage.getItem('buscar')) {
        const buscar = JSON.parse(localStorage.getItem('buscar'));
        url = 'index.php?module=shop&op=count_buscador';
        sdata = { 'buscar': buscar };
    }else {
        url = 'index.php?module=shop&op=count_productos_all';
    }

    ajaxPromise(url, 'POST', 'JSON', sdata)
        .then(function(data) {
            const total_productos = data[0]?.contador || 0; // Número total de productos
            const items_por_pagina = 3; // Número de productos por página
            const total_paginas = Math.ceil(total_productos / items_por_pagina);

            console.log("Total_productos: ", total_productos, " Items por pagina: ", items_por_pagina, " Total paginas: ", total_paginas)
            // return false;

            // Generar los botones de paginación
            generarBotonesPaginacion(total_paginas, items_por_pagina, total_productos);
        })
        .catch(function(error) {
            console.error('Error en la paginación:', error);
        });
} // end paginacion

function generarBotonesPaginacion(total_paginas, items_por_pagina, total_productos) {
    console.log("hola generarBotonesPaginacion")
    // console.log(total_productos)
    // return false;
    $('#paginacion').empty();

    var pagina = parseInt(localStorage.getItem('pagina')) || 1;

    // if(pagina == null | pagina == 1){
    //     $('.pagina-previa').remove();
    // }else{
    //     $('#paginacion').append(
    //         '<button class="pagina-previa">⟨</button>'
    //     );
    // }

    // $('#paginacion').append(
    //     '<button class="pagina-previa">⟨</button>'
    // );

    if (pagina > 1) {
        $('#paginacion').append('<button class="pagina-previa">⟨</button>');
    }

    // for (let i = 1; i <= total_paginas; i++) {
    //     $('#paginacion').append(`<button class="pagina" data-pagina="${i}">${i}</button>`);
    // }

    for (let i = 1; i <= total_paginas; i++) {
        $('#paginacion').append(
            `<button class="pagina ${pagina === i ? 'active' : ''}" data-pagina="${i}">${i}</button>`
        );
    }

    // if(pagina == total_paginas){
    //     $('.pagina-siguiente').remove();
    // }else{
    //     $('#paginacion').append(
    //         '<button class="pagina-siguiente">⟩</button>'
    //     );
    // }

    // $('#paginacion').append(
    //     '<button class="pagina-siguiente">⟩</button>'
    // );

    if (pagina < total_paginas) {
        $('#paginacion').append('<button class="pagina-siguiente">⟩</button>');
    }

    // $(document).on('click', '.pagina', function() {
    //     const pagina = $(this).data('pagina');
    //     const offset = (pagina - 1) * items_por_pagina;

    //     localStorage.setItem('pagina', pagina);

    //     console.log("generarBotonesPaginacion:\nPagina: ", pagina, "\nOffset: ", offset, "\nTotal paginas: ", total_paginas, "\nItems por pagina: ", items_por_pagina)
    //     // return false;

    //     loadShop(total_productos, items_por_pagina);
    // });

    $(document).off('click', '.pagina').on('click', '.pagina', function () {
        const nuevaPagina = parseInt($(this).data('pagina'));
        localStorage.setItem('pagina', nuevaPagina);
        console.log("Página seleccionada: ", nuevaPagina);
        // return false;
        loadShop(total_productos, items_por_pagina);
    });

    // $(document).on('click', '.pagina-previa', function () {
    //     const pagina = parseInt(localStorage.getItem('pagina')) || 1;
    //     if (pagina > 1) {
    //         localStorage.setItem('pagina', pagina - 1);
    //         console.log("Página anterior: ", pagina - 1);
    //         // return false;
    //         loadShop(total_productos, items_por_pagina);
    //     }
    // });

    $(document).off('click', '.pagina-previa').on('click', '.pagina-previa', function () {
        let paginaActual = parseInt(localStorage.getItem('pagina')) || 1;
        if (paginaActual > 1) {
            paginaActual -= 1;
            localStorage.setItem('pagina', paginaActual);
            console.log("Página anterior: ", paginaActual);
            loadShop(total_productos, items_por_pagina);
        }
    });

    $(document).off('click', '.pagina-siguiente').on('click', '.pagina-siguiente', function () {
        let paginaActual = parseInt(localStorage.getItem('pagina')) || 1;
        if (paginaActual < total_paginas) {
            paginaActual += 1;
            localStorage.setItem('pagina', paginaActual);
            console.log("Página siguiente: ", paginaActual);
            loadShop(total_productos, items_por_pagina);
        }
    });

    // $(document).on('click', '.pagina-siguiente', function () {
    //     const pagina = parseInt(localStorage.getItem('pagina')) || 1;
    //     if (pagina < total_paginas) {
    //         localStorage.setItem('pagina', pagina + 1);
    //         console.log("Página siguiente: ", pagina + 1);
    //         // return false;
    //         loadShop(total_productos, items_por_pagina);
    //     }
    // });

} // end generarBotonesPaginacion

function delete_home_details(){
    $(document).on("click", "#page-productos", function(){
        localStorage.removeItem('details_home');
    });
} // end delete_home_details

function like_clicks(){
    // details
    $(document).on("click", ".details_like", function(){
        var id_producto = this.getAttribute('id');
        click_like(id_producto, "details");
    });
    // list
    $(document).on("click", ".list_like", function(){
        var id_producto = this.getAttribute('id');
        click_like(id_producto, "list");
    });
} // end like_clicks (manejar los clicks sobre los likes)

function click_like(id_producto, lugar){
    var token = JSON.parse(localStorage.getItem('token'));
    if(token){
        ajaxPromise("index.php?module=shop&op=ctrl_likes", 'POST', 'JSON', {'id_producto': id_producto, 'token': token})
            .then(function(like){
                // console.log(like);
                // return false;
                if (like === '0') {
                    $("#" + id_producto + ".fa-heart").addClass('like_red');
                } else if (like === '1') {
                    $("#" + id_producto + ".fa-heart").removeClass('like_red');
                }
                // $("#" + id_producto + ".fa-hearth").toggleClass('like_red');
            }).catch(function(){
                console.error('ERROR click_like');
                return false;
                window.location.href = "index.php?module=ctrl_exceptions&op=503";
            });
    }else{
        const redirect = [];
        redirect.push(id_producto, lugar);

        localStorage.setItem('redirect_like', redirect);
        localStorage.setItem('id_producto', id_producto);

        toastr.warning("Inicia sesión para poder guardar en favoritos productos");
        setTimeout("location.href="+ friendlyURL("?module=auth&op=login_view") +";", 1000);
    }
} // end click_like (manejar que hacer al hacer click sobre el corazón del like)

function load_likes_user(){
    var token = JSON.parse(localStorage.getItem('token'));
    if(token){
        ajaxPromise("index.php?module=shop&op=load_likes_user", 'POST', 'JSON', {'token': token})
            .then(function(like){
                // console.log(like);
                // return false;
                for(row in like){
                    // console.log(like[row].id_producto_like);
                    $("#" + like[row].id_producto_like + ".fa-heart").toggleClass('like_red');
                }
            }).catch(function(error){
                console.error("ERROR load_likes_user:\n", error);
                return false;
                window.location.href='index.php?module=ctrl_exceptions&op=503';
            });
    }
} // end load_likes_user

function redirect_login_like(){
    var token = JSON.parse(localStorage.getItem('token'));
    var id_producto = localStorage.getItem('id_producto');
    ajaxPromise("index.php?module=shop&op=ctrl_likes", 'POST', 'JSON', {'token':token, 'id_producto':id_producto})

    var redirect = localStorage.getItem('redirect_like').split(",");
    if(redirect[1] == "details"){
        loadProductoDetails(redirect[0]);
        localStorage.removeItem('pagina');
        localStorage.removeItem('redirect_like');
    }else if(redirect[1] == "list"){
        localStorage.removeItem('redirect_like');
        loadShop();
    }
} // end redirect_login_like

function prueba_POST_framework(){
    // $parametro1 = "parametro1_prueba_POST";
    // $parametro2 = "parametro2_prueba_POST";
    // ajaxPromise('index.php?module=shop&op=prueba_POST_framework', 'POST', 'JSON', {'parametro1': $parametro1, 'parametro2': $parametro2})
    //     .then(function(data){
    //         console.log('Datos de prueba de POST\n' + data);
    //     });
    $parametro = "parametro_solo_POST";
    ajaxPromise('index.php?module=shop&op=prueba_POST_framework', 'POST', 'JSON', {'parametro': $parametro})
        .then(function(data){
            console.log('Dato parametro solo de POST\n' + data);
        });
} // 

$(document).ready(function(){
    // prueba_POST_framework();
    print_filtros();
    loadEquipos();

    loadShop();

    botones_filtros();

    loadDetails();

    scrollOnTop();

    // paginacion();

    delete_home_details();

    like_clicks();
});