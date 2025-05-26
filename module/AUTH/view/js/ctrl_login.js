// console.log("hola ctrl_login.js")
// return false;
let tokenEmailRecoverPwd = null;

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
                } else if (login == "cuenta_desactivada"){
                    document.getElementById('cuenta_desactivada').innerHTML = "Esta cuenta esta desactivada <br> Activa tu cuenta en el correo de registro que recibiste al registrarte"
                } else if (login == "otp_send"){
                    document.getElementById('otp_send').innerHTML = "Acabamos de enviarte un código único de inicio de sesión a tu whatsapp para que puedas acceder a tu cuenta<br>Haz click <span id='otp_click'>aquí</span> para iniciar sesión con el código que recibiste en tu whatsapp"
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
                                setTimeout(function() {
                                    window.location.href = friendlyURL("?module=shop");
                                }, 2000);
                            }else{
                                setTimeout(function() {
                                    window.location.href = "/SegundaJugada-POO/";
                                }, 2000);
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
    let path = window.location.pathname.split('/');
    if(path[3] == 'login_view'){
        console.log('key_login enter');
        $(".login-button").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            login();
        }
    });
    }


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

function recuperar_pwd(){
    document.getElementById('recuperar_pwd').href = friendlyURL("?module=auth&op=recover_view");
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
                                setTimeout(function() {
                                    window.location.href = friendlyURL("?module=shop");
                                }, 2000);
                            }else{
                                setTimeout(function() {
                                    window.location.href = "/SegundaJugada-POO/";
                                }, 2000);
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

///////////////
/// RECOVER ///
///////////////

function verify_pwd_recover(){
    var pwd_regex = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var error = false;

    if (document.getElementById('new_pwd_recover').value.length === 0) {
        document.getElementById('error_new_pwd').innerHTML = "Tienes que escribir la contraseña";
        error = true;
    } else if (document.getElementById('new_pwd_recover').value.length < 8) {
        document.getElementById('error_new_pwd').innerHTML = "La contraseña tiene que tener 8 caracteres como mínimo";
        error = true;
    } else if (!pwd_regex.test(document.getElementById('new_pwd_recover').value)) {
        document.getElementById('error_new_pwd').innerHTML = "La contraseña debe contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales";
        error = true;
    } else {
        document.getElementById('error_new_pwd').innerHTML = "";
    }

    if (document.getElementById('repeat_pwd_recover').value !== document.getElementById('new_pwd_recover').value) {
        document.getElementById('error_repeat_pwd').innerHTML = "Las contraseñas no coinciden";
        error = true;
    }

    if(error == true){
        return 0;
    }
}

function verify_recover_email(){
    var mail_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var error = false;

    if (document.getElementById('email_recover').value.length === 0) {
        document.getElementById('error_email_recover').innerHTML = "Tienes que escribir un correo";
        error = true;
    } else {
        if (!mail_regex.test(document.getElementById('email_recover').value)) {
            document.getElementById('error_email_recover').innerHTML = "El formato del mail es invalido";
            error = true;
        } else {
            document.getElementById('error_email_recover').innerHTML = "";
        }
    }

    if(error == true){
        return 0;
    }
}

function click_recover_email(){
    let path = window.location.pathname.split('/');
    var redirectRecover = localStorage.getItem('redirect_recover');
    $(document).on("click", ".recover-email-button", function() {
        if(verify_recover_email() != 0){
            var email = $('#email_recover').val();
            // $('.recover-form').remove();
            // $('.recover-email-container').empty();
            // show_recover_pwd();
            send_email_recover_pwd(email);
        }
    });
    // no hacer caso al click del enter si redirectRecover es = a yes
    if(path[3] == 'recover_view'){
        if(redirectRecover != 'yes'){
            console.log('click_recover_email enter');
            $(".recover-email-button").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                e.preventDefault();
                if(verify_recover_email() != 0){
                    var email = $('#email_recover').val();
                    // $('.recover-form').remove();
                    // show_recover_pwd();
                    // alert('hola click_recover_email');
                    send_email_recover_pwd(email);
                }
            }
            });
        }
    }
}

