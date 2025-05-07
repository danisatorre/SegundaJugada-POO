function load_menu() {
    // var token = localStorage.getItem('token');
    var token = JSON.parse(localStorage.getItem('token'));
    // const token = JSON.parse(localStorage.getItem("token"));
    // console.log(token)
    // console.log(token.username)
    // return false;
    $('.submenu-cuenta').empty();
    if (token) {
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=data_user', 'POST', 'JSON', { 'token': token })
            .then(function(data) {
                // console.log(data)
                // console.log(token.username);
                // return false;
                // if (data.tipo_usuario == "Cliente") {
                //     console.log("Cliente logeado");
                //     $('.opc_CRUD').empty();
                //     $('.opc_exceptions').empty();
                // } else {
                //     console.log("Admin loged");
                //     $('.opc_CRUD').show();
                //     $('.opc_exceptions').show();
                // }
                $('.submenu-cuenta').empty();
                $('<a href="javascript:;"><img src="' + data.avatar + '" id="user-icon">' + data.username + '</a>' +
                    '<ul>' +
                    '<li id="logout"><a>Cerrar sesión</a></li>' +
                    '<li id="switch-cuenta"><a href="index.php?module=ctrl_auth&op=login-view">Cambiar de cuenta</a></li>' +
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
        console.log("No hay token disponible");
        $('.submenu-cuenta').empty();
        $('<a href="javascript:;"><img src="view/images/top-page/user.svg" id="user-icon">Cuenta</a>' +
            '<ul>' +
            '<li><a href="index.php?module=ctrl_auth&op=login-view">Iniciar sesión</a></li>' +
            '<li><a href="index.php?module=ctrl_auth&op=register-view">Registrarse</a></li>' +
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
                window.location.href = "index.php";
            }
        });
    });
}

//================LOG-OUT================
function logout() {
    var timeout = localStorage.getItem('timeoutSesion');
    if(timeout == "Si"){
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            // console.log('hola logout');
            window.location.href="index.php?module=ctrl_auth&op=login-view";
        }).catch(function() {
            console.error('ERROR al cerrar sesión');
        });
    }else{
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            // console.log('hola logout');
            window.location.href = "index.php";
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

$(document).ready(function() {
    load_menu();
    click_logout();
    click_shop();
});