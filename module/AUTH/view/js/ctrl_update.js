
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
    });
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
});