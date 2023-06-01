    /**  Short syntax for document.getElementById()  **/

function byID(id){

    return document.getElementById(id);

}



function logOut(){

    sessionStorage.clear();

    window.location = "./login.html";

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

function AbVe(n){

    let mensaje = document.createElement("div");

        mensaje.setAttribute("id","mensajeCsesion");

        mensaje.classList.add("alertaCS");

        let lbl = document.createElement("label");

        lbl.innerHTML= "¿Desea cancelar el abono #"+n+"?";

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

        btna.setAttribute("onClick",'cancelarAbono('+n+')');

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



function facVe(n){

    let mensaje = document.createElement("div");

        mensaje.setAttribute("id","mensajeCsesion");

        mensaje.classList.add("alertaCS");

        let lbl = document.createElement("label");

        lbl.innerHTML= "¿Desea cancelar la factura #"+n+"?";

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

        btna.setAttribute("onClick",'cancelarFactura('+n+')');

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

function serVe(n){

    let mensaje = document.createElement("div");

        

        mensaje.setAttribute("id","mensajeCsesion");

        mensaje.classList.add("alertaCS");

        let lbl = document.createElement("label");

        lbl.innerHTML= "¿Desea cancelar el servicio #"+n+"?";

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

        btna.setAttribute("onClick",'cancelarServicio('+n+')');

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

        listadesaldos();

}



function nomUsu(){

    let nombre = sessionStorage.getItem("sesionlog");

    nombre = JSON.parse(nombre);

    document.getElementById("notificationNom").innerHTML = nombre[1];

   

}

function validar(){

    let validar =sessionStorage.getItem("sesionlog");

    validar=JSON.parse(validar)[0];

    if(validar!=13){

        logOut();

    }

}



function downloadPDFWithjsPDF_consiliacion(){

    document.getElementById("EncabezadoPDFconsiliacion").style.display = "block";

    var doc = new jspdf.jsPDF({

        orientation: 'p',

        unit: 'pt',

        format: 'a4'

    });



    doc.html(document.querySelector('#consiliacionpdf'), {

        callback: function (doc) {

            doc.save("Consiliasion de clientes credito");

            document.getElementById("EncabezadoPDFconsiliacion").style.display = "none";

        },

        margin: [30, 30, 30, 30],

        html2canvas: {

            scale: 0.5, //this was my solution, you have to adjust to your size

        },

    });

}



function leer_consiliacion(){

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getConsiliacion", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        let tbl = byID("tbl-consiliacion");

            let rows = tbl.getElementsByTagName("tr");

            rows = Array.from(rows);

            rows.shift();

            for(let elmt of rows){

                elmt.remove();

            }

            console.log(data)

            for(element of data){

                let saldo = element.limiteCredito-element.restante;

                var rw = tbl.insertRow();

                            var cll0 = rw.insertCell();

                            var cll1 = rw.insertCell();

                            var cll2 = rw.insertCell();

                            var cll3 = rw.insertCell();

                            var cll4 = rw.insertCell();

                            var cll5 = rw.insertCell();

        

                            cll0.innerHTML=element.idcliente;

                            cll1.innerHTML=element.rzonsocial;

                            cll2.innerHTML=formatNumber(element.limiteCredito);

                            cll3.innerHTML=element.periodoCredito;

                            cll4.innerHTML=formatNumber(element.restante);

                            cll5.innerHTML=formatNumber(saldo);

            }



    })

    



}





function getTarjetaFPlaca(idvehiculo, selId){ 
 
    let input = byID("editar-tarjeta-fplaca");
    let seltarjetas = byID(selId);
    input.value = "";
    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetaFPlaca&idvehiculo="+idvehiculo, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {
       // seltarjetas = data;
         input.value = data;
         seltarjetas.value = data;
         fillSelects_Placas();
 
         


    })

    



}


function getPlacas(cte, selId){ 
    let selest = byID(selId);
    selest.options.length = 0;
    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getPlacas&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {
        console.log(data); 
 

        
        let option0 = document.createElement("option"); 
        option0.setAttribute("value", "0"); 
        option0.innerHTML="SELECCIONE"; 
        selest.append(option0);

        for (var element of data) {  
            let option1 = document.createElement("option");

            option1.setAttribute("value", element.idvehiculo);

            option1.innerHTML=element.placas;

            selest.append(option1);
        }
      

         


    })

    



}

function filtrarAbono(){

    let cliente = byID("altatarjetas-idcte06A").value;

    let fi = byID("fechainiAb").value;

    let ff = byID("fechafinAb").value;

    let toSend = new FormData();

    toSend.append("id","filtrarAbonos");

    toSend.append("cliente",cliente);

    toSend.append("Fechaini",fi);

    toSend.append("Fechafin",ff);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        let tbl = byID("tbl-abonoctaD2").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

             elmt.remove();

        }



        let abonos = data;

        abonos=JSON.parse(abonos);

        //console.log(abonos)



        tbl = byID("tbl-abonoctaD2");



        //console.log(abonos);

        for (let element of abonos) { 

        let rw = tbl.insertRow();

        let cll0 = rw.insertCell();

        let cll1 = rw.insertCell();

        let cll2 = rw.insertCell();

        let cll3 = rw.insertCell();

        let cll4 = rw.insertCell();

        let cll5 = rw.insertCell();

        let cll6 = rw.insertCell();



        var button = document.createElement("input");

        button.setAttribute("type","submit");

        button.setAttribute("id",element.IDabono);

        button.classList.add("Inactivo");

        button.setAttribute("onclick",'AbVe('+element.IDabono+')');

        button.setAttribute("value","Eliminar");



        cll0.innerHTML = element.IDabono;

        cll1.innerHTML = element.rzonsocial;

        cll2.innerHTML = formatFecha(element.fecha);

        cll3.innerHTML = formatNumber(element.importeabono);

        cll4.innerHTML = element.concepto;

        if(element.formapago==1){

            cll5.innerHTML = "Transferencia";

        }

        if(element.formapago==2){

            cll5.innerHTML = "Efectivo";

        }

        if(element.formapago==3){

            cll5.innerHTML = "Cheque";

        }

        if(element.formapago==4){

            cll5.innerHTML = "Tarjeta Débito";

        }

        if(element.formapago==5){

            cll5.innerHTML = "Tarjeta Crédito";

        }

        cll6.append(button);



    }

    })



}



function leer_Editarcliente(){

    let cte = byID("altatarjetas-editarcte").value;



    let clientes = sessionStorage.getItem("clientes");

    clientes = JSON.parse(clientes);

    for(element of clientes){

        if(element.idcliente == cte){

            byID("editcte-rfc").value = element.rfc;

            byID("editcte-colonia").value = element.colonia;

            byID("editcte-estado").value = element.estado;

            byID("editcte-direccion").value = element.direccion;

            byID("editcte-ciudad").value = element.ciudad;

            byID("editcte-contact").value = element.contacto;

            byID("editcte-cp").value = element.cp;

            byID("editcte-tel").value = element.telefono;

            byID("editcte-ccargo").value = element.cuentaCargo;

            byID("editcte-cabono").value = element.cuentaAbono;

            byID("editcte-Rl").value = element.representante;

            if(element.Tipo==0){

                byID("ctepago-credito2").checked = "false";

                byID("ctepago-debito2").checked = "true";

                byID("editpago-creditodias").disabled = true;

                byID("editpago-creditolimite").disabled = true;

                byID("editcte-debitotipoprepago").disabled = false

                byID("editcte-debitotipoprepago").value = "1";

                byID("editpago-creditolimite").value = "";

                byID("editpago-creditodias").value = "";

            }else{

                byID("ctepago-debito2").checked = "false";

                byID("ctepago-credito2").checked = "true";

                byID("editpago-creditodias").disabled = false;

                byID("editpago-creditolimite").disabled = false;

                byID("editcte-debitotipoprepago").disabled = true;

                byID("editpago-creditodias").value = element.periodoCredito;

                byID("editpago-creditolimite").value = element.limiteC;

            }

            

           

        }



    }



}



function filtrarpoliza(){



    let fecha = byID("fechaPoliza").value;

    let fechap = byID("fechaP");

    fechap.innerHTML=formatFecha(fecha);



        //console.log(fecha);

        let toSend = new FormData;

        toSend.append("id", "poliza");

        toSend.append("fecha", fecha);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        //console.log(data);

        let info = JSON.parse(data);

        //console.log(info);

        let tbl = byID("tbl-poliza").childNodes[1];

            let rows = tbl.getElementsByTagName("tr");

            rows = Array.from(rows);

            rows.shift();

            for(let elmt of rows){

                elmt.remove();

            }

            let clientes =  sessionStorage.getItem("clientes");

            clientes = JSON.parse(clientes);

         

         

        tbl = byID("tbl-poliza");

        for (var element of info ) { 

            for( var cte of clientes){

                if(cte.idcliente==element.idcliente ){

                    if(element.importeabono==undefined){

                        element.importeabono="0";

                    }

                    var rw = tbl.insertRow();

                    var cll0 = rw.insertCell();

                    var cll1 = rw.insertCell();

                    var cll2 = rw.insertCell();

                    var cll3 = rw.insertCell();

                    cll0.innerHTML = cte.cuentaCargo;

                    cll1.innerHTML = cte.rzonsocial;

                    cll2.innerHTML = "$"+formatCant(element.importe);

                }

                if( cte.idcliente==element.IDclienteAbono){

                    

                    var rw = tbl.insertRow();

                    var cll0 = rw.insertCell();

                    var cll1 = rw.insertCell();

                    var cll2 = rw.insertCell();

                    var cll3 = rw.insertCell();

                    cll0.innerHTML = cte.cuentaAbono;

                    cll1.innerHTML = cte.rzonsocial;

                    cll3.innerHTML = "$"+formatCant(element.importeabono);

                }

            }

           

        }



    });

}



function Editarcliente(){



    var cte = byID("altatarjetas-editarcte").value;

    var rfc = byID("editcte-rfc").value.toUpperCase();

    var contacto = byID("editcte-contact").value;

    var telefono = byID("editcte-tel").value;

    var direccion = byID("editcte-direccion").value;

    var colonia = byID("editcte-colonia").value;

    var estado = byID("editcte-estado").value;

    var ciudad = byID("editcte-ciudad").value;

    var CuentaA = byID("editcte-cabono").value;

    var CuentaC = byID("editcte-ccargo").value;

    var cp = byID("editcte-cp").value;

    var repre = byID("editcte-Rl").value;

    let formapago = document.getElementsByName("editcte-tipopago2");

    let tipopago;

    let metodoprepago;

    let periodocredito;

    let limitecredito;

    

    try{

        if(formapago[1].checked){

            tipopago = 1;

            metodoprepago = null;

            periodocredito = byID("editpago-creditodias").value;

            limitecredito = byID("editpago-creditolimite").value;

            if(formapago[1].checked&&limitecredito==""){return mensajeError("Ingrese limite de credito")}

        } else { if(formapago[0].checked){

            tipopago = 0;

            metodoprepago = byID("editcte-debitotipoprepago").value;

            periodocredito = null;

            limitecredito = null;}else{ tipopago = 2;}

            

        }

    }catch{



    }

    

    //console.log(telefono.length)

    if(rfc==""||rfc==null){return mensajeError("Ingrese un RFC correcto")}

    if(colonia==""||ciudad==""||estado==""||cp==""){return mensajeError("Complete los datos de dirección")}

    //document.getElementById("altacte-rfc").onblur=function(){this.value=this.value.toUpperCase();}

    if(telefono==null||telefono==""){return mensajeError("Ingrese un número telefónico")}

    if(telefono.match(/^[a-zA-Z]./)||telefono.length<=9){return mensajeError("Ingrese un numero telefónico correcto")}

    if(cp==null||cp==""){return mensajeError("Ingrese un código postal")}

    if(cp.match(/^[a-zA-Z]./)||cp.length<=4){return mensajeError("Ingrese un código postal valido")}

    if(direccion==null||direccion==""){return mensajeError("Ingrese una dirección")}

    if(tipopago==2){return mensajeError("Seleccione un tipo de pago")}

    if(CuentaA==""||CuentaC==""){return mensajeError("Ingrese número de cuenta")}

    var expReg = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;

    var validar = expReg.test(contacto);

    if(validar==true){}else{return mensajeError("El correo NO es valido")}

    if(repre==""||repre==null){return mensajeError("Ingrese un Representante Legal")}



    let toSend = new FormData();

        toSend.append('id', "EditarCliente");

        toSend.append('cte', cte);

        toSend.append('rfc', rfc);

        toSend.append('direccion',direccion);

        toSend.append('contacto', contacto);

        toSend.append('telefono', telefono);

        toSend.append('tipo', tipopago);

        toSend.append('metodopago', metodoprepago);

        toSend.append('periodopago', periodocredito);

        toSend.append('limitecredito', limitecredito);

        toSend.append('colonia', colonia);

        toSend.append('estado', estado);

        toSend.append('ciudad', ciudad);

        toSend.append('CuentaA', CuentaA);

        toSend.append('CuentaC', CuentaC);

        toSend.append('cp', cp);

        toSend.append('repre', repre);





    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        mensajeRespuesta(data.trim());

        leer_Clientes();

        byID("editcte-rfc").value="";

        byID("editcte-contact").value="";

        byID("editcte-tel").value="";

        byID("editcte-direccion").value="";

        byID("editcte-colonia").value="";

        byID("editcte-estado").value="";

        byID("editcte-ciudad").value="";

        byID("editcte-cp").value="";

        byID("editcte-cabono").value="";

        byID("editcte-ccargo").value="";

        byID("editcte-Rl").value="";

        byID("ctepago-debito2").checked=false;

        byID("ctepago-credito2").checked=false;

        byID("editpago-creditodias").value=null;

        byID("editpago-creditolimite").value=null;

        byID("editcte-debitotipoprepago").value=null;

        leer_Clientes();

    });









}



function alta_Cliente(a){



    let grupo = sessionStorage.getItem("sesionlog");

    grupo =  JSON.parse(grupo)[3];

    let divusu = document.getElementById("divcliente4");

    if(divusu.style.display=="none"){

        divusu.style.display="block";

        

    }else{

        let mensaje = document.createElement("div");

    mensaje.classList.add("alerta2");

    mensaje.setAttribute("id","mensajeContra");

    let lbl = document.createElement("label");

    lbl.innerHTML= "Contraseña: ";

    mensaje.append(lbl);

    let input = document.createElement("input");

    input.setAttribute("id","contraCtar");

    mensaje.append(input);

    let buton = document.createElement("button");

    buton.setAttribute("class","btn btn-success22");

    buton.innerHTML= "Aceptar";

    buton.setAttribute("onclick","contraC("+a+")");

    mensaje.append(buton);

    document.getElementsByTagName("body")[0].append(mensaje);



}

}



function contraC(a){

    let mensaje=byID("mensajeContra");

    

    let contra= byID("contraCtar").value;

    if(contra == 1234){

        mensaje.remove();

        var nombre = byID("altacte-name").value;

    var rfc = byID("altacte-rfc").value.toUpperCase();

    var contacto = byID("altacte-contact").value;

    var telefono = byID("altacte-tel").value;

    var direccion = byID("altacte-direccion").value;

    var colonia = byID("altacte-colonia").value;

    var estado = byID("altacte-estado").value;

    var ciudad = byID("altacte-ciudad").value;

    var cp = byID("altacte-cp").value;

    var cabono = byID("altacte-cabono").value;

    var ccargo = byID("altacte-ccargo").value;

    var Rl = byID("altacte-Rl").value;

    var tcliente = a;

    let limitecredito = 0;

    let periodocredito = 0;

    /*let formapago = document.getElementsByName("altacte-tipopago");

    let tipopago;

    let metodoprepago;*/

    

    if(a==1){

         periodocredito = byID("ctepago-creditodias").value;

         limitecredito  = byID("ctepago-creditolimite").value;



        

    }else{

        periodocredito = 0;

        limitecredito  = 0;

    }

    

    

    

   /* if(formapago[1].checked){

        tipopago = 1;

        metodoprepago = null;

        periodocredito = byID("ctepago-creditodias").value;

        limitecredito = byID("ctepago-creditolimite").value;

    } else { if(formapago[0].checked){

        tipopago = 0;

        metodoprepago = byID("altacte-debitotipoprepago").value;

        periodocredito = null;

        limitecredito = null;}else{ tipopago = 2;}

        

    }*/

    //console.log(telefono.length)

    if(nombre==""||nombre==null){return mensajeError("Ingrese un nombre")}

    if(rfc==""||rfc==null){return mensajeError("Ingrese un RFC correcto")}

    if(colonia==""||ciudad==""||estado==""||cp==""){return mensajeError("Complete los datos de dirección")}

    //document.getElementById("altacte-rfc").onblur=function(){this.value=this.value.toUpperCase();}

    if(telefono==null||telefono==""){return mensajeError("Ingrese un número telefónico")}

    if(telefono.match(/^[a-zA-Z]./)||telefono.length<=9){return mensajeError("Ingrese un numero telefónico correcto")}

    if(cp==null||cp==""){return mensajeError("Ingrese un código postal")}

    if(cp.match(/^[a-zA-Z]./)||cp.length<=4){return mensajeError("Ingrese un código postal valido")}

    if(direccion==null||direccion==""){return mensajeError("Ingrese una dirección")}

    /*if(tipopago==2){return mensajeError("Seleccione un tipo de pago")}

    if(formapago[1].checked&&limitecredito==""){return mensajeError("Ingrese limite de credito")}*/

    var expReg = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;

    var validar = expReg.test(contacto);

    if(validar==true){}else{return mensajeError("El correo NO es valido")}

    if(Rl==""||Rl==null){return mensajeError("Ingrese un Representante Legal")}

   



    



    let toSend = new FormData();

        toSend.append('id', "agregarCliente");

        toSend.append('nombre', nombre);

        toSend.append('rfc', rfc);

        toSend.append('direccion',direccion);

        toSend.append('contacto', contacto);

        toSend.append('telefono', telefono);

        toSend.append('tcliente', tcliente);

        /*toSend.append('tipo', tipopago);

        toSend.append('metodopago', metodoprepago);*/

            toSend.append('periodopago', periodocredito);

            toSend.append('limitecredito', limitecredito);

        

        toSend.append('colonia', colonia);

        toSend.append('estado', estado);

        toSend.append('ciudad', ciudad);

        toSend.append('cabono', cabono);

        toSend.append('ccargo', ccargo);

        toSend.append('cp', cp);

        toSend.append('Rl', Rl);

        toSend.append('usocdfi', byID("altacte-usocdfi").value);
        toSend.append('domfiscal', byID("altacte-domfiscal").value);
        toSend.append('regfiscalrec', byID("altacte-regfiscalrec").value);





    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        if(data==1){

            mensajeRespuesta("Guardado Correctamente");

        

        leer_Clientes();

        byID("altacte-name").value="";

        byID("altacte-rfc").value="";

        byID("altacte-contact").value="";

        byID("altacte-tel").value="";

        byID("altacte-direccion").value="";

        byID("altacte-colonia").value="";

        byID("altacte-estado").value="";

        byID("altacte-ciudad").value="";

        byID("altacte-cp").value="";

        byID("altacte-cabono").value="";

        byID("altacte-ccargo").value="";

        byID("altacte-Rl").value="";

        /*byID("ctepago-debito").checked=false;

        byID("ctepago-credito").checked=false;

        byID("altacte-debitotipoprepago").value=null;*/

        if(a==1){

            byID("ctepago-creditodias").value=null;

        byID("ctepago-creditolimite").value=null;

        }

        

        divusu.style.display="none";

        }else{

            mensajeError("Error al guardar");

            console.log(data)

        }

        

    });

    }else{

        

        mensajeError("Contraseña incorrecta");

        mensaje.remove();

    }

}



