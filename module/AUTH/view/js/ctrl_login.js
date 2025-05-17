// console.log("hola ctrl_login.js")
// return false;

function login() {
    // console.log("hola login")
    if (validate_login() != 0) {
        // alert('Validación de login correcta');
        var data = $('.login-form').serialize();
        ajaxPromise('index.php?module=auth&op=login', 'POST', 'JSON', data)
            .then(function(login) {
                console.log('Login: ', login)
                // return false;
                if (login == "error_user") {
                    document.getElementById('error_username_log').innerHTML = "El usario o correo electrónico introducido no existe, asegurase de que lo a escrito correctamente"
                } else if (login == "error_pwd") {
                    document.getElementById('error_pwd_log').innerHTML = "La contraseña es incorrecta"
                } else {
                    localStorage.setItem("token", JSON.stringify(login));
                    Swal.fire({
                        title: "Has iniciado sesión",
                        text: "Pulsa en Continuar para ver todos nuestros productos",
                        icon: "success",
                        confirmButtonText: "Continuar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(localStorage.getItem('redirect_like')){
                                setTimeout('window.location.href =' + friendlyURL("?module=shop") + ';', 2000);
                            }else{
                                setTimeout('window.location.href = "/SegundaJugada-POO/";', 2000);
                            }
                        }
                    });
                }
            }).catch(function(textStatus) {
                if (console && console.log) {
                    console.error("La solicitud ha fallado: " + textStatus);
                }
            });
    }
} // login

function key_login() {
    // console.log("hola key_login")
    $(".login-button").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            login();
        }
    });


} // key_login

function button_login() {
    // console.log("hola button_login")
    $('.login-button').on('click', function(e) {
        e.preventDefault();
        login();
    });
} // button_login

function validate_login() {
    // console.log("hola validate_login")
    var error = false;

    if (document.getElementById('username').value.length === 0) {
        document.getElementById('error_username_log').innerHTML = "* Escribe un nombre de usuario o correo electrónico";
        error = true;
    } else {
        if (document.getElementById('username').value.length < 5) {
            document.getElementById('error_username_log').innerHTML = "* El nombre de usuario debe tener 5 caracteres como minimo";
            error = true;
        } else {
            document.getElementById('error_username_log').innerHTML = "";
        }
    }

    if (document.getElementById('password').value.length === 0) {
        document.getElementById('error_pwd_log').innerHTML = "* Escribe una contraseña para iniciar sesión";
        error = true;
    } else {
        document.getElementById('error_pwd_log').innerHTML = "";
    }

    if (error == true) {
        return 0;
    }
} // validate_login

function timeoutSesion(){
    var timeout = localStorage.getItem('timeoutSesion');
    if(timeout){
        localStorage.removeItem('timeoutSesion');
        document.getElementById('timeout_sesion').innerHTML = "Has estado inactivo demasiado tiempo <br> Vuelve a iniciar sesión";
    }
} // timeoutSesion

function google_icon_login(){
    document.getElementById('google-icon-login').src = ICONS_IMG + 'google-icon.webp';
}

function register_link(){
    document.getElementById('register-link').href = friendlyURL("?module=auth&op=register_view");
}

function github_icon_login(){
    document.getElementById('github-icon-login').src = ICONS_IMG + 'github-icon.png';
}

function google_login(){
    $('.google-login-button').on('click', function(e) {
        social_login('google');
    }); 
}

function github_login(){
    $('.github-login-button').on('click', function(e) {
        social_login('github');
    });
}

function social_login(param){
    // console.log(param);
    // return false;
    authService = firebase_config();
    authService.signInWithPopup(provider_config(param))
    .then(function(result) {
        console.log('Hemos autenticado al usuario ', result.user);
        email_name = result.user.email;
        // console.log(result.user.email);
        let username = email_name.split('@');
        // console.log(username[0]);
        // console.log(result.user.photoURL);
        // return false;
        // console.log(result);

        var social_user = {id: result.user.uid, username: username[0], email: result.user.email, avatar: result.user.photoURL, provider: param};
        // console.log(social_user);
        // return false;
        if (result) {
            console.log('social_login: SI result');
            ajaxPromise("index.php?module=auth&op=social_login", 'POST', 'JSON', social_user)
            .then(function(data) {
                // console.log(data);
                // return false;
                localStorage.setItem("provider", param);
                localStorage.setItem("token", JSON.stringify(data));
                console.log('social_login despues de añadir el token en localStorage')
                    Swal.fire({
                        title: "Has iniciado sesión",
                        text: "Pulsa en Continuar para ver todos nuestros productos",
                        icon: "success",
                        confirmButtonText: "Continuar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(localStorage.getItem('redirect_like')){
                                setTimeout('window.location.href =' + friendlyURL("?module=shop") + ';', 2000);
                            }else{
                                setTimeout('window.location.href = "/SegundaJugada-POO/";', 2000);
                            }
                        }
                    });
            })
            .catch(function() {
                console.error('Error: Social login error');
            });
        }else{
            console.error('social_login: NO result')
        }
    })
    .catch(function(error) {
        var errorCode = error.code;
        console.error(errorCode);
        var errorMessage = error.message;
        console.error(errorMessage);
        var email = error.email;
        console.error(email);
        var credential = error.credential;
        console.error(credential);
    });
}

function provider_config(param){
    // console.log(param);
    // return false;
    if(param === 'google'){
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        return provider;
    }else if(param === 'github'){
        return provider = new firebase.auth.GithubAuthProvider();
    }
}

$(document).ready(function(){
    key_login()
    button_login()
    timeoutSesion()
    google_icon_login();
    register_link();
    github_icon_login();
    google_login();
    github_login();
});