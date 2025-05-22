// console.log("hola ctrl_register.js")
// return false;

function register() {
    // console.log("hola register")
    if (validate_register() != 0) {
        // Swal.fire({
        //     title: "Registro",
        //     text: "Formulario de registro correcto",
        //     icon: "success",
        //     confirmButtonText: "Aceptar"
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         window.location.href = "index.php?module=ctrl_auth&op=login-view";
        //     }
        // });
        // return false;
        var data = $('.register-form').serialize();
        // alert("Validación de register correcta\nDatos introducidos:\n" + data)
        // return false;
        // console.log("Validación de register correcta\nDatos introducidos:\n" + data)
        // return false;
        ajaxPromise('index.php?module=auth&op=register', 'POST', 'JSON', data)
            .then(function(register){
                console.log(register)
                // return false;
                if(register == "error_email"){
                    document.getElementById('error_email_reg').innerHTML = "El correo introducido ya esta en úso por otro usuario, intenta con iniciar sesión"
                }else if(register == "error_username"){
                    document.getElementById('error_username_reg').innerHTML = "El nombre de usuario introducido ya esta en uso por otro usuario, introduce otro nombre de usuario"
                }else if(register == "error_email_google"){
                    document.getElementById('error_email_reg').innerHTML = "Ya existe una cuenta de google registrada con el correo introducido, prueba a iniciar sesión mediante google"
                }else if(register == "error_email_github"){
                    document.getElementById('error_email_reg').innerHTML = "Ya existe una cuenta de github registrada con el correo introducido, prueba a iniciar sesión mediante github"
                }else{
                    Swal.fire({
                        title: "Cuenta creada",
                        text: "Te hemos enviado un correo electronico para que verifiques tu cuenta",
                        icon: "success",
                        confirmButtonText: "Iniciar Sesión"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = friendlyURL("?module=auth&op=login_view");
                        }
                    });
                }
            })
    }
}

function key_register() {
    // console.log("hola key_register")
    $(".register-button").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            register();
        }
    });
}

function button_register() {
    // console.log("hola button_register")
    $('.register-button').on('click', function(e) {
        e.preventDefault();
        register();
    });
}

function validate_register() {
    // console.log("hola validate_register")
    var username_regex = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
    var mail_regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var pwd_regex = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var phone_regex = /^[0-9]{9}$/;
    var error = false;

    if (document.getElementById('username_reg').value.length === 0) {
        document.getElementById('error_username_reg').innerHTML = "Tienes que escribir el usuario";
        error = true;
    } else {
        if (document.getElementById('username_reg').value.length < 5) {
            document.getElementById('error_username_reg').innerHTML = "El username tiene que tener 5 caracteres como minimo";
            error = true;
        } else {
            if (!username_regex.test(document.getElementById('username_reg').value)) {
                document.getElementById('error_username_reg').innerHTML = "No se pueden poner caracteres especiales";
                error = true;
            } else {
                document.getElementById('error_username_reg').innerHTML = "";
            }
        }
    }

    if (document.getElementById('email_reg').value.length === 0) {
        document.getElementById('error_email_reg').innerHTML = "Tienes que escribir un correo";
        error = true;
    } else {
        if (!mail_regex.test(document.getElementById('email_reg').value)) {
            document.getElementById('error_email_reg').innerHTML = "El formato del mail es invalido";
            error = true;
        } else {
            document.getElementById('error_email_reg').innerHTML = "";
        }
    }

    if (document.getElementById('pwd1_reg').value.length === 0) {
        document.getElementById('error_pwd1_reg').innerHTML = "Tienes que escribir la contraseña";
        error = true;
    } else if (document.getElementById('pwd1_reg').value.length < 8) {
        document.getElementById('error_pwd1_reg').innerHTML = "La contraseña tiene que tener 8 caracteres como mínimo";
        error = true;
    } else if (!pwd_regex.test(document.getElementById('pwd1_reg').value)) {
        document.getElementById('error_pwd1_reg').innerHTML = "La contraseña debe contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales";
        error = true;
    } else {
        document.getElementById('error_pwd1_reg').innerHTML = "";
    }
    
    if (document.getElementById('pwd2_reg').value.length === 0) {
        document.getElementById('error_pwd2_reg').innerHTML = "Vuelve a escribir la contraseña";
        error = true;
    } else if (document.getElementById('pwd2_reg').value.length < 8) {
        document.getElementById('error_pwd2_reg').innerHTML = "La contraseña debe tener 8 caracteres como mínimo";
        error = true;
    } else if (document.getElementById('pwd2_reg').value !== document.getElementById('pwd1_reg').value) {
        document.getElementById('error_pwd2_reg').innerHTML = "Las contraseñas no coinciden";
        error = true;
    } else {
        document.getElementById('error_pwd2_reg').innerHTML = "";
    }

    if (document.getElementById('phone_prefix').value === "") {
        document.getElementById('error_phone').innerHTML = "Selecciona un prefijo";
        error = true;
    } else if (document.getElementById('phone_number').value.length === 0) {
        document.getElementById('error_phone').innerHTML = "Introduce el número de teléfono";
        error = true;
    } else if (!phone_regex.test(document.getElementById('phone_number').value)) {
        document.getElementById('error_phone').innerHTML = "El número de teléfono no es válido";
        error = true;
    } else {
        document.getElementById('error_phone').innerHTML = "";
    }

    if (error == true) {
        return 0;
    }
}

function load_prefijos_phone(){ // cargar los prefijos de teléfonos en los select
    ajaxPromise(friendlyURL('?module=auth&op=get_prefijos_phone'), 'POST', 'JSON')
        .then(function(prefijos) {
            // console.log(prefijos);
            // return false;
            var select = $('#phone_prefix');
            select.empty();
            select.append('<option value="">Prefijo</option>');
            for (row in prefijos) {
                select.append(
                    '<option value="+' + prefijos[row].country_phone_code + '">' +
                    '+' + prefijos[row].country_phone_code + ' (' + prefijos[row].country_name + ')' +
                    '</option>'
                );
            }
        }).catch(function(error){
            console.error('Error al cargar los prefijos:', error);
        });
}

$(document).ready(function() {
    load_prefijos_phone();
    key_register();
    button_register();
    google_icon_register();
    github_icon_register();
});