function leer_Clientes(){

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getClientes", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        //console.log(data)

        data = JSON.stringify(data);

        sessionStorage.setItem("clientes", data);

        let tbl = byID("tbl-clientes").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for (let elmt of rows) {

            elmt.remove();

        }



        let clientes = sessionStorage.getItem("clientes");

        clientes = JSON.parse(clientes);

        tbl = byID("tbl-clientes");

        for (var element of clientes) { 

            var rw = tbl.insertRow();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            cll0.innerHTML = element.idcliente;

            cll1.innerHTML = element.rzonsocial;

            cll2.innerHTML = element.rfc;

            cll3.innerHTML = element.contacto;

            cll4.innerHTML = element.telefono;

        }



        fillSelects_Clientes();

        fillSelects_producto();

        fillSelects_ClientesC();

        leer_impuestos();

        listadesaldos();

    });

}



function listadesaldos(){

    let tbl = byID("tbl-Saldos").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for (let elmt of rows) {

            elmt.remove();

        }



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=listadesaldos", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        let saldos=data;

        console.log(saldos)

        for(element of saldos){



            rw = tbl.insertRow();

            cll0 = rw.insertCell();

            cll1 = rw.insertCell();



            cll0.innerHTML = element.nombre;

            cll1.innerHTML = formatNumber(element.importedisponible);

            

        }





    })

}





function fillSelects_Clientes(){

    var selects = document.getElementsByClassName("sf-cte")



    for (const sel of selects) {

        selectClientes(sel);

    }

}



function fillSelects_ClientesC(){

    var selects = document.getElementsByClassName("sf-cte_c")



    for (const sel of selects) {

        selectClientesC(sel);

    }

}

function fillSelects_TarjetasC(){

    var selects = document.getElementsByClassName("sltarjetas")



    for (const sel of selects) {

        selectTarjetasC(sel);

    }

}



function fillSelects_pagos(){

    var selects = document.getElementsByClassName("sf-pago")



    for (const sel of selects) {

        selectPagos(sel);

    }

}



function fillSelects_grupo(){

    var selects = document.getElementsByClassName("sf-grupo")



    for (const sel of selects) {

        selectgrupo(sel);

    }

}



function fillSelects_producto(){

    var selects = document.getElementsByClassName("sl-prod")



    for (const sel of selects) {

        selectProd(sel);

    }

}



function alta_UsuariosWeb(){

    let divusu = document.getElementById("divusuWeb");

 

    if(divusu.style.display=="none"){

        divusu.style.display="block";

        

    }else{

        let mensaje = document.createElement("div");

    mensaje.classList.add("alerta2");

    mensaje.setAttribute("id","mensajeContra1");

    let lbl = document.createElement("label");

    lbl.innerHTML= "Contraseña: ";

    mensaje.append(lbl);

    let input = document.createElement("input");

    input.setAttribute("id","contraUsuw");

    mensaje.append(input);

    let buton = document.createElement("button");

    buton.setAttribute("class","btn btn-success22");

    buton.innerHTML= "Aceptar";

    buton.setAttribute("onclick","contraUw()");

    mensaje.append(buton);

    document.getElementsByTagName("body")[0].append(mensaje);





    

    

}

}

function contraUw(){

    let mensaje = byID("mensajeContra1");

    let contra1 = byID("contraUsuw").value;



    if(contra1==1234){

        mensaje.remove();

        var cliente = byID("altauserweb-cte").value;

    var nombre = byID("altauserweb-name").value;

    var usuario = byID("altauserweb-user").value;

    var contra = byID("altauserweb-pass").value;

    var tipo = byID("altauserweb-tipo").value;

    //var checkadmin = +(byID("userweb-checkadmin").checked);

    //var checkrepor = +(byID("userweb-checkrepor").checked);

    //var checkgrafs = +(byID("userweb-checkgrafs").checked);

    //var checksecur = +(byID("userweb-checksecur").checked);

    if(nombre==""||usuario==""||contra==""){return mensajeError("Complete los campos")}

    //if(checkadmin=="0"&&checkrepor=="0"&&checkgrafs=="0"&&checksecur=="0"){return mensajeError("Complete los campos")}

    let toSend = new FormData();

        toSend.append('id', "agregarUsuarioWeb");

        toSend.append('nombre', nombre);

        toSend.append('idcliente', cliente);

        toSend.append('usuario', usuario);

        toSend.append('contrasena', contra);

        toSend.append('tipo', tipo);

        //toSend.append('administracion', checkadmin);

        //toSend.append('reportes', checkrepor);

        //toSend.append('graficas', checkgrafs);

        //toSend.append('seguridad', checksecur);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        if(data==1){

            mensajeRespuesta("Guardado Correctamente");

        leer_UsuariosWeb();

        byID("altauserweb-cte").value="";

        byID("altauserweb-tipo").value="1";

        byID("altauserweb-name").value="";

        byID("altauserweb-user").value="";

        byID("altauserweb-pass").value="";

        //(byID("userweb-checkadmin").checked=false);

        //(byID("userweb-checkrepor").checked=false);

        //(byID("userweb-checkgrafs").checked=false);

        //(byID("userweb-checksecur").checked)=false;

        divusu.style.display="none";

        }else{

            //console.log(data)

            mensajeError("Error al guardar")

        }

        

        

    });

    }else{

        mensaje.remove();

        mensajeError("Contraseña incorrecta");

    }



}



function selecciongpo(){

    let a = byID("altauser-tipo").value;

    if(a=="2"){

        byID("altauser-gpo").disabled=true;

    }else{byID("altauser-gpo").disabled=false;}

}



function leer_UsuariosWeb(){

    let cte = byID("altatarjetas-idcte14").value;

    //console.log(cte)

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getUsuariosWeb&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        //console.log(data)

        data = JSON.stringify(data);

        sessionStorage.setItem("usuariosweb", data);

        let tbl = byID("tbl-usuariosweb").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for (let elmt of rows) {

            elmt.remove();

        }



        let usuariosweb = sessionStorage.getItem("usuariosweb");

        usuariosweb = JSON.parse(usuariosweb);

        tbl = byID("tbl-usuariosweb");

        for (var element of usuariosweb){ 

            

            rw = tbl.insertRow(); 

            cll4 = rw.insertCell();

            cll0 = rw.insertCell();

            cll1 = rw.insertCell();

            cll2 = rw.insertCell();

            

            var input = document.createElement("input");

            input.setAttribute("type","submit");

            input.setAttribute("name","bntADusuariosweb");

            input.setAttribute("id",element.idusuarioweb);

            input.setAttribute("onClick",'activarbtn('+element.idusuarioweb+')');

            if(element.activo==1){

                input.setAttribute("class",'Activo');

                input.setAttribute("value","Activo");

            }else{ 

                input.setAttribute("value","Inactivo");

                input.setAttribute("class",'Inactivo');

                rw.style.backgroundColor = '#D7D7D7';};

            cll4.append(input);

            cll0.innerHTML = element.nombreweb;

            cll1.innerHTML = element.usuario;

            cll2.innerHTML = element.nombre;

            

        } 

    });

    

    // fillSelects_UsuariosWeb();  → NO ESTA ESTA FUNCION

}

function filclientes(){

    /*var s = byID("altauserweb-grupo").childNodes[1];

    let o = s.getElementsByTagName("option");

        for(let elmt of o){

            elmt.remove();

        }*/



        



    let grupo = byID("altauserweb-grupo").value;

    let sel = byID("altauserweb-cte");



    selectClientes(sel, grupo);

  

}





function alta_Usuarios(){

    

    let divusu = document.getElementById("divUsuarios");

    

    if(divusu.style.display=="none"){

        divusu.style.display="block"

        if(grupo!=0){byID("userdiv").remove(); byID("userdiv2").remove();}

    }else{

        let mensaje = document.createElement("div");

    mensaje.classList.add("alerta2");

    mensaje.setAttribute("id","mensajeContra2");

    let lbl = document.createElement("label");

    lbl.innerHTML= "Contraseña: ";

    mensaje.append(lbl);

    let input = document.createElement("input");

    input.setAttribute("id","contraUsu");

    mensaje.append(input);

    let buton = document.createElement("button");

    buton.setAttribute("class","btn btn-success22");

    buton.innerHTML= "Aceptar";

    buton.setAttribute("onclick","contraU()");

    mensaje.append(buton);

    document.getElementsByTagName("body")[0].append(mensaje);







        

}

}



function contraU(){

    let gpo;

    var tipo = byID("altauser-tipo").value;

    let grupo = sessionStorage.getItem("sesionlog");

    grupo = JSON.parse(grupo)[3];

    let mensaje = byID("mensajeContra2");

    let contra1 = byID("contraUsu").value;



    if(contra1 == 1234){

        

        mensaje.remove();

        if(grupo!=0){

            gpo = grupo;



        }else{

            if(tipo ==1){ gpo = byID("altauser-gpo").value;}else{

                gpo = 0;

            }

        }



        

        //alert(tipo+" "+gpo)

    var nombre = byID("altauser-name").value;

    var usuario = byID("altauser-user").value;

    var contra = byID("altauser-pass").value;

    if(nombre==""||usuario==""||contra==""){return mensajeError("Complete todos los campos")}

    if(nombre==null||usuario==null||contra==null){return mensajeError("Complete todos los campos")}

    if(tipo=="" || tipo == null){return mensajeError("Seleccione tipo")}

    if(tipo=="1"){

        if(gpo=="" || gpo == null){

            return mensajeError("Seleccione grupo")

        }

    }

    





    let toSend = new FormData();

        toSend.append('id', "agregarUsuario");

        toSend.append('nombre', nombre);

        toSend.append('grupo', grupo);

        toSend.append('gpo', gpo);

        toSend.append('usuario', usuario);

        toSend.append('contrasena', contra);

        toSend.append('tipo', tipo);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        if(data==1 || data == 2){

        mensajeRespuesta("Guardado correctamente");

        leer_Usuarios();

        if(data==1){

            byID("altauser-gpo").value="1";

            byID("altauser-tipo").value="1";

        }

        byID("altauser-name").value="";

        byID("altauser-user").value="";

        byID("altauser-pass").value="";

        

        

        divusu.style.display="none"

        }else{console.log(data)}

    });

    }else{

        mensaje.remove();

        mensajeError("Contraseña incorrecta")

    }

}



function conduc_vehiculo(){

    

    let divchoferes = byID("choferes-checks");

    divchoferes.innerHTML = "";

    let choferes = sessionStorage.getItem("choferes");

    choferes = JSON.parse(choferes);

    let div = byID("choferes-checks");

    //console.log(choferes)

    for(element of choferes){

        var input = document.createElement("input");

        input.setAttribute("type","checkbox");

        input.setAttribute("value",element.idchofer);

        input.setAttribute("name","checkchofer");

        input.setAttribute("id",element.idchofer);

        div.appendChild(input);

        var label = document.createElement("label");

        label.setAttribute("for",element.idchofer);

        label.setAttribute("id","checkchoferlbl");

        label.innerHTML=element.nombre;

        div.appendChild(label);    

        var br = document.createElement("br");

        div.appendChild(br);  

    }

}

function checkchoferes(){

    let check =  byID("chochecks-all");

    let choferes = document.getElementsByName("checkchofer");

    if(check.checked==true){

        for(element of choferes){

            element.checked=true;

        }

    }else{

        for(element of choferes){

            element.checked=false;

        }

    }

}



function estacion_precio(){

    let estaciones = sessionStorage.getItem("estaciones");

    estaciones = JSON.parse(estaciones);

    let div = byID("estaciones-checks");

    //console.log(estaciones)

    for(element of estaciones){

        var input = document.createElement("input");

        input.setAttribute("type","checkbox");

        input.setAttribute("value",element.idestacion);

        input.setAttribute("name","checkestacion");

        input.setAttribute("id",element.idestacion);

        div.appendChild(input);

        var label = document.createElement("label");

        label.setAttribute("for",element.idestacion);

        label.innerHTML=element.nombre;

        div.appendChild(label);    

        var br = document.createElement("br");

        div.appendChild(br);  

    }

    estacion_precio2();

    

    estacion_precio21();

}



function estacion_precio2(){

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

        label.setAttribute("for","");

        label.innerHTML=element.nombre;

        div2.appendChild(label);    

        var br = document.createElement("br");

        div2.appendChild(br);  

    }

}



function estacion_precio21(){

    let estaciones = sessionStorage.getItem("estaciones");

    estaciones = JSON.parse(estaciones);

    let div2 = byID("estaciones-checks21");

    for(element of estaciones){

        

        var input = document.createElement("input");

        input.setAttribute("type","checkbox");

        input.setAttribute("value",element.idestacion);

        input.setAttribute("name","listadeestacionesconcheck1");

        input.setAttribute("id",element.idestacion);

        div2.appendChild(input);

        var label = document.createElement("label");

        label.setAttribute("for","");

        label.innerHTML=element.nombre;

        div2.appendChild(label);    

        var br = document.createElement("br");

        div2.appendChild(br);  

    }

}



function leer_combustibles(){



 fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getCombustibles", {

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

    //console.log(combustibles);

    let div2 = byID("combustibles-checks21");

    let div1 = byID("combustibles-checks2");

    for(element of combustibles){

        

        var input = document.createElement("input");

        input.setAttribute("type","checkbox");

        input.setAttribute("value",element.tipocombustible);

        input.setAttribute("name","listadecombustibles");

        input.setAttribute("id",element.tipocombustible);

        div2.appendChild(input);

        var label = document.createElement("label");

        label.setAttribute("for","");

        label.innerHTML=element.nombre;

        div2.appendChild(label);    

        var br = document.createElement("br");

        div2.appendChild(br);  



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



function leer_Usuarios(){

    let grupo = sessionStorage.getItem("sesionlog");

    grupo = JSON.parse(grupo)[3];   

    //console.log(grupo);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getUsuarios&gpo="+grupo, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => { 

        data = JSON.stringify(data);

        sessionStorage.setItem("usuarios", data);

        let tbl = byID("tbl-usuarios").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

        let usuarios = sessionStorage.getItem("usuarios");

        usuarios = JSON.parse(usuarios);

        tbl = byID("tbl-usuarios");



        for (var element of usuarios) { 

            rw = tbl.insertRow(); 

            cll4 = rw.insertCell();

            cll1 = rw.insertCell();

            cll2 = rw.insertCell();

            cll3 = rw.insertCell();

            var input = document.createElement("input");

            input.setAttribute("type","submit");

            input.setAttribute("name","bntADusuario");

            input.setAttribute("id",element.idusuario);

            input.setAttribute("onClick",'activarbtn1('+element.idusuario+')');

            if(element.activo==1){

                input.setAttribute("class",'Activo');

                input.setAttribute("value","Activo");

            }else{ 

                input.setAttribute("value","Inactivo");

                input.setAttribute("class",'Inactivo');

                rw.style.backgroundColor = '#D7D7D7';};

            cll4.append(input);

            cll1.innerHTML = element.nombre;

            cll2.innerHTML = element.usuario;

            cll3.innerHTML = element.tipo;

        } 

    });



    //fillSelects_Usuarios();  → NO ESTA ESTA FUNCION

}

function actualizarNip(){

//alert("a");

    let toSend = new FormData();

    toSend.append('id', 'actualizarNip');

    toSend.append('idchofer', byID("selectChoferCambioNip").value);

    toSend.append('nip', byID("nuevoNip").value);

    //toSend.append('idvehiculo', idvehiculo);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

    method: "POST",

    mode: "cors",

    body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

    if(data==1){

        mensajeRespuesta("Actualizado correctamente");

        }

    });





}



function alta_Choferes(){

    let divusu = document.getElementById("divCho");

    if(divusu.style.display=="none"){

        divusu.style.display="block"

    }else{

    var nombre = byID("altachofer-name").value;

    var idCliente = byID("altachofer-idcte").value;

    

    //var idvehiculo = byID("altachofer-vehi").value;

    if(nombre==""||nombre==null ){return mensajeError("Complete los campos")}

    if(idCliente=="000"||idCliente==null ){return mensajeError("Seleccione un cliente")}

    let toSend = new FormData();

        toSend.append('id', 'agregarChofer');

        toSend.append('nombre', nombre);

        toSend.append('idCliente', idCliente);

        //toSend.append('idvehiculo', idvehiculo);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) => {

        if(data==1){

            mensajeRespuesta("Guardado Correctamente");

        

        byID("altachofer-name").value="";

        byID("altachofer-idcte").value="000";

        byID("altachofer-nip").value="";

        divusu.style.display="none"



        }else{

            mensajeError(data);

        }

        

    });

}

}



