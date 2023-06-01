/*  Short syntax for document.getElementById()  */
function byID(id){
    return document.getElementById(id);
}

function logOutVe(){
    let mensaje = document.createElement("div");
        mensaje.setAttribute("id","mensajeCsesion");
        mensaje.classList.add("alertaCS");
        let lbl = document.createElement("label");
        lbl.innerHTML= "¿Desea salir de la sesion?";
        mensaje.append(lbl);
        let hr = document.createElement("hr");
        mensaje.append(hr); 
        let hr1 = document.createElement("hr");
        mensaje.append(hr1); 
        let br = document.createElement("br");
        mensaje.append(br); 
        
        let btna = document.createElement("input");
        btna.setAttribute("type","submit");
        btna.setAttribute("id","btnaceptar");
        btna.setAttribute("name","bntAD2cS");
        btna.setAttribute("onClick",'logOut()');
        btna.setAttribute("class",'Activo1');
        btna.setAttribute("value","Aceptar");
        
        let btnc = document.createElement("input");
        btnc.setAttribute("type","submit");
        btnc.setAttribute("id","btncancelar");
        btnc.setAttribute("name","bntADcS");
        btnc.setAttribute("onClick","CancelarAct('mensajeCsesion')");
        btnc.setAttribute("class",'Inactivo1');
        btnc.setAttribute("value","Cancelar");
    
        mensaje.append(btnc);
        mensaje.append(btna);
    
        document.getElementsByTagName("body")[0].append(mensaje);
        setTimeout(function(){
            mensaje.remove()
        },
            30000
        )
}

function CancelarAct(i){
    let mensaje = byID(i);
    mensaje.remove();
   }
   
function initMap() {
    let map;
    map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 23.2399997, lng: -106.4461689 },
    zoom: 13,
  });

    let preciomagna=0;
    let nombremagna=0;
    let preciopremium=0;
    let nombrepremium=0;
    let preciodiesel=0;
    let nombrediesel=0;
    let preciogas=0;
    let nombregas=0;
  let toSend = new FormData();
  toSend.append('id', "coordenadasEstaciones");
fetch("https://monedero.grupopetromar.com/apirest/index.php/", {
  method: "POST",
  mode: "cors",
  body: toSend,
})
.then(response => response.text())
.catch(error => alert(error))
.then((data) => {
  data=JSON.parse(data);
  //console.log(data);
  let precios=data.precios;
  data=data.estaciones;
  
  for(let ubi of data){
      let lat = ubi.lat;
      let long = ubi.longi;
      //console.log(lat);
      for(let pre of precios){
          
          if(pre.idestacionprod==ubi.idestacion){
              if(pre.idproduc==1){
                preciomagna = pre.preciouni;
                nombremagna = pre.nombreprod;
              }
              if(pre.idproduc==2){
                preciopremium = pre.preciouni;
                nombrepremium = pre.nombreprod;
            }
            if(pre.idproduc==3){
                preciodiesel = pre.preciouni;
                nombrediesel = pre.nombreprod;
            }
            if(pre.idproduc==4){
                 preciogas = pre.preciouni;
                nombregas = pre.nombreprod;
            }
            const myLatLng1 = { lat:parseFloat(lat), lng: parseFloat(long) };
            marker = new google.maps.Marker({
                position: myLatLng1,
                map: map,
                title: ubi.nombre+"\n"+nombremagna+": $"+preciomagna+"\n"+nombrepremium+": $"+preciopremium+"\n"+nombrediesel+": $"+preciodiesel,
              });
          }
        
      }

      
  }
// console.log(marker)
})    
 // leer_ubicacion();
}

function leer_ProdyEsta(){ 
    var sesionlog = sessionStorage.getItem("sesionlog");
    sesionlog = JSON.parse(sesionlog);
    //console.log(sesionlog)
    sesionlog = sesionlog[0];
    
    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getProd&cte="+sesionlog.idcliente,{
        method: "GET",
        modo: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => { 
        data= JSON.stringify(data);
        sessionStorage.setItem("prod",data);
       
        //console.log(data);

        fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getEsta&cte="+sesionlog.idcliente,{
        method: "GET",
        modo: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => { 
        data= JSON.stringify(data);
        sessionStorage.setItem("esta",data);
       
        //console.log(data);
        leer_Tarjeta();
        
    });
        
    });

}

function leer_prodRel(){
    let cte = sessionStorage.getItem("sesionlog");
    cte=JSON.parse(cte);
    cte=cte[0].idcliente;
    //console.log(cte)
    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getProducto", {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())  
    .catch(error => console.log(error))
    .then((data) => {
        data=JSON.stringify(data);
        sessionStorage.setItem("ProdRel", data);


        //console.log(data);  
        
    });

    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getEstacionRel&cte="+cte, {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())  
    .catch(error => console.log(error))
    .then((data) => {

        data=JSON.stringify(data);
        sessionStorage.setItem("EstacionRela", data);
        //console.log(data);  
        
    });


}

function logOut(){
    sessionStorage.clear();
    window.location = "./login.html";
}

function nomUsu(){
    let nombre = sessionStorage.getItem("sesionlog");
    nombre = JSON.parse(nombre);
    document.getElementById("notificationNom").innerHTML = nombre[0].nombreweb;
   
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
    usuario.innerHTML = datosUsuario.rzonsocial;

    let abonos = sessionStorage.getItem("abonos");
    abonos = JSON.parse(abonos);
    let restante = 0.00;
    for (let item of abonos){
        //item.importedisponible 
        restante += parseFloat(item.importedisponibleabono);
        
    }
    
    saldo.innerHTML = formatNumber(restante);

    let tarjetasCte = sessionStorage.getItem("tarjetas");
    tarjetasCte = JSON.parse(tarjetasCte);
    tarjetasCte = tarjetasCte.length;
    tarjetas.innerHTML = tarjetasCte;

    let servicios = sessionStorage.getItem("servicios");
    servicios = JSON.parse(servicios);
    let noTrans = 0;
    let totalTrans = 0.00;
    let fecha = new Date();
    let day = fecha.getDate();
    let month =fecha.getMonth()+1;
    if(month < 10){
        month = "0"+month;
    };
    let year = fecha.getFullYear();
    let date = day+"/"+month+"/"+year;

    //console.log(date)
    for (let item of servicios){
        let hoy = formatDate(item.fecha)
       // console.log(hoy)
        if(hoy==date){
        totalTrans += parseFloat(item.importe);
        noTrans = noTrans+1;
        //console.log("condicion "+hoy+"-"+date)
        }

    }
    movshoy.innerHTML = noTrans+' / '+formatNumber(totalTrans);
}


