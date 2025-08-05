function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    // console.log("hola ajaxPromise");
    // console.log("sUrl -> " + sUrl + " sType -> " + sType + " sTData -> " + sTData + " sData -> " + sData);
    // return false;
    return new Promise((resolve, reject) => {
        $.ajax({ // dirige al servidor
            url: sUrl, // url del servidor
            type: sType, // tipo de petición (GET / POST)
            dataType: sTData,
            data: sData,
            processData: !(sData instanceof FormData),
            contentType: !(sData instanceof FormData) ? 'application/x-www-form-urlencoded; charset=UTF-8' : false
        }).done((data) => {
            // console.log("Respuesta del servidor: ", data);
            // return false;
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            console.error("Error ajax:", textStatus, errorThrow);
            reject(errorThrow);
        }); 
    });
}