function send_email_recover_pwd(email){
    // console.log(email);
    ajaxPromise(friendlyURL('?module=auth&op=send_email_recover_pwd'), 'POST', 'JSON', {email: email})
        .then(function(data){
            console.log(data);
            if(data == 'fail'){
                toastr.error('No se pudo encontrar el email introducido');
                document.getElementById('error_email_recover').innerHTML = "No existe una cuenta local con el correo introducido. Recuerda que si has iniciado sesión con alguna red social no puedes cambiar tu contraseña";
            }else if(data == 'ok'){
                toastr.info('Te hemos envíado un correo electrónico para que restablezcas tu contraseña');
            }
        });
}

function click_recover_pwd(){
    let path = window.location.pathname.split('/');
    var redirect_recover = localStorage.getItem('redirect_recover');
    $(document).on("click", ".recover-pwd-button", function(){
        if(verify_pwd_recover() != 0){
            var pwd = $('#new_pwd_recover').val();
            update_recover_pwd(tokenEmailRecoverPwd, pwd);
        }
    });
    // solo hacer caso al click del enter si en la ruta esta recover_view y si redirectRecover es = a yes
    if(path[3] == 'recover_view'){
        if(redirect_recover == 'yes'){
            // console.log('click_recover_pwd enter');
            $(".recover-pwd-button").keypress(function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    e.preventDefault();
                    if(verify_pwd_recover() != 0){
                        var pwd = $('#new_pwd_recover').val();
                        update_recover_pwd(tokenEmailRecoverPwd, pwd);
                    }
                }
            });
        }
    }
}

function update_recover_pwd(tokenEmail, pwd){
    // alert('Hola update_recover_pwd\n' + tokenEmail);
    ajaxPromise(friendlyURL('?module=auth&op=verify_token'), 'POST', 'JSON', {token_email: tokenEmail, pwd: pwd})
        .then(function(data){
            console.log(data);
            // return false;
            if(data == 'ok'){
                //toastr.succes('Contraseña actualizada correctamente');
                setTimeout(function() {
                    window.location.href = friendlyURL("?module=auth&op=login_view");
                }, 2000);
            }else if(data == 'fail'){
                toastr.error('Hubo un error al acutalizar la contraseña');
                setTimeout(function(){
                    window.location.href = '/SegundaJugada-POO/';
                }, 2000);
            }else if(data == 'expired'){
                toastr.error('El tiempo para restablecer tu contraseña caduco. Vuelve a pedir otro correo para restablecer tu contraseña');
                setTimeout(function(){
                    window.location.href = '/SegundaJugada-POO/';
                }, 5000);
            }
        });
    
}

function show_recover_pwd(){
    $('<div></div>').attr('class', "recover-codigo-container").appendTo('.show-recover-pwd')
            .html(
            `
            <form class="pwd-form" method="POST">
                <div class="form-group">
                    <label for="new_password">Nueva Contraseña</label>
                    <input type="password" id="new_pwd_recover" name="new_pwd_recover" placeholder="Introduce tu nueva contraseña">
                    <span id="error_new_pwd" class="error"></span>
                </div>
                <div class="form-group">
                    <label for="repeat_password">Repetir Contraseña</label>
                    <input type="password" id="repeat_pwd_recover" name="repeat_pwd_recover" placeholder="Repite tu nueva contraseña">
                    <span id="error_repeat_pwd" class="error"></span>
                </div>
                <button type="button" class="recover-pwd-button">Cambiar contraseña</button>
            </form>
            `
            );
}