function leer_Vehiculos(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];

    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getVehiculos&idcliente="+cte.idcliente,{
            method: "GET",
            mode: "cors",
        }
    )
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        sessionStorage.setItem("vehiculos", JSON.stringify(data));
        
        let tbl = byID("tbl-vehiculos").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
        let vehiculos = data;
        tbl = byID("tbl-vehiculos"); 
        // vehiculos = JSON.parse(vehiculos);
        for (var element of vehiculos) { 
            var rw = tbl.insertRow();
            var cll7 = rw.insertCell();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            var input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("id",element.idvehiculo);
            input.setAttribute("name","bntADvehi");
            input.setAttribute("onClick",'activarbtn('+element.idvehiculo+')');
            if(element.activo==1){
                input.setAttribute("class",'Activo');
                input.setAttribute("value","Activo");
            }else{ 
                input.setAttribute("value","Inactivo");
                input.setAttribute("class",'Inactivo');
                rw.style.backgroundColor = '#D7D7D7';}
            cll7.append(input);
            cll0.innerHTML = element.idtarjeta;
            cll1.innerHTML = element.modelo;
            cll2.innerHTML = element.ano;
            cll3.innerHTML = element.placas;
            cll4.innerHTML = element.centrocosto;
            if(element.controlaodometro==1){
                cll5.innerHTML = "Si" 
            }else{
                cll5.innerHTML = "No"
            }
            
            cll6.innerHTML = formatDate(element.fechacaptura);
        }

        fillSelects_Vehiculos();
        fillSelects_Placas();
        fillSelects_pla()
    })

    
}
function leer_UsuarioWeb(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];
    //console.log(cte.idcliente)
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getUsuariosWeb&idcliente="+cte.idcliente,{
            method: "GET",
            mode: "cors",
        }
    )
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        //console.log(data)
        sessionStorage.setItem("Usuario", JSON.stringify(data));
        let tbl = byID("tbl-UsuWeb").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
        let usuario = data;
        tbl = byID("tbl-UsuWeb"); 
       // usuario = JSON.parse(usuario);
        //console.log(usuario)
        for (var element of usuario) { 
            var rw = tbl.insertRow();
            var cll7 = rw.insertCell();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("id",element.idusuarioweb);
            input.setAttribute("name","bntADusu");
            input.setAttribute("onClick",'activarbtnUW('+element.idusuarioweb+')');
            if(element.activo==1){
                input.setAttribute("class",'Activo');
                input.setAttribute("value","Activo");
            }else{ 
                input.setAttribute("value","Inactivo");
                input.setAttribute("class",'Inactivo');
                rw.style.backgroundColor = '#D7D7D7';}
            cll7.append(input);
            cll0.innerHTML = element.usuario;
            cll1.innerHTML = element.nombreweb;
        }

    })

}


function leer_Abonos(){
    let cte = sessionStorage.getItem("sesionlog");
    cte = JSON.parse(cte);
    cte = cte[0];

    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getAbonos&cte="+cte.idcliente,{
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
            cll5.innerHTML = formatNumber(element.importe);
            cll6.innerHTML = element.referencia;
        } 
        cards_Cliente();
    })
}

function leer_Tarjeta(){ 

    //console.log("leer tarjetas")

    var sesionlog = sessionStorage.getItem("sesionlog");
    sesionlog = JSON.parse(sesionlog);
    sesionlog = sesionlog[0];
    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getTarjetas&idcliente="+sesionlog.idcliente,{
        method: "GET",
        modo: "cors",
    })

    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => { 
        sessionStorage.setItem("tarjetas", JSON.stringify(data));

       fillSelects_Tarjetas();  
       fillSelects_Estaciones();
        let tarjeta = data;
        let tbl = byID("tbl-tarjetas"); 
        tbl = byID("tbl-tarjetas").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
        
        //console.log(tbl);
        //console.log(tarjeta)
        for( var element of tarjeta){
            let estaciones=sessionStorage.getItem("esta");
            estaciones=JSON.parse(estaciones);
            let e=[];
            let dia=[];
            let combustible=sessionStorage.getItem("prod");
            combustible=JSON.parse(combustible);
            let c=[]
            let periodo=[];
            let tipo=[];
            let activo=[];
            for(let ele of estaciones){
                
                if(ele.folio==element.folio){
                    e.push(ele.nombre+" ")
                   // console.log(ele.nombre)
                }
            }
            //combustibles
            for(let f of combustible){
                if(f.folio==element.folio){
                    c.push(f.nombre+" ")
                   // console.log(f.nombre)
                }
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
            if(element.tipo==2){
                tipo.push("Tarjeta")
            }else{tipo.push("RFID")}
            if(element.activo==0){
                activo.push("Inactivo")
            }else{activo.push("Activo")}
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
            }if(element.activo==0){ 
                input.setAttribute("value","Inactivo");
                input.setAttribute("class",'Inactivo');
                rw.style.backgroundColor = '#D7D7D7';}
            cll7.append(input);
            cll0.innerHTML = element.notarjeta;
            cll2.innerHTML = tipo;
            cll3.innerHTML = e;
            cll4.innerHTML = c;
            cll5.innerHTML = dia+", "+element.horarioinicial+" - "+element.horariofinal;
            cll6.innerHTML = "Litros: "+element.limitelitros+"Lts Dinero: "+formatNumber(element.limitedinero)+" Periodo: "+periodo;
        }
        fillSelects_noTarjetas();
        
    })

    
}

function leer_Bitacora(){
    var sesionlog = sessionStorage.getItem("sesionlog");
    sesionlog = JSON.parse(sesionlog);
    sesionlog = sesionlog[0];
fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getBitacora&idcliente="+sesionlog.idcliente,{
    method: "GET",
    modo: "cors",
})

.then(response => response.json())
.catch(error => console.log(error))
.then((data) => { 
    let tbl = byID("tbl-bitacora"); 
        tbl = byID("tbl-bitacora").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    //sessionStorage.setItem("Bitacora", JSON.stringify(data)); 
    let abonos = data;
    let accion;
    //console.log(abonos)
    tbl = byID("tbl-bitacora"); 
    for( var element of abonos){
        if(element.tipo=="Actualización tarjeta"){
            accion = "Se actualizó los valores de la tarjeta ";
        }
        if(element.tipo=="Actualización vehiculo"){
            accion = "Actualización al vehiculo con la terjeta: ";
        }
        if(element.tipo=="Servicio"){
            accion = "Se actualizó los valores de la tarjeta ";
        }
        if(element.tipo=="Realizó abono"){
            accion = "Se realizó un abono por la cantidad: $ ";
        }
        if(element.tipo=="Registro de tarjeta"){
            accion = "Se registro una nueva tarjeta:  "
        }
        if(element.tipo=="Registro de vehiculo"){
            accion = "Se registró un nuevo vehiculo : ";
        }
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            cll0.innerHTML = formatDate(element.fecha);
            cll1.innerHTML = element.tipo;
            cll2.innerHTML = accion + element.descripcion;
            
    }

})

}

function fillSelects_pla(){ 
    var selects = document.getElementsByClassName("slplacas");
    var selects1 = document.getElementsByClassName("slnoeco");
    
    for (const item of selects) {
        selectPla(item);
    }
    for (const item of selects1) {
        selectNoe(item);
    }

}
function selectPla(item){
   
    var options =  item.childNodes;
    options = Array.from(options);

    for(let element of options){ 
       // console.log(options);
        element.remove();
    }

    var placas = sessionStorage.getItem("vehiculos");
    placas = JSON.parse(placas);
    
     for (var element of placas) { 
        var option = document.createElement("option");
        option.text = element.placas;
        option.value = element.idvehiculo;
        item.add(option);
        
    } 
}
function selectNoe(item){
   
    var options =  item.childNodes;
    options = Array.from(options);

    for(let element of options){ 
       // console.log(options);
        element.remove();
    }

    var Noeco = sessionStorage.getItem("vehiculos");
    Noeco = JSON.parse(Noeco);
    
     for (var element of Noeco) { 
        var option = document.createElement("option");
        option.text = element.noeconomico;
        option.value = element.idvehiculo;
        item.add(option);
        
    } 
}

function fillSelects_Chofer(){ 
    var selects = document.getElementsByClassName("slchofer");
    
    for (const item of selects) {
        selectChofer(item);
    }

}
function selectChofer(item){
    var options =  item.childNodes;
    options = Array.from(options);

    for(let element of options){ 
       // console.log(options);
        element.remove();
    }

    var chofer = sessionStorage.getItem("choferes");
    chofer = JSON.parse(chofer);
    
     for (var element of chofer) { 
        var option = document.createElement("option");
        option.text = element.nombre;
        option.value = element.idchofer;
        item.add(option);
        
    } 
}

function fillSelects_Estaciones(){ 
    var selects = document.getElementsByClassName("slestacion");
    
    for (const item of selects) {
        selectEstaciones(item);
    }

}

function leer_estaciones(){
    //alert("Hola");
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getEstaciones", {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => {
        //console.log(data)
        data = JSON.stringify(data);
        sessionStorage.setItem("estaciones", data);
        
        estaciones_checks();
    });
}


