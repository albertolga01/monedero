var inputs = document.getElementsByTagName('input');
window.onload = function(){
    for(var i=0; i<inputs.length; i++){
        if(i == 0){
            inputs[i].focus();
        }
        inputs[i].addEventListener('keypress', enterTab);
    }
    document.getElementById("button-login"),addEventListener("click", enterTab);
}

document.getElementById("button-login").onclick=logincliente;

function logincliente(){
    let usuario = document.getElementById("userLogin").value;
    let contra = document.getElementById("passwordLogin").value;
    let toSend = new FormData();
        toSend.append("id","C_login");
        toSend.append("user",usuario);
        toSend.append("pass",contra);
        
    fetch("https://monedero.grupopetromar.com/apirest/index.php",{
        method: "POST",
        mode: "cors",
        body: toSend
    })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        //console.log(data)
        if(data[0].act==0){
            return alert("Usuario INACTIVO");
        }
        if(data[0].res == "1"){
            sessionStorage.setItem("sesionlog", JSON.stringify(data));
            window.location = "./dashboard.html";
        } else {
            console.log(data[0].res);
            alert("Usuario o contraseña incorrectos");
        }
    });
}

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