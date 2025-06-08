
// console.log("hola ctrl home js");
// return false;

function carouselPrincipal(){
    ajaxPromise('index.php?module=home&op=carousel_principal','GET', 'JSON')
    .then(function(data) {
            for (row in data) {
                $('<div></div>').attr('class', "div_cp").attr('id_cphome', data[row].id_cphome).appendTo(".carousel-home-principal")
                .html(
                    "<img src='"+ CAROUSEL_HOME_IMG + data[row].ruta_img + "' alt='foto' >"
                )
            }

            // console.log("hola end FOR row in data CAROUSELMARCAS");
            // return false;

              $(function() {
                // Owl Carousel
                var owl = $(".carousel-home-principal");
                owl.owlCarousel({
                  items: 1,
                  margin: 10,
                  loop: true,
                  nav: true,
                  autoplay: true,
                  autoplayTimeout: 10000, // 10 segundos (10k ms)
                  autoplaySpeed: 2500,
                });
              });
        })
        .catch(function() {
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end carouselPrincipal

function carouselMarcas() {
    // console.log("hola CAROUSELMARCAS");
    // return false;
    ajaxPromise('index.php?module=home&op=marcas','GET', 'JSON')
    .then(function(data) {
            for (row in data) {
                // console.log("hola data FUNCTION CAROUSELMARCAS");
                // console.log(data);
                // return false;
                $('<div></div>').attr('class', "div_marca").attr('id_marca', data[row].id_marca).appendTo(".carousel-home")
                .html(
                    "<img src='"+ MARCAS_IMG + data[row].img_marca + "' alt='foto' >" +
                    "<h5>" + data[row].nom_marca + "</h5>"
                )
            }

            // console.log("hola end FOR row in data CAROUSELMARCAS");
            // return false;

              $(function() {
                // Owl Carousel
                var owl = $(".carousel-home");
                owl.owlCarousel({
                  items: 2,
                  margin: 10,
                  loop: true,
                  nav: true,
                  autoplay: true,
                  autoplaySpeed: 2500,
                });
              });
            // console.log("hola end OWL CAROUSELMARCAS");
            // return false;
        })
        .catch(function() {
            // console.log("hola CATCH CAROUSELMARCAS");
            // return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end carouselMarcas

function loadCategorias() {
    // console.log("hola LOADCATEGORIAS");
    // return false;
    ajaxPromise('index.php?module=home&op=categorias','GET', 'JSON')
    .then(function(data) { 
        // console.log("hola data FUNCTION");
        // return false;
        for (row in data) {
            // console.log("hola data");
            // return false;
            $('<div></div>').attr('class', "div_categoria").attr({ 'id_categoria': data[row].id_categoria }).appendTo('#containerCategoria')
                .html(
                    `<li class='portfolio-item'>
                        <div class='item-main'>
                            <div class='portfolio-image'>
                                <img src="${CATEGORIAS_IMG + data[row].img_categoria}" alt='foto'>
                            </div>
                            <h5>${data[row].categoria}</h5>
                        </div>
                    </li>`
                );
        }
    }).catch(function() {
        // console.log("ERROR loadCategorias");
        // return false;
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    });
} // end loadCategoiras

function loadCatTipos() {
    // console.log("hola loadCatTipos");
    // return false;
    ajaxPromise('index.php?module=home&op=tipos','GET', 'JSON')
    .then(function(data) {
            for (row in data) {
                // console.log("hola data FUNCTION loadCatTipos");
                // console.log(data);
                // return false;
                $('<div></div>').attr('class', "div_tipo").attr('id_tipo', data[row].id_tipo).appendTo(".carousel-tipo")
                .html(
                    "<img src='"+ TIPOS_IMG + data[row].img_tipo + "' alt='foto' >" +
                    "<h5>" + data[row].tipo + "</h5>"
                )
            }

            // console.log("hola end FOR row in data loadCatTipos");
            // return false;

              $(function() {
                // Owl Carousel
                var owl = $(".carousel-tipo");
                owl.owlCarousel({
                  items: 4,
                  margin: 10,
                  loop: true,
                  nav: true,
                });
              });
            // console.log("hola end OWL loadCatTipos");
            // return false;
        })
        .catch(function() {
            // console.log("hola CATCH CAROUSELMARCAS");
            // return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end loadCatTipos

function loadProductos() {
    // console.log("hola loadProductos");
    // return false;
    ajaxPromise('index.php?module=home&op=carousel_productos','GET', 'JSON')
    .then(function(data) {
        // console.log("hola loadProductos then function data");
        // return false;
            for (row in data) {
                // console.log("hola data FUNCTION loadProductos");
                // console.log(data);
                // return false;
                $('<div></div>').attr('class', "div_producto").attr('id_producto', data[row].id_producto).appendTo(".carousel-producto")
                .html(
                    "<img src='"+ PRODUCT_IMAGES + data[row].img_producto + "' alt='foto' >" +
                    "<h5>" + data[row].nom_prod + "</h5>"
                );
            }

            // console.log("hola end FOR row in data loadProductos");
            // return false;

              $(function() {
                // Owl Carousel
                var owl = $(".carousel-producto");
                owl.owlCarousel({
                  items: 4,
                  margin: 10,
                  loop: true,
                  nav: true,
                });
              });
            // console.log("hola end OWL loadProductos");
            // return false;
        })
        .catch(function() {
            // console.log("hola CATCH loadProductos");
            // return false;
            window.location.href = "index.php?module=ctrl_exceptions&op=503";
        });
} // end loadProductos

function loadAccesorios(){
    // console.log("hola loadAccesorios");
    // return false;
    ajaxPromise('index.php?module=home&op=accesorios', 'GET', 'JSON')
    .then(function(data){
        for (row in data){
            $('<div></div>').attr('class', "div_accesorio").attr('id_accesorio', data[row].tipo).appendTo(".carousel-accesorio")
            .html(
                "<img src='"+ PRODUCT_IMAGES + data[row].img_producto + " 'alt='foto'>" +
                "<h5>" + data[row].nom_prod + "</h5>"
            )
        }

        // CAROUSEL

        $(function(){
            var owl = $(".carousel-accesorio");
            owl.owlCarousel({
                items: 4,
                margin: 10,
                loop: true,
                nav: true,
            }); // END owl.owlCarousel
        }); // END FUNCTION OWL
    }) // END FUNCTION DATA
    .catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadAccesorios

function loadPopulares(){
    // console.log("hola loadPpopulares");
    // return false;
    ajaxPromise('index.php?module=home&op=populares', 'GET', 'JSON')
    .then(function(data){
        for (row in data){
            $('<div></div>').attr('class', "div_popular").attr('id_popular', data[row].id_producto).appendTo(".carousel-popular")
            .html(
                "<img src='"+ PRODUCT_IMAGES + data[row].img_producto + " 'alt='foto'>" +
                "<h5>" + data[row].nom_prod + "</h5>"
            )
        }

        // CAROUSEL

        $(function(){
            var owl = $(".carousel-popular");
            owl.owlCarousel({
                items: 4,
                margin: 10,
                loop: true,
                nav: true,
            }); // END owl.owlCarousel
        }); // END FUNCTION OWL
    }) // END FUNCTION DATA
    .catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadPopulares

function loadMostRating(){
    // console.log("hola loadMostRating");
    // return false;
    ajaxPromise('index.php?module=home&op=mostrating', 'GET', 'JSON')
    .then(function(data){
        for (row in data){
            $('<div></div>').attr('class', "div_rating").attr('id_rating', data[row].id_producto).appendTo(".carousel-rating")
            .html(
                "<img src='"+ PRODUCT_IMAGES + data[row].img_producto + " 'alt='foto'>" +
                "<h5>" + data[row].nom_prod + 
                "<br>" +
                "Valoración: " + data[row].rating +
                "</h5>"
            )
        }

        // CAROUSEL

        $(function(){
            var owl = $(".carousel-rating");
            owl.owlCarousel({
                items: 4,
                margin: 10,
                loop: true,
                nav: true,
            }); // END owl.owlCarousel
        }); // END FUNCTION OWL
    }) // END FUNCTION DATA
    .catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadMostRating

function loadMostRatingCategoria(){
    // console.log("hola loadMostRatingCategoria");
    // return false;
    ajaxPromise('index.php?module=home&op=mostratingcategoria', 'GET', 'JSON')
    .then(function(data){
        for (row in data){
            $('<div></div>').attr('class', "div_rating_categoria").attr('id_rating_categoria', data[row].id_categoria).appendTo(".carousel-rating-categoria")
            .html(
                "<img src='"+ CATEGORIAS_IMG + data[row].img_categoria + " 'alt='foto'>" +
                "<h5>" + data[row].categoria + 
                "<br>" +
                "Visitas: " + data[row].visitas_cat +
                "</h5>"
            )
        }

        // CAROUSEL

        $(function(){
            var owl = $(".carousel-rating-categoria");
            owl.owlCarousel({
                items: 4,
                margin: 10,
                loop: true,
                nav: true,
            }); // END owl.owlCarousel
        }); // END FUNCTION OWL
    }) // END FUNCTION DATA
    .catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
} // end loadMostRatingCategoria

function loadMostRatingTipo(){
    // console.log("hola loadMostRatingTipo");
    // return false;
    ajaxPromise('index.php?module=home&op=mostratingtipo', 'GET', 'JSON')
    .then(function(data){
        for (row in data){
            $('<div></div>').attr('class', "div_rating_tipo").attr('id_rating_tipo', data[row].id_tipo).appendTo(".carousel-rating-tipo")
            .html(
                "<img src='"+ TIPOS_IMG + data[row].img_tipo + " 'alt='foto'>" +
                "<h5>" + data[row].tipo + 
                "<br>" +
                "Visitas: " + data[row].visitas_tipo +
                "</h5>"
            )
        }

        // CAROUSEL

        $(function(){
            var owl = $(".carousel-rating-tipo");
            owl.owlCarousel({
                items: 4,
                margin: 10,
                loop: true,
                nav: true,
            }); // END owl.owlCarousel
        }); // END FUNCTION OWL
    }) // END FUNCTION DATA
    .catch(function(){
        window.location.href = "index.php?module=ctrl_exceptions&op=503";
    })
}

function goToShop(){
    // categoria
    $(document).on("click", '.div_categoria', function(){
        var filtro_categoria = this.getAttribute('id_categoria');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar'); // eliminar filtro de buscar al hacer el salto para que no se quede marcado el select en el buscador
        localStorage.setItem('filtro_categoria', filtro_categoria);

        var filtro = [];
        if(localStorage.getItem('filtro_categoria')){
            filtro.push(['categoria', localStorage.getItem('filtro_categoria')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro)); 

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_categoria: filtro_categoria})
            .then(function(data) {
                // console.log(data);
                // return false
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error) {
                console.error(error);
            });
        }, 500);
    });
    // marca
    $(document).on("click", '.div_marca', function(){
        var filtro_marca = this.getAttribute('id_marca');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('filtro_marca', filtro_marca);

        var filtro = [];
        if(localStorage.getItem('filtro_marca')){
            filtro.push(['marca', localStorage.getItem('filtro_marca')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_marca: filtro_marca})
            .then(function(data) {
                // console.log(data);
                // return false;
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error) {
                console.error(error);
            });
        }, 500);
    });
    // tipo
    $(document).on("click", '.div_tipo', function(){
        var filtro_tipo = this.getAttribute('id_tipo');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('filtro_tipo', filtro_tipo);

        var filtro = [];
        if(localStorage.getItem('filtro_tipo')){
            filtro.push(['tipo', localStorage.getItem('filtro_tipo')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_tipo: filtro_tipo})
            .then(function(data){
                console.log(data);
                // return false
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error){
                console.error(error);
            })
        }, 500);
    });
    // accesorio
    $(document).on("click", '.div_accesorio', function(){
        var filtro_accesorio = this.getAttribute('id_accesorio');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('filtro_tipo', filtro_accesorio);

        var filtro = [];
        if(localStorage.getItem('filtro_tipo')){
            filtro.push(['tipo', localStorage.getItem('filtro_tipo')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_accesorio: filtro_accesorio})
            .then(function(data){
                console.log(data);
                // return false;
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error){
                console.error(error);
            })
        }, 500);
    });
    // popular (go to details)
    $(document).on("click", '.div_popular', function(){
        var filtro_visitas = this.getAttribute('id_popular');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('details_home', filtro_visitas);

        setTimeout(function(){
            window.location.href = friendlyURL("?module=shop");
        }, 500);
    });
    $(document).on("click", '.div_producto', function(){
        var producto = this.getAttribute('id_producto');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('details_home', producto);

        setTimeout(function(){
            window.location.href = friendlyURL("?module=shop");
        }, 500);
    });
    // rating (go to detials)
    $(document).on("click", '.div_rating', function(){
        var rating = this.getAttribute('id_rating');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('details_home', rating);

        setTimeout(function(){
            window.location.href = friendlyURL("?module=shop");
        }, 500);
    });
    // rating categoria
    $(document).on("click", '.div_rating_categoria', function(){
        var rating_categoria = this.getAttribute('id_rating_categoria');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('filtro_categoria', rating_categoria);

        var filtro = [];
        if(localStorage.getItem('filtro_categoria')){
            filtro.push(['categoria', localStorage.getItem('filtro_categoria')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro)); 

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_categoria: rating_categoria})
            .then(function(data) {
                // console.log(data);
                // return false
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error) {
                console.error(error);
            });
        }, 500);
    });
    // rating tipo
    $(document).on("click", '.div_rating_tipo', function(){
        var rating_tipo = this.getAttribute('id_rating_tipo');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_categoria');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_visitas');
        localStorage.removeItem('pagina');
        localStorage.removeItem('details_home');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.setItem('filtro_tipo', rating_tipo);

        var filtro = [];
        if(localStorage.getItem('filtro_tipo')){
            filtro.push(['tipo', localStorage.getItem('filtro_tipo')])
        }
        localStorage.setItem('filtro', JSON.stringify(filtro));

        setTimeout(function(){
            ajaxPromise('index.php?module=shop&op=filtro_home', 'POST', 'JSON', {filtro_tipo: rating_tipo})
            .then(function(data) {
                // console.log(data);
                // return false
                window.location.href = friendlyURL("?module=shop");
            })
            .catch(function(error) {
                console.error(error);
            });
        }, 500);
    });
} // end goToShop (saltar del home al shop con filtros aplicados)

$(document).ready(function() {
    carouselPrincipal();
    carouselMarcas();
    loadCategorias();
    loadCatTipos();
    loadProductos();
    loadAccesorios();
    loadPopulares();
    loadMostRating();
    loadMostRatingCategoria();
    loadMostRatingTipo();
    goToShop();
});