function checktodas2(){
    let check = byID("estchecks-all2");
    let checks = document.getElementsByName("checkestacion2");
    if(check.checked==true){
        for(element of checks){
            element.checked = true;
        }
    }
    if(check.checked==false){
        for(element of checks){
            element.checked = false;
        }
    }
}
/*function selectEstaciones(item){
    var options =  item.childNodes;
    options = Array.from(options);
    for(let element of options){ 
       // console.log(options);
        element.remove();
    }
    var santafe = document.createElement("option");
    santafe.text = "Santa fé";
    santafe.value = "1";
    item.add(santafe);
    var ley = document.createElement("option");
    ley.text = "Ley";
    ley.value = "2";
    item.add(ley);
    var insurgentes = document.createElement("option");
    insurgentes.text = "Insurgentes";
    insurgentes.value = "3";
    item.add(insurgentes);
    var munich = document.createElement("option");
    munich.text = "Munich";
    munich.value = "4";
    item.add(munich);
    var libramiento = document.createElement("option");
    libramiento.text = "Libramiento";
    libramiento.value = "5";
    item.add(libramiento);
    var lopez = document.createElement("option");
    lopez.text = "Lopéz";
    lopez.value = "6";
    item.add(lopez);
    var rio = document.createElement("option");
    rio.text = "Río";
    rio.value = "7";
    item.add(rio);
   
    var estacion = sessionStorage.getItem("tarjetas");
    estacion = JSON.parse(estacion);
    
     for (var element of estacion) { 
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.folio;
        item.add(option);
        
    } 
}*/

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
     var Seleccione = document.createElement("option");
     Seleccione.text = "Seleccione una Tarjeta...";
     Seleccione.value = "";
     item.add(Seleccione);
     for (var element of tarjeta) { 
        var option = document.createElement("option");
        option.text = element.notarjeta;
        option.value = element.folio;
        item.add(option);
        
    } 
}
/*
function estaciones_checks(){
    let estaciones = sessionStorage.getItem("estaciones");
    estaciones = JSON.parse(estaciones);
    let div2 = byID("estaciones-checks2");
    //console.log(estaciones)
    for(element of estaciones){
        var input = document.createElement("input");
        input.setAttribute("type","checkbox");
        input.setAttribute("value",element.idestacion);
        input.setAttribute("name","checkestacion2");
        input.setAttribute("id",element.idestacion);
        div2.appendChild(input);
        var label = document.createElement("label");
        label.setAttribute("for",element.idestacion);
        label.innerHTML=element.nombre;
        div2.appendChild(label);    
        var br = document.createElement("br");
        div2.appendChild(br);  
    }
}
*/
function estaciones_checks(){
    let estaciones = sessionStorage.getItem("estaciones");
    estaciones = JSON.parse(estaciones);
    let div2 = byID("estaciones-checks2");
    //console.log(estaciones)
    for(element of estaciones){
        var input = document.createElement("input");
        input.setAttribute("type","checkbox");
        input.setAttribute("value",element.idestacion);
        input.setAttribute("name","listadeestacionesconcheck");
        input.setAttribute("id",element.idestacion);
        div2.appendChild(input);
        var label = document.createElement("label");
        //label.setAttribute("for",element.idestacion);
        label.innerHTML=element.nombre;
        div2.appendChild(label);    
        var br = document.createElement("br");
        div2.appendChild(br);  
    }
}
function fillSelects_Placas(){
    var selects = document.getElementsByClassName("sltarjetas-placas");
    var selects2 = document.getElementById("altatarjetas-notarjeta");
    var selects3 = document.getElementById("limite-cant");
    let estaciones = document.getElementsByName("listadeestacionesconcheck");
    let combustibles = document.getElementsByName("listadecombustibles2");
    var checkday1 = document.getElementById("daycheck-1");
    var checkday2 = document.getElementById("daycheck-2");
    var checkday3 = document.getElementById("daycheck-3");
    var checkday4 = document.getElementById("daycheck-4");
    var checkday5 = document.getElementById("daycheck-5");
    var checkday6 = document.getElementById("daycheck-6");
    var checkday7 = document.getElementById("daycheck-7");
    var fechaini = document.getElementById("daytime-ini");
    var fechafin = document.getElementById("daytime-fin");
    var litros = document.getElementById("limite-cant");
    var tipo = document.getElementById("limite-cant1");
    var dinero = document.getElementById("limite-din");
    var periodo = document.getElementById("limite-periodo");
    for(element of estaciones){
        element.checked=false;
    }
    for(element of combustibles){
        element.checked=false;
    }
   
    checkday1.checked=false;
    checkday2.checked=false;
    checkday3.checked=false;
    checkday4.checked=false;
    checkday5.checked=false;
    checkday6.checked=false;
    checkday7.checked=false;
    
    leer_prodRel();
                
    for (const item of selects) {
        selectPlacas(item, selects2, selects3, estaciones, checkday1, checkday2, 
            checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo, tipo, combustibles);
    }
}


