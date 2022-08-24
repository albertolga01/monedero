/*  Short syntax for document.getElementById()  */
function byID(id){
    return document.getElementById(id);
}


function logOut(){
    sessionStorage.clear();
    window.location = "./login.html";
}

function headerDate(){
    var currentTime = new Date();
    var day = currentTime.getDay();
        var dayWord = {
            0:"Domingo",
            1:"Lunes",
            2:"Martes",
            3:"Miércoles",
            4:"Jueves",
            5:"Viernes",
            6:"Sábado",
        }
        day = dayWord[day];
    var date = currentTime.getDate();
    var month = currentTime.getMonth();
        var monthWord = {
            0:"enero",
            1:"febrero",
            2:"marzo",
            3:"abril",
            4:"mayo",
            5:"junio",
            6:"julio",
            7:"agosto",
            8:"septiembre",
            9:"octubre",
            10:"noviembre",
            11:"diciembre",
        }
        month = monthWord[month];
    var year = currentTime.getFullYear();
    var toDisplay = day + ", " + date + " de " + month + " de " + year;
    document.getElementById("navbar-fecha").innerHTML = toDisplay;
}

function cards_Cliente(){
    let usuario = document.getElementById("cards-usuario");
    let saldo = document.getElementById("cards-saldo");
    let tarjetas = document.getElementById("cards-tarjetas");
    let movshoy = document.getElementById("cards-movshoy");

    let datosUsuario = sessionStorage.getItem("sesionlog");
    datosUsuario = JSON.parse(datosUsuario);
    datosUsuario = datosUsuario[0];
    usuario.innerHTML = datosUsuario.nombre;

    let abonos = sessionStorage.getItem("abonos");
    abonos = JSON.parse(abonos);
    let restante = 0.00;
    for (let item of abonos){
        restante += parseFloat(item.importedisponible);
    }
    saldo.innerHTML = formatCant("$"+restante);

    let tarjetasCte = sessionStorage.getItem("tarjetas");
    tarjetasCte = JSON.parse(tarjetasCte);
    tarjetasCte = tarjetasCte.length;
    tarjetas.innerHTML = tarjetasCte;

    let servicios = sessionStorage.getItem("servicios");
    servicios = JSON.parse(servicios);
    let noTrans = servicios.length;
    let totalTrans = 0.00;
    for (let item of servicios){
        totalTrans += parseFloat(item.importe);
    }
    movshoy.innerHTML = formatCant(noTrans+' / $'+totalTrans);
}
function formatCant(cant){
    
    let cents= cant.split(".");
    try{if(cents[1].length==1){
        let formatedDate = cant+"0";
        return(formatedDate);
    }else{
        if(cents[1].length==2){
            let formatedDate = cant;
            return(formatedDate);}
    }

    }catch(error){
        let formatedDate = cant+".00";
        return(formatedDate);
    }
    
    
    
}

function leer_Vehiculos(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];

    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getVehiculos&idcliente="+cte.idcliente,{
            method: "GET",
            mode: "cors",
        }
    )
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        sessionStorage.setItem("vehiculos", JSON.stringify(data));
        let vehiculos = data;
        let tbl = byID("tbl-vehiculos"); 
        // vehiculos = JSON.parse(vehiculos);
        for (var element of vehiculos) { 
            var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            cll0.innerHTML = element.idtarjeta;
            cll1.innerHTML = element.modelo;
            cll2.innerHTML = element.ano;
            cll3.innerHTML = element.placas;
            cll4.innerHTML = element.centrocosto;
            cll5.innerHTML = element.controlaodometro;
            cll6.innerHTML = element.fechacaptura;
        }
        
    })

    fillSelects_Vehiculos();
    fillSelects_Placas();
}

function leer_Abonos(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];

    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getAbonos&cte="+cte.idcliente,{
            method: "GET",
            mode: "cors",
        }
    )
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        sessionStorage.setItem("abonos", JSON.stringify(data));
        let abonos = data;
        let tbl = byID("tbl-abonos"); 
        //console.log(tbl);
        
        for (var element of abonos) { 
            var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            cll0.innerHTML = formatFecha(element.fecha);
            cll1.innerHTML = element.bancodestino;
            cll2.innerHTML = element.cuentabancaria;
            cll3.innerHTML = element.concepto;
            cll4.innerHTML = element.formapago;
            cll5.innerHTML = formatCant("$"+element.importe);
            cll6.innerHTML = element.referencia;
        } 
        cards_Cliente();
    })
}


