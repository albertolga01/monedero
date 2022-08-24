var inputs = document.getElementsByClassName('logininput');
window.onload = function(){
    
    for(var i=0; i<inputs.length; i++){
        
        if(i == 0){
            inputs[i].focus();
        }
        inputs[i].addEventListener('keypress', enterTab);
    }
   // document.getElementById("button-login"),addEventListener("click", aceptar);
}

//document.getElementById("button-login").onclick=logIn();

///////////////Ejecutar funcion con el boton ENTER//////////////////////////
/*document.onkeydown=function(evt){
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if(keyCode == 13)
    {
        logincliente()
    }
}*/
////////////////////////////////////////////////////////////////////////////
////////Pasar al siguiente input del formulario al presionar ENTER//////////
function enterTab(e){

    /// se carga el valor del codigo de la tecla presionada///
    var keyCode = e.keyCode;
    if(keyCode == '13'){

    ///previene la accion predeterminada al dar ENTER////
    e.preventDefault();
    ////itera todos los input existentes////////
    for(x=0; x < inputs.length; x++){
            /////se valida cual es el actual///
            if(inputs[x].id==e.target.id){
                //se carga el siguiente
                var nextinput = inputs[x+1];
            }
    }
    //sí se encontro el siguiente input
    if(nextinput){
        //se posiciona en el input
        nextinput.focus();
        ///seleciona el contenido del objeto
        nextinput.select();
    }else{
        //se posiciona sobre el boton y se hace un click//
        document.getElementById("button-login").focus();
        document.getElementById("button-login").click();
    }

}
}

////////////////////////////////////////////////////////////////////////////

function logIn(){
    var user = document.getElementById("userLogin").value;
    var pass = document.getElementById("passwordLogin").value;

    var toSend = new FormData();
    toSend.append('id', 'logIn');
    toSend.append('user', user);
    toSend.append('pass', pass); 

    fetch("https://monedero.grupopetromar.com/admin/apirest/index.php/", {
        method: "POST",
        mode: "cors",
        body: toSend
    })
    .then(response => response.text())
    .catch(error => alert(error))
    .then((data) =>{
            if(JSON.parse(data)[0].act==0){
                return alert("Usuario INACTIVO");
            }
            if(JSON.parse(data)[0].res == "1"){
                //console.log(JSON.parse(data)[0].nombre)
               window.location = "./dashboard.html";
                
                
                //console.log(JSON.parse(data)[0].usuario);
                let sesionlog = [13, JSON.parse(data)[0].nombre,JSON.parse(data)[0].cliente, JSON.parse(data)[0].grupo,JSON.parse(data)[0].tipo];
                sesionlog = JSON.stringify(sesionlog);
    
                sessionStorage.setItem("sesionlog", sesionlog);
            } else {
                console.log(data[0])
                alert("Usuario o contraseña incorrectos");
            }
        

       
    
    });
}