var producto;
function selectPlacas(item, selects2, selects3, estaciones,  checkday1, checkday2, 
    checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo, tipo, combustibles){ 
        
       let tarjeta1 = byID("altatarjetas-notarjeta").value;
       
       

        var ProdRel = sessionStorage.getItem("ProdRel");
        ProdRel = JSON.parse(ProdRel);


        for(element of ProdRel){
            if(element.folio_tarjeta==tarjeta1){
                for(let est of combustibles){
                    if(est.value==element.folio_producto){
                        est.checked = 'true';
                    }
                }
            }
         }

         var EstacionRela = sessionStorage.getItem("EstacionRela");
         EstacionRela = JSON.parse(EstacionRela);

         for(element of EstacionRela){
            if(element.folio_tarjeta==tarjeta1){
                for(let est of estaciones){
                    if(est.value==element.folio_estacion){
                        est.checked = 'true';
                    }
                }
            }
         }



    var placas = sessionStorage.getItem("vehiculos");
    placas = JSON.parse(placas);
    var tarjeta = sessionStorage.getItem("tarjetas");
    tarjeta = JSON.parse(tarjeta);
    for (let element of placas) { 
        if(element.idtarjeta==selects2.value){
            item.value = element.placas;
        }
        if(selects2.value==null||selects2.value==""){
            for(element of estaciones){
                element.checked=false;
            }
            for(element of combustibles){
                element.checked=false;
            }
            checkday1.checked=false;
            checkday2.checked=false;
            checkday3.checked=false;
            checkday4.checked=false;
            checkday5.checked=false;
            checkday6.checked=false;
            checkday7.checked=false;
            selects3.value="1";
            selects2.value="";
            byID("altatarjetas-placas").value="";
            byID("daytime-ini").value="";
            byID("daytime-fin").value="";
            byID("limite-cant").value="";
            //byID("limite-din").value="";
        }
    } 
    for( let tar of tarjeta){
        if(selects2.value==tar.folio){  
            fechaini.value= tar.horarioinicial;  
            fechafin.value= tar.horariofinal;
           // litros.value= tar.limitelitros;
           // dinero.value= tar.limitedinero;
           console.log(tar.tipolimite);
            if(tar.tipolimite==1){
                tipo.value = "1";
                litros.value= tar.limitelitros;
            }else{
                tipo.value = "2";
                litros.value= tar.limitedinero;
            }
            if(tar.tipoperiodo=="1"){
                periodo.value = 1 ;
            }
            if(tar.tipoperiodo=="2"){
                periodo.value = 2 ;
            }
            if(tar.tipoperiodo=="3"){
                periodo.value = 3 ;
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
        
            /*for(element of producto){
                if(element.folio_tarjeta==tar.tarjeta_producto){
                    if(element.folio_tarjeta==1){checkprod1.checked="true"};
                    if(element.folio_tarjeta==2){checkprod2.checked="true"};
                    if(element.folio_tarjeta==3){checkprod3.checked="true"};
                    if(element.folio_tarjeta==4){checkprod4.checked="true"};
                }
            }*/
        
        }
        }
        
    }

function alta_UsuariosWeb(){
    let divusu = document.getElementById("divusuWeb");
 
    if(divusu.style.display=="none"){
        divusu.style.display="block";
        
    }else{
    var cliente = sessionStorage.getItem("sesionlog");
    cliente= JSON.parse(cliente);
    cliente = cliente[0].idcliente;
    var nombre = byID("altauserweb-name").value;
    var usuario = byID("altauserweb-user").value;
    var contra = byID("altauserweb-pass").value;
    var tipo = byID("altauserweb-tipo").value;
    var checkadmin = +(byID("userweb-checkadmin").checked);
    var checkrepor = +(byID("userweb-checkrepor").checked);
    var checkgrafs = +(byID("userweb-checkgrafs").checked);
    var checksecur = +(byID("userweb-checksecur").checked);
    if(nombre==""||usuario==""||contra==""){return alert("Complete los campos")}
    if(checkadmin=="0"&&checkrepor=="0"&&checkgrafs=="0"&&checksecur=="0"){return alert("Complete los campos")}
    let toSend = new FormData();
        toSend.append('id', "agregarUsuarioWeb");
        toSend.append('nombre', nombre);
        toSend.append('idcliente', cliente);
        toSend.append('usuario', usuario);
        toSend.append('contrasena', contra);
        toSend.append('tipo', tipo);
        toSend.append('administracion', checkadmin);
        toSend.append('reportes', checkrepor);
        toSend.append('graficas', checkgrafs);
        toSend.append('seguridad', checksecur);

    fetch("https://monedero.grupopetromar.com/apirest/index.php", {
        method: "POST",
        mode: "cors",
        body: toSend,
    })
    .then(response => response.text())
    .catch(error => alert(error))
    .then((data) => {
        if(data==1){
            mensajeRespuesta("Guardado Correctamente")
        byID("altauserweb-tipo").value="1";
        byID("altauserweb-name").value="";
        byID("altauserweb-user").value="";
        byID("altauserweb-pass").value="";
        (byID("userweb-checkadmin").checked=false);
        (byID("userweb-checkrepor").checked=false);
        (byID("userweb-checkgrafs").checked=false);
        (byID("userweb-checksecur").checked=false);
        divusu.style.display="none";
        leer_UsuarioWeb();}
        else{mensajeError(data)}
    });
    
}
}

function UpDateTarjetas(){
    /*let mensaje = document.createElement("div");
    mensaje.classList.add("alerta");
    let lbl = document.createElement("label");
    lbl.innerHTML= res;
    mensaje.append(lbl);
    document.getElementsByTagName("body")[0].append(mensaje);
    setTimeout(function(){
        mensaje.remove()
    },
       2500
    )*/
    
    var tarjeta = document.getElementById("altatarjetas-notarjeta").value;
    let estacion= document.getElementsByName("listadeestacionesconcheck");
    var horaiodia = document.getElementsByName("tarjetas-daycheck");
    var horaio = document.getElementsByName("tarjetas-daytime");
    var limiteC = document.getElementById("limite-cant").value;
    var tipoLimite = document.getElementById("limite-cant1").value;
    //1 -> litros 
    //2 -> importe 

    //var limiteD = document.getElementById("limite-din").value;
    var productos = document.getElementsByName("listadecombustibles2");
    var limiteP = document.getElementById("limite-periodo").value;
    let arregloEstacion = [].slice.call(estacion);
    let arreglohd = [].slice.call(horaiodia);
    let e=0;
    let contador2=0;
    let hd=0;
    //console.log(arreglocombustible)
    let toSend = new FormData();

    for(let element of productos){
        if(element.checked){
            toSend.append("combustible[]",element.value);
            //console.log(element.value)
            contador2 = Number(contador2) + 1;
        }
    }


    arregloEstacion.forEach((est) => {
        
        if(est.checked){
           // console.log(est.value)
           e+=
            toSend.append('estacion[]', est.value);
        }
    });

    
    arreglohd.forEach((est) => {
        
        if(est.checked){
           // console.log(est.value)
           hd+= 
           console.log();
        }
    });


    //console.log(arregloEstacion instanceof Array);
    if(tarjeta==""||tarjeta==null){
        return alert("Seleccione una tarjeta");
    }
    if(e==0){
        return alert("Ninguna estación fue seleccionada")
    }
    if(contador2==0){
        return alert("Ningun combustible fue seleccionado")
    }
    if(hd==0){
        return alert("Ningun día fue seleccionado")
    }
    if(horaio[0].value==null||horaio[0].value==""||horaio[1].value==null||horaio[1].value==""){
        return alert("Ingrese un horario valido")
    }
    if(limiteC==""||limiteC==null){
        return alert("Ingrese limite valido")
    }
    

        toSend.append('id', 'UpDateTarjeta');
        toSend.append('tarjeta', tarjeta);

        

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
       // toSend.append('limiteD', limiteD);
        toSend.append('limiteP', limiteP);
        toSend.append('tipoLimite', tipoLimite);
        //console.log(toSend)
    fetch("https://monedero.grupopetromar.com/apirest/index.php/", {
        method: "POST",
        mode: "cors",
        body: toSend,
    })
    .then(response => response.text())
    .catch(error => alert(error))
    .then((data) => {
       //console.log(data)
       if(data==1){
        leer_ProdyEsta();
        leer_Tarjeta();
        mensajeRespuesta("Guardado Correctamente")
        estacion[0].checked=false;
        estacion[1].checked=false;
        estacion[2].checked=false;
        estacion[3].checked=false;
        estacion[4].checked=false;
        estacion[5].checked=false;
        estacion[6].checked=false;
        for(element of productos){
            element.checked=false;
        }
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
        //document.getElementById("limite-din").value="";
        document.getElementById("limite-periodo").value="1";
        document.getElementById("altatarjetas-placas").value="";
        //document.getElementById("altatarjetas-tipo").value="";
        document.getElementById("altatarjetas-notarjeta").value="";
        document.getElementById("checkcombus").checked=false;
        document.getElementById("estchecks-all2").checked=false;
        fillSelects_Placas()
       }else{mensajeError("ERROR AL GUARDAR");}
        
    
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
    
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getTransacciones&idcliente="+cte.idcliente, {
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
           // var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
           // cll0.innerHTML = element.estacion;
            cll1.innerHTML = formatDate(element.fecha);
            cll2.innerHTML = element.folio;
            cll3.innerHTML = formatNumber(element.importe);
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
        

    fetch("https://monedero.grupopetromar.com/apirest/index.php",{
            method: "POST",
            mode: "cors",
            body: toSend,
    })
    .then(response => response.text())
    .catch(error => alert("error"))
    .then((data)=>{
        if(data=1){
        mensajeRespuesta("Vehiculo Actualizado Correctamente")
        leer_Vehiculos()}else{mensajeRespuesta("Error")}
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

        fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
    console.log(factura);
    
    let tbl = byID("tbl-facturas"); 
    for( var element of factura){
        let elPDF = element.factura;
            
        if(!elPDF){
            elPDF="00000";
        }
        elPDF =elPDF.slice(0,-4);
        let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+elPDF+".pdf";
        
        var rw = tbl.insertRow();
        var cll0 = rw.insertCell();
        var cll1 = rw.insertCell();
        var cll2 = rw.insertCell();
        var cll3 = rw.insertCell();
        var cll4 = rw.insertCell();
        var cll7 = rw.insertCell();
        var input = document.createElement("input");
            input.setAttribute("type","submit");
            input.setAttribute("id",element.folio);
            input.setAttribute("name","bntPDFfac");
           // input.setAttribute("onClick",'PDFfactura()');
            input.setAttribute("class",'bttn bttn-success');
            input.setAttribute("value","PDF");
            input.addEventListener("click",()=>{PDFfactura(url)}, false);
            
    
        cll0.innerHTML = element.folio;
        cll1.innerHTML = formatDate(element.fechagenerado);
        cll2.innerHTML = formatNumber(element.importe);
        cll3.innerHTML = element.cantidad;
        cll4.innerHTML = "<a href='https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+element.factura+"' target='_blank'>Descargar</a>";
        cll7.append(input);
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

        fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
           // var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            
            //cll0.innerHTML = element.estacion;
            cll1.innerHTML = formatDate(element.fecha);
            cll2.innerHTML = element.folio;
            cll3.innerHTML = formatNumber(element.importe);
            cll4.innerHTML = element.litros;
            cll5.innerHTML = element.producto;
            cll6.innerHTML = element.tarjeta;
            
    }   
    });
}

function filtrarBitacora(){

    var cte1 = sessionStorage.getItem("sesionlog");
    cte1 = JSON.parse(cte1);
    //console.log(cte1[0].idcliente);
    var idcliente = cte1[0].idcliente;
    //var fechainicial = byID("fechaini").value;
    var fechafinal = byID("fechafin").value;
    let toSend = new FormData();
        toSend.append("id","bitacoraFiltrada");
        toSend.append("idcliente",idcliente);
       // toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
    tbl = byID("tbl-bitacora").childNodes[1];
    let rows = tbl.getElementsByTagName("tr");
    rows = Array.from(rows);
    rows.shift();
    for(let elmt of rows){
        elmt.remove();
    }
    tbl = byID("tbl-bitacora");
        
    for( var element of servicio){
        if(element.tipo==1){
            accion = "Se actualizó los valores de la tarjeta ";
            element.tipo ="Actualización tarjeta";
        }
        if(element.tipo==2){
            accion = "Actualización al vehiculo con la terjeta: ";
            element.tipo = "Actualización vehiculo";
        }
        if(element.tipo==3){
            accion = "Se realizó un nuevo servicio ";
            element.tipo = "Servicio";
        }
        if(element.tipo==4){
            accion = "Se realizó un abono por la cantidad de: $ ";
            element.tipo = "Realizó abono";
        }
        if(element.tipo==5){
            accion = "Se registró una nueva tarjeta: ";
            element.tipo = "Registro de tarjeta";
        }
        if(element.tipo==6){
            accion = "Se registro un nuevo vehiculo asociado a la tarjeta: ";
            element.tipo = "Registro de vehiculo";
        }
        var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            
            cll0.innerHTML = formatDate(element.fecha);
            cll1.innerHTML = element.tipo;
            cll2.innerHTML = accion+ element.descripcion;

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

        fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
            
            cll0.innerHTML = formatFecha(element.fecha);
            cll1.innerHTML = element.bancodestino;
            cll2.innerHTML = element.cuentabancaria;
            cll3.innerHTML = element.concepto;
            cll4.innerHTML = element.formapago;
            cll5.innerHTML = formatNumber(element.importe);
            cll6.innerHTML = element.referencia;
            

    }   
    });
}


function leer_Choferes(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    //console.log(cte)
    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php?id=getChoferes&cte="+cte, {
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
            if(element.choferactivo==1){
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
        fillSelects_Chofer()
        
    });
}
function leer_facturas(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    //console.log(cte)
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getFacturas&cte="+cte, {
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

            let elPDF = element.factura;
            
            if(!elPDF){
                elPDF="00000";
            }
            elPDF =elPDF.slice(0,-4);
            let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+elPDF+".pdf";
            let factura = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+element.factura;
            
            var rw = tbl.insertRow();
            
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll7 = rw.insertCell();
            var input = document.createElement("input");
                input.setAttribute("type","submit");
                input.setAttribute("id",element.folio);
                input.setAttribute("name","bntPDFfac");
                //input.setAttribute("onClick",'PDFfactura()');
                input.setAttribute("class",'bttn bttn-success');
                input.setAttribute("value","PDF");
                input.addEventListener("click",()=>{PDFfactura(url)}, false);

            var input1 = document.createElement("input");
                input1.setAttribute("type","submit");
                input1.setAttribute("id",element.folio);
                input1.setAttribute("name","bntPDFfac");
                input1.setAttribute("class",'btn btn-print');
                input1.setAttribute("value","XML");
                input1.addEventListener("click",()=>{XMLfactura(factura)}, false);
                
        
            cll0.innerHTML = element.folio;
            cll1.innerHTML = formatDate(element.fechagenerado);
            cll2.innerHTML = formatNumber(element.importe);
            cll3.innerHTML = element.cantidad;
            cll4.append(input1);
            cll7.append(input);
        } 

        
    });
}

