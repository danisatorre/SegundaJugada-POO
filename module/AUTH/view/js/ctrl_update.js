
function getDataUserUpdate(){ // coger los datos del usuario
    var token = JSON.parse(localStorage.getItem('token'));
    ajaxPromise(friendlyURL("?module=auth&op=data_user"), 'POST', 'JSON', {'token': token})
        .then(function(data){
            // console.log(data);
            // console.log(data[0].username);
            // return false;
            printUsername(data[0].username);
            changeUsername(data[0].username);
        });
}

function printUsername(username){ // pintar el nombre de usuario en el campo del formulario
    document.getElementById('new-username').value = username;
}

function changeUsername(username){ // cambiar el nombre de usuario
    // console.log(username);
    $(document).on('click', '#update-username-btn', function(){
        if(validateNewUsername() != 0){
            var newUsername = document.getElementById('new-username').value;
            // console.log(newUsername);
            var token = JSON.parse(localStorage.getItem('token'));
            // console.log(token);
            // return false;
            ajaxPromise(friendlyURL("?module=auth&op=updateUsername"), 'POST', 'JSON', {'token': token, 'oldUsername': username, 'newUsername': newUsername})
                .then(function(data){
                    console.log(data);
                    // return false;
                    // toastr.succes('Nombre de usuario actualizado correctamente');
                    if(data == 'error_username'){
                        document.getElementById('error_username_update').innerHTML  = '<br>*El nombre de usuario elegido ya esta en úso, prueba con otro nombre de usuario';
                    }else{
                        setTimeout(function(){
                            localStorage.setItem("token", JSON.stringify(data));
                            window.location.href = '/SegundaJugada-POO/';
                        }, 2000);
                    }
                });
        }
    });
}

function updateUserPwd(pwd){
    $(document).on('click', '#update-pwd-btn', function(){
        if(validateNewPwd() != 0){
            var newPwd = document.getElementById('new-pwd').value;
            var newPwdC = document.getElementById('confirm-pwd').value;
            if(newPwd != newPwdC){
                console.log('LAS CONTRASEÑAS NO COINCIDEN');
                document.getElementById('error_pwd_update').innerHTML = '<br>*La contraseña nueva no es la misma en los dos recuadros, vuelve a introducir la contraseña en los dos recuadros<br>';
            }else{
                console.log('LAS CONTRASEÑAS SI COINCIDEN');
            }
        }else{
            console.warn('Las contraseñas no cumplen con el requisito');
        }
    });
}

function validateNewPwd(){
    var pwd_regex = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var error = false;

    if (document.getElementById('new-pwd').value.length === 0) {
        document.getElementById('error_pwd_update').innerHTML = "<br>*Tienes que escribir la contraseña nueva en los dos recuadros<br>";
        error = true;
    }else if(document.getElementById('confirm-pwd').value.length === 0){
        document.getElementById('error_pwd_update').innerHTML = "<br>*Tienes que escribir la contraseña nueva en los dos recuadros<br>";
        error = true;
    }else if (document.getElementById('new-pwd').value.length < 8) {
        document.getElementById('error_pwd_update').innerHTML = "<br>*La nueva contraseña tiene que tener 8 caracteres como mínimo<br>";
        error = true;
    }else if(document.getElementById('confirm-pwd').value.length < 8){
        document.getElementById('error_pwd_update').innerHTML = "<br>*La nueva contraseña tiene que tener 8 caracteres como mínimo<br>";
        error = true;
    }else if (!pwd_regex.test(document.getElementById('new-pwd').value)) {
        document.getElementById('error_pwd_update').innerHTML = "<br>*La contraseña debe contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales<br>";
        error = true;
    }else if (!pwd_regex.test(document.getElementById('confirm-pwd').value)){
        document.getElementById('error_pwd_update').innerHTML = "<br>*La contraseña debe contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales<br>";
        error = true;
    }else {
        document.getElementById('error_pwd_update').innerHTML = "";
    }

    if(error == true){
        return 0;
    }
}

function validateNewUsername(){
    var username_regex = /^[a-zA-Z0-9]{5,}$/;
    var error = false;

    if (document.getElementById('new-username').value.length === 0) {
        document.getElementById('error_username_update').innerHTML = "<br>*Tienes que escribir el usuario<br>";
        error = true;
    } else {
        if (document.getElementById('new-username').value.length < 5) {
            document.getElementById('error_username_update').innerHTML = "<br>*El nuevo username tiene que tener 5 caracteres como minimo<br>";
            error = true;
        }else {
            if (!username_regex.test(document.getElementById('new-username').value)) {
                document.getElementById('error_username_update').innerHTML = "<br>*No se pueden poner caracteres especiales al username<br>";
                error = true;
            } else {
                document.getElementById('error_username_update').innerHTML = "";
            }
        }
    }

    if(error == true){
        return 0;
    }
}

function checkProviderUpdate(){ // consultar si el usuario es local o no para permitir o no el acceso a esta funcion
    console.log('hola checkProviderUpdate');
    var token = JSON.parse(localStorage.getItem('token'));
    if(token){
        ajaxPromise(friendlyURL('?module=auth&op=checkProvider'), 'POST', 'JSON', {'token': token})
            .then(function(provider){
                console.log(provider);
                if(provider == 'google'){
                    $('.update-container').remove();
                    $('#update-cuenta').remove();
                    $('.noUpdate').html(
                        `
                        <div class="provider-blocked google-blocked">
                            <img src="${ICONS_IMG + 'google-icon.webp'}" alt="Google" class="provider-logo">
                            <h2 class="provider-title">No puedes cambiar tus datos</h2>
                            <p class="provider-msg">
                                Eres un usuario de <span class="provider-name">Google</span>, la gestión de tus datos se realiza desde Google.
                            </p>
                        </div>
                        `
                    );
                }else if(provider == 'github'){
                    $('.update-container').remove();
                    $('#update-cuenta').remove();
                    $('.noUpdate').html(
                        `
                        <div class="provider-blocked github-blocked">
                            <img src="${ICONS_IMG + 'github-icon.png'}" alt="GitHub" class="provider-logo">
                            <h2 class="provider-title">No puedes cambiar tus datos</h2>
                            <p class="provider-msg">
                                Eres un usuario de <span class="provider-name">GitHub</span>, la gestión de tus datos se realiza desde GitHub.
                            </p>
                        </div>
                        `
                    );
                }
            })
    }else{
        $('.update-container').remove();
        $('.noUpdate').html(
            `
            <div class="provider-blocked login-blocked">
                <h2 class="provider-title">Acceso restringido</h2>
                <p class="provider-msg">
                    Debes iniciar sesión para poder cambiar los datos de tu cuenta.
                </p>
                <button class="login-btn" onclick="window.location.href='${friendlyURL('?module=auth&op=login_view')}'">Iniciar Sesión</button>
            </div>
            `
        );
    }
}


$(document).ready(function() {
    checkProviderUpdate();
    getDataUserUpdate();
    changeUsername();
    updateUserPwd();
});