function recover_pwd_redirect(){
    if(localStorage.getItem('redirect_recover') == 'yes'){
        tokenEmailRecoverPwd = localStorage.getItem('token_email');
        localStorage.removeItem('token_email');
        localStorage.removeItem('redirect_recover');
        // console.log(tokenEmailRecoverPwd);
        $('.recover-form').remove();
        show_recover_pwd();
    }
} // carga directamente el formulario de cambiar contraseña si en la ruta existe el tokenEmail

function otp_click(){
    $(document).on("click", "#otp_click", function(){
        showModalOTP();
    });
}

function showModalOTP(){
    $('#otp_modal_content, #otp_modal').remove();

    // Crea el contenedor del modal
    $('<div></div>').attr('id', 'otp_modal').appendTo('body');
    $('<div></div>').attr('id', 'otp_modal_content').appendTo('#otp_modal');

    // Estructura del contenido del modal
    $('#otp_modal_content').html(`
        <form id="otp_form" class="otp-modal-form" autocomplete="off">
            <div class="otp-modal-title">Validar código OTP</div>
            <div class="otp-modal-group">
                <label for="otp_username">Introduce tu usuario o correo electrónico</label>
                <input type="text" id="otp_username" name="otp_username" placeholder="Usuario / Correo electrónico" autocomplete="off">
                <span id="error_otp_username" class="otp-modal-error"></span>
            </div>
            <a id='message_otp'>Introduce aquí el código otp que has recibido en tu whatsapp</a><br>
            <div class="otp-modal-group otp-modal-otp-row">
                <input type="text" maxlength="1" class="otp-digit" id="otp_digit_1" name="otp_digit_1" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit" id="otp_digit_2" name="otp_digit_2" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit" id="otp_digit_3" name="otp_digit_3" autocomplete="off">
                <input type="text" maxlength="1" class="otp-digit" id="otp_digit_4" name="otp_digit_4" autocomplete="off">
            </div>
            <span id="error_otp_code" class="error"></span>
            <button type="button" id="validate_otp_btn" class="otp-modal-btn">Validar código</button>
        </form>
    `);

    $("#otp_modal_content").dialog({
        title: "Validar código OTP",
        width: 400,
        height: 350,
        resizable: false,
        modal: true,
        hide: "scale",
        show: "scale",
        close: function() {
            $('#otp_modal, #otp_modal_content').remove();
        }
    });

    $('#validate_otp_btn').on('click', function() {
        verify_userOTP();
    });

} // mostrar el modal para el formulario del OTP

function verify_userOTP(){
    // alert('hola verify_userOTP');
    var data = $('.otp-modal-form').serialize();
    // console.log(data);
    // return false;
    ajaxPromise(friendlyURL('?module=auth&op=verify_OTP'), 'POST', 'JSON', data)
        .then(function(verify){
            //console.log(verify);
            // return false;
            if(verify == "otp_no_valido"){
                document.getElementById('error_otp_code').innerHTML = "El código OTP introducido no es válido"
            }else if(verify == "cuenta_desactivada"){
                document.getElementById('error_otp_code').innerHTML = "Esta cuenta esta desactivada <br> Activa tu cuenta en el correo de registro que recibiste al registrarte"
            }else {
                localStorage.setItem("token", JSON.stringify(verify));
                    Swal.fire({
                        title: "Has iniciado sesión",
                        text: "Pulsa en Continuar para ver todos nuestros productos",
                        icon: "success",
                        confirmButtonText: "Continuar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(localStorage.getItem('redirect_like')){
                                setTimeout(function() {
                                    window.location.href = friendlyURL("?module=shop");
                                }, 2000);
                            }else{
                                setTimeout(function() {
                                    window.location.href = "/SegundaJugada-POO/";
                                }, 2000);
                            }
                        }
                    });
            }
        });
}

$(document).ready(function(){
    // RECOVER
    click_recover_email();
    click_recover_pwd();
    recover_pwd_redirect();
    otp_click();
    // LOGIN
    key_login()
    button_login()
    timeoutSesion()
    google_icon_login();
    register_link();
    recuperar_pwd();
    github_icon_login();
    google_login();
    github_login();
});