function filtroRendimiento(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    let tbl = byID("tbl-rendimiento").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }
    
    let tar = document.getElementById("tarjetaR").value;
    let fechai = document.getElementById("fechainirend").value;
    let fechaf = document.getElementById("fechafinrend").value;
    
        //console.log();
    let toSend = new FormData();

    toSend.append("id","fRendimiento");
    toSend.append("tar",tar);
    toSend.append("fechai",fechai);
    toSend.append("fechaf",fechaf);
    toSend.append("cte",cte);

    fetch("https://monedero.grupopetromar.com/apirest/index.php", {
        method: "POST",
        mode: "cors",
        body: toSend

    })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
       console.log(data);
        let rendimiento = data;
        //console.log(rendimiento);
        rendimiento = rendimiento[0];
        tbl = byID("tbl-rendimiento");
        let a;
        let b;
        let resultado;
        let c;
        let rendi;
        
        for( var element of data){
            var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            var cll7 = rw.insertCell();
            var cll8 = rw.insertCell();
            var cll9 = rw.insertCell();
            var cll10 = rw.insertCell();
            
            a = element.kmnuevo;
            b = element.kmanterior;
            resultado = a-b;
            c=element.litros;
            rendi =resultado/c;

            if(element.estacion==1){
                cll5.innerHTML = "Santa Fé";
            }
            if(element.estacion==2){
                cll5.innerHTML = "Ley";
            }
            if(element.estacion==3){
                cll5.innerHTML = "Insurgentes";
            }
            if(element.estacion==4){
                cll5.innerHTML = "Munich";
            }
            if(element.estacion==5){
                cll5.innerHTML = "Libramiento";
            }
            if(element.estacion==6){
                cll5.innerHTML = "Lopéz";
            }
            if(element.estacion==7){
                cll5.innerHTML = "Río";
            }

            
            cll0.innerHTML = formatDate(element.fecha);
            cll1.innerHTML = element.notarjeta;
            cll2.innerHTML = element.placas;
            cll3.innerHTML = element.noeconomico;
            cll4.innerHTML = formatNumber(element.importe);
            cll6.innerHTML = element.nombre;
            cll7.innerHTML = element.litros;
            cll8.innerHTML = element.producto;
            cll9.innerHTML = resultado+" km";
            cll10.innerHTML = rendi.toLocaleString()+" Km por litro";
        }

    })
    
}

/*function leer_odometro(){
    let vehiculo = document.sessionStorage.getItem("vehiculos");
    vehiculo = JSON.parse(vehiculo);
    let toSend = new FormData();
    let idv;
    for(var element of vehiculo){
        idv = element.idvehiculo;
        
        
    }
    toSend.append('id','odometro');
        toSend.append('idv[]',idv);
    fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{



    })
}*/

