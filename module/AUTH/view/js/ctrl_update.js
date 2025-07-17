
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


$(document).ready(function() {
    getDataUserUpdate();
    changeUsername();
});