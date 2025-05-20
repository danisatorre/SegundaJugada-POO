function friendlyURL(url) {
    // console.log('hola friendlyURL');
    // return false;
    var link = "";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i = 0; i < url.length; i++) {
    	cont++;
        var aux = url[i].split("=");
        if (cont == 2) {
        	link += "/" + aux[1] + "/";	
        }else{
        	link += "/" + aux[1];
        }
    }
    return "/SegundaJugada-POO" + link;
}

function load_menu() {
    // console.log(friendlyURL("?module=shop"));
    // console.log(friendlyURL("?module=shop&op=view"));
    $('.main-nav').html(
        '<a href="' + SITE_PATH + '/" class="logo"><img src="' + WEB_LOGO_IMG + 'b-logo.png"></a>' +
        '<ul class="nav">' +
        '<li class="scroll-to-section"><a href="' + SITE_PATH + '/" class="active">Home</a></li>' +
        '<li class="scroll-to-section"><a href="' + friendlyURL("?module=shop") + '" id="page-productos">Productos</a></li>' +
        '<li class="submenu"><a href="javascript:;">Categorías</a>' +
        '<ul>' +
        '<li><a class="categoria_menu" id_categoria_menu="1">Hombre</a></li>' +
        '<li><a class="categoria_menu" id_categoria_menu="2">Mujer</a></li>' +
        '<li><a class="categoria_menu" id_categoria_menu="3">Niños</a></li>' +
        '<li><a class="categoria_menu" id_categoria_menu="4">Adolescentes</a></li>' +
        '<li><a class="categoria_menu" id_categoria_menu="5">Bebes</a></li>' +
        '</ul>' +
        '</li>' +
        '<li class="submenu submenu-cuenta"></li>' +
        '</ul>' +
        '<a class="menu-trigger"><span>Menu</span></a>'
    );
    // var token = localStorage.getItem('token');
    var token = JSON.parse(localStorage.getItem('token'));
    var provider = localStorage.getItem('provider');
    // const token = JSON.parse(localStorage.getItem("token"));
    // console.log(token)
    // console.log(token.username)
    // return false;
    $('.submenu-cuenta').empty();
    if (token) {
        ajaxPromise('index.php?module=auth&op=data_user', 'POST', 'JSON', { 'token': token, 'provider': provider })
            .then(function(data) {
                console.log(data);
                console.log(data[0].avatar);
                // return false;
                $('.submenu-cuenta').empty();
                $('<a href="javascript:;"><img src="' + data[0].avatar + '" id="user-icon">' + data[0].username + '</a>' +
                    '<ul>' +
                    '<li id="logout"><a>Cerrar sesión</a></li>' +
                    '<li id="switch-cuenta"><a href="'+ friendlyURL("?module=auth&op=login_view") +'">Cambiar de cuenta</a></li>' +
                    '</ul>' 
                ).appendTo('.submenu-cuenta');
                // $('<p></p>').attr({ 'id': 'user_info' }).appendTo('#des_inf_user')
                //     .html(
                //         '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>' +
                //         '<a>' + data.username + '<a/>'

                //     )

            }).catch(function() {
                console.error("load_menu:\nError al cargar los datos del user");
            });
    } else {
        // console.log("load_menu: no hay token disponible");
        $('.submenu-cuenta').empty();
        $('<a href="javascript:;"><img src="'+ TOP_PAGE_IMG +'user.svg" id="user-icon" style="border-radius: 0px;">Cuenta</a>' +
            '<ul>' +
            '<li><a href="'+ friendlyURL("?module=auth&op=login_view") +'">Iniciar sesión</a></li>' +
            '<li><a href="'+ friendlyURL("?module=auth&op=register_view") +'">Registrarse</a></li>' +
            '</ul>' 
        ).appendTo('.submenu-cuenta');                  
    }
}

//================CLICK-LOGIUT================
function click_logout() {
    $(document).on('click', '#logout', function() {
        // localStorage.removeItem('total_prod');
        // toastr.success("Logout succesfully");
        setTimeout('logout(); ', 1000);
        localStorage.removeItem('token');
        Swal.fire({
            title: "Sesión cerrada",
            text: "Pulsa en Continuar para acceder a la página principal",
            icon: "success",
            confirmButtonText: "Continuar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = SITE_PATH;
            }
        });
    });
}

//================LOG-OUT================
function logout() {
    var timeout = localStorage.getItem('timeoutSesion');
    if(timeout == "Si"){
        ajaxPromise('index.php?module=auth&op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            // console.log('hola logout');
            window.location.href=friendlyURL("?module=auth&op=login_view");
        }).catch(function() {
            console.error('ERROR al cerrar sesión');
        });
    }else{
        ajaxPromise('index.php?module=auth&op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            // console.log('hola logout');
            window.location.href = SITE_PATH;
        }).catch(function() {
            console.error('ERROR al cerrar sesión');
        });
    }
}

// Eliminar la pagina del localStorage al acceder al shop para entrar siempre desde la 1ª página
function click_shop() {
    $(document).on('click', '#page-productos', function() {
        localStorage.removeItem('pagina');
    });
}

function load_content() {
    let path = window.location.pathname.split('/');
    console.log(path);
    // return false;
    
    if(path[3] === 'recover'){
        console.log('hola recover load_content');
        localStorage.setItem('redirect_recover', 'yes');
        // return false;
        // localStorage.setItem('token_email', 'pruebaTokenEmail');
        localStorage.setItem("token_email", path[4]);
        window.location.href = friendlyURL("?module=auth&op=recover_view");
    }else if (path[3] === 'verify') {
        var tokenEmail = path[4];
        // console.log(tokenEmail);
        // return false;
        ajaxPromise(friendlyURL("?module=auth&op=verify_email"), 'POST', 'JSON', {token_email: tokenEmail})
        .then(function(verify) {
            console.log(verify);
            // return false;
            if(verify == 'verify'){
                toastr.options.timeOut = 2000;
                toastr.success('Cuenta verificada correctamente');
                setTimeout(function() {
                    window.location.href = friendlyURL("?module=auth&op=login_view");
                }, 2000);
            }else if(verify == 'fail'){
                toastr.error('Hubo un error al verificar tu cuenta');
            }
        })
        .catch(function() {
            toastr.error('Hubo un error al verificar tu cuenta');
            console.error('ERROR: verify email error');
        });
    }else if (path[3] === 'recover_view') {
        load_form_new_password();
    }
}

$(document).ready(function() {
    load_content();
    load_menu();
    click_logout();
    click_shop();
});