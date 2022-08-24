<?php 

require_once('conexion.php'); 

require_once('api.php');

require_once('cors.php');

$method = $_SERVER['REQUEST_METHOD'];

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

if($method == "GET"){
    if($_GET["id"] == "getClientes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getClientes();
        $json = json_encode($vector);
        echo $json;
    }
 
}


if($method == "POST"){
    if($_POST["id"] == "login"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->Login($user, $pass);
        echo json_encode($json);
    }
 
    // inician peticiones de app despachador 
    if($_POST["id"] == "obtenerDatos"){
        $noTarjeta = $_POST["noTarjeta"];  
        $claveestacion = $_POST["claveestacion"];
        $api = new Api();
        $json = $api->obtenerDatos($noTarjeta,$claveestacion);
        echo json_encode($json);
    }

    
    if($_POST["id"] == "guardarServicio"){
    
        $idcliente = $_POST["idcliente"];
        $idtarjeta = $_POST["idtarjeta"];  
        $importe = $_POST["importe"];  
        $litros = $_POST["litros"];  
        $producto = $_POST["producto"];  
        $estacion = $_POST["estacion"];  
        $controlaodometro = $_POST["controlaodometro"];  
        $idvehiculo = $_POST["idvehiculo"];  
        $kmanterior = $_POST["kmanterior"];  
        $kmnuevo = $_POST["kmnuevo"];  
        $bomba = $_POST["bomba"];   
        $nip = $_POST["nip"];   
        $proximaCompra = $_POST["proximaCompra"];   
        $api = new Api();
        $json = $api->guardarServicio($idcliente, $idtarjeta, $importe, $litros, $producto, $estacion, $controlaodometro, $idvehiculo, $kmanterior, $kmnuevo, $bomba, $nip, $proximaCompra);
        echo json_encode($json);
    }



    if($_POST["id"] == "getDatosEstTicket"){
    
        $noEstacion = $_POST["noEstacion"]; 
        $api = new Api();
        $json = $api->getDatosEstTicket($noEstacion);
        echo json_encode($json);
    }


    if($_POST["id"] == "getDatosServTicket"){
    
        $folio = $_POST["folio"]; 
        $api = new Api();
        $json = $api->getDatosServTicket($folio);
        echo json_encode($json);
    }


    if($_POST["id"] == "getServiciosDespachador"){
    
        $estacion = $_POST["estacion"]; 
        $fecha = $_POST["fecha"]; 
        $api = new Api();
        $json = $api->getServiciosDespachador($estacion, $fecha);
        echo json_encode($json);
    }


    
    if($_POST["id"] == "autorizacionNip"){
    
        $tipo = $_POST["tipo"]; 
        $idcliente = $_POST["idcliente"];  
        $tarjeta = $_POST["tarjeta"];  
        $api = new Api();
        $json = $api->autorizacionNip($tipo, $idcliente, $tarjeta);
        echo json_encode($json);
    }
    


    if($_POST["id"] == "obtenerEstadoTarjeta"){
     
        $tarjeta = $_POST["tarjeta"];   
        $api = new Api();
        $json = $api->obtenerEstadoTarjeta($tarjeta);
        echo json_encode($json);
    }


    if($_POST["id"] == "getBombas"){
     
        $estacion = $_POST["estacion"];   
        $api = new Api();
        $json = $api->getBombas($estacion);
        echo json_encode($json);
    }
    

    


}

if($method=="DELETE"){

}

?>