function leer_Tarjeta(){ 

   

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
        sessionStorage.setItem("tarjetas", JSON.stringify(data));
       fillSelects_Tarjetas()  
        let abonos = data;
        let tbl = byID("tbl-tarjetas"); 
        tbl = byID("tbl-tarjetas").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
        //console.log(tbl);
        //console.log(abonos)
        for( var element of abonos){
            let estaciones=[];
            let dia=[];
            let combustible=[];
            let periodo=[];
            //estaciones
            if(element.insurgentes==1){
                estaciones.push("Insurgentes")
            }
            if(element.ley==1){
                estaciones.push("Ley")
            }
            if(element.libramiento==1){
                estaciones.push("Libramiento")
            }
            if(element.lopez==1){
                estaciones.push("Lopez Saenz")
            }
            if(element.munich==1){
                estaciones.push("Munich")
            }
            if(element.rio==1){
                estaciones.push("Rio")
            }
            if(element.santafe==1){
                estaciones.push("Santa Fe")
            }
            //dias
            if(element.lunes==1){
                dia.push("Lunes")
            }
            if(element.martes==1){
                dia.push("Martes")
            }
            if(element.miercoles==1){
                dia.push("Miercoles")
            }
            if(element.jueves==1){
                dia.push("Jueves")
            }
            if(element.viernes==1){
                dia.push("Viernes")
            }
            if(element.sabado==1){
                dia.push("Sábado")
            }
            if(element.domingo==1){
                dia.push("Domingo")
            }
            //combustibles
            if(element.magna==1){
                combustible.push("Magna")
            }
            if(element.premium==1){
                combustible.push("Premium")
            }
            if(element.diesel==1){
                combustible.push("Diesel")
            }
            //periodo
            if(element.tipoperiodo==1){
                periodo.push("Diario")
            }
            if(element.tipoperiodo==2){
                periodo.push("Semanal")
            }
            if(element.tipoperiodo==3){
                periodo.push("Mensual")
            }
            var rw = tbl.insertRow();
            var cll7 = rw.insertCell();
            var cll0 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            var input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("id",element.folio);
            input.setAttribute("name","bntADTar");
            input.setAttribute("onClick",'activarbtn1('+element.folio+')');
            if(element.activo==1){
                input.setAttribute("class",'Activo');
                input.setAttribute("value","Activo");
            }else{ 
                input.setAttribute("value","Inactivo");
                input.setAttribute("class",'Inactivo');
                rw.style.backgroundColor = '#D7D7D7';}
            cll7.append(input);
            cll0.innerHTML = element.notarjeta;
            cll2.innerHTML = tipo;
            cll3.innerHTML = estaciones;
            cll4.innerHTML = combustible;
            cll5.innerHTML = dia+", "+element.horarioinicial+" - "+element.horariofinal;
            cll6.innerHTML = "Litros: "+element.limitelitros+"Lts Dinero: $"+element.limitedinero+" Periodo: "+periodo;
        }
        fillSelects_noTarjetas();
    })

    
}
function leer_Bitacora(){
    var sesionlog = sessionStorage.getItem("sesionlog");
    sesionlog = JSON.parse(sesionlog);
    sesionlog = sesionlog[0];
fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getBitacora&idcliente="+sesionlog.idcliente,{
    method: "GET",
    modo: "cors",
})

.then(response => response.json())
.catch(error => console.log(error))
.then((data) => { 
    sessionStorage.setItem("Bitacora", JSON.stringify(data)); 
    let abonos = data;
    console.log(abonos)
    let tbl = byID("tbl-bitacora"); 
    for( var element of abonos){
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            cll0.innerHTML = formatDate(element.fecha);
            cll1.innerHTML = element.tipo;
            cll2.innerHTML = element.descripcion;
    }

})

}

function fillSelects_Tarjetas(){ 
    var selects = document.getElementsByClassName("sltarjetas");
    
    for (const item of selects) {
        selectTarjetas(item);
    }

}