function leer_Choferes(a){

    let cte = a;

    

    if(cte==1){

        cte = byID("altatarjetas-idcte27").value;

    }

    if(cte==2){

        cte = byID("altavehicle-idcte").value;

    }

       

    

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getChoferes&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        //console.log(data);

        data = JSON.stringify(data);

        sessionStorage.setItem("choferes", data);





        if(a==1){

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

        let selest = byID("selectChoferCambioNip");

        document.getElementById("selectChoferCambioNip").options.length = 0;

        for (var element of choferes) { 



            let option1 = document.createElement("option");

            option1.setAttribute("value",element.idchofer);

            option1.innerHTML=element.nombre;

            selest.append(option1);

        





            var rw = tbl.insertRow();

            var cll7 = rw.insertCell();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var input = document.createElement("input");

            input.setAttribute("type","submit");

            input.setAttribute("id",element.idchofer);

            input.setAttribute("name","bntADchofer");

            input.setAttribute("onClick",'activarbtn2('+element.idchofer+','+a+')');

            //console.log("FFFFF")

            if(element.choferactivo==1){

                input.setAttribute("class",'Activo');

                input.setAttribute("value","Activo");

            }else{ 

                input.setAttribute("value","Inactivo");

                input.setAttribute("class",'Inactivo');

                rw.style.backgroundColor = '#D7D7D7'};

            cll7.append(input);

            cll0.innerHTML = element.idchofer;

            cll1.innerHTML = element.nombre;

            cll2.innerHTML = element.idcliente;

        } 



        fillSelects_Choferes();

        }

        if(a==2){

            conduc_vehiculo();

        }

        

        

    });

}



function fillSelects_Choferes(){

    var selects = document.getElementsByClassName("sf-drivers")



    for (const sel of selects) {

        selectChoferes(sel);

    }

}



function leer_Tarjeta(){

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetas", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        var tarjetas = data;

        let tbl = byID("tbl-tarjetas"); 

        

        for (var element of tarjetas) { 

            var rw = tbl.insertRow();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            cll0.innerHTML = element.numero;

            cll1.innerHTML = element.nombre;

            cll2.innerHTML = element.nip;

            cll3.innerHTML = element.tarjeta;

        } 

    });

}



function alta_Vehiculos(){

    let divusu = document.getElementById("divVehi");

    if(divusu.style.display=="none"){

        divusu.style.display="block"

    }else{    

    var idCliente = byID("altavehicle-idcte").value;

    var modelo = byID("altavehicle-model").value;

    var ano = byID("altavehicle-year").value;

    var placas = byID("altavehicle-placas").value;

    var noEconomico = byID("altavehicle-noecono").value;

    var tipoVehiculo = byID("altavehicle-tipo").value;

    var controlaOdometro = byID("altavehicle-contodo").value;

    var kmmx = byID("altavehicle-kmmx").value;

    let choferes;

    let checks = document.getElementsByName("checkchofer");

    //var maxCarga = byID("altavehicle-maxcarga").value;

    //var variacion = byID("altavehicle-var").value;

    //var odometroInicial = byID("altavehicle-odoini").value;

    //var rendimientoProm = byID("altavehicle-rendprom").value;

    //var departamento = byID("altavehicle-dpto").value;

    //var tarjeta = byID("altavehicle-tarjeta").value;

        

    

    if(controlaOdometro==1&&kmmx==""){

        kmmx=1;

    }



    if(modelo==""||ano==""||placas==""||noEconomico==""){

        return alert("Complete todos los campos");

    }



    let toSend = new FormData();

    for(l of checks){

        if(l.checked==true){

            choferes=l.id;

            toSend.append('choferes[]', choferes);

        }

    }

    if(choferes==null || choferes==0){

        return alert("Seleccione al menos un chofer");

    }



        toSend.append('id', 'agregarVehiculo');

        toSend.append('idCliente', idCliente);

        toSend.append('modelo', modelo);

        toSend.append('ano', ano);

        toSend.append('placas', placas);

        toSend.append('noEconomico', noEconomico);

        toSend.append('tipoVehiculo', tipoVehiculo);

        toSend.append('controlaOdometro', controlaOdometro);

        toSend.append('kmmx', kmmx);

        

        //toSend.append('kmMax', maxCarga);

        //toSend.append('variacion', variacion);

        //toSend.append('odometro', odometroInicial);

        //toSend.append('rendimiento', rendimientoProm);

        //toSend.append('centroCosto', departamento);

        //toSend.append('idTarjeta', tarjeta);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) =>{

        if(data==1){

        mensajeRespuesta("Guardado correctamente");

        

        //byID("altavehicle-dpto").value="1";

        byID("altavehicle-tipo").value="1";

        byID("altavehicle-idcte").value="1";

        byID("altavehicle-model").value="";

        byID("altavehicle-year").value="";

        byID("altavehicle-placas").value="";

        byID("altavehicle-noecono").value="";

        byID("altavehicle-contodo").value="";

        byID("altavehicle-kmmx").value="";

        for(a of checks){

            a.checked=false;

        }

        //byID("altavehicle-maxcarga").value="";

        //byID("altavehicle-var").value="";

        //byID("altavehicle-odoini").value="";

        //byID("altavehicle-rendprom").value="";  

       // byID("altavehicle-tarjeta").value="";

       leer_Vehiculos2();

        divusu.style.display="none"

    }else{

       // console.log(data)

        mensajeError("Error al guardar")

    }

    });

}

}



function leer_Vehiculos(){

    

    var idcte = byID("altavehicle-idcte45").value;

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getVehiculos&cte="+idcte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("vehiculos", data);

        var tarjetas = data;

       let tbl = byID("tbl-vehiculos").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

        tbl = byID("tbl-vehiculos"); 

        tarjetas = JSON.parse(tarjetas);

        for (var element of tarjetas) { 

           // alert(element.activo);

            var rw = tbl.insertRow();

            var cll7 = rw.insertCell();

            var cll6 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            ///////////////Crea un boton para cambiar estado Activio/Inactivo de los vehiculos

            var input = document.createElement("input");

            input.setAttribute("type","submit");

            input.setAttribute("id",element.idvehiculo);

            input.setAttribute("name","bntADvehiculo");

            input.setAttribute("onClick",'activarbtn3('+element.idvehiculo+')');

            //console.log("BBBB")

            if(element.activo==1){

                input.setAttribute("class",'Activo');

                input.setAttribute("value","Activo");

            }else{ 

                input.setAttribute("value","Inactivo");

                input.setAttribute("class",'Inactivo');

                rw.style.backgroundColor = '#D7D7D7'};

             //////////////////////////////////////////////////// 

            cll7.append(input);

            cll6.innerHTML = element.idvehiculo;

            cll1.innerHTML = element.modelo;

            cll2.innerHTML = element.ano;

            cll3.innerHTML = element.placas;

            cll4.innerHTML = element.centrocosto;

            if(element.controlaodometro==0){

                cll5.innerHTML = "No";

            }else{

                cll5.innerHTML = "Sí";

            }

            

            //cll6.innerHTML = element.fechacaptura;

        } 



        fillSelects_Vehiculos();

    });

}



function fillSelects_Vehiculos(a){

    if(a==1){

        $("#altatarjetas-placas").find('option').remove();

    var selects = document.getElementsByClassName("sf-vehi")

    for (const sel of selects) {

        selectVehiculos(sel,a);

    }}

    if(a==2){

        let choferes = byID("pago_chofer");

        let rows = choferes.getElementsByTagName("option");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

        byID("pago_nip").value="";

        byID("pago_tarjeta").value="";

        byID("pago_disp").value="";

        let cte =  byID("pago_cliente").value;

        $("#pago_placas").find('option').remove();

        //placa.shift();

        //placa.remove();

        let deudor = sessionStorage.getItem("clientes");

        deudor = JSON.parse(deudor);

        for(element of deudor){

            if(element.idcliente == cte){

                if(element.tipocliente==0){

                    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getSaldo&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        //console.log(data)

                        var total=0;

                        let importe = data;

                        for(element of importe){

                            if(element.importedisponibleabono==null){

                                element.importedisponibleabono = 0;

                            }

                            total = total + parseFloat(element.importedisponibleabono,10);

                            //console.log(total)

                            //console.log(element.importedisponibleabono)

                        }

                       

                        byID("pago_disp").value= formatNumber(total);

                    })

                }

                if(element.tipocliente==1){

                    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getCredito&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        

                        //console.log(data)

                        var disponible = 0;

                        var total=0;

                        let importe = data;

                        let disp = byID("pago_disp");

                        for(element of importe){

                            if(element.restante==null){

                                element.restante=0;

                            }



                            total = total + parseFloat(element.restante,10);

                            //console.log(total)

                            //console.log(element.restante)

                        }

                        if(importe[0].limiteCredito==null){

                            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getCredito2&cte="+cte, {

                                method: "GET",

                                mode: "cors",

                                   })

                               .then(response => response.json())

                               .catch(error => console.log(error))

                               .then((data) => {

                                   //console.log(data);

                                disponible = data[0].limiteCredito;

                                disp.value = formatNumber(disponible);

                               })

                        }else{

                            disponible = importe[0].limiteCredito - total;

                            disp.value = formatNumber(disponible);

                        }



                        

                    })

                }

            }

        }

    var selects = document.getElementsByClassName("sltarjetas2")

    for (const sel of selects) {

        selectVehiculos(sel,a);

    }

    }

    if(a==2){

        var selects = document.getElementsByClassName("sf-vehi2")

    for (const sel of selects) {

        selectVehiculos(sel,a);

    }

    }



}



function leer_estaciones(){
 

    let grupo = sessionStorage.getItem("sesionlog");

    grupo = JSON.parse(grupo);

    grupo = grupo[3];

    //console.log(grupo)

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getEstaciones&grupo="+grupo, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        //console.log("Estaciones:")

        

        data = JSON.stringify(data);

        sessionStorage.setItem("estaciones", data);

        fillSelects_Estaciones();

        estacion_precio();

    });

}




function leer_todas_estaciones(){



    let tbl = byID("tbl-estaciones");

    let rows = tbl.getElementsByTagName("tr");

    rows = Array.from(rows);

    rows.shift();

    for(let elmt of rows){

        elmt.remove();

    }
 

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTodasEstaciones", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {
 

        for (var element of data) { 
 
 
             var rw = tbl.insertRow();  
             var cll0 = rw.insertCell(); 
             var cll1 = rw.insertCell(); 
             var cll2 = rw.insertCell(); 
             var cll3 = rw.insertCell(); 
             var cll4 = rw.insertCell(); 
             var cll5 = rw.insertCell(); 
             var cll6 = rw.insertCell(); 
             var cll7 = rw.insertCell();  
             cll0.innerHTML = element.codigo;
             cll1.innerHTML = element.nombre;
             cll2.innerHTML = element.direccion;
             cll3.innerHTML = element.calle;
             cll4.innerHTML = element.colonia;
             cll5.innerHTML = element.claveestacion;
             cll6.innerHTML = element.lat + element.longi;
             cll7.innerHTML = element.rzonsocial; 
        }
 

      

    });

}


function leer_Vehiculos2(){

    //var idcte = byID("altavehicle-idcte45").value;

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getVehiculos2", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("vehiculos2", data);

       // var tarjetas = data;

       /*let tbl = byID("tbl-vehiculos").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

        tbl = byID("tbl-vehiculos"); 

        tarjetas = JSON.parse(tarjetas);

        for (var element of tarjetas) { 

           // alert(element.activo);

            var rw = tbl.insertRow();

            var cll7 = rw.insertCell();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            var input = document.createElement("input");   //

            input.setAttribute("type","checkbox");         // AGREGA UN CHECKBOX A CADA FILA

            input.setAttribute("value",element.idvehiculo);     //

            input.classList.add("serviciocheck45");          //

            if(element.activo==1){

                input.checked=true;

            }else{ input.checked=false};

            cll7.append(input);

            cll0.innerHTML = element.idtarjeta;

            cll1.innerHTML = element.modelo;

            cll2.innerHTML = element.ano;

            cll3.innerHTML = element.placas;

            cll4.innerHTML = element.centrocosto;

            cll5.innerHTML = element.controlaodometro;

            //cll6.innerHTML = element.fechacaptura;

        } */



        fillSelects_Vehiculos();

    });

}



function filtrarcomplementos(){

    var idcliente = byID("no_clienteCom").value;

    var fechainicial = byID("fechainiCom").value;

    var fechafinal = byID("fechafinCom").value;

    let toSend = new FormData();

        toSend.append("id","obtenercomplementos");

        toSend.append("idcliente",idcliente);

        toSend.append("fechainicial",fechainicial);

        toSend.append("fechafinal",fechafinal);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

    let Complementos = data;

    //console.log(factura);



        let tbl = byID("tbl-complementosEmitidas");

    let rows = tbl.getElementsByTagName("tr");

    rows = Array.from(rows);

    rows.shift();

    for(let elmt of rows){

        elmt.remove();

    }

    tbl = byID("tbl-complementosEmitidas"); 

    for( var element of Complementos){

        let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/LACAJAMZT-COMPLEMENTO-"+element.folio+"-"+formatFecha3(element.fecha)+".pdf";

        let factura = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/LACAJAMZT-COMPLEMENTO-"+element.folio+"-"+formatFecha3(element.fecha)+".xml";

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

            cll1.innerHTML = formatFecha1(element.fecha);

            cll2.innerHTML = formatNumber(element.importe);

            cll3.append(input1);

            cll4.append(input);

    }   



    

    });

}





function alta_Tarjetas(){

    let divusu = document.getElementById("divTarje");

    if(divusu.style.display=="none"){

        divusu.style.display="block"

    }else{   

    var notarjeta = byID("altatarjetas-notarjeta").value; 

    

    var idcliente = byID("altatarjetas-idcte").value;

    var idvehiculo = byID("altatarjetas-placas").value;

    var tipo = byID("altatarjetas-tipo").value;

    var activo = 1;//byID("altatarjetas-activo").value;

    var estacioncheck = document.getElementsByName("checkestacion2");

    var productos = document.getElementsByName("listadecombustibles2");

    var horarios1 = byID("daycheck-1").checked;

    var horarios2 = byID("daycheck-2").checked;

    var horarios3 = byID("daycheck-3").checked;

    var horarios4 = byID("daycheck-4").checked;

    var horarios5 = byID("daycheck-5").checked;

    var horarios6 = byID("daycheck-6").checked;

    var horarios6 = byID("daycheck-6").checked;

    var horarios7 = byID("daycheck-7").checked;

    var horariosini = byID("daytime-ini").value;

    var horariosfin = byID("daytime-fin").value;

    var contador = 0;

    var contador2 = 0;

    var cantidadlimite = byID("limite-cant").value;

    var limitecantidad = 0;

    var limitedinero = 0;

    var limitetipo=byID("limite-tipo").value;

    var limiteperiodo = byID("limite-periodo").value;

    

    let toSend = new FormData();

  

        for(let element of estacioncheck){

            if(element.checked){

                toSend.append("estacion[]",element.value);

               // console.log(element.value)

                contador = Number(contador) + 1;

            }

        }



        for(let element of productos){

            if(element.checked){

                toSend.append("combustible[]",element.value);

                //console.log(element.value)

                contador2 = Number(contador2) + 1;

            }

        }

        if(limitetipo==1){

            limitecantidad = cantidadlimite;

            limitedinero =0;

        }else{

            limitedinero = cantidadlimite;

            limitecantidad = 0;

        }



        //console.log(contador)

        //notarjeta.match(/^[a-zA-Z]/) ||

    if( notarjeta==""){return mensajeError("Ingrese una Tarjeta valida")}//  /^[0-9]*$/ <----- Solo acepta numeros(Desactualizado)

    //if(nip==""|| nip.match(/^[a-zA-Z]/)){return mensajeError("Ingrese una NIP valido")}

    if(contador<=0){return mensajeError("Seleccione estacion")};

    if(contador2<=0){return mensajeError("Seleccione producto")};

    if(horarios1=="0"&&horarios2=="0"&&horarios3=="0"&&horarios4=="0"&&horarios5=="0"&&horarios6=="0"&&horarios7=="0"){return mensajeError("Seleccione al menos un día")}

    if(horariosini=="00:00:00"&&horariosfin=="00:00:00"){return mensajeError("Ingrese horarios correctos")}

    if(horariosini==null&&horariosfin==null){return mensajeError("Ingrese horarios correctos")}

    if(horariosini==""&&horariosfin==""){return mensajeError("Ingrese horarios correctos")}

    if(cantidadlimite=="0"||cantidadlimite==null||cantidadlimite==""){return mensajeError("Ingrese una cantidad limite")}

     

    

        toSend.append('id', 'AgregarTarjetas');

        toSend.append('notarjeta', notarjeta);

        toSend.append('idcliente', idcliente);

        toSend.append('idplaca', idvehiculo);

        toSend.append('tipo', tipo);

        toSend.append('activo', +(activo));

        toSend.append('lunes', +(horarios1));

        toSend.append('martes', +(horarios2));

        toSend.append('miercoles', +(horarios3));

        toSend.append('jueves', +(horarios4));

        toSend.append('viernes', +(horarios5));

        toSend.append('sabado', +(horarios6));

        toSend.append('domingo', +(horarios7));

        toSend.append('horarioinicial', horariosini);

        toSend.append('horariofinal', horariosfin);

        toSend.append('limitedinero', limitedinero);

        toSend.append('limitelitros', limitecantidad);

        toSend.append('tipoperiodo', limiteperiodo);

        toSend.append('limitetipo', limitetipo);

        



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) =>{

        if(data.trim()=="3"){return mensajeError("Número de tarjeta ya existe")}

        if(data.trim()=="1"){

            mensajeRespuesta("Guardado correctamente");

        byID("altatarjetas-notarjeta").value="";

        

        for(var element of estacioncheck){

            element.checked=false;

        }



        for(var element of productos){

            element.checked=false;

        }

        

        byID("comchecks-all1").checked=false;

        byID("estchecks-all2").checked=false;

        byID("daycheck-1").checked=false;

        byID("daycheck-2").checked=false;

        byID("daycheck-3").checked=false;

        byID("daycheck-4").checked=false;

        byID("daycheck-5").checked=false;

        byID("daycheck-6").checked=false;

        byID("daycheck-6").checked=false;

        byID("daycheck-7").checked=false;

        byID("daytime-ini").value="";

        byID("daytime-fin").value="";

        byID("limite-cant").value="";

        //byID("limite-din").value="";

        byID("altatarjetas-idcte").value="1";

        byID("altatarjetas-placas").value="1";

        //byID("altatarjetas-tipo").value="1";

        byID("altatarjetas-activo").value="1";

        leer_Vehiculos2();

        divusu.style.display="none"

        }else{

            mensajeError("Error al guardar")

            console.log(data)

        }

        

    });

}

}







