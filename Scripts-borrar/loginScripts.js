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
        
    fetch("https://compras.grupopetromar.com/monedero/apirest/",{
        method: "POST",
        mode: "cors",
        body: toSend
    })
    .then(response => response.json())
    .catch(error => alert(error))
    .then((data) => {
        if(data[0].res == "1"){
            sessionStorage.setItem("sesionlog", JSON.stringify(data));
            window.location = "./dashboard.html";
        } else {
            console.log(data[0].res);
            alert("Usuario o contraseña incorrectos");
        }
    });
}
