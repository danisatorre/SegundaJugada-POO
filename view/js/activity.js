function protecturl() {
    var token = JSON.parse(localStorage.getItem('token'));
    if(token){
        console.log("protecturl: SI TOKEN");
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=control_user', 'POST', 'JSON', { 'token': token })
        .then(function(data) {
            console.log(data);
            if (data == "UsuarioValido") {
                console.log("CORRECTO --> El usario coincide con la session");
            } else if (data == "UsuarioNoValido") {
                console.warn("INCORRCTO --> Estan intentando acceder a una cuenta");
                logout(); // funcion en main.js
            }
        })
        .catch(function(error) { console.error("ANONYMOUS_user", error) });
    }else{
        console.log("protecturl: NO TOKEN");
    }
} // end protecturl

function control_activity(){
    var token = localStorage.getItem('token');
    if(token){
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=actividad', 'POST', 'JSON')
            .then(function(actividad){
                if(actividad == "inactivo"){
                    console.warn("USUARIO INACTIVO");
                    localStorage.setItem("timeoutSesion", "Si");
                    logout(); // funcion en main.js
                }else{
                    console.warn("USUARIO ACTIVO");
                }
            });
    }else{
        console.log("La sesión no esta iniciada");
    }
} // end control_activity

function refresh_token(){
    var token = JSON.parse(localStorage.getItem('token'));
    if(token){
        ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=refresh_token', 'POST', 'JSON', {'token': token})
            .then(function(refToken){
                console.log(refToken);
                console.log("refres_token\nToken refrescado correctamente");
                // localStorage.setItem("token", refToken);
                // JSON.parse(localStorage.setItem("token", refToken));
                localStorage.setItem("token", JSON.stringify(refToken));
                load_menu(); // función en main.js
            });
    }
} // end refresh_token

function refresh_cookie(){
    ajaxPromise('module/AUTH/ctrl/ctrl_auth.php?op=refresh_cookie', 'POST', 'JSON')
        .then(function(cookie){
            console.log(cookie);
            console.log("refresh_cookie\nCookie actualizada correctamente");
        });
} // end refresh_cookie

$(document).ready(function(){ // 10min = 600000 | 1min = 60000
    setInterval(function() {control_activity()}, 1800000); // 30 min
    protecturl();
    setInterval(function() {refresh_token()}, 300000); // 5 min
    setInterval(function() {refresh_cookie()}, 300000); // 5 min
});