function leer_Tarjetas(a){

    if(a==1){let tbl = byID("tbl-tarjetaszz").childNodes[1];

    let rows = tbl.getElementsByTagName("tr");

    rows = Array.from(rows);

    rows.shift();

    for(let elmt of rows){

        elmt.remove();

    }

    let cte = byID("altatarjetas-idcte22").value;

    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getProd&cte="+cte,{

        method: "GET",

        modo: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => { 

        data= JSON.stringify(data);

        sessionStorage.setItem("prod",data);

       

        //console.log(data);

        

    });



    fetch("https://monedero.grupopetromar.com/apirest/index.php/?id=getEsta&cte="+cte,{

        method: "GET",

        modo: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => { 

        data= JSON.stringify(data);

        sessionStorage.setItem("esta",data);

       

        //console.log(data);

        

    });

    

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetas&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("tarjetas", data);

        var tarjetas = sessionStorage.getItem("tarjetas");

        tarjetas = JSON.parse(tarjetas); 

       tbl = byID("tbl-tarjetaszz");  

        for (var element of tarjetas) { 

            let estaciones=sessionStorage.getItem("esta");

            estaciones=JSON.parse(estaciones);

            let e=[];

            let combustible=sessionStorage.getItem("prod");

            combustible=JSON.parse(combustible);

            let c=[]

                let periodo=[];

                let dia=[];

                //estaciones

                for(let ele of estaciones){

                

                    if(ele.folio==element.folio){

                        e.push(ele.nombre+" ")

                       //console.log(ele.nombre)

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

                    dia.push(" Lunes")

                }

                if(element.martes==1){

                    dia.push(" Martes")

                }

                if(element.miercoles==1){

                    dia.push(" Miercoles")

                }

                if(element.jueves==1){

                    dia.push(" Jueves")

                }

                if(element.viernes==1){

                    dia.push(" Viernes")

                }

                if(element.sabado==1){

                    dia.push(" Sábado")

                }

                if(element.domingo==1){

                    dia.push(" Domingo")

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

            var cll1 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            var cll6 = rw.insertCell();

            var cll8 = rw.insertCell();

            

            var input = document.createElement("input");

            input.setAttribute("type","submit");

            input.setAttribute("id",element.folio);

            input.setAttribute("name","bntAD");

            input.setAttribute("onClick",'activarbtn4('+element.folio+')');

            if(element.activo==1){

                input.setAttribute("class",'Activo');

                input.setAttribute("value","Activo");

            }else{ 

                input.setAttribute("value","Inactivo");

                input.setAttribute("class",'Inactivo');

                rw.style.backgroundColor = '#D7D7D7';}

            cll7.append(input);

            cll0.innerHTML = element.notarjeta;

            cll1.innerHTML = element.modelo;

            cll8.innerHTML = element.placas;

            cll3.innerHTML = e;

            cll4.innerHTML = c;

            cll5.innerHTML = dia+", "+element.horarioinicial+" - "+element.horariofinal;

            cll6.innerHTML = "Litros: "+element.limitelitros+"Lts Dinero: $"+element.limitedinero+" Periodo: "+periodo;

        } 

    });

}

    if(a==2){



    let cte = byID("pago_cliente").value;

    

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetas&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("tarjetas", data);

        fillSelects_Tarjetas();

    });



        

    }

    if(a=="imp-tarjeta"){



        let cte = byID("imp_cliente").value;

        let select = byID("imp_tarjeta");

        let razon = byID("imp_rzon");

        while (select.options.length > 1) {                

            select.remove(1);

        }  

        

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetas&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        let tarjetas = data;

        console.log(tarjetas);



        for(let element of tarjetas){

            let option = document.createElement("option");

            option.value = element.notarjeta;

            option.innerHTML= element.notarjeta;

            select.add(option);

        }



        razon.value = tarjetas[0].rzonsocial;



    });



    }



    // fillSelects_Tarjetas();

}





function nWin() { 

    var w = window.open(); 

    var html = $("#imptarjetas").html(); 

   

      $(w.document.body).html(html); 

      w.print(); 

  }



function verT(){

    let vt = byID("imp_tarjeta").value;

    let vr = byID("imp_rzon").value;



    

    let conjunto1 = vt.substring(0, 4);

    let conjunto2 = vt.substring(4, 8);

    let conjunto3 = vt.substring(8, 12);

    let conjunto4 = vt.substring(12, 16);



    let nt = conjunto1+"&nbsp; "+conjunto2+"&nbsp;  "+conjunto3+"&nbsp;  "+conjunto4;



    let labelt = byID("impT");

    let labelr = byID("impR");

    let labelp = byID("impP");



    

    let numeroTarjeta = byID("imp_tarjeta").value;

    let placaseleccionada = byID("placaseleccionada");

    let placasel = "";

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getPlacaFTarjeta&numeroTarjeta="+numeroTarjeta,{

        method: "GET",

        modo: "cors",

    })

    .then(response => response.text())

    .catch(error => console.log(error))

    .then((data) => { 

        data= data;

        placaseleccionada.value = data.trim();

        placasel = data.trim();

        //sessionStorage.setItem("prod",data);

        labelp.innerHTML = placasel;

        console.log(data);

        

    });

    labelt.innerHTML = nt;

    labelr.innerHTML = vr;

    

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



function fillSelects_Estaciones(){ 

    var selects = document.getElementsByClassName("sl-estaciones");

    

    for (const item of selects) {

        selectEstaciones(item);

    }



}



function selectEstaciones(item){

    

    var options =  item.childNodes;

    options = Array.from(options);

    //options.shift();

    /*for(let element of options){ 

       // console.log(options);

        

        element.remove();

    }*/



    var estacion = sessionStorage.getItem("estaciones");

     estacion = JSON.parse(estacion);

    

     for (var element of estacion) { 

        

            var option = document.createElement("option");

            option.text = element.nombre;

            option.value = element.idestacion;

            item.add(option);

         

        

        

    } 

}







function alta_Abonos(){

    let idcliente = byID("altatarjetas-idcte04").value;

    //let fecha = byID("abonoctaD-fecha").value;

    let importe = byID("abonoctaD-importe2").value;

    let formapago = byID("abonoctaD-fpago2").value;

    let bancodestino = byID("abonoctaD-bcodest2").value;

    let cuentabancaria = byID("abonoctaD-ctabanc2").value;

    let referencia = byID("abonoctaD-referencia2").value;

    let concepto = byID("abonoctaD-concepto2").value;





    //console.log(idcliente);

    //console.log(importe);

    //console.log(referencia);

    //console.log(concepto);

    if(idcliente == "" || importe== "" || referencia =="" || concepto == ""){

        mensajeError("Complete todos los campos");

        

    }else{







        if(formapago == null|| bancodestino == null || cuentabancaria == null||formapago == ""){

            mensajeError("Complete todos los campos")

        }else{

            let toSend = new FormData();

        toSend.append("id", "agregarAbono");

        toSend.append("idcliente", idcliente);

        //toSend.append("fecha", fecha);

        toSend.append("importe", importe);

        toSend.append("formapago", formapago);

        toSend.append("bancodestino", bancodestino);

        toSend.append("cuentabancaria", cuentabancaria);

        toSend.append("referencia", referencia);

        toSend.append("concepto", concepto);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend

        })

        .then(response => response.text())

        .catch(error => alert(error))

        .then((data) =>{

            if(data==1){

        mensajeRespuesta("Guardado correctamente");

        listadesaldos();

        //byID("abonoctaD-folio2").value="";

        byID("abonoctaD-importe2").value="";

        byID("abonoctaD-fpago2").value="";

        byID("abonoctaD-bcodest2").value="";

        byID("abonoctaD-ctabanc2").value="";

        byID("abonoctaD-referencia2").value="";

        byID("abonoctaD-concepto2").value="";

        byID("abonoctaD-cte3").value="";

        byID("abonoctaD-cte2").value="";

        byID("RFCctaD-cte2").value="";

        byID("abonoctaD-lim").value="";

        byID("abonoctaD-dis").value="";

        Buscarcliente('3');



        let toSend1 = new FormData();

        toSend1.append("cte",idcliente);

        fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/abonoscorreo.php/",{

        method: "POST",

        mode: "cors",

        body: toSend1

        })

        .then(response => response.json())

        .catch(error => console.log(error))

        .then((data) =>{

           // console.log(data);

        })





            }else{

                console.log(data)

                mensajeError("Error al Guardar")



            }



        });



        }

    

}

}



function alta_estacion(){

    let codigo = byID("altaestacion-codi").value;

    let nombre = byID("altaestacion-nombre").value;

    let direc = byID("altaestacion-dire").value;

    let calle = byID("altaestacion-calle").value;

    let colonia = byID("altaestacion-colonia").value;

    let clave = byID("altaestacion-clave").value;

    let grupo = byID("altaestacion-grupo").value;

    let lat = byID("altaestacion-lat").value;

    let long = byID("altaestacion-long").value;



    if(codigo=="" || nombre=="" || direc=="" || clave=="" || grupo=="" || lat=="" || long == ""){

        return mensajeError("Complete todos los campos")

    }





    let toSend = new FormData();

    toSend.append("id","altaestacion");

    toSend.append("codigo",codigo);

    toSend.append("nombre",nombre);

    toSend.append("direc",direc);

    toSend.append("clave",clave);

    toSend.append("calle",calle);

    toSend.append("colonia",colonia);

    toSend.append("grupo",grupo);

    toSend.append("lat",lat);

    toSend.append("long",long);

    



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php",{

            method: "POST",

            mode: "cors",

            body: toSend

        }).then(response => response.text())

        .catch(error => alert(error))

        .then((data) => {

            if(data == 1){

                mensajeRespuesta("Guardado correctamente");



                byID("altaestacion-codi").value ="";

                byID("altaestacion-nombre").value ="";

                byID("altaestacion-dire").value ="";

                byID("altaestacion-clave").value ="";

                byID("altaestacion-grupo").value = "1";

                byID("altaestacion-lat").value ="";

                byID("altaestacion-long").value ="";

                byID("altaestacion-calle").value ="";

                byID("altaestacion-colonia").value ="";

                leer_estaciones();

                estacion_precio();

                estacion_precio2();

            }else{mensajeError(data)}

        })



}



/*function leer_Abonos(){

    let cte = byID("abonoctaD-cte").value;

    console.log(cte)

    fetch(`https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getAbonos&cte=`+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("abonos", data);

        console.log(data)

        let tbl = byID("tbl-abonoctaD").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }



        let abonos = sessionStorage.getItem("abonos");

        abonos = JSON.parse(abonos);

        

        tbl = byID("tbl-abonoctaD");

        

        //console.log(abonos);

        for (let element of abonos) { 

            let rw = tbl.insertRow();

            let cll0 = rw.insertCell();

            let cll1 = rw.insertCell();

            let cll2 = rw.insertCell();

            let cll3 = rw.insertCell();

            let cll4 = rw.insertCell();

            let cll5 = rw.insertCell();

            cll0.innerHTML = element.IDabono;

            cll1.innerHTML = element.IDcliente;

            cll2.innerHTML = element.fecha;

            cll3.innerHTML = element.importe;

            cll4.innerHTML = element.concepto;

            cll5.innerHTML = element.importedisponible;

        } 

    });

}*/



function tipodeusuario(){

    let grupo1 = sessionStorage.getItem("sesionlog");

    grupo = JSON.parse(grupo1)[3];

    let menu;

    let menu2;

    let modulos;

    if(grupo != 0){

        menu = byID("sidemenu");

        menu.remove();

        menu2 = byID("sidemenu2").hidden=false;

        let Impuestos = byID("div-impuestos");

        Impuestos.remove();

        modulos = byID("module").remove();

        let tipo = JSON.parse(grupo1)[4]

        if(tipo==1){

           let tabla = byID("OCB");

            tabla.remove();

        }



    }else{

        menu = byID("sidemenu2");

        menu.remove();

        menu2 = byID("sidemenu").hidden=false;

        modulos = byID("module2").remove();

    }

}



function selectPagos(select){ 

    select.innerHTML = "";

    var pagos = sessionStorage.getItem("pagos");

    pagos = JSON.parse(pagos);

    // console.log(clientes);

    var option2 = document.createElement("option");

        option2.text = "SELECCIONE PAGO";

        select.add(option2); 

    for (var element of pagos) { 

        if(element.importedisponibleabono>=1){

            var option = document.createElement("option");

        option.text = element.referencia;

        option.value = element.IDabono;

        select.add(option); 

        }

    } 

}



function selectClientes(select){ 

    

     

    select.innerHTML = "";

    var clientes = sessionStorage.getItem("clientes");

    clientes = JSON.parse(clientes);

    // console.log(clientes);

    var option2 = document.createElement("option");

        option2.text = "SELECCIONE CLIENTE";

        option2.value = "000";

        select.add(option2); 

    for (var element of clientes) { 

            var option = document.createElement("option");

        option.text = element.rzonsocial;

        option.value = element.idcliente;

        select.add(option); 

        

        

    } 

}



function selectClientesC(select){ 

    

     

    select.innerHTML = "";

    var clientes = sessionStorage.getItem("clientes");

    clientes = JSON.parse(clientes);

    // console.log(clientes);

    var option2 = document.createElement("option");

        option2.text = "SELECCIONE CLIENTE";

        select.add(option2); 

    for (var element of clientes) { 

        if(element.tipocliente==1){

        var option = document.createElement("option");

        option.text = element.rzonsocial;

        option.value = element.idcliente;

        select.add(option); 

        }

        

    } 

}

function selectTarjetasC(select){ 

    

     

    select.innerHTML = "";

    var tarjetas = sessionStorage.getItem("tCliente");

    tarjetas = JSON.parse(tarjetas);

    // console.log(tarjetas);

    var option2 = document.createElement("option");

        option2.text = "SELECCIONE TARJETA";

        option2.value = "";

        select.add(option2); 

    for (var element of tarjetas) { 

        var option = document.createElement("option");

        option.text = element.notarjeta;

        option.value = element.folio;

        select.add(option); 

        

        

    } 

}



function selectgrupo(select){ 

    for (let i = select.options.length; i >= 0; i--) {

        select.remove(i);

      }

    // console.log(clientes);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getgrupo", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.text())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.parse(data);

        for (var element of data) { 

            var option = document.createElement("option");

            option.text = element.nombre;

            option.value = element.idgrupo;

            select.add(option);

        } 

    });



    

}



function selectProd(select){ 

    // console.log(clientes);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getproducto", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.text())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.parse(data);

        for (var element of data) { 

            var option = document.createElement("option");

            option.text = element.nombre;

            option.value = element.folio;

            select.add(option);

        } 

    });



    

}



function selectChoferes(select){ 

    var choferes = sessionStorage.getItem("choferes");

    choferes = JSON.parse(choferes);

    for (var element of choferes) { 

        var option = document.createElement("option");

        option.text = element.nombre;

        option.value = element.idchofer;

        select.add(option);

    } 

    var option = document.createElement("option");

        option.text = "test";

        option.value = "test";

        select.add(option);

}

function slc_chofer(a, placa){

    let choferes = sessionStorage.getItem("choferes");

    choferes = JSON.parse(choferes);

    let select = byID("pago_chofer");





    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getchoferesC&c="+a+"&p="+placa, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        console.log(data)

        let choferes =data;

        for (var element of choferes) { 

            var option = document.createElement("option");

            option.text = element.nombre;

            option.value = element.idchofer;

            select.add(option);

            }



    });





    

}

function ONp(){



    let C = byID("pago_chofer").value;

fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getONp&c="+C, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        //console.log(data);



        byID("pago_nip").value=data[0].nip;

    });





}

function kmmax(){

    let kmx =byID("kmmx");

    let odometro =byID("altavehicle-contodo").value;

    console.log(odometro);

    if(odometro==1){

        kmx.style.display = "flex";

    }else{

        kmx.style.display = "none";

        kmx.value=null;

    }





}





function selectVehiculos(select, a){ 

    if(a==1){

    let cte =byID("altatarjetas-idcte").value;

    var vehiculos = sessionStorage.getItem("vehiculos2");

    vehiculos = JSON.parse(vehiculos);

    for (var element of vehiculos) { 

        if(element.idtarjeta=="" && element.idcliente==cte){

        var option = document.createElement("option");

        option.text = element.placas;

        option.value = element.idvehiculo;

        select.add(option);

        }

    } }

    if(a==2){

        let cte =byID("pago_cliente").value;

    var vehiculos = sessionStorage.getItem("vehiculos2");

    vehiculos = JSON.parse(vehiculos);

        var option2 = document.createElement("option");

        option2.text = "SELECCIONE PLACA";

        option2.value = "SELECCION";

        select.add(option2);

    for (var element of vehiculos) { 

        if(element.idcliente==cte){

        var option = document.createElement("option");

        option.text = element.placas;

        option.value = element.idvehiculo;

        select.add(option);

        }

    }

    }

    if(a==3){

        let cte =byID("altachofer-idcte").value;

    var vehiculos = sessionStorage.getItem("vehiculos2");

    vehiculos = JSON.parse(vehiculos);

        var option2 = document.createElement("option");

        option2.text = "SELECCIONE VEHICULO";

        option2.value = "SELECCION";

        select.add(option2);

    for (var element of vehiculos) { 

        if(element.idcliente==cte && element.chofer==0){

        var option = document.createElement("option");

        option.text = element.placas;

        option.value = element.idvehiculo;

        select.add(option);

        }

    }

    }



}