function selectTarjetas(item){
    var options =  item.childNodes;
    options = Array.from(options);

    for(let element of options){ 
       // console.log(options);
        element.remove();
    }

    var tarjeta = sessionStorage.getItem("tarjetas");
     tarjeta = JSON.parse(tarjeta);
    
     for (var element of tarjeta) { 
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.folio;
        item.add(option);
        
    } 
}

function fillSelects_Placas(){
    var selects = document.getElementsByClassName("sltarjetas-placas")
    var selects2 = document.getElementById("altatarjetas-notarjeta")
    var selects3 = document.getElementById("altatarjetas-tipo")
    var checkEstacion1 = document.getElementById("estacsauth-1")
    var checkEstacion2 = document.getElementById("estacsauth-2")
    var checkEstacion3 = document.getElementById("estacsauth-3")
    var checkEstacion4 = document.getElementById("estacsauth-4")
    var checkEstacion5 = document.getElementById("estacsauth-5")
    var checkEstacion6 = document.getElementById("estacsauth-6")
    var checkEstacion7 = document.getElementById("estacsauth-7")
    var checkprod1 = document.getElementById("prodsauth-1")
    var checkprod2 = document.getElementById("prodsauth-2")
    var checkprod3 = document.getElementById("prodsauth-3") 
    var checkday1 = document.getElementById("daycheck-1")
    var checkday2 = document.getElementById("daycheck-2")
    var checkday3 = document.getElementById("daycheck-3")
    var checkday4 = document.getElementById("daycheck-4")
    var checkday5 = document.getElementById("daycheck-5")
    var checkday6 = document.getElementById("daycheck-6")
    var checkday7 = document.getElementById("daycheck-7")
    var fechaini = document.getElementById("daytime-ini")
    var fechafin = document.getElementById("daytime-fin")
    var litros = document.getElementById("limite-cant")
    var dinero = document.getElementById("limite-din")
    var periodo = document.getElementById("limite-periodo")
    checkEstacion1.checked=false;
    checkEstacion2.checked=false;
    checkEstacion3.checked=false;
    checkEstacion4.checked=false;
    checkEstacion5.checked=false;
    checkEstacion6.checked=false;
    checkEstacion7.checked=false;
    checkprod1.checked=false;
    checkprod2.checked=false;
    checkprod3.checked=false;
    checkday1.checked=false;
    checkday2.checked=false;
    checkday3.checked=false;
    checkday4.checked=false;
    checkday5.checked=false;
    checkday6.checked=false;
    checkday7.checked=false;
                checkday6.checked = "true";
    for (const item of selects) {
        selectPlacas(item, selects2, selects3, checkEstacion1, checkEstacion2, checkEstacion3, checkEstacion4,
            checkEstacion5, checkEstacion6, checkEstacion7, checkprod1, checkprod2, checkprod3, checkday1, checkday2, 
            checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo);
    }
}

function selectPlacas(item, selects2, selects3, checkEstacion1, checkEstacion2, checkEstacion3, checkEstacion4,
    checkEstacion5, checkEstacion6, checkEstacion7, checkprod1, checkprod2, checkprod3, checkday1, checkday2, 
    checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo){ 
    var placas = sessionStorage.getItem("vehiculos");
    placas = JSON.parse(placas);
    var tarjeta = sessionStorage.getItem("tarjetas");
    tarjeta = JSON.parse(tarjeta);
    for (let element of placas) { 
        if(element.idtarjeta==selects2.value){
            item.value = element.placas;
            
        }
    } 
    for( let tar of tarjeta){
        if(selects2.value==tar.folio){  
            fechaini.value= tar.horarioinicial;  
            fechafin.value= tar.horariofinal;
            litros.value= tar.limitelitros;
            dinero.value= tar.limitedinero;
            if(tar.tipo==2){
                selects3.value = "Tarjeta" ;
            }else{selects3.value = "RFID";}
            if(tar.tipoperiodo=="1"){
                periodo.value = 1 ;
            }
            if(tar.tipoperiodo=="2"){
                periodo.value = 2 ;
            }
            if(tar.tipoperiodo=="3"){
                periodo.value = 3 ;
            }
            if(tar.santafe==1){
                checkEstacion1.checked = "true";
            }
            if(tar.ley==1){
                checkEstacion2.checked = "true";
            }
            if(tar.insurgentes==1){
                checkEstacion3.checked = "true";
            }
            if(tar.munich==1){
                checkEstacion4.checked = "true";
            }
            if(tar.libramiento==1){
                checkEstacion5.checked = "true";
            }
            if(tar.lopez==1){
                checkEstacion6.checked = "true";
            }
            if(tar.rio==1){
                checkEstacion7.checked = "true";
            }
            if(tar.magna==1){
                checkprod1.checked = "true";
            }
            if(tar.premium==1){
                checkprod2.checked = "true";
            }
            if(tar.diesel==1){
                checkprod3.checked = "true";
            }
            if(tar.lunes==1){
                checkday1.checked = "true";
            }
            if(tar.martes==1){
                checkday2.checked = "true";
            }
            if(tar.miercoles==1){
                checkday3.checked = "true";
            }
            if(tar.jueves==1){
                checkday4.checked = "true";
            }
            if(tar.viernes==1){
                checkday5.checked = "true";
            }
            if(tar.sabado==1){
                checkday6.checked = "true";
            }
            if(tar.domingo==1){
                checkday7.checked = "true";
            }
            if(tar.domingo==1){
                checkday7.checked = "true";
            }
        
        
        
        }
            
    }
    /*for( let per of tarjeta){
        if(selects2.value==tar.folio){    
            if(per.tipoperiodo==1){
                periodo.value = "1" ;
            }
            if(per.tipoperiodo==2){
                periodo.value = "2" ;
            }
            if(per.tipoperiodo==3){
                periodo.value = "3" ;
            }else{alert("Error al guardar el periodo")}
        
        }
            
    }*/

    

}

