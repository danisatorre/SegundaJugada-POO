function goToShopMenu(){
    // categoria (menu)
    $(document).on("click", '.categoria_menu', function(){
        var filtro_categoria = this.getAttribute('id_categoria_menu');
        localStorage.removeItem('filtro');
        localStorage.removeItem('filtro_tipo');
        localStorage.removeItem('filtro_precio');
        localStorage.removeItem('filtro_equipo');
        localStorage.removeItem('filtro_marca');
        localStorage.removeItem('filtro_ciudad');
        localStorage.removeItem('buscar');
        localStorage.removeItem('pagina');
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
}

$(document).ready(function() {
    goToShopMenu();
});