function alta_cargo(){

    var idcliente = byID("idcliente").value;

    var estacion = byID("estacion").value;

    var fecha = byID("fecha").value;

    var tarjeta = byID("tarjeta").value;

    var importe = byID("importe").value;

    var producto = byID("producto").value;



    let toSend = new  FormData();

        toSend.append("id","");

        toSend.append("idcliente", idcliente);

        toSend.append("estacion", estacion);

        toSend.append("fecha", fecha);

        toSend.append("tarjeta", tarjeta);

        toSend.append("importe", importe);

        toSend.append("producto", producto);



    fetch("", {

        method: "POST",

        mode: "cors",

        body: toSend,

    })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) =>{

        mensajeRespuesta(data.trim());

    });

    

}

function leer_Transacciones(){

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTransacciones", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("transacciones", data);

        

       /* let tbl = byID("tbl-transaccionesctes").childNodes[1];

         let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

*/

        let transacciones = sessionStorage.getItem("transacciones");

        transacciones = JSON.parse(transacciones);

        

        let tbl = byID("tbl-transaccionesctes");

        

        for (let element of transacciones) { 

            let rw = tbl.insertRow();

            let cll0 = rw.insertCell();

            let cll1 = rw.insertCell();

            let cll2 = rw.insertCell();

            let cll3 = rw.insertCell();

            let cll4 = rw.insertCell();

            let cll5 = rw.insertCell();

            let cll6 = rw.insertCell();

            cll0.innerHTML = element.estacion;

            cll1.innerHTML = element.fecha;

            cll2.innerHTML = element.folio;

            cll3.innerHTML = element.idcliente;

            cll4.innerHTML = element.importe;

            cll5.innerHTML = element.producto;

            cll6.innerHTML = element.tarjeta;

        }  

    });

}



function leer_abonos(){

    let cte = byID("num_cliente_p").value;

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getAbonos2&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

        data = JSON.stringify(data);

        sessionStorage.setItem("pagos", data);

        fillSelects_pagos();

    });

    

}



function pagar(){

    let cliente = byID("num_cliente_p").value;

    let abono = byID("pago_p").value;

    let a = byID("pago_impo").value;

    let foliopago = byID("pago").value;

    let importe = [];

    let servicios = sessionStorage.getItem("facturaR");

    servicios = JSON.parse(servicios);

    if(abono=="" || a==""){

        return alert("Seleccione un Pago y Factura");

    }

    let toSend = new FormData();

   for(let l of foliosFacturas){

        for(let s of servicios){

         if(l==s.folio){

            importe.push(s.restante);

            toSend.append("folios[]",s.folio);

            toSend.append("importe[]",s.restante);

          

         }

        }

    }

    abono = abono.slice(1);

    abono = parseFloat(abono);

    

    //if(abono>=total){



        

        toSend.append("id","aplicacionPagosCredito");

        toSend.append("foliopago",foliopago);

        toSend.append("cte",cliente);

        toSend.append("abono",abono);

        

    //console.log(importe);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) =>{

        if(data==1){

            mensajeRespuesta("Realizado correctamente");

            pagosrestantes();

            byID("pago_impo").value="0.00";

            importe.splice(0, importe.length);

            sumarimporte("limpiar");



        }else{mensajeError("ERROR AL GUARDAR");

        }



    })

   /* }else{

        return mensajeError("El pago no cubre la cantidad necesaria");

    }*/



}



function mostrarpago(){

    let saldo = sessionStorage.getItem("pagos");

    saldo = JSON.parse(saldo);

    let abono = byID("pago").value;

    for(let element of saldo){

    if(element.IDabono==abono){

        let importedisponible =dosdecimales(element.importedisponibleabono);

        byID("pago_p").value=formatCant('$'+importedisponible);

    }

}

}



function Buscarcliente(e){

    if(e=="1"){

 var cte = byID("altatarjetas-idcte05").value;

 var input =byID("nombre_cliente");

    selects_clientes(cte, input)}

    if(e=="2"){

        var cte = byID("no_cliente2").value;

        var input =byID("nombre_cliente2");

           selects_clientes(cte, input)}

    if(e=="3"){

        var cte = byID("altatarjetas-idcte04").value; 

        var input =byID("abonoctaD-cte2");

        var input2 =byID("abonoctaD-cte3");

        var limCredito = byID("abonoctaD-lim");

        var disp = byID("abonoctaD-dis");

        

        let deudor = sessionStorage.getItem("clientes");

        deudor = JSON.parse(deudor);

        for(element of deudor){

            

            if(element.idcliente == cte){

                //console.log(element.rfc

                var input3 = byID("RFCctaD-cte2").value = element.rfc;

            

                if(element.tipocliente==0){

                    byID("limCre").style.display="none";

                    byID("dispCre").style.display="none";

                    byID("eti_abono").innerHTML="Saldo";

                    //$('#eti_abono').text("Saldo");

                    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getSaldo&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        //console.log(data)

                        var total=0;

                        let importe = data;

                        for(element of importe){

                            if(element.importedisponibleabono==null){

                                element.importedisponibleabono = 0;

                            }

                            total = total + parseFloat(element.importedisponibleabono,10);

                            //console.log(total)

                            //console.log(element.importedisponibleabono)

                        }

                       

                        input2.value= "$"+total;

                    })

                }   

                if(element.tipocliente==1){

                    //byID("limCre").style.display="flex";

                    //byID("dispCre").style.display="flex";

                    //$('#eti_abono').text("Saldo");

                    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getCredito&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        

                        //console.log(data)

                        var disponible = 0;

                        var total=0;

                        let importe = data;

                        for(element of importe){

                            if(element.restante==null){

                                element.restante=0;

                            }



                            total = total + parseFloat(element.restante,10);

                            //console.log(total)

                            //console.log(element.restante)

                        }

                        if(importe[0].limiteCredito==null){

                            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getCredito2&cte="+cte, {

                                method: "GET",

                                mode: "cors",

                                   })

                               .then(response => response.json())

                               .catch(error => console.log(error))

                               .then((data) => {

                                disponible = data[0].limiteCredito - total;

                                limCredito.value = "$"+data[0].limiteCredito;

                                input2.value = "$"+disponible;

                               })

                        }else{

                            disponible = importe[0].limiteCredito - total;

                            limCredito.value = "$"+importe[0].limiteCredito;

                            input2.value = "$"+disponible;

                        }



                        //input2.value= "$"+total;

                        

                        

                        

                        

                    })

                }



                fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getAbonos&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        //console.log(data)

                        let tbl = byID("tbl-abonoctaD2").childNodes[1];

                        let rows = tbl.getElementsByTagName("tr");

                        rows = Array.from(rows);

                        rows.shift();

                        for(let elmt of rows){

                             elmt.remove();

                        }



                        let abonos = data;

                        //console.log(abonos)

        

                        tbl = byID("tbl-abonoctaD2");

        

                        //console.log(abonos);

                        for (let element of abonos) { 

                        let rw = tbl.insertRow();

                        let cll0 = rw.insertCell();

                        let cll1 = rw.insertCell();

                        let cll2 = rw.insertCell();

                        let cll3 = rw.insertCell();

                        let cll4 = rw.insertCell();

                        let cll5 = rw.insertCell();

                        let cll6 = rw.insertCell();



                        var button = document.createElement("input");

                        button.setAttribute("type","submit");

                        button.setAttribute("id",element.IDabono);

                        button.classList.add("Inactivo");

                        button.setAttribute("onclick",'AbVe('+element.IDabono+')');

                        button.setAttribute("value","Eliminar");

                        cll0.innerHTML = element.IDabono;

                        cll1.innerHTML = element.rzonsocial;

                        cll2.innerHTML = formatFecha(element.fecha);

                        cll3.innerHTML = formatNumber(element.importeabono);

                        cll4.innerHTML = element.concepto;

                        if(element.formapago==1){

                            cll5.innerHTML = "Transferencia";

                        }

                        if(element.formapago==2){

                            cll5.innerHTML = "Efectivo";

                        }

                        if(element.formapago==3){

                            cll5.innerHTML = "Cheque";

                        }

                        if(element.formapago==4){

                            cll5.innerHTML = "Tarjeta Débito";

                        }

                        if(element.formapago==5){

                            cll5.innerHTML = "Tarjeta Crédito";

                        }

                        cll6.append(button);

                        

                        

        } 

                    })

            }else{

                //byID("abonoctaD-folio2").value=""; 

                byID("abonoctaD-cte2").value="";

                byID("abonoctaD-cte3").value="";

               // byID("RFCctaD-cte2").value ="";

            }

            

        }

        selects_clientes(cte, input);

        

    

    }

}





function selects_clientes(cte, input){ 

    var ctes = sessionStorage.getItem("clientes");

    ctes = JSON.parse(ctes);



    for (let element of ctes) { 

        if(element.idcliente==cte){

            input.value=element.nombre;

        }

    } 

}



function pagosrestantes(){

    byID("pago_p").value="";

    let tbl = byID("tbl-pagorestante").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

    var idcliente = byID("num_cliente_p").value;

    //console.log(idcliente)



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getservR&cte="+idcliente, {

    method: "GET",

    mode: "cors",

     })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

    console.log(data)

    let factura = data;

    //console.log(abonos);

    factura = JSON.stringify(factura);

    sessionStorage.setItem("facturaR",factura);

    factura = JSON.parse(factura);

    

    let tbl = byID("tbl-pagorestante"); 

    for( var element of factura){

        var rw = tbl.insertRow();

            var cll8 = rw.insertCell();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var input = document.createElement("input");

            input.setAttribute("type","checkbox");

            input.setAttribute("value",element.folio);

            input.setAttribute("onClick","sumarimporte("+element.folio+")");

            input.classList.add("restantecheck");

            cll8.append(input);

            cll0.innerHTML = "#"+element.folio;

            cll1.innerHTML = formatDate(element.fechagenerado);

            cll2.innerHTML = formatCant("$"+element.importe);

            cll3.innerHTML = formatCant("$"+element.restante);

            cll4.innerHTML = element.factura;

            

    }   

    leer_abonos();

    byID("pago_impo").value="0.00";

    sumarimporte("limpiar");

    });

    

}

let foliosFacturas=[];

function sumarimporte(i){

    if(i=="limpiar"){

        foliosFacturas.splice(0, foliosFacturas.length);

    }

 

 let check = document.getElementsByClassName("restantecheck");

 let factura = sessionStorage.getItem("facturaR");

    factura = JSON.parse(factura);

let pago = byID("pago_p").value;

let importe = byID("pago_impo").value;

pago = pago.slice(1);

pago = parseFloat(pago);

console.log(importe);



if(importe==""){

    importe=0;

}else{

    importe = parseFloat(importe);

}

var dif = (pago - importe);



 for(element of check){

     if(element.value==i){

         if(element.checked==true){

             for(registro of factura){

                 if(registro.folio==i){

                    if (dif >= 0){

                    byID("pago_impo").value=  importe + parseFloat(registro.restante);

                    foliosFacturas.push(registro.folio);

                    }else{

                        for(f of check){

                            if(f.value==i){

                                f.checked=false;

                            }

                        }

                        mensajeError("Saldo disponible insuficiente");

                    }

                 }

             }

             //console.log(foliosFacturas);

         }else{

            let remover = (foliosFacturas.indexOf(element.value));

            foliosFacturas.splice(remover, 1);

            for(registro of factura){

                if(registro.folio==i){

                   byID("pago_impo").value=  importe - parseFloat(registro.restante);

                }

            }//console.log(foliosFacturas);

         }

     }

 }



 









}

function sumarServicios(){
    let checks = document.getElementsByClassName("serviciocheck");
    let sum = 0; 
    for(let item of checks){
        if(item.checked == true){
            sum = sum + parseFloat(item.id);
        }
        
    }
    document.getElementById("sumaImporteServicios").innerHTML = "Total: " + sum;
}





function filtrarservicios(){

    let tbl = byID("tbl-clientesservicios").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

    var idcliente = byID("altatarjetas-idcte05").value;

    //console.log(idcliente)

    var fechainicial = byID("fechaini1").value;

    var fechafinal = byID("fechafin1").value;
    var idtarjeta = byID("altatarjetas-notarjeta1-servicios").value;

    let toSend = new FormData();

        toSend.append("id","obtenerServicios");

        toSend.append("idcliente",idcliente);

        toSend.append("fechainicial",fechainicial);

        toSend.append("fechafinal",fechafinal);
        toSend.append("idtarjeta",idtarjeta);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

        //console.log(data)

        data = JSON.stringify(data);

        sessionStorage.setItem("servicioscte", data); 

        data=JSON.parse(data);

    let abonos = data;

    //console.log(abonos);

    

    let tbl = byID("tbl-clientesservicios"); 

    for( var element of abonos){

        var rw = tbl.insertRow();

            var cll6 = rw.insertCell();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();
            var cllpl = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            var cll7 = rw.insertCell();

            var input = document.createElement("input");

            input.setAttribute("type","checkbox");

            input.setAttribute("value",element.folio);
            input.setAttribute("id",element.importe);

            input.classList.add("serviciocheck");
            input.setAttribute("onchange", 'sumarServicios()');

 

            cll1.innerHTML = element.nombreestacion;


            var button = document.createElement("input");

            button.setAttribute("type","submit");

            button.setAttribute("id",element.folio);

            button.classList.add("Inactivo");

            button.setAttribute("onclick",'serVe('+element.folio+')');

            button.setAttribute("value","Cancelar");





            cll6.append(input);

            cll0.innerHTML = element.folio;

            cll2.innerHTML = element.tarjeta;

            cllpl.innerHTML = element.placas;

            cll3.innerHTML = formatDate(element.fecha);

            cll4.innerHTML = dosdecimales(element.litros);

            cll5.innerHTML = formatCant("$"+Number(element.importe).toFixed(2));

            cll7.append(button);

    }   

    });

}



function cancelarServicio(n){

    CancelarAct('mensajeCsesion');

    let toSend = new FormData();

        toSend.append("id","CancelarServicios");

        toSend.append("servicio",n);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

      

        if(data==1){

            mensajeRespuesta("Servicio #"+n+" Cancelado")

            filtrarservicios();

            listadesaldos();

            pagoapp();

        }else{

            mensajeError("Error al cancelar servicio")

        }

        

    })

}



function generateValidCard(bin, length) {

	//obtener ultima tarjeta guardada +1

    cardNumber = "";

    let toSend = new FormData();

        toSend.append("id","lastCardNumber"); 



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

    .then(response => response.text())

    .catch(error => alert(error))

    .then((data) =>{ 

        cardNumber = data.trim();

        document.getElementById("altatarjetas-notarjeta").value = parseInt(cardNumber) + 1;

    })

    /*var cardNumber = generate(bin, length),

		luhnValid  = luhnChk(cardNumber),

		limit      = 20,

		counter	   = 0;



	while (!luhnValid) {

		cardNumber = generate(bin, length);

		luhnValid  = luhnChk(cardNumber);

		counter++;

		

		if (counter === limit) {

			cardNumber = (luhnValid) ? cardNumber : 'cannot make valid card with given params'

			break;

		}

	}*/

	

	return cardNumber + 1;

}



function generate(bin, length) {

    var cardNumber = bin,

        randomNumberLength = length - (bin.length + 1);



    for (var i = 0; i < randomNumberLength; i++) {

        var digit = Math.floor((Math.random() * 9) + 0);

        cardNumber += digit;

    }



	//var checkDigit = getCheckDigit(cardNumber);



	cardNumber += String(cardNumber);

	if(bin!='1'){

        cardNumber = cardNumber.substring(0,16);

        byID("altatarjetas-notarjeta").value = cardNumber;

    }else{

        cardNumber = cardNumber.substring(8,12);

        return cardNumber;

    }

    

}



function getCheckDigit(number){

    var sum = 0,

        module,

        checkDigit;



    for (var i = 0; i < number.length; i++) {



        var digit = parseInt(number.substring(i, (i + 1)));



        if ((i % 2) == 0) {

            digit = digit * 2;

            if (digit > 9) {

                digit = (digit / 10) + (digit % 10);

            }

        }

        sum += digit;

    }



    module     = parseInt(sum) % 10;

    checkDigit = ((module === 0) ? 0 : 10 - module);

    

    return checkDigit;

}



/**

 * Luhn algorithm in JavaScript: validate credit card number supplied as string of numbers

 * @author ShirtlessKirk. Copyright (c) 2012.

 * @license WTFPL (http://www.wtfpl.net/txt/copying)

 */

var luhnChk = (function (arr) {

    return function (ccNum) {

        var 

            len = ccNum.length,

            bit = 1,

            sum = 0,

            val;



        while (len) {

            val = parseInt(ccNum.charAt(--len), 10);

            sum += (bit ^= 1) ? arr[val] : val;

        }



        return sum && sum % 10 === 0;

    };

}([0, 2, 4, 6, 8, 1, 3, 5, 7, 9]));



// Visual stuff

$('#generateCard').submit(function(e){

	var bin = $('#bin').val(),

		length = $('#length').val(),

		cardNumber = generateValidCard(bin,length);

	

	$('#displayCard').val(cardNumber);

	

	e.preventDefault();

})







function alta_grupo(){



    let nombre = byID("altagrupo-nombre").value;

    let direccion = byID("altagrupo-direccion").value;

    let rfc = byID("altagrupo-rfc").value;

    let toSend = new FormData();

    toSend.append("id","altagrupo");

    toSend.append(" nombre", nombre);

    toSend.append("direccion",direccion);

    toSend.append("rfc",rfc);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

        method: "POST",

        mode: "cors",

        body: toSend

    }).then(response => response.text())

    .catch(error => alert(error))

    .then((data)=>{

        if(data==1){

            mensajeRespuesta("Guardado correctamente")



            byID("altagrupo-nombre").value="";

            byID("altagrupo-direccion").value="";

            byID("altagrupo-rfc").value="";

            fillSelects_grupo();

        }else{mensajeError(data)}



    })



}