function UpDateTarjetas(){
    var tarjeta = document.getElementById("altatarjetas-notarjeta").value;
    var estacion = document.getElementsByName("tarjetas-estacscheck");
    var combustible = document.getElementsByName("tarjetas-prodscheck");
    var horaiodia = document.getElementsByName("tarjetas-daycheck");
    var horaio = document.getElementsByName("tarjetas-daytime");
    var limiteC = document.getElementById("limite-cant").value;
    var limiteD = document.getElementById("limite-din").value;
    var limiteP = document.getElementById("limite-periodo").value;
    let toSend = new FormData();
        toSend.append('id', 'UpDateTarjeta');
        toSend.append('tarjeta', tarjeta);
        
        toSend.append('estacion1', +(estacion[0].checked));
        toSend.append('estacion2', +(estacion[1].checked));
        toSend.append('estacion3', +(estacion[2].checked));
        toSend.append('estacion4', +(estacion[3].checked));
        toSend.append('estacion5', +(estacion[4].checked));
        toSend.append('estacion6', +(estacion[5].checked));
        toSend.append('estacion7', +(estacion[6].checked));
        toSend.append('combustible1', +(combustible[0].checked));
        toSend.append('combustible2', +(combustible[1].checked));
        toSend.append('combustible3', +(combustible[2].checked));
        toSend.append('horariodia1', +(horaiodia[0].checked));
        toSend.append('horariodia2', +(horaiodia[1].checked));
        toSend.append('horariodia3', +(horaiodia[2].checked));
        toSend.append('horariodia4', +(horaiodia[3].checked));
        toSend.append('horariodia5', +(horaiodia[4].checked));
        toSend.append('horariodia6', +(horaiodia[5].checked));
        toSend.append('horariodia7', +(horaiodia[6].checked));
        toSend.append('horario1', horaio[0].value);
        toSend.append('horario2', horaio[1].value);
        toSend.append('limiteC', limiteC);
        toSend.append('limiteD', limiteD);
        toSend.append('limiteP', limiteP);

    fetch("https://compras.grupopetromar.com/monedero/apirest/", {
        method: "POST",
        mode: "cors",
        body: toSend,
    })
    .then(response => response.text())
    .catch(error => alert(error))
    .then((data) => {
       if(data==1){
        mensajeRespuesta("Guardado Correctamente")
        estacion[0].checked=false;
        estacion[1].checked=false;
        estacion[2].checked=false;
        estacion[3].checked=false;
        estacion[4].checked=false;
        estacion[5].checked=false;
        estacion[6].checked=false;
        combustible[0].checked=false;
        combustible[1].checked=false;
        combustible[2].checked=false;
        horaiodia[0].checked=false;
        horaiodia[1].checked=false;
        horaiodia[2].checked=false;
        horaiodia[3].checked=false;
        horaiodia[4].checked=false;
        horaiodia[5].checked=false;
        horaiodia[6].checked=false;
        horaio[0].value="";
        horaio[1].value="";
        document.getElementById("limite-cant").value="";
        document.getElementById("limite-din").value="";
        document.getElementById("limite-periodo").value="1";
        leer_Tarjeta();
       }else{mensajeRespuesta("ERROR")}
        
    
    }); 
    
}