function leer_rendimiento(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    //console.log(cte.idcliente)
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getRendimiento&idcliente="+cte,{
    method: "GET",
    modo: "cors",
    }).then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => { 
    sessionStorage.setItem("rendimiento", JSON.stringify(data));
    let servicio =data;
    //console.log(servicio)
    let tbl = byID("tbl-rendimiento").childNodes[1];
    let rows = tbl.getElementsByTagName("tr");
    rows = Array.from(rows);
    rows.shift();
    for(let elmt of rows){
        elmt.remove();
    }
    let a;
    let b;
    let resultado;
    let c;
    let rendi;
        tbl = byID("tbl-rendimiento"); 
        for (var element of servicio) { 
            var rw = tbl.insertRow();
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell();
            var cll5 = rw.insertCell();
            var cll6 = rw.insertCell();
            var cll7 = rw.insertCell();
            var cll8 = rw.insertCell();
            var cll9 = rw.insertCell();
            var cll10 = rw.insertCell();    
            rw.style.backgroundColor = '#FBFBFB';
            a = element.kmnuevo;
            b = element.kmanterior;
            resultado = a-b;
            c=element.litros;
            rendi =resultado/c;

            if(element.estacion==1){
                cll5.innerHTML = "Santa Fé";
            }
            if(element.estacion==2){
                cll5.innerHTML = "Ley";
            }
            if(element.estacion==3){
                cll5.innerHTML = "Insurgentes";
            }
            if(element.estacion==4){
                cll5.innerHTML = "Munich";
            }
            if(element.estacion==5){
                cll5.innerHTML = "Libramiento";
            }
            if(element.estacion==6){
                cll5.innerHTML = "Lopéz";
            }
            if(element.estacion==7){
                cll5.innerHTML = "Río";
            }

            
            cll0.innerHTML = formatDate(element.fecha);
            cll1.innerHTML = element.notarjeta;
            cll2.innerHTML = element.placas;
            cll3.innerHTML = element.noeconomico;
            cll4.innerHTML = formatNumber(element.importe);
            cll6.innerHTML = element.nombre;
            cll7.innerHTML = element.litros;
            cll8.innerHTML = element.producto;
            cll9.innerHTML = resultado+" km";
            cll10.innerHTML = rendi.toLocaleString()+" Km por litro";

        }
        
    })

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
        document.getElementById("fechafinrend").value = data;
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
       // document.getElementById("fechaini").value = data;
        document.getElementById("reFinicio").value = data;
        document.getElementById("fechainiabono").value = data;
        document.getElementById("fechainirend").value = data;
}   
    /////////////////vehiculos///////////////
function activarbtn(i){
        if(document.getElementById(i).value=='Activo'){
            document.getElementById(i).value="Inactivo";
            document.getElementById(i).classList='Inactivo';
            
        }else{
            document.getElementById(i).value="Activo";
            document.getElementById(i).classList='Activo';
        }
    let button = document.getElementById(i);
    let activo;
    let iduser;
    
    let toSend = new FormData();
        
       if(button.value=="Activo"){
           activo = "1";
           iduser = button.id;
       }else{
            activo = "0";
            iduser = button.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarVehi");
       toSend.append("activo",activo);
       toSend.append("iduser",iduser);
    
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            leer_Bitacora();
            //console.log(data)
         if(data==1){
            mensajeRespuesta("Guardado Correctamente")
            
            leer_Vehiculos();

         }else{
            mensajeRespuesta("Error")
         };
     })
 


}
function activarbtn1(i){
    if(document.getElementById(i).value=='Activo'){
        document.getElementById(i).value="Inactivo";
        document.getElementById(i).classList='Inactivo';
        
    }else{
        document.getElementById(i).value="Activo";
        document.getElementById(i).classList='Activo';
    }
    let button = document.getElementById(i);
    let activo;
    let iduser;
    let toSend = new FormData();
       if(button.value=="Activo"){
           activo = "1";
           iduser = button.id;
       }else{
            activo = "0";
            iduser = button.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarTar");
       toSend.append("activo",activo);
       toSend.append("iduser",iduser);
    
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            
            //console.log(data)
         if(data==1){
            
            mensajeRespuesta("Guardado Correctamente");
            leer_Tarjeta();
            leer_Bitacora();
            
         }else{
            mensajeRespuesta("Error")
         };
     })


}
//////////////////Choferes//////////////////
function activarbtn2(i){
    if(document.getElementById(i).value=='Activo'){
        document.getElementById(i).value="Inactivo";
        document.getElementById(i).classList='Inactivo';
        
    }else{
        document.getElementById(i).value="Activo";
        document.getElementById(i).classList='Activo';
    }
    let button = document.getElementById(i);
    let activo;
    let iduser;
    let toSend = new FormData();
       if(button.value=="Activo"){
           activo = "1";
           iduser = button.id;
       }else{
            activo = "0";
            iduser = button.id;
       }
       console.log(activo,iduser)
       
       toSend.append("id","actualizarChofer");
       toSend.append("activo",activo);
       toSend.append("iduser",iduser);
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            //console.log(data)
         if(data==1){
            mensajeRespuesta("Guardado Correctamente")
            leer_Choferes();
         }else{
            mensajeError("Error")
         };
     })
 



}

