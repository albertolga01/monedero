/*function fillSelects_Tarjetas(){ 
    var selects = document.getElementsByClassName("sltarjetas")
    for (const item of selects) {
        selectTarjetas(item);
    }
}

function fillSelects_placas(){
    var selects = document.getElementsByClassName("sltarjetas-placa")
    for (const item of selects) {
        selectPlaca(item);
    }
}

function selectTarjetas(item){ 
    var placas = sessionStorage.getItem("tarjetas");
    placas = JSON.parse(placas);
    for (var element of placas) { 
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.notarjeta;
        item.add(option);
        
    } 
}

function selectPlaca(item){ 
    var tarjetas = sessionStorage.getItem("tarjetas");
    tarjetas = JSON.parse(tarjetas);
    for (var element of tarjetas) { 
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.folio;
        item.add(option);
        //alert("hola")
    } 
}

function leer_Tarjeta(){
    //alert("Llegó");
    var sesionlog = sessionStorage.getItem("sesionlog");
    sesionlog = JSON.parse(sesionlog);
    sesionlog = sesionlog[0];
    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getTarjetas&idcliente="+sesionlog.idcliente,{
        method: "GET",
        modo: "cors",
    })

    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => {
        console.log(data);
         data = JSON.stringify(data);
          sessionStorage.setItem("tarjetas", data); 
         fillSelects_Tarjetas()
    })
}

function leerVehiculo(){
    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getVehiculo&idcliente=")
}*/