function fillSelects_Vehiculos(){
    let selects = document.getElementsByClassName("sf-vehi")
    for (const sel of selects) {
        selectVehiculos(sel);
    }
}
function fillSelects_noTarjetas(){
    let selects = document.getElementsByClassName("sf-vehi1")
    for (const sel of selects) {
        selectTarje(sel);
    }
}
function selectTarje(select){ 
    var tarjeta = sessionStorage.getItem("tarjetas");
    tarjeta = JSON.parse(tarjeta);
    for (var element of tarjeta) { 
        if(element.activo==0){
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.folio;
        select.add(option);}
    } 
}

function selectVehiculos(select){ 
    var vehiculos = sessionStorage.getItem("vehiculos");
    vehiculos = JSON.parse(vehiculos);
    for (var element of vehiculos) { 
        var option = document.createElement("option");
        option.text = element.placas;
        option.value = element.idvehiculo;
        select.add(option);
    } 
}

function leer_Servicios(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];
    
    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getTransacciones&idcliente="+cte.idcliente, {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data)=>{
        sessionStorage.setItem("servicios", JSON.stringify(data));
        let abonos = data;
        let tbl = byID("tbl-servicios"); 
        //console.log(tbl);
        for (var element of abonos) { 
            var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            cll0.innerHTML = element.estacion;
            cll1.innerHTML = formatDate(element.fecha);
            cll2.innerHTML = element.folio;
            cll3.innerHTML = formatCant("$"+element.importe);
            cll4.innerHTML = element.litros;
            cll5.innerHTML = element.producto;
            cll6.innerHTML = element.tarjeta;
        } 
        tablaservicio();
        tablaconsumo();
    })
}

function fillForm_Vehi(){
    let placas = byID("altavehicle-idcte").value;
    let input_model = byID("altavehicle-model");
    let input_year = byID("altavehicle-year");
    let input_placas = byID("altavehicle-placas");
    let input_noecono = byID("altavehicle-noecono");
    let input_tipovehi = byID("altavehicle-tipovehi");
    let input_contodo = byID("altavehicle-contodo");
    let input_maxcarga = byID("altavehicle-maxcarga");
    let input_var = byID("altavehicle-var");
    let input_odoini = byID("altavehicle-odoini");
    let input_rendprom = byID("altavehicle-rendprom");
    let input_dpto = byID("altavehicle-dpto");
    let input_tipo = byID("altavehicle-tipo");
    let input_tarjeta = byID("altavehicle-tarjeta");

    let selectedVehi = sessionStorage.getItem("vehiculos");
    selectedVehi = JSON.parse(selectedVehi);
    let tarjetasCte = sessionStorage.getItem("tarjetas");
    tarjetasCte = JSON.parse(tarjetasCte);
    
    for (let item of selectedVehi){
        
        if(item.idvehiculo == placas){
            input_model.value = item.modelo;
            input_year.value = item.ano;
            input_placas.value = item.placas;
            input_noecono.value = item.noeconomico;
            input_tipovehi.value = item.tipovehiculo;
            input_contodo.value = item.controlaodometro;
            input_maxcarga.value = item.kmmax;
            input_var.value = item.variacion;
            input_odoini.value = item.odometro;
            input_rendprom.value = item.rendimiento;
            input_dpto.value = item.centrocosto;
            input_rendprom.value = item.rendimiento;
            input_dpto.value = item.centrocosto;
            input_tipo.value = item.tipovehiculo; // QUE ONDA CON EL DOBLE INPUT DE TIPO??
            //input_tarjeta.value = item.placas;
            for(let f of tarjetasCte){
             if(f.folio == item.idtarjeta){
                input_tarjeta.value = f.notarjeta

            } }
        }
        //console.log(tarjetasCte[item].notarjeta)
   
        
   
    
    }
    
}

