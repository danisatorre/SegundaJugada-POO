
function getDataUserUpdate(){ // coger los datos del usuario
    var token = JSON.parse(localStorage.getItem('token'));
    ajaxPromise(friendlyURL("?module=auth&op=data_user"), 'POST', 'JSON', {'token': token})
        .then(function(data){
            // console.log(data);
            // console.log(data[0].username);
            // return false;
            printUsername(data[0].username);
        });
}

function printUsername(username){ // pintar el nombre de usuario en el campo del formulario
    document.getElementById('new-username').value = username;
}


$(document).ready(function() {
    getDataUserUpdate();
});