function cambioieps(){;

    let mieps = byID("magna_ieps").value;

    let pieps = byID("premium_ieps").value;

    let dieps = byID("diesel_ieps").value;

    let iva = byID("cambio_iva").value;

    let toSend = new FormData();

    toSend.append("id","cambioieps");

    toSend.append("mieps",mieps);

    toSend.append("pieps",pieps);

    toSend.append("dieps",dieps);

    toSend.append("iva",iva);

    //toSend.append("cte",cte);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend

        }).then(response =>response.text())

        .catch(error => alert(error))

        .then((data) =>{

            if(data == 1){

                mensajeRespuesta("Impuestos Actualizados");

                byID("magna_ieps").value="";

                byID("premium_ieps").value="";

                byID("diesel_ieps").value="";

                byID("cambio_iva").value="";

                leer_impuestos();

            }else{

                console.log(data)

                mensajeError("Error al guardar");

            }



            

        })





}



function leer_impuestos(){

    let mg = byID("eipsmagna");

    let pm = byID("eipspremium");

    let ds = byID("eipsdiesel");

    let iva = byID("eipsiva");



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getImpuestos", {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => {

       // console.log(data)

        for(element of data){

            mg.innerHTML = '$'+element.IEPSmagna;

            pm.innerHTML = '$'+element.IEPSpremium

            ds.innerHTML = '$'+element.IEPSdiesel;

            iva.innerHTML = '%'+element.IVA;

        }



    })

}



function cambioprecio(){

    let grupo = sessionStorage.getItem("sesionlog");

    grupo = JSON.parse(grupo)[3];

    let checks = document.getElementsByName("checkestacion");

    let fecha  = byID("fechacambio").value;

    let magna = byID("prod_magna").value;

    let premium = byID("prod_prem").value;

    let diesel = byID("prod_dies").value;

    let gas = byID("prod_gas").value;

    let estacion=[];

    let toSend =new FormData();

    for(element of checks){

        if(element.checked==true){

            estacion.push(element.id);

            toSend.append("estacion[]",element.id);

        }      

    } 

    if(fecha==""){

        return alert("Ingrese fecha valida");

    }

    if(magna==""||premium==""||diesel==""||gas==""){

        return alert("Ingrese precios validos");

    }

    if(estacion.length=0){

        return alert("Seleccione estacion");

    }

        

        toSend.append("id","cambioprecio");

        toSend.append("fecha",fecha);

        toSend.append("grupo",grupo);

        toSend.append("magna",magna);

        toSend.append("premium",premium);

        toSend.append("diesel",diesel); 

        console.log(estacion)

 

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        }).then(response =>response.text())

        .catch(error => alert(error))

        .then((data) =>{

            //console.log(data);

            if(data.trim() == "1"){

                mensajeRespuesta("Cambio realizado");

                byID("fechacambio").value="";

                byID("prod_magna").value="";

                byID("prod_prem").value="";

                byID("prod_dies").value="";

                byID("prod_gas").value="";

                checks = document.getElementsByName("checkestacion");

                for(element of checks){

                        element.checked=false;

                     

                }

            }else{mensajeError("Error en el cambio")}

        });

   



}



function checktodas(){

    let check = byID("estchecks-all");

    let checks = document.getElementsByName("checkestacion");

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


function SelTodosServicios(){
    let checks = document.getElementsByClassName("serviciocheck");
    
    for(let item of checks){
        console.log(item);
        item.checked =  true;
    }

    sumarServicios();

    
}



function Enviarservicios(){  

    //alert("siuu");

    var info = sessionStorage.getItem("servicioscte");

    info = JSON.parse(info);

    var servicioslista = [];

    var idcliente = byID("altatarjetas-idcte05").value;

    var checados = document.getElementsByClassName("serviciocheck");

    var fecha = new Date();

    fecha = fecha.toLocaleDateString();

    fecha = JSON.stringify(fecha);

    fecha = fecha.substring(1, 9);

    //console.log(fecha)

    fecha = fecha.split("/");

    let formatedDate = fecha[2] +"/"+ fecha[1] +"/"+ fecha[0];

    

    //console.log(formatedDate)





    let toSend = new FormData();

        toSend.append("id","generarFactura");
        toSend.append("periodoi",byID("fechaini1").value);
        toSend.append("periodof",byID("fechafin1").value);

  

        for(let item of checados){

            if(item.checked){

               //alert(item.value);

                toSend.append("folio[]",item.value);

            }

        } 

      

        toSend.append("idcliente",idcliente);

        toSend.append("fecha",formatedDate);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

        method: "POST",

        mode: "cors",

        body: toSend

        }).then(response =>response.json())

        .catch(error => alert(error))

        .then((data) =>{

            //console.log(data[0].res);

            if(data[0].res == "1"){
                mensajeRespuesta("Generado correctamente");
                filtrarservicios();

            }else{
                mensajeError("Error al generar");
            }

        });

        

}



function filtrarFacturas(){

    

    let tbl = byID("tbl-facturasEmitidas").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }



    let cte = document.getElementById("no_cliente2").value;

    let fini = document.getElementById("fechaini2").value;

    let ffin = document.getElementById("fechafin2").value;

    let toSend = new FormData();



        toSend.append("id","Filtrarfac");

        toSend.append("cte",cte);

        toSend.append("fini",fini);

        toSend.append("ffin",ffin);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data)=>{

       console.log(data)

    

        let facturas = data;

        tbl = byID("tbl-facturasEmitidas");

        for(element of facturas){

            let fecha = element.fechagenerado;

            

            if(!fecha){

                fecha="0000000";

            }

            fecha =fecha.slice(0,-9);

            let url = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/LACAJAMZT-F"+element.folio+"-"+fecha+".pdf";

            let factura = "https://monedero.grupopetromar.com/DocsClientes/"+element.rfc+"/LACAJAMZT-F"+element.folio+"-"+fecha+".xml";

            //console.log(url)

            var rw = tbl.insertRow();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            var cll6 = rw.insertCell();

            var input = document.createElement("input");

                input.setAttribute("type","submit");

                input.setAttribute("id",element.folio);

                input.setAttribute("name","bntPDFfac");

                // input.setAttribute("onClick","PDFfactura("+url+")");

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



                var button = document.createElement("input");

                button.setAttribute("type","submit");

                button.setAttribute("id",element.folio);

                button.classList.add("Inactivo");

                button.setAttribute("onclick",'facVe('+element.folio+')');

                button.setAttribute("value","Cancelar");





            cll0.innerHTML = element.folio;

            cll1.innerHTML = formatDate(element.fechagenerado);

            cll2.innerHTML = formatNumber(element.importe);

            cll3.innerHTML = dosdecimales(element.cantidad);

            cll4.append(input1);

            cll5.append(input);

            cll6.append(button);

        }



    })

}

function PDFfactura(a){

    //alert("hola")

    window.open(a)



}

function XMLfactura(a){

    window.open(a)

}



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

  data1;



if(d < 10){

  d = "0"+d;

};

if(m < 10){

  m = "0"+m;

};



data1 = y+"-"+m+"-"+d;

 // alert(data1);



    document.getElementById("fechafin").value = data1;

    document.getElementById("fechafin1").value = data1;

    document.getElementById("fechafinAb").value = data1;

    document.getElementById("fechafinCom").value = data1;

    document.getElementById("fechafin2").value = data1;

    document.getElementById("fechafin3").value = data1;

    document.getElementById("abonoctaD-fecha").value = data1;

    document.getElementById("fechapago").innerHTML = "Fecha: "+formatFecha(data1);

    document.getElementById("fechacambio").value = data1;

    document.getElementById("fechaPoliza").value = data1;

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

    document.getElementById("fechaini").value = data;

    document.getElementById("fechaini1").value = data;

    document.getElementById("fechainiAb").value = data;

    document.getElementById("fechaini2").value = data;

    document.getElementById("fechaini3").value = data;

    document.getElementById("fechainiCom").value = data;

}



function inicio(){

    if(document.getElementsByClassName("modulevisible")[0]){

        let visible = document.getElementsByClassName("modulevisible")[0];

        visible.style.display = "none";

        visible.classList.remove("modulevisible");

        visible.classList.add("modulehidden");

    }

}



function Buscarfacturacliente(){

    

        let tbl = byID("tbl-clientesfacturas").childNodes[1];

            let rows = tbl.getElementsByTagName("tr");

            rows = Array.from(rows);

            rows.shift();

            for(let elmt of rows){

                elmt.remove();

            }

            

            var input =byID("nom_cliente");

            var idcliente = byID("num_cliente").value;

            //selects_clientes(idcliente, input);

            let toSend = new FormData();

            toSend.append("id","obtenerFacturas");

            toSend.append("idcliente",idcliente);

    

            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

            method: "POST",

            mode: "cors",

            body: toSend

        })

        .then(response => response.json())

        .catch(error => alert(error))

        .then((data) =>{

            data = JSON.stringify(data);

            sessionStorage.setItem("facturacte", data); 

            data=JSON.parse(data);

            let abonos = data;

           //console.log(abonos);

        

            let tbl = byID("tbl-clientesfacturas"); 

            for( var element of abonos){

            var rw = tbl.insertRow();

                var cll6 = rw.insertCell();

                var cll0 = rw.insertCell();

                var cll1 = rw.insertCell();

                var cll2 = rw.insertCell();

                //var cll3 = rw.insertCell();

                var cll4 = rw.insertCell();

                var cll5 = rw.insertCell();

                var cll7 = rw.insertCell();

                var input = document.createElement("input");

                input.setAttribute("type","checkbox");

                input.setAttribute("value",element.folio);

                input.classList.add("facturascheck");





                var button = document.createElement("input");

                button.setAttribute("type","submit");

                button.setAttribute("id",element.folio);

                button.classList.add("Inactivo");

                button.setAttribute("onclick",'facVe('+element.folio+')');

                button.setAttribute("value","Cancelar");





                cll6.append(input);

                cll0.innerHTML = element.folio;

                cll1.innerHTML = formatDate(element.fechagenerado);

                cll2.innerHTML = formatCant("$"+element.importe);

                //cll3.innerHTML = element.restante;

                cll4.innerHTML = element.factura;

                cll5.innerHTML = dosdecimales(element.cantidad);

                cll7.append(button);

                

        }   

        });

}



function cancelarAbono(n){

    CancelarAct('mensajeCsesion');

    let toSend = new FormData();

            toSend.append("id","CancelarAbono");

            toSend.append("abono",n);

    

            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

            method: "POST",

            mode: "cors",

            body: toSend

        })

        .then(response => response.json())

        .catch(error => alert(error))

        .then((data) =>{



            if(data==1){

                mensajeRespuesta("Abono #"+n+" eliminado");

                filtrarAbono();

            }else{

                mensajeError("Error al eliminar abono")

            }

        })





}





function cancelarFactura(n){

    CancelarAct('mensajeCsesion');

    let toSend = new FormData();

            toSend.append("id","CancelarFacturas");

            toSend.append("factura",n);

    

            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

            method: "POST",

            mode: "cors",

            body: toSend

        })

        .then(response => response.json())

        .catch(error => alert(error))

        .then((data) =>{



            if(data==1){

                mensajeRespuesta("Factura #"+n+" Cancelada");

                Buscarfacturacliente();

                filtrarFacturas();

            }else{

                mensajeError("Error al cancelar factura")

            }

        })

}







function filtroRendimiento(){

    

    let tbl = byID("tbl-rendimiento").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

    let cte = document.getElementById("nom_cliente_r").value;

    let fechai = document.getElementById("fechaini").value;

    let fechaf = document.getElementById("fechafin").value;

        //console.log(tar);

    let toSend = new FormData();



    toSend.append("id","fRendimiento");

    toSend.append("fechai",fechai);

    toSend.append("fechaf",fechaf);

    toSend.append("cte",cte);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

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

                cll5.innerHTML = "PETROMAR SUC. SANTA FE";

            }

            if(element.estacion==2){

                cll5.innerHTML = "PETROMAR SUC. LEY DEL MAR";

            }

            if(element.estacion==3){

                cll5.innerHTML = "PETROMAR LIBRAMIENTO";

            }

            if(element.estacion==4){

                cll5.innerHTML = "PETROMAR SUC. MUNICH";

            }

            if(element.estacion==5){

                cll5.innerHTML = "PETROMAR INSURGENTES";

            }

            if(element.estacion==6){

                cll5.innerHTML = "PETROMAR LOPEZ SAENZ";

            }

            if(element.estacion==7){

                cll5.innerHTML = "RIO PRESIDIO";

            }

            





            

            cll0.innerHTML = formatFecha(element.fecha);

            cll1.innerHTML = element.notarjeta;

            cll2.innerHTML = element.placas;

            cll3.innerHTML = element.noeconomico;

            cll4.innerHTML = formatNumber(element.importe);

            cll6.innerHTML = element.nombre;

            cll7.innerHTML = dosdecimales(element.litros);

            cll8.innerHTML = element.nombrep;

            cll9.innerHTML = resultado+" km";

            cll10.innerHTML = rendi.toLocaleString()+" Km por litro";

        }



    })

    

}

function dosdecimales(litros){

    litros = litros.split(".");

    console.log(litros)

    if(litros[1]){

        let decimales =litros[1]

        console.log(decimales)

        decimales=decimales.substring(0, 2);

        let formatedlitros = litros[0] +"."+ decimales;

        return(formatedlitros);

    }else{

        return(litros);

    }

    

}



function FacturasEmitidas(){



    let tbl = byID("tbl-facturasEmitidas").childNodes[1];

    let rows = tbl.getElementsByTagName("tr");

    rows = Array.from(rows);

    rows.shift();

    for(let elmt of rows){

        elmt.remove();

    }

    

    var input =byID("nom_clientef");

    var idcliente = byID("nu_idcliente").value;

    selects_clientes(idcliente, input);

    let toSend = new FormData();

    toSend.append("id","obtenerFacturasSinrestante");

    toSend.append("idcliente",idcliente);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

    method: "POST",

    mode: "cors",

    body: toSend

})

.then(response => response.json())

.catch(error => alert(error))

.then((data) =>{

    data = JSON.stringify(data);

    sessionStorage.setItem("facturaSinres", data); 

    data=JSON.parse(data);

    let abonos = data;

   //console.log(abonos);



    let tbl = byID("tbl-facturasEmitidas"); 

    for( var element of abonos){

    var rw = tbl.insertRow();

       // var cll6 = rw.insertCell();

        var cll0 = rw.insertCell();

        var cll1 = rw.insertCell();

        var cll2 = rw.insertCell();

        var cll3 = rw.insertCell();

       

      /*  var input = document.createElement("input");  AGREGA UN CHECKBOX A CADA FILA PARA SER SELECCIONADA

        input.setAttribute("type","checkbox");

        input.setAttribute("value",element.folio);

        input.classList.add("serviciocheck");

        cll6.append(input);*/

        cll0.innerHTML = element.folio;

        cll1.innerHTML = element.fechagenerado;

        cll2.innerHTML = element.importe;

        cll3.innerHTML = element.factura;

        

        

}   

});

}





let inputimporte = byID("pago_precio");

let inputlitros = byID("pago_litro");

document.getElementById("pago_precio").addEventListener('keyup',(event)=>{

   

    let litros = byID("pago_litro").value;

    let importe = event.target.value;

    if(litros==""||litros==null){

        litros=0;

    }else{

        let r =litros * importe;

        document.getElementById("pago_importe").value=r;

    }

    

});

inputlitros.addEventListener('keyup', (event)=>{

    let importe = byID("pago_precio").value;

    let litros = event.target.value;

    if(importe==""||importe==null){

        importe=0;

    }else{

        let r =litros*importe;

        document.getElementById("pago_importe").value=r; 

    }

       

});



function CargoCliente(){

    let choferes = byID("pago_chofer");

        let rows = choferes.getElementsByTagName("option");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

    let a =byID("pago_cliente").value

    byID("pago_tarjeta").value = "";

    byID("pago_nip").value = "";

    byID("pago_chofer").value = "";

    byID("pago_importe").value = "";

    //byID("pago_litro").value = "";

    //byID("pago_precio").value = "";



    let placa = byID("pago_placas").value

    let toSend = new FormData();



    toSend.append("id","Cargos");

    toSend.append("placa",placa);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

                     method: "POST",

                     mode: "cors",

                     body: toSend

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        console.log(data)

                        byID("pago_tarjeta").value = data[0].notarjeta; 
                        byID("pago_KM").value = data[0].odometro; 

                        data=JSON.stringify(data);

                        sessionStorage.setItem("t",data)

                     })

                     

                    slc_chofer(a,placa);

}







function addservicio(){

    //leer_Choferes();

    let servicio = 1;

    let folio = sessionStorage.getItem("t");

    folio=JSON.parse(folio);

    let tarjeta=folio[0].notarjeta;

    let cliente=byID("pago_cliente").value;

    let km = byID("pago_KM").value;

    let importe= byID("pago_importe").value;

    let producto = byID("pago_prod").value;

    let estacion = byID("pago_estacion").value;

    let chofer = byID("pago_chofer").value;

    let litros = 0;

    let precio = 0;

    /*if(folio[0].activo ==0||folio[0].choferactivo==0){

        return mensajeError("ERROR Conductor y vehiculo deben estar activos")

    }*/

      
    //console.log(tarjeta);
    if(producto==""||estacion=="" || importe==""||chofer==""||tarjeta==""||tarjeta=="null"||tarjeta==null){

        return mensajeError("Complete todos los campos");

    }else{

    

    let toSend = new FormData();



    toSend.append("id","serviciomanual");

    toSend.append("tarjeta",tarjeta);

    toSend.append("cliente",cliente);

    toSend.append("estacion",estacion);

    toSend.append("importe",importe);

    toSend.append("producto",producto);

    toSend.append("litros",litros);

    toSend.append("precio",precio);

    toSend.append("servicio",servicio);

    toSend.append("chofer",chofer);

    toSend.append("km",km);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) =>{

        if(data[0].respuesta == "1"){

            mensajeRespuesta("Servicio realizado");

            pagosrestantes();

            listadesaldos();

            byID("pago_cliente").value="";

            byID("pago_KM").value="";

            byID("pago_importe").value="";

            byID("pago_prod").value="";

            byID("pago_estacion").value="";

            byID("pago_placas").value="";

            byID("pago_chofer").value="";

            byID("pago_tarjeta").value="";

            byID("pago_nip").value="";

            byID("pago_disp").value="";

            let toSend1 = new FormData();

            toSend1.append("cliente",cliente);

            fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/servicioscorreo.php/",{

            method: "POST",

            mode: "cors",

            body: toSend1

            })

            .then(response => response.json())

            .catch(error => console.log(error))

            .then((data) =>{

                console.log(data);

            })



        }else{

            mensajeError(data)

        }

    })

}

}