function mod_Vehiculo(){
    let  placa = document.getElementById("altavehicle-idcte").value;
    let  newplaca = document.getElementById("altavehicle-placas").value;
    let  numeco = document.getElementById("altavehicle-noecono").value;
    

    let toSend =  new FormData;
        toSend.append("id","modvehiculo");
        toSend.append("placa",placa);
        toSend.append("newplaca",newplaca);
        toSend.append("numeco",numeco);
        

    fetch("https://compras.grupopetromar.com/monedero/apirest/",{
            method: "POST",
            mode: "cors",
            body: toSend,
    })
    .then(response => response.text())
    .catch(error => alert("error"))
    .then((data)=>{
        alert(data.trim())
    })
}   

function Cambiartabla1(){
    document.getElementById("grafica_consumo").style.display='block';
    document.getElementById("grafica_servicio").style.display='none';
}

function Cambiartabla2(){
    
    document.getElementById("grafica_consumo").style.display='none';
    document.getElementById("grafica_servicio").style.display='block';
}

function filtrarFacturas(){
   
    let tbl = byID("tbl-facturas").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    var cte1 = sessionStorage.getItem("sesionlog");
    cte1 = JSON.parse(cte1);
    //console.log(cte1[0].idcliente);
    var idcliente = cte1[0].idcliente;
    var fechainicial = byID("fechainiFac").value;
    var fechafinal = byID("fechafinFac").value;
    let toSend = new FormData();
        toSend.append("id","obtenerFacturas");
        toSend.append("idcliente",idcliente);
        toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{
        data = JSON.stringify(data);
        sessionStorage.setItem("Facturascte", data); 
        data=JSON.parse(data);
    let factura = data;
    //console.log(servicio);
    
    let tbl = byID("tbl-facturas"); 
    for( var element of factura){
        var rw = tbl.insertRow();
        var cll0 = rw.insertCell();
        var cll1 = rw.insertCell();
        var cll2 = rw.insertCell();
        var cll3 = rw.insertCell();
    
        cll0.innerHTML = element.folio;
        cll1.innerHTML = element.fechagenerado;
        cll2.innerHTML = element.importe;
        cll3.innerHTML = element.cantidad;
            
    }   
    });
}

function filtrarservicios(){
   
    let tbl = byID("tbl-servicios").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    var cte1 = sessionStorage.getItem("sesionlog");
    cte1 = JSON.parse(cte1);
    //console.log(cte1[0].idcliente);
    var idcliente = cte1[0].idcliente;
    var fechainicial = byID("fechainiserv").value;
    var fechafinal = byID("fechafinserv").value;
    let toSend = new FormData();
        toSend.append("id","obtenerServicios");
        toSend.append("idcliente",idcliente);
        toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{
        data = JSON.stringify(data);
        sessionStorage.setItem("servicioscte", data); 
        data=JSON.parse(data);
    let servicio = data;
    //console.log(servicio);
    
    let tbl = byID("tbl-servicios"); 
    for( var element of servicio){
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            
            cll0.innerHTML = element.estacion;
            cll1.innerHTML = element.fecha;
            cll2.innerHTML = element.folio;
            cll3.innerHTML = formatCant("$"+element.importe);
            cll4.innerHTML = element.litros;
            cll5.innerHTML = element.producto;
            cll6.innerHTML = element.tarjeta;
            
    }   
    });
}

function filtrarBitacora(){

    let tbl = byID("tbl-bitacora").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    var cte1 = sessionStorage.getItem("sesionlog");
    cte1 = JSON.parse(cte1);
    //console.log(cte1[0].idcliente);
    var idcliente = cte1[0].idcliente;
    var fechainicial = byID("fechaini").value;
    var fechafinal = byID("fechafin").value;
    let toSend = new FormData();
        toSend.append("id","bitacoraFiltrada");
        toSend.append("idcliente",idcliente);
        toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{
        data = JSON.stringify(data);
        sessionStorage.setItem("bitacorasfiltradas", data); 
        data=JSON.parse(data);
    let servicio = data;
    //console.log(servicio);
    
    let tbl = byID("tbl-bitacora"); 
    for( var element of servicio){
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            
            cll0.innerHTML = element.fecha;
            cll1.innerHTML = element.tipo;
            cll2.innerHTML = element.descripcion;

    }   
    });
}