///////////////////Usuarios Web///////////////
function activarbtnUW(i){
    if(document.getElementById(i).value=='Activo'){
        document.getElementById(i).value="Inactivo";
        document.getElementById(i).classList='Inactivo';
        
    }else{
        document.getElementById(i).value="Activo";
        document.getElementById(i).classList='Activo';
    }

    let button = document.getElementById(i);
    let activo;
    let iduser;
    
    let toSend = new FormData();
        
       if(button.value=="Activo"){
           activo = "1";
           iduser = button.id;
       }else{
            activo = "0";
            iduser = button.id;
       }
       //console.log(activo,iduser)
       
       toSend.append("id","actualizarUsuario");
       toSend.append("activo",activo);
       toSend.append("iduser",iduser);
    
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
        .then(response => response.text())
        .catch(error => alert(error))
        .then((data) =>{
            //console.log(data)
         if(data==1){
            mensajeRespuesta("Guardado Correctamente")
            leer_UsuarioWeb();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
          


}
function leer_servicioshoy(){
    
}


/*function ActivarDesactivarChofer(){ 
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
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
 
          
     
}*/

/*function ActivarDesactivarUW(){ 
    let check = document.getElementsByName("bntADusu");
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
       
       toSend.append("id","actualizarUsuario");
       toSend.append("activo[]",activo);
       toSend.append("iduser[]",iduser);
    }
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
            leer_UsuarioWeb();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
          
     
}*/


/*function ActivarDesactivarTar(){ 
    
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
       fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
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
 
          
     
}*/

/*function ActivarDesactivarVehi(){ 
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
       fetch("https://monedero.grupopetromar.com/apirest/", {    
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
            leer_Vehiculos();
         }else{
            mensajeRespuesta("Error")
         };
     })
 
    
     
}*/

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
function mensajeError(res){
    let mensaje = document.createElement("div");
    mensaje.classList.add("alertaError");
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
///////////////dibujar img en un canvas////////////////////////////
/*function img(){
    let canvasIMG = document.getElementById("imagenc");
    let ctx = canvasIMG.getContext("2d");
    let imagenlogo = document.createElement("img");
    imagenlogo.src="imagen/favicon4.png";
    imagenlogo.addEventListener('load', ()=>{
        ctx.drawImage(imagenlogo, 0,0,200,200,0,0,200,200);
    });
}*/
////////   NO SE ESTÁ USANDO / ////////////
function PdfDownload(filename){
    if(filename == "Rendimiento"){
        document.getElementById("EncabezadoPDF8").style.display = "block";
   
    kendo.drawing.drawDOM($("#graficaderendimiento"))
    .then(function(group){
        document.getElementById("EncabezadoPDF8").style.display = "none";
       
           return kendo.drawing.exportPDF(
               group,{
                paperSize: "auto",
                margin: {
                    left: "1cm",
                    right:"1cm",
                    top: "1cm",
                    bottom: "1cm"
                    }
                   }
               
           );
           
    })
    .done(function(data){
        
       kendo.saveAs({
           dataURI:data,
           fileName:filename
       });
       
    });

    }

   if(filename == "Grafica"){
    document.getElementById("EncabezadoPDF2").style.display = "block";
   
    kendo.drawing.drawDOM($("#graficas"))
    .then(function(group){
        document.getElementById("EncabezadoPDF2").style.display = "none";
       
           return kendo.drawing.exportPDF(
               group,{
                paperSize: "auto",
                margin: {
                    left: "1cm",
                    right:"1cm",
                    top: "1cm",
                    bottom: "1cm"
                    }
                   }
               
           );
           
    })
    .done(function(data){
        
       kendo.saveAs({
           dataURI:data,
           fileName:filename
       });
       
    });


   }
   
}
/////////////////////////////////////////////////////////

function downloadPDFWithjsPDF() {
    document.getElementById("EncabezadoPDF").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#tbltarjetas'), {
        callback: function (doc) {
            doc.save("Tarjetas");
            document.getElementById("EncabezadoPDF").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}


function downloadPDFWithjsPDF_chofer() {
    document.getElementById("EncabezadoPDF3").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#tblchofer'), {
        callback: function (doc) {
            doc.save("Choferes");
            document.getElementById("EncabezadoPDF3").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}

function downloadPDFWithjsPDF_vehi() {
    document.getElementById("EncabezadoPDF4").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#tblvehi'), {
        callback: function (doc) {
            doc.save("Vehiculos");
            document.getElementById("EncabezadoPDF4").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}

function downloadPDFWithjsPDF_servicio() {
    document.getElementById("EncabezadoPDF1").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#tblservicio'), {
        callback: function (doc) {
            doc.save("Servicios");
            document.getElementById("EncabezadoPDF1").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}

function downloadPDFWithjsPDF_grafica() {
    document.getElementById("EncabezadoPDF2").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#graficas'), {
        callback: function (doc) {
            doc.save("Grafica");
            document.getElementById("EncabezadoPDF2").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}
function downloadPDFWithjsPDF_abono() {
    document.getElementById("EncabezadoPDF5").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#abonoss'), {
        callback: function (doc) {
            doc.save("Abonos");
            document.getElementById("EncabezadoPDF5").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}
function downloadPDFWithjsPDF_bit() {
    document.getElementById("EncabezadoPDF6").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#bitacorass'), {
        callback: function (doc) {
            doc.save("Bitacora");
            document.getElementById("EncabezadoPDF6").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}
function downloadPDFWithjsPDF_rend() {
    document.getElementById("EncabezadoPDF7").style.display = "block";
    var doc = new jspdf.jsPDF({
        orientation: 'p',
        unit: 'pt',
        format: 'a4'
    });

    doc.html(document.querySelector('#rendimientoss'), {
        callback: function (doc) {
            doc.save("Rendimientos");
            document.getElementById("EncabezadoPDF7").style.display = "none";
        },
        margin: [30, 30, 30, 30],
        html2canvas: {
            scale: 0.5, //this was my solution, you have to adjust to your size
        },
    });
}




function PDFfactura(a){
    window.open(a)
}

function XMLfactura(a){
    window.open(a)
}

function formatNumber(importe){
	   
    return ((Number(importe)).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',}));
    }

function serviciosgraf(a){
    if(a==1){
    document.getElementById("tabla-grafica-servicios").style.display="none";
    document.getElementById("graficaserv").style.display="none";
    document.getElementById("mostrargraf").style.display="block";
    document.getElementById("tablaserv").style.display="block";
    }
    if(a==2){
    document.getElementById("tabla-grafica-servicios").style.display="block";
    document.getElementById("graficaserv").style.display="block";
    document.getElementById("mostrargraf").style.display="none";
    document.getElementById("tablaserv").style.display="none";}
    if(a==3){
    graficarendimiento();
    document.getElementById("tblrend").style.display="none";
    document.getElementById("graficarend").style.display="none";
    document.getElementById("tablarend").style.display="block";
    document.getElementById("graficasrend").style.display="block";
    }
    if(a==4){
        document.getElementById("tblrend").style.display="block";
        document.getElementById("graficarend").style.display="block";
        document.getElementById("tablarend").style.display="none";
        document.getElementById("graficasrend").style.display="none";
        
        }

}

//VARIABLES GLOBALES QUE SE NECESITAN PARA LAS GRAFICAS DE SERVICIOS Y RENDIMIENTOS//
        /////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////
        /*////*/let graficaconsumo;//////////////////////////////////////
        /*////*/let graficaservicio1;////////////////////////////////////
        /*////*/let graficarend;/////////////////////////////////////////
        /////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////

/*function graficaservicio(){
    let cte = sessionStorage.getItem("servicios");
    cte = JSON.parse(cte);
    let importe =[];
    let fecha =[];
    let litros =[];

    for(let item of cte){
        importe.push(item.importe)
        fecha.push(item.fecha)
        litros.push(item.litros)
    }
    //console.log(importe);
    let delayed;
    var ctx = document.getElementById("graficaconsumo").getContext("2d");
    graficaconsumo = new Chart(ctx,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Importe',
                data:importe,
                backgroundColor:[
                    'rgb(51, 122, 183)'
                ]
            }]
        },
        options:{
            animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
           
        }
    })
}*/
function graficarendimiento(){
    let cte = sessionStorage.getItem("rendimiento");
    cte = JSON.parse(cte);
    let rendimiento =[];
    let fecha =[];

    for(let item of cte){
        let km = item.kmnuevo - item.kmanterior;
        let rend= km/item.litros;
        let date = formatDate(item.fecha);
        rendimiento.push(rend)
        fecha.push(date)
    }
    let delayed;
    var ctx3 = document.getElementById("graficarendimiento").getContext("2d");
    if(graficarend){
        graficarend.destroy();
    }
    graficarend = new Chart(ctx3,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Rendimiento por KM',
                data:rendimiento,
                backgroundColor:[
                    'rgb(51, 122, 183)',
                ]
            }]
        },
        options:{
           animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
        }
    })
}

    
    //Grafica de consumos en reportes de servicios
function tablaconsumo(){
    let cte = sessionStorage.getItem("servicios");
    cte = JSON.parse(cte);
    let importe =[];
    let fecha =[];
    let litros =[];

    for(let item of cte){
        let date = formatDate(item.fecha)
        importe.push(item.importe)
        fecha.push(date)
        litros.push(item.litros)
    }
    //console.log(importe);
    let delayed;
    var ctx = document.getElementById("graficaconsumo").getContext("2d");
    if(graficaconsumo){
        graficaconsumo.destroy();
    }
    graficaconsumo = new Chart(ctx,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Importe',
                data:importe,
                backgroundColor:[
                    'rgb(51, 122, 183)'
                ]
            }]
        },
        options:{
            animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
           
        }
    })
}

function tablaconsumofiltrado(){

    let tarjeta = document.getElementById("altatarjetas-notarjeta-grafica").value;
    //  console.log(tarjeta)
    let cte = sessionStorage.getItem("servicios");
    cte = JSON.parse(cte);
    let importe =[];
    let fecha =[];
    let litros =[];

    for(let item of cte){
        if(item.tarjeta==tarjeta){
        let date = formatDate(item.fecha)
        importe.push(item.importe)
        fecha.push(date)
        litros.push(item.litros)
        }
    }
    //console.log(importe);
    let delayed;
    var ctx = document.getElementById("graficaconsumo").getContext("2d");
    if(graficaconsumo){
        graficaconsumo.destroy();
    }
    graficaconsumo = new Chart(ctx,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Importe',
                data:importe,
                backgroundColor:[
                    'rgb(51, 122, 183)'
                ]
            }]
        },
        options:{
            animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
           
        }
    })

    let delayed2;
    var ctx2 = document.getElementById("graficaservicios").getContext("2d");
    if(graficaservicio1){
        graficaservicio1.destroy();
    }
    graficaservicio1 = new Chart(ctx2,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Litros',
                data:litros,
                backgroundColor:[
                    'rgb(51, 122, 183)',
                ]
            }]
        },
        options:{
           animation: {
      onComplete: () => {
        delayed2 = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed2) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
        }
    })




}