function ComplementoG(folio, nombrecomplemento,UUID){

    let toSend= new FormData();

        toSend.append("id","GuardarComplemento");

        toSend.append("folio",folio);

        toSend.append("nombre",nombrecomplemento);

        toSend.append("uuid",UUID);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.text())

    .catch(error => console.log(error))

    .then((data) =>{

        if(data.trim()==1){

           //console.log("#REALIZADÓ")

            pagoapp();

        }else{

           // console.log("#NOREALIZADÓ")

        }



    })

}



function EnviarComplemento(folio){

    //timbrar complementos de pago  

    let cte = byID("cliente_app_pago").value;

    let a =byID("idbutton"+folio+"C").value;

    if(a=="Generado"){

        return alert("El Documento ya fue generado")

    }



    let checked = document.getElementsByClassName("facturascheck");

    let toSend = new FormData();



    toSend.append("foliopagoaplicacion", folio);

   



    fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/facturacioncomplementos.php", {

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

      //console.log(data)

        if(data[0].respuesta == 1){

            mensajeRespuesta("Proceso de timbrado de complemento completado correctamente"); //PONER DIV DE MENSAJE POP UP

            var nombrecomplemento = document.getElementById('nombrecomplemento');

            var nombre = document.getElementById('nombrec');

            var formcomplemento = document.getElementById('formcomplemento'); //CHECAR SI PODEMOS QUITAR EL FORM CON UN FETCH}

            nombrecomplemento.value = data[0].factura;

            byID("idbutton"+folio+"C").value = "Generado";

            byID("idbutton"+folio+"C").setAttribute("Class","generado");

            nombre.value = data[0].nombre;

            var U = data[0].Xml;

            formcomplemento.submit();

            ComplementoG(folio, nombre.value,U);

            let nombreCom= nombre.value;



            let toSend1 = new FormData();



            toSend1.append("folio", folio);

            toSend1.append("cte", cte);

            toSend1.append("complemento", nombreCom);

   



            fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/complementoscorreo.php", {

                method: "POST",

                mode: "cors",

                body: toSend1

            })

            .then(response => response.json())

            .catch(error => alert(error))

            .then((data) =>{

                //console.log(data)

            })



        } else {

            mensajeError("Problema en el proceso de facturación");

        }

    })

}

function EnviarFacturas(){

    let udu = [];

    let checked = document.getElementsByClassName("facturascheck");

    let toSend = new FormData();



    



    for (let item of checked){

        if(item.checked){

            udu.push(item.value);

            toSend.append("idFacturas[]", item.value);

            //console.log(item.value)

        }

    }

    if(udu.length>=2){

       

        return mensajeError("Seleccione una sola factura")

    }



    fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/facturacion.php", {

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

      

        if(data[0].respuesta == "1"){

            Buscarfacturacliente();

            mensajeRespuesta("Proceso de facturación completado correctamente"); //PONER DIV DE MENSAJE POP UP

            var nombrefactura = document.getElementById('nombrefactura');

            var nombre = document.getElementById('nombref');

            var formfactura = document.getElementById('formfactura'); //CHECAR SI PODEMOS QUITAR EL FORM CON UN FETCH

            nombrefactura.value = data[0].factura;

            nombre.value = data[0].nombre;

            formfactura.submit();

            

        } else {

            mensajeError("Problema en el proceso de facturación");

        }

    })

}



function leer_tarjetaUsuarios(idcte){ 
    let cte = idcte; 
    

    leer_ProdyEsta(cte);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getTarjetasCliente&cte="+cte, {

                     method: "GET",

                     mode: "cors",

                        })

                    .then(response => response.json())

                    .catch(error => console.log(error))

                    .then((data) => {

                        data=JSON.stringify(data);

                        sessionStorage.setItem("tCliente",data)

                        fillSelects_TarjetasC();

                    });



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getVehiculosCliente&cte="+cte, {

                        method: "GET",

                        mode: "cors",

                           })

                       .then(response => response.json())

                       .catch(error => console.log(error))

                       .then((data) => {

                           data=JSON.stringify(data);

                           //console.log("vCliente")

                           //console.log(data)

                           sessionStorage.setItem("vCliente",data)

                       });



}

function leer_prodRel(){

    let cte =byID("altatarjetas-idcte15").value;

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getProductoR&cte="+cte, {

        method: "GET",

        mode: "cors",

    })

    .then(response => response.json())  

    .catch(error => console.log(error))

    .then((data) => {

        data=JSON.stringify(data);

        //console.log("prodrel")

        //console.log(data);  

        sessionStorage.setItem("ProdRel", data);



        

        

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

function leer_ProdyEsta(a){ 

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getProd&cte="+a,{

        method: "GET",

        modo: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => { 

        data= JSON.stringify(data);

        sessionStorage.setItem("prod",data);

       

        //console.log(data);

        

    });



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getEsta&cte="+a,{

        method: "GET",

        modo: "cors",

    })

    .then(response => response.json())

    .catch(error => console.log(error))

    .then((data) => { 

        data= JSON.stringify(data);

        sessionStorage.setItem("esta",data);

       

        //console.log(data);

        

    });





    

}



function checktodas21(){

    let check = byID("estchecks-all21");

    let checks = document.getElementsByName("listadeestacionesconcheck1");

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



function checktodoscom(){

    let check = byID("comchecks-all21");

    let checks = document.getElementsByName("listadecombustibles");

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





    let check1 = byID("comchecks-all1");

    let checks1 = document.getElementsByName("listadecombustibles2");

    if(check1.checked==true){

        for(element of checks1){

            element.checked = true;

        }

    }

    if(check1.checked==false){

        for(element of checks1){

            element.checked = false;

        }

    }



    

}



function fillSelects_Placas(){

    var selects2 = document.getElementById("altatarjetas-notarjeta1");

    var selects = document.getElementById("sltarjetas-placas1");

    var selects3 = document.getElementById("altatarjetas-tipo1");

    var selects4 = document.getElementById("altatarjetas-placas1");

    let estaciones = document.getElementsByName("listadeestacionesconcheck1");

    let combustibles = document.getElementsByName("listadecombustibles");

    

    var checkday1 = document.getElementById("daycheck-11");

    var checkday2 = document.getElementById("daycheck-21");

    var checkday3 = document.getElementById("daycheck-31");

    var checkday4 = document.getElementById("daycheck-41");

    var checkday5 = document.getElementById("daycheck-51");

    var checkday6 = document.getElementById("daycheck-61");

    var checkday7 = document.getElementById("daycheck-71");

    var fechaini = document.getElementById("daytime-ini1");

    var fechafin = document.getElementById("daytime-fin1");

    var litros = document.getElementById("limite-cant1");

    var dinero = document.getElementById("limite-din1");

    var periodo = document.getElementById("limite-periodo1");

    var tipo = document.getElementById("limite-tipo1");

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

    if(selects2.value==""){

    checkday1.checked=false;

    checkday2.checked=false;

    checkday3.checked=false;

    checkday4.checked=false;

    checkday5.checked=false;

    checkday6.checked=false;

    checkday7.checked=false;

    byID("altatarjetas-placas1").value="";

    byID("daytime-ini1").value="";

    byID("daytime-fin1").value="";

    byID("limite-cant1").value="";

    byID("limite-periodo1").value="1";

    byID("limite-tipo1").value="";

    }else{

        leer_prodRel();

        // for (const item of selects) {

             selectPlacas(selects, selects2, selects3, selects4, estaciones, checkday1, checkday2, 

                 checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo, tipo, combustibles);

        // }

    }



    

    

}



function selectPlacas(selects, selects2, selects3, selects4, estaciones, checkday1, checkday2, 

    checkday3, checkday4, checkday5, checkday6, checkday7, fechaini, fechafin, litros, dinero, periodo, tipo, combustibles){ 

        //console.log("=^_^=")

       let tarjeta1 = byID("altatarjetas-notarjeta1").value;

      // console.log(tarjeta1)

       

       



        var ProdRel = sessionStorage.getItem("ProdRel");

        ProdRel = JSON.parse(ProdRel);





        for(element of ProdRel){

            if(element.folio==tarjeta1){

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







    var placas = sessionStorage.getItem("vCliente");

    placas = JSON.parse(placas);

    var tarjeta = sessionStorage.getItem("tCliente");

    tarjeta = JSON.parse(tarjeta);

    for (let element of placas) { 

        if(element.idtarjeta==selects2.value){

            selects4.value = element.placas;

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

            periodo.value="";

            selects2.value="";

            byID("altatarjetas-placas").value="";

            byID("daytime-ini").value="";

            byID("daytime-fin").value="";

            byID("limite-cant").value="";

            byID("limite-din").value="";

        }

    } 

    for( let tar of tarjeta){

        if(selects2.value==tar.folio){  

            fechaini.value= tar.horarioinicial;  

            fechafin.value= tar.horariofinal;

            //console.log(tar.tipolimite);

            if(tar.tipolimite==1){

                tipo.value = "1" ;

                litros.value= tar.limitelitros;

            }else{ tipo.value = "2";

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

            if(tar.tipoperiodo=="4"){

                periodo.value = 4 ;

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

        

    }



    function UpDateTarjetas(){

        var tarjeta = document.getElementById("altatarjetas-notarjeta1").value;

        let estacion= document.getElementsByName("listadeestacionesconcheck1");

        var combustible = document.getElementsByName("listadecombustibles");

        var horaiodia = document.getElementsByName("tarjetas-daycheck1");

        var horaio = document.getElementsByName("tarjetas-daytime1");

        let arregloEstacion = [].slice.call(estacion);

        let arreglocombustible = [].slice.call(combustible);

        let arreglohd = [].slice.call(horaiodia);

        let e=0;

        let c=0;

        let hd=0;

        var cantidadlimite = byID("limite-cant1").value;

        var limitecantidad = 0;

        var limitedinero = 0;

        var limitetipo=byID("limite-tipo1").value;

        var limiteperiodo = byID("limite-periodo1").value;

        console.log(arreglohd)

        let toSend = new FormData();

        arregloEstacion.forEach((est) => {

            

            if(est.checked){

               // console.log(est.value)

               e+=

                toSend.append('estacion[]', est.value);

            }

        });

    

        arreglocombustible.forEach((com) => {

            

            if(com.checked){

                console.log(com.value)

                c+=

                toSend.append('combustible[]', com.value);

            }

        });

        arreglohd.forEach((est) => {

            

            if(est.checked){

                console.log(est.value)

               hd+= 

               console.log();

            }

        });

        if(limitetipo==1){

            limitecantidad = cantidadlimite;

            limitedinero =0;

        }else{

            limitedinero = cantidadlimite;

            limitecantidad = 0;

        }

    

    

        //console.log(arregloEstacion instanceof Array);

        if(tarjeta==""||tarjeta==null){

            return alert("Seleccione una tarjeta");

        }

        if(e==0){

            return alert("Ninguna estación fue seleccionada")

        }

        if(c==0){

            return alert("Ningun combustible fue seleccionado")

        }

        if(hd==0){

            return alert("Ningun día fue seleccionado")

        }

        if(horaio[0].value==null||horaio[0].value==""||horaio[1].value==null||horaio[1].value==""){

            return alert("Ingrese un horario valido")

        }

        if(cantidadlimite=="0"||cantidadlimite==null||cantidadlimite==""){return mensajeError("Ingrese una cantidad limite")}

        

    

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

    

            toSend.append('limiteC', limitecantidad);

            toSend.append('limiteD', limitedinero);

            toSend.append('limiteP', limiteperiodo);

            toSend.append('limitetipo', limitetipo);

            //console.log(toSend)

        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {

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

            leer_prodRel();

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

            combustible[3].checked=false;

            horaiodia[0].checked=false;

            horaiodia[1].checked=false;

            horaiodia[2].checked=false;

            horaiodia[3].checked=false;

            horaiodia[4].checked=false;

            horaiodia[5].checked=false;

            horaiodia[6].checked=false;

            horaio[0].value="";

            horaio[1].value="";

            document.getElementById("limite-cant1").value="";

            document.getElementById("limite-periodo1").value="1";

            document.getElementById("altatarjetas-placas1").value="";

            document.getElementById("altatarjetas-notarjeta1").value="";

            leer_tarjetaUsuarios();

            fillSelects_Placas()

           }else{

               //mensajeError("ERROR AL GUARDAR");

               console.log(data)

            }

            

        

        }); 

        

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

function mensajeRespuesta1(res){

    let mensaje = document.createElement("div");

    mensaje.setAttribute("id","mensajeRes1");

    mensaje.classList.add("alerta");

    let lbl = document.createElement("label");

    lbl.innerHTML= res;

    mensaje.append(lbl);

    let br = document.createElement("br");

        mensaje.append(br);

    let btnAcep = document.createElement("input");

    btnAcep.setAttribute("type","submit");

    btnAcep.setAttribute("onclick","PdfDownloadchonip('ChoferNip')");

    btnAcep.setAttribute("Value","Aceptar");

    btnAcep.classList.add("Activo");

    mensaje.append(btnAcep);

    let btncancelar = document.createElement("input");

    btncancelar.setAttribute("type","submit");

    btncancelar.setAttribute("Value","Cancelar");

    btncancelar.setAttribute("onclick","cerraralerta('mensajeRes1')");

    btncancelar.classList.add("Inactivo");

    mensaje.append(btncancelar);

    document.getElementsByTagName("body")[0].append(mensaje); 



}



function cerraralerta(id){

    let div = byID(id);

    div.remove();

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



function activarbtn(i){

    if(document.getElementById(i).value=='Activo'){

        document.getElementById(i).value="Inactivo";

        document.getElementById(i).classList='Inactivo';

        

    }else{

        document.getElementById(i).value="Activo";

        document.getElementById(i).classList='Activo';

    }

    let btn = byID(i);

    let activo;

    let iduser;

    let toSend = new FormData();

    if(btn.value=="Activo"){

        activo="1";

        iduser = btn.id;

    }else{

        activo="0";

        iduser = btn.id;

    }



    toSend.append("id","actualizarUsuarioWeb");

    toSend.append("activo",activo);

    toSend.append("iduser",iduser);

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

     method: "POST",

     mode: "cors",

     body: toSend

     })

     .then(response => response.json())

     .catch(error => alert(error))

     .then((data) =>{

        //console.log(data)

      if(data=="1"){

         mensajeRespuesta("Guardado Correctamente")

         leer_UsuariosWeb();

      }else{

          

         mensajeError("Error")

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

    var btn = byID(i);

    let activo;

    let iduser = btn.id;

    let toSend = new FormData();

        

       if(btn.value=="Activo"){

           activo = "1";

          

       }else{

            activo = "0";

           

       }

       //console.log(activo,iduser)

       

       toSend.append("id","actualizarUsuario");

       toSend.append("activo",activo);

       toSend.append("iduser",iduser);

       fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

        .then(response => response.json())

        .catch(error => alert(error))

        .then((data) =>{

        //console.log(data)

         if(data=="1"){

            mensajeRespuesta("Guardado Correctamente")

            leer_Usuarios();

         }else{

            mensajeError("Error")

         };

     })







}



function activarbtn2(i,a){

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

       

       toSend.append("id","actualizarChofer");

       toSend.append("activo",activo);

       toSend.append("iduser",iduser);

       fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

        .then(response => response.text())

        .catch(error => alert(error))

        .then((data) =>{

            //console.log(data)

         if(data==1){

            leer_Choferes(a);

            mensajeRespuesta("Guardado Correctamente");

            

         }else{

            mensajeError("Error");

         };

     })

 







}





/*function activarbtn2(i){

    if(document.getElementById(i).value=='Activo'){

        document.getElementById(i).value="Inactivo";

        document.getElementById(i).classList='Inactivo';

        

    }else{

        document.getElementById(i).value="Activo";

        document.getElementById(i).classList='Activo';

    }

}*/

function activarbtn3(i){

    if(document.getElementById(i).value=='Activo'){

        document.getElementById(i).value="Inactivo";

        document.getElementById(i).classList='Inactivo';

        

    }else{

        document.getElementById(i).value="Activo";

        document.getElementById(i).classList='Activo';

    }



    let activo;

    let valor;

    let btn = byID(i);

    let toSend = new FormData();

    

        if(btn.value=="Activo"){

            activo = "1";

            valor = btn.id;

        }else{

             activo = "0";

             valor = btn.id;

        }

        

        toSend.append("id","actualizarEstadoVehiculo");

        toSend.append("activo",activo);

        toSend.append("valor",valor);

    



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

         method: "POST",

         mode: "cors",

         body: toSend

         })

        .then(response => response.json())

        .catch(error => alert(error))

        .then((data) =>{

          //console.log(data)

             if(data=="1"){

            mensajeRespuesta("Guardado Correctamente")

            leer_Vehiculos();

            }else{

            mensajeError("Error")

         };



     })



}

function activarbtn4(i){

    let toSend = new FormData();

    toSend.append("id","RRU");

    toSend.append("tarjeta",i);



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

        method: "POST",

        mode: "cors",

        body: toSend

        })

        .then(response => response.json())

    .catch(error => alert(error))

    .then((data) =>{

        console.log(data)

        let rfc = data[0];

        rfc = rfc.rfc;

        let rzonsocial = data[0];

        rzonsocial = rzonsocial.rzonsocial;

        

        

        

        let mensaje = document.createElement("div");

        mensaje.setAttribute("id","mensajeActivar");

        mensaje.classList.add("alerta3");

        let lbl = document.createElement("label");

        lbl.innerHTML= "¿Desea continuar?";

        mensaje.append(lbl);

        let hr = document.createElement("hr");

        mensaje.append(hr); 

        let hr1 = document.createElement("hr");

        mensaje.append(hr1); 

        let br = document.createElement("br");

        let br1 = document.createElement("br");

        let br2 = document.createElement("br");

        let br3 = document.createElement("br");

        mensaje.append(br); 

        let lbl1 = document.createElement("label");

        lbl1.innerHTML= "RFC: "+rfc;

        mensaje.append(lbl1);

        mensaje.append(br1);

        let lbl2 = document.createElement("label");

        lbl2.innerHTML= "Razón: "+rzonsocial;

        mensaje.append(lbl2);

        mensaje.append(br2);

        if(data[1]){

            let fecha = data[1];   

            fecha = fecha.fecha;

            fecha = formatDate(fecha);

            let lbl3 = document.createElement("label");

            lbl3.innerHTML= "Fecha: "+fecha;

            mensaje.append(lbl3);

            mensaje.append(br3);

        }else{

            let fecha = "Sin ultima fecha"; 

            fecha = "Sin ultima fecha"; 

            let lbl3 = document.createElement("label");

            lbl3.innerHTML= "Fecha: "+fecha;

            mensaje.append(lbl3);

            mensaje.append(br3);

        }

        

        let btna = document.createElement("input");

        btna.setAttribute("type","submit");

        btna.setAttribute("id","btnaceptar");

        btna.setAttribute("name","bntAD2");

        btna.setAttribute("onClick",'activarbtn41('+i+')');

        btna.setAttribute("class",'Activo1');

        btna.setAttribute("value","Aceptar");

        

        let btnc = document.createElement("input");

        btnc.setAttribute("type","submit");

        btnc.setAttribute("id","btncancelar");

        btnc.setAttribute("name","bntAD1");

        btnc.setAttribute("onClick","CancelarAct('mensajeActivar')");

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





    });



    



}



function activarbtn41(i){

    let mensaje = byID('mensajeActivar');

    mensaje.remove();

    if(document.getElementById(i).value=='Activo'){

        document.getElementById(i).value="Inactivo";

        document.getElementById(i).classList='Inactivo';

        

    }else{

        document.getElementById(i).value="Activo";

        document.getElementById(i).classList='Activo';

    }



    let activo;

    let valor;

    var btn = byID(i);

    let toSend = new FormData();



        if(btn.value=="Activo"){

            activo = "1";

            valor = btn.id;

        }else{

             activo = "0";

             valor = btn.id;

        }

        

        toSend.append("id","actualizarEstadoTarjeta");

        toSend.append("activo",activo);

        toSend.append("valor",valor); 



        fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {    

         method: "POST",

         mode: "cors",

         body: toSend

         })

         .then(response => response.json())

      .catch(error => alert(error))

      .then((data) =>{

          //console.log(data);

          if(data=="1"){

             mensajeRespuesta("Guardado Correctamente")

             leer_Tarjetas("1");

            }else{

             mensajeRespuesta("Error")

          };

      })

   





}

function CancelarAct(i){

 let mensaje = byID(i);

 mensaje.remove();

}



 /////////////////////////   Exportar tablas a PDF  /////////////////////////////////////////////

 function PdfDownload(filename){

    kendo.drawing.drawDOM($("#tbl-usuariosweb-1"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

                   }

               }

           );

    })

    .done(function(data){

       kendo.saveAs({

           dataURI:data,

           fileName:filename

       })

    }).then(function(){
  
     //   alert("terminado");

 });

}