function filtrarAbono(){

    let tbl = byID("tbl-abonos").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    var cte1 = sessionStorage.getItem("sesionlog");
    cte1 = JSON.parse(cte1);
    //console.log(cte1[0].idcliente);
    var idcliente = cte1[0].idcliente;
    var fechainicial = byID("fechainiabono").value;
    var fechafinal = byID("fechafinabono").value;
    let toSend = new FormData();
        toSend.append("id","AbonosFiltrado");
        toSend.append("idcliente",idcliente);
        toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{
        data = JSON.stringify(data);
        sessionStorage.setItem("AbonosFiltrados", data); 
        data=JSON.parse(data);
    let abono = data;
    //console.log(servicio);
    
    let tbl = byID("tbl-abonos"); 
    for( var element of abono){
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            
            cll0.innerHTML = element.fecha;
            cll1.innerHTML = element.bancodestino;
            cll2.innerHTML = element.cuentabancaria;
            cll3.innerHTML = element.concepto;
            cll4.innerHTML = element.formapago;
            cll5.innerHTML = element.importe;
            cll6.innerHTML = element.referencia;
            

    }   
    });
}


function leer_Choferes(){
    
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    //console.log(cte)
    fetch("https://compras.grupopetromar.com/monedero/admin/apirest/?id=getChoferes&cte="+cte, {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => {
       // console.log(data);
        data = JSON.stringify(data);
        sessionStorage.setItem("choferes", data);
        let tbl = byID("tbl-choferes").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }

        let choferes = sessionStorage.getItem("choferes");
        choferes = JSON.parse(choferes);
        tbl = byID("tbl-choferes");
        for (var element of choferes) { 
            var rw = tbl.insertRow();
            var cll7 = rw.insertCell();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            
            var input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("id",element.idchofer);
            input.setAttribute("name","bntADchofer");
            input.setAttribute("onClick",'activarbtn2('+element.idchofer+')');
            if(element.activo==1){
                input.setAttribute("class",'Activo');
                input.setAttribute("value","Activo");
            }else{ 
                input.setAttribute("value","Inactivo");
                input.setAttribute("class",'Inactivo');
                rw.style.backgroundColor = '#D7D7D7';}
            cll7.append(input);
            cll0.innerHTML = element.idchofer;
            cll1.innerHTML = element.nombre;

        } 

        
    });
}
function leer_facturas(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    console.log(cte)
    fetch("https://compras.grupopetromar.com/monedero/apirest/?id=getFacturas&cte="+cte, {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => {
       // console.log(data);
        data = JSON.stringify(data);
        sessionStorage.setItem("facturas", data);
        let tbl = byID("tbl-facturas").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }

        let facturas = sessionStorage.getItem("facturas");
        facturas = JSON.parse(facturas);
        tbl = byID("tbl-facturas");
        for (var element of facturas) { 
            var rw = tbl.insertRow();
            
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
        
            cll0.innerHTML = element.folio;
            cll1.innerHTML = formatDate(element.fechagenerado);
            cll2.innerHTML = formatCant("$"+element.importe);
            cll3.innerHTML = element.cantidad;

        } 

        
    });
}
//////////////
function formatDate(date){
    let index = date.search(" ");
    date = date.substring(0, index);
    date = date.split("-");
    let formatedDate = date[2] +"/"+ date[1] +"/"+ date[0];
    return(formatedDate);
}
function formatFecha(date){
    //let index = date.search(" ");
    date = date.substring(0, 10);
    date = date.split("-");
    let formatedDate = date[2] +"/"+ date[1] +"/"+ date[0];
    return(formatedDate);
}




//Fecha
function fechadehoy(){
    /*var currentTime = new Date();
    var year = currentTime.getFullYear();
    var month = currentTime.getMonth()+1;
    var date = String(currentTime.getDate()).padStart(2,'0');
    var fecha = year+'-'+month+'-'+date;
    alert(date.toString());
    */
     
     
      var hoy =new Date(new Date().setDate(new Date().getDate() - 0)),
         
      d = hoy.getDate(),
      m = hoy.getMonth()+1, 
      y = hoy.getFullYear(),
      data;
    
    if(d < 10){
      d = "0"+d;
    };
    if(m < 10){
      m = "0"+m;
    };
    
    data = y+"-"+m+"-"+d;
     // alert(data);

        document.getElementById("fechafinFac").value = data;
        document.getElementById("fechafinserv").value = data;
        document.getElementById("fechafin").value = data;
        document.getElementById("reFfinal").value = data;
        document.getElementById("fechafinabono").value = data;
}
    
    
    