//grafica de servicios en reportes de servicios
function tablaservicio(){
    let cte = sessionStorage.getItem("servicios");
    cte = JSON.parse(cte);
    let importe =[];
    let fecha =[];
    let litros =[];

    for(let item of cte){
        let date = formatDate(item.fecha)
        importe.push(item.importe)
        fecha.push(date)
        litros.push(item.litros)
    }
    let delayed;
    var ctx2 = document.getElementById("graficaservicios").getContext("2d");
    if(graficaservicio1){
        graficaservicio1.destroy();
    }
    graficaservicio1 = new Chart(ctx2,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Litros',
                data:litros,
                backgroundColor:[
                    'rgb(51, 122, 183)',
                ]
            }]
        },
        options:{
           animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
        }
    })
}

function rendimientoFiltrado(){
    let cte = sessionStorage.getItem("rendimiento");
    let tarjeta = document.getElementById("notarjeta-graficarend").value;
    cte = JSON.parse(cte);
    let rendimiento =[];
    let fecha =[];
    console.log(tarjeta)
    for(let item of cte){
        if(item.tarjeta == tarjeta){

            let km = item.kmnuevo - item.kmanterior;
            let rend= km/item.litros;
            let date = formatDate(item.fecha);
            rendimiento.push(rend)
            fecha.push(date)
        }
        
    }
    let delayed;
    var ctx3 = document.getElementById("graficarendimiento").getContext("2d");
    if(graficarend){
        graficarend.destroy();
    }
    graficarend = new Chart(ctx3,{
        type: "bar",
        data:{
            labels:fecha,
            datasets:[{
                label:'Rendimiento por KM',
                data:rendimiento,
                backgroundColor:[
                    'rgb(51, 122, 183)',
                ]
            }]
        },
        options:{
           animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
           scales:{
                yAxes:[{
                    ticks:{
                        beginAtZaero:true
                    }
                }]
            }
        }
    })

}

/*
Fiunciones faltantes
*/
//no es necesaria 
function validar(){

    let validar =sessionStorage.getItem("sesionlog");

    validar=JSON.parse(validar)[0];
    if(validar!=13){

        //logOut();

    }

}



function leer_Complementos(){
    let user = sessionStorage.getItem("sesionlog");
    user = JSON.parse(user);
    let cte = user[0].idcliente;
    //console.log(cte)
    fetch("https://monedero.grupopetromar.com/apirest/index.php?id=getComplementos&cte="+cte, {
        method: "GET",
        mode: "cors",
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then((data) => {
        //console.log(data);
        data = JSON.stringify(data);
        sessionStorage.setItem("complementos", data);
        let tbl = byID("tbl-Complementos").childNodes[1];
        let rows = tbl.getElementsByTagName("tr");
        rows = Array.from(rows);
        rows.shift();
        for(let elmt of rows){
            elmt.remove();
        }

        let complementos = sessionStorage.getItem("complementos");
        complementos = JSON.parse(complementos);
        tbl = byID("tbl-Complementos");
        for (var element of complementos) { 
            let elPDF = element.complemento;
            
            if(!elPDF){
                elPDF="00000";
            }
            elPDF =elPDF.slice(0,-4);
            let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+elPDF+".pdf";
            let factura = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+element.complemento;
            
            var rw = tbl.insertRow();
            
            var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell(); 
            var input = document.createElement("input");
                input.setAttribute("type","submit");
                input.setAttribute("id",element.folio);
                input.setAttribute("name","bntPDFfac");
                //input.setAttribute("onClick",'PDFfactura()');
                input.setAttribute("class",'bttn bttn-success');
                input.setAttribute("value","PDF");
                input.addEventListener("click",()=>{PDFfactura(url)}, false);

            var input1 = document.createElement("input");
                input1.setAttribute("type","submit");
                input1.setAttribute("id",element.folio);
                input1.setAttribute("name","bntPDFfac");
                input1.setAttribute("class",'btn btn-print');
                input1.setAttribute("value","XML");
                input1.addEventListener("click",()=>{XMLfactura(factura)}, false);
                
        
            cll0.innerHTML = element.folio;
            cll1.innerHTML = formatDate(element.fecha);
            cll2.innerHTML = formatNumber(element.importe);
            cll3.append(input); 
            cll4.append(input1); 
        } 

        
    });
}
//filtrar complementos 

function filtrarComplementos(){
   
    let tbl = byID("tbl-Complementos").childNodes[1];
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
    var fechainicial = byID("fechainiCom").value;
    var fechafinal = byID("fechafinCom").value;
    let toSend = new FormData();
        toSend.append("id","obtenercomplementos");
        toSend.append("idcliente",idcliente);
        toSend.append("fechainicial",fechainicial);
        toSend.append("fechafinal",fechafinal);

        fetch("https://monedero.grupopetromar.com/apirest/index.php", {    
        method: "POST",
        mode: "cors",
        body: toSend
        })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) =>{
        
        data = JSON.stringify(data);
        sessionStorage.setItem("complementos", data); 
        data=JSON.parse(data);
    let complemento = data;
    console.log(complemento);
    
    let tbl = byID("tbl-Complementos"); 
    for( var element of complemento){
        let elPDF = element.complemento;
            
        if(!elPDF){
            elPDF="00000";
        }
        elPDF =elPDF.slice(0,-4);
        let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+elPDF+".pdf";
        let factura = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/"+element.complemento;
        var rw = tbl.insertRow();
        var cll0 = rw.insertCell();
            var cll1 = rw.insertCell();
            var cll2 = rw.insertCell();
            var cll3 = rw.insertCell();
            var cll4 = rw.insertCell(); 
            var input = document.createElement("input");
                input.setAttribute("type","submit");
                input.setAttribute("id",element.folio);
                input.setAttribute("name","bntPDFfac");
                //input.setAttribute("onClick",'PDFfactura()');
                input.setAttribute("class",'bttn bttn-success');
                input.setAttribute("value","PDF");
                input.addEventListener("click",()=>{PDFfactura(url)}, false);

            var input1 = document.createElement("input");
                input1.setAttribute("type","submit");
                input1.setAttribute("id",element.folio);
                input1.setAttribute("name","bntPDFfac");
                input1.setAttribute("class",'btn btn-print');
                input1.setAttribute("value","XML");
                input1.addEventListener("click",()=>{XMLfactura(factura)}, false);
                
        
            cll0.innerHTML = element.folio;
            cll1.innerHTML = formatDate(element.fecha);
            cll2.innerHTML = formatNumber(element.importe);
            cll3.append(input); 
            cll4.append(input1); 
    }   
    });
}


function leer_combustibles(){

    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getCombustibles", {
           method: "GET",
           mode: "cors",
       })
       .then(response => response.json())
       .catch(error => console.log(error))
       .then((data) => {
   
           data = JSON.stringify(data);
           sessionStorage.setItem("combustible", data);
           let combustibles = sessionStorage.getItem("combustible");
       combustibles  = JSON.parse(combustibles );
      // console.log(combustibles);
       let div1 = byID("combustibles-checks22");
       for(element of combustibles){
   
           var input1 = document.createElement("input");
           input1.setAttribute("type","checkbox");
           input1.setAttribute("value",element.tipocombustible);
           input1.setAttribute("name","listadecombustibles2");
           input1.setAttribute("id",element.tipocombustible);
           div1.appendChild(input1);
           var label1 = document.createElement("label");
           label1.setAttribute("for","");
           label1.innerHTML=element.nombre;
           div1.appendChild(label1);    
           var br1 = document.createElement("br");
           div1.appendChild(br1);  
       }
        })
   
   
   
       
   }


function productos_checks(){
    let productos = sessionStorage.getItem("productos");
    productos = JSON.parse(productos);
    let div2 = byID("combustibles-checks22");
   // productos = JSON.stringify(productos);
    console.log(productos)
    for(element of productos){
        var input = document.createElement("input");
        input.setAttribute("type","checkbox");
        input.setAttribute("value",element.folio);
        input.setAttribute("name","checkproducto2");
        input.setAttribute("id",element.folio);
        div2.appendChild(input);
        var label = document.createElement("label");
        label.setAttribute("for",element.folio);
        label.innerHTML=element.nombre;
        div2.appendChild(label);    
        var br = document.createElement("br");
        div2.appendChild(br);  
    }
}