function PdfDownloadcli(filename){

    

    kendo.drawing.drawDOM($("#listadeclientes"))

    .then(function(group){

            

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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



function PdfDownloadusu(filename){

    kendo.drawing.drawDOM($("#listausuarios"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

function PdfDownloadchonip(filename){

    cerraralerta('mensajeRes1');

    let div=byID("t-choferNip");

    div.style.display='block';

    kendo.drawing.drawDOM($("#t-choferNip"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

    div.style.display='none';

    

}

function PdfDownloadcho(filename){

    kendo.drawing.drawDOM($("#t-chofer"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

function PdfDownloadve(filename){

    kendo.drawing.drawDOM($("#t-vehiculos"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

function PdfDownloadPol(filename){

    kendo.drawing.drawDOM($("#tbl-polizaT"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

function PdfDownloadSal(filename){

    kendo.drawing.drawDOM($("#tbl-SaldosT"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

function PdfDownloadtar(filename){

    kendo.drawing.drawDOM($("#t-tarjetas"))

    .then(function(group){

           return kendo.drawing.exportPDF(

               group,{

                   paperSize:"auto",

                   margin:{

                       left:"1.5cm",

                       right:"1cm",

                       top: "1.5cm",

                       bottom:"2cm"

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

//////////////////////////////////////////////////////////////////////////////////

///////////////////////////////Exportar Excel///////////////////////////////////// 



function excelExport(){



 

        $("#tbl-clientes").table2excel({

             name: "Clientes",

            filename: "Clientes",

            sheetname: "Clientes", //do not include extension

            fileext: ".xls" // file extension

        });  

}



function excelExportusuariosweb(){



 

    $("#tbl-usuariosweb").table2excel({

         name: "Usuarios web",

        filename: "Usuarios web",

        sheetname: "Usuarios web", //do not include extension

        fileext: ".xls" // file extension

    });  

}



function excelExportusuarios(){



 

    $("#tbl-usuarios").table2excel({

         name: "Usuarios",

        filename: "Usuarios",

        sheetname: "Usuarios", //do not include extension

        fileext: ".xls" // file extension

    });  

}



function excelExportchoferes(){



 

    $("#tbl-choferes").table2excel({

         name: "Choferes",

        filename: "Choferes",

        sheetname: "Choferes", //do not include extension

        fileext: ".xls" // file extension

    });  

}



function excelExportvehiculos(){



 

    $("#tbl-vehiculos").table2excel({

         name: "Vehiculos",

        filename: "Vehiculos",

        sheetname: "Vehiculos", //do not include extension

        fileext: ".xls" // file extension

    });  

}



function excelExporttarjetas(){



 

    $("#tbl-tarjetaszz").table2excel({

         name: "Tarjetas",

        filename: "Tarjetas",

        sheetname: "Tarjetas", //do not include extension

        fileext: ".xls" // file extension

    });  

}









///////////////////////////'''''''''''''''''''''''//////////////////////////////////



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

function formatDate(date){

    let index = date.search(" ");

    date = date.substring(0, index);

    date = date.split("-");

    let formatedDate = date[2] +"/"+ date[1] +"/"+ date[0];

    return(formatedDate);

}





function formatFecha1(date){

    //let index = date.search(" ");

    date = date.substring(0, 10);

    date = date.split("-");

    let formatedDate = date[2] +"/"+ date[1] +"/"+ date[0];

    return(formatedDate);

}







function formatFecha(date){

    //let index = date.search(" ");

    date = date.substring(0, 10);

    date = date.split("-");

    if(date[1]==01){

        date[1]="Enero";

    }

    if(date[1]==02){

        date[1]="Febrero";

    }

    if(date[1]==03){

        date[1]="Marzo";

    }

    if(date[1]==04){

        date[1]="Abril";

    }

    if(date[1]==05){

        date[1]="Mayo";

    }

    if(date[1]==06){

        date[1]="Junio";

    }

    if(date[1]==07){

        date[1]="Julio";

    }

    if(date[1]==08){

        date[1]="Agosto";

    }

    if(date[1]==09){

        date[1]="Septiembre";

    }

    if(date[1]==10){

        date[1]="Octubre";

    }

    if(date[1]==11){

        date[1]="Noviembre";

    }

    if(date[1]==12){

        date[1]="Diciembre";

    }

    let formatedDate = date[2] +" / "+ date[1] +" / "+ date[0];

    return(formatedDate);

}



function formatFecha3(date){

    date = date.split(" ");

    let formatedDate = date[0];

    return(formatedDate);

}

function formatFecha2(date){

    //console.log(date)

    date = JSON.stringify(date);

    //console.log(date)

    //let index = date.search(" ");

    date = date.substring(1, 11);

    //console.log(date)

    date = date.split("-");

    let formatedDate = date[2] +"/"+ date[1] +"/"+ date[0];

    return(formatedDate);

}

function formatNumber(importe){

	   

    return ((Number(importe)).toLocaleString('en-US', {

      style: 'currency',

      currency: 'USD',}));

 }

    



function pagoapp(){



    let tbl = byID("tbl-pagorapp").childNodes[1];

        let rows = tbl.getElementsByTagName("tr");

        rows = Array.from(rows);

        rows.shift();

        for(let elmt of rows){

            elmt.remove();

        }

    let cte = byID("cliente_app_pago").value;

    let fini = byID("fechaini3").value;

    let ffin = byID("fechafin3").value;

    let toSend = new FormData();



    toSend.append("id","pagosapp");

    toSend.append("cte",cte);

    toSend.append("fini",fini);

    toSend.append("ffin",ffin);



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

        method: "POST",

        mode: "cors",

        body: toSend

    })

    .then(response => response.json())

    .catch(error => alert(error))

    .then((data)=>{

        let info = data;

        //console.log(info)

        let rest_app=0;

        

        let tbl=byID("tbl-pagorapp");

    for( var element of info){

        //rest_app = Number(element.importe_app) + Number(element.abono_app);

        if(element.periododepago==7){

            element.fechacaptura = new Date(element.fechacaptura);

            element.fechacaptura.setDate(element.fechacaptura.getDate() + 6);

        }

        if(element.periododepago==15){

            element.fechacaptura = new Date(element.fechacaptura);

            element.fechacaptura.setDate(element.fechacaptura.getDate() + 14);

        }

        if(element.periododepago==30){

            element.fechacaptura = new Date(element.fechacaptura);

            element.fechacaptura.setDate(element.fechacaptura.getDate() + 29);

        }

        if(element.formapago==1){

            element.formapago= "Transferencia"

        }

        if(element.formapago==2){

            element.formapago= "Efectivo"

        }

        if(element.formapago==3){

            element.formapago= "Cheque"

        }

        if(element.formapago==4){

            element.formapago= "Tarjeta Débito"

        }

        if(element.formapago==5){

            element.formapago= "Tarjeta Crédito"

        }

            var rw = tbl.insertRow();

            var cll0 = rw.insertCell();

            var cll1 = rw.insertCell();

            var cll2 = rw.insertCell();

            var cll3 = rw.insertCell();

            var cll4 = rw.insertCell();

            var cll5 = rw.insertCell();

            var cll6 = rw.insertCell();

            var cll7 = rw.insertCell();

            var cll9 = rw.insertCell();

            var cll10 = rw.insertCell();

            var cll11 = rw.insertCell();

            var cll12 = rw.insertCell();

            var cll13 = rw.insertCell();

            

            

            cll0.innerHTML = element.rzonsocial;

            cll1.innerHTML = "#"+element.folio_p;

            cll2.innerHTML = "#"+element.folio;

            cll3.innerHTML = formatNumber(element.importe);

            cll4.innerHTML = formatNumber(element.importe_app);

            cll5.innerHTML = element.formapago;

            cll6.innerHTML = formatFecha2(element.fechacaptura);

            if(element.tipocliente==0){

                cll7.innerHTML = "Contado";

                cll13.innerHTML="N/A";

                let tbl = byID("TPA");

                tbl.style.width = "1150px";

            }

            if(element.tipocliente==1){

                let tbl = byID("TPA");

                tbl.style.width = "1220px";

                cll7.innerHTML = "Crédito";

                var input = document.createElement("input");

            input.setAttribute("type","button");

            

            input.setAttribute("onClick","EnviarComplemento("+element.folio_p+")");

            input.classList.add("complementobtn");

            if(element.generado=="0"){

                input.setAttribute("Class","Activo");

                input.setAttribute("value","Generar");

                input.setAttribute("id","idbutton"+element.folio_p+"C");

            }else{

                input.setAttribute("Class","generado");

                input.setAttribute("value","Generado");

                input.setAttribute("id","idbutton"+element.folio_p+"C");

            }

            cll13.append(input);

            }

            

            cll9.innerHTML = element.referencia;

            cll10.innerHTML = formatFecha(element.fecha);

            cll11.innerHTML = formatNumber(element.abono_app);

            cll12.innerHTML = formatNumber(element.restanteabono);

            

            



    }

    })

}



function AddFacturaPorEstacion(){

    let estacion = byID("num_Estacion").value;

    let fechainicio = byID("inicio_Mes").value;

    let fechafin = byID("fin_Mes").value;

    

    if(fechainicio==""||fechafin==""){

        return alert("Ingrese fechas validas");

    }

    let fd = new FormData();

    fd.append("id","Addfacturaestacion")

    fd.append("estacion",estacion)

    fd.append("fechainicio",fechainicio)

    fd.append("fechafin",fechafin)

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php",{

        method: "POST",

        mode: "cors",

        body: fd

    })

    .then(response=>response.text())

    .catch(error=>alert(error))

    .then((data)=>{

        if(data.trim()=="1"){

            mensajeRespuesta("Factura generada");

            leer_facturaestacion();

        }else{

            mensajeError("Error al generar factura");

        }

    })

}   



function EnviarFacturasEstacion(){

    let Facturas = document.getElementsByName("checkFacEstacion");

    let fd = new FormData();

    Facturas.forEach(element=>{

        if(element.checked==true){

            fd.append("factura",element.value)

        }

    })

    

    

    fetch("https://monedero.grupopetromar.com/admin/apirest/sw-sdk-php/facturacionestacion.php",{

        method: "POST",

        mode: "cors",

        body: fd

    })

    .then(response=>response.json())

    .catch(error=>alert(error))

    .then((data)=>{

        //console.log(data);

       if(data[0].respuesta == "1"){

            mensajeRespuesta("Proceso de facturación completado correctamente"); //PONER DIV DE MENSAJE POP UP

            var factEstacion = document.getElementById('factEstacion');

            var nombrefactEstacion = document.getElementById('nombrefactEstacion');

            var formfactura = document.getElementById('formfacturaEstacion'); //CHECAR SI PODEMOS QUITAR EL FORM CON UN FETCH

            factEstacion.value = data[0].factura;

            nombrefactEstacion.value = data[0].nombre;

            formfactura.submit();

            leer_facturaestacion();

        } else {

            mensajeError("Problema en el proceso de facturación");

        }



    })



}



function leer_facturaestacion(){



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=getFaturaEstacion",{

        method: "GET",

        mode: "cors"

    })

    .then(response=>response.json())

    .catch(error=>alert(error))

    .then((data)=>{



        let tbl = byID("tbl-estacionfacturas");

            let rows = tbl.getElementsByTagName("tr");

            rows = Array.from(rows);

            rows.shift();

            for(element of rows){

                element.remove();

            }



        for(element of data){

            let rw = tbl.insertRow();

            let cll0 = rw.insertCell();

            let cll1 = rw.insertCell();

            let cll2 = rw.insertCell();

            let cll3 = rw.insertCell();

            let cll4 = rw.insertCell();

            let cll5 = rw.insertCell();

            let cll6 = rw.insertCell();



            var input = document.createElement("input");

                input.setAttribute("type","checkbox");

                input.setAttribute("value",element.folio);

                input.setAttribute("onchange","desmarcar("+element.folio+")");

                input.setAttribute("name","checkFacEstacion");



            let btn = document.createElement("input");

            btn.setAttribute("type","button");

            btn.setAttribute("id","FacEsta"+element.folio);

            btn.setAttribute("value","Cancelar");

            btn.setAttribute("Class","Inactivo");

            btn.setAttribute("onclick","CancelarFacEstacion("+element.folio+")");





            cll0.append(input);

            cll1.innerHTML=element.folio;

            cll2.innerHTML=formatDate(element.fechagenerado);

            cll3.innerHTML=element.importe;

            cll4.innerHTML=element.factura;

            cll5.innerHTML=element.cantidad;

            cll6.append(btn);







        }

        







    })



}



function desmarcar(folio){

let checks = document.getElementsByName("checkFacEstacion");



checks.forEach(element=>{



    if(element.value!=folio){

        element.checked=false;

    }



})





}







function CancelarFacEstacion(id){

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=cancelarFaturaEstacion&folio="+id,{

        method: "GET",

        mode: "cors"

    })

    .then(response=>response.text())

    .catch(error=>alert(error))

    .then((data)=>{

        if(data.trim()=="1"){

            mensajeRespuesta("Factura cancelada");

        }else{

            mensajeError("Error al actualizar")

        }



    })

}



function GenerarNip(){

    let nip=0;

        



    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/?id=GetChoferSinNip",{

        method: "GET",

        mode: "cors"

    })

    .then(response=>response.json())

    .catch(error=>alert(error))

    .then((data)=>{

        console.log(data);



        

        

            let fd = new FormData();

            fd.append("id","addNip")

            data.forEach((folio)=>{

                nip = Math.random();

                nip=JSON.stringify(nip);

                    nip = nip.substring("2","6");

            fd.append("folio[]",folio)

            fd.append("nip[]",nip)

           // alert(nip);

            })

            



            fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/",{

            method: "POST",

            mode: "cors",

            body: fd

            })

        .then(response=>response.json())

        .catch(error=>alert(error))

        .then((data1)=>{

            //console.log(data1);

            let tbl = byID("tbl-choferesNip");

            let rows = tbl.getElementsByTagName('tr')

            rows = Array.from(rows);

            rows.shift();

            for(element of rows){

                element.remove();

            }

            for(element of data1){

                let rw = tbl.insertRow();

            let cll0 = rw.insertCell();

            let cll1 = rw.insertCell();

            let cll2 = rw.insertCell();



            cll0.innerHTML=element.nombre;

            cll1.innerHTML=element.nip;

            cll2.innerHTML=element.cliente;

            }



            alert("Se generaron "+data1.length+" nip correctamente");

            mensajeRespuesta1("¿Desea imprimir el registro de nip?");

        })



        



    })

}