function fechaanterior(){
       
        var hoy =new Date(new Date().setDate(new Date().getDate() - 7)),
            d = hoy.getDate(),
            m = hoy.getMonth()+1, 
            y = hoy.getFullYear(),
            data;
    
        if(d < 10){
            d = "0"+d;
        };
        if(m < 10){
            m = "0"+m;
        };
    
        data = y+"-"+m+"-"+d;
      
       // alert(data);
        document.getElementById("fechainiFac").value = data;
        document.getElementById("fechainiserv").value = data;
        document.getElementById("fechaini").value = data;
        document.getElementById("reFinicio").value = data;
        document.getElementById("fechainiabono").value = data;
        
}   
    
function activarbtn(i){
        if(document.getElementById(i).value=='Activo'){
            document.getElementById(i).value="Inactivo";
            document.getElementById(i).classList='Inactivo';
            
        }else{
            document.getElementById(i).value="Activo";
            document.getElementById(i).classList='Activo';
        }
}
function activarbtn1(i){
    if(document.getElementById(i).value=='Activo'){
        document.getElementById(i).value="Inactivo";
        document.getElementById(i).classList='Inactivo';
        
    }else{
        document.getElementById(i).value="Activo";
        document.getElementById(i).classList='Activo';
    }
}
function activarbtn2(i){
    if(document.getElementById(i).value=='Activo'){
        document.getElementById(i).value="Inactivo";
        document.getElementById(i).classList='Inactivo';
        
    }else{
        document.getElementById(i).value="Activo";
        document.getElementById(i).classList='Activo';
    }
}


function ActivarDesactivarChofer(){ 
    let check = document.getElementsByName("bntADchofer");
    let activo;
    let iduser;
    var btn = Array.from(check);
    let toSend = new FormData();
    for(let item of btn){
        
       if(item.value=="Activo"){
           activo = "1";
           iduser = item.id;
       }else{
            activo = "0";
            iduser = item.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarChofer");
       toSend.append("activo[]",activo);
       toSend.append("iduser[]",iduser);
    }
       fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            //console.log(data)
         if(btn.length.toString() == data.trim()){
            mensajeRespuesta("Guardado Correctamente")
            leer_Choferes();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
          
     
}
function ActivarDesactivarTar(){ 
    
    let check = document.getElementsByName("bntADTar");
    let activo;
    let iduser;
    var btn = Array.from(check);
    let toSend = new FormData();
    for(let item of btn){
        
       if(item.value=="Activo"){
           activo = "1";
           iduser = item.id;
       }else{
            activo = "0";
            iduser = item.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarTar");
       toSend.append("activo[]",activo);
       toSend.append("iduser[]",iduser);
    }
       fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            //console.log(btn.length.toString() +"----" +data.trim())
         if(btn.length.toString() == data.trim()){
            mensajeRespuesta("Guardado Correctamente");
            leer_Tarjeta();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
          
     
}

function ActivarDesactivarVehi(){ 
    let check = document.getElementsByName("bntADvehi");
    let activo;
    let iduser;
    var btn = Array.from(check);
    let toSend = new FormData();
    for(let item of btn){
        
       if(item.value=="Activo"){
           activo = "1";
           iduser = item.id;
       }else{
            activo = "0";
            iduser = item.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarVehi");
       toSend.append("activo[]",activo);
       toSend.append("iduser[]",iduser);
    }
       fetch("https://compras.grupopetromar.com/monedero/apirest/", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            console.log(data)
         if(btn.length.toString() == data.trim()){
            mensajeRespuesta("Guardado Correctamente")
            leer_Vehiculos();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
    
     
}

function mensajeRespuesta(res){
    let mensaje = document.createElement("div");
    mensaje.classList.add("alerta");
    let lbl = document.createElement("label");
    lbl.innerHTML= res;
    mensaje.append(lbl);
    document.getElementsByTagName("body")[0].append(mensaje);
    setTimeout(function(){
        mensaje.remove()
    },
       2500
    )

}
