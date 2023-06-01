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
 

    if($_GET["id"] == "getTarjetaFPlaca"){
        $vector = array();
        $api = new Api();
        $idvehiculo = $_GET["idvehiculo"]; 
        $vector = $api->getTarjetaFPlaca($idvehiculo);
        $json = $vector;
        echo json_encode($json);
    }


    if($_GET["id"] == "getPlacas"){
        $vector = array();
        $api = new Api();
        $cte = $_GET["cte"]; 
        $vector = $api->getPlacas($cte);
        $json = $vector;
        echo json_encode($json);
    }

    
    if($_GET["id"] == "getPlacaFTarjeta"){
        $vector = array();
        $api = new Api();
        $numeroTarjeta = $_GET["numeroTarjeta"]; 
        $vector = $api->getPlacaFTarjeta($numeroTarjeta);
        $json = $vector;
        echo $json;
    }


    if($_GET["id"] == "listadesaldos"){
        $vector = array();
        $api = new Api();
        $vector = $api->listadesaldos();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getchoferesC"){
        $vector = array();
        $api = new Api();
        $vector = $api->getchoferesC($_GET["c"],$_GET["p"]);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getConsiliacion"){
        $vector = array();
        $api = new Api();
        $vector = $api->consiliacion();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCombustibles"){
        $vector = array();
        $api = new Api();
        $vector = $api->getCombustibles();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getONp"){
        $vector = array();
        $api = new Api();
        $vector = $api->getONp($_GET["c"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getProd"){
        $vector = array();
        $api = new Api();
        $vector = $api->getProd($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getEsta"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEsta($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getVehiculosCliente"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculosCliente($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getEstacionRel"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEstacionRel($_GET["cte"]);
        $json = json_encode($vector);
        echo $json;
    }
    
    if($_GET["id"] == "getVehiculosClient"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculosClient($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }



    if($_GET["id"] == "getTarjetasCliente"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTarjetasCliente($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }


    
    if($_GET["id"] == "getservR"){
        $vector = array();
        $api = new Api();
        $vector = $api->getservR($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getClientes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getClientes();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getProductoR"){
        $vector = array();
        $api = new Api();
        $vector = $api->getProductoR($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getproducto"){
        $vector = array();
        $api = new Api();
        $vector = $api->getproducto();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getEstaciones"){
        $vector = array();
        $api = new Api();
        $vector = $api->getEstaciones($_GET['grupo']);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getTodasEstaciones"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTodasEstaciones();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCliente"){
        echo 'alivianesepadrino';    
    }

    if($_GET["id"] == "getUsuarios"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuarios($_GET['gpo']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getUsuariosWeb"){
        $vector = array();
        $api = new Api();
        $vector = $api->getUsuariosWeb($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getChoferes"){
        $vector = array();
        $api = new Api();
        $vector = $api->getChoferes($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getSaldo"){
        $vector = array();
        $api = new Api();
        $vector = $api->getSaldo($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCredito"){
        $vector = array();
        $api = new Api();
        $vector = $api->getCredito($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getCredito2"){
        $vector = array();
        $api = new Api();
        $vector = $api->getCredito2($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }
    

    if($_GET["id"] == "getVehiculos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculos($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }
    if($_GET["id"] == "getVehiculos2"){
        $vector = array();
        $api = new Api();
        $vector = $api->getVehiculos2();
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getTarjetas"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTarjetas($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getAbonos2"){
        $vector = array();
        $api = new Api();
        $vector = $api->getAbonos2($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getAbonos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getAbonos($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getImpuestos"){
        $vector = array();
        $api = new Api();
        $vector = $api->getImpuestos(); //($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getTransacciones"){
        $vector = array();
        $api = new Api();
        $vector = $api->getTransacciones(); //($_GET['cte']);
        $json = json_encode($vector);
        echo $json;
    }
    
    if($_GET["id"] == "C_getVehiculos"){

        $vector = array();
        $api = new Api();
        $vector = $api->C_getVehiculos($_GET['idcliente']);
        $json = json_encode($vector);
        echo $json;
    }

    if($_GET["id"] == "getgrupo"){
        $vector = array();
        $api = new Api();
        $vector = $api->getgrupo();
        $json = json_encode($vector);
        echo $json ;
    }

    if($_GET["id"] == "getFaturaEstacion"){
        $vector = array();
        $api = new Api();
        $vector = $api->getFaturaEstacion();
        $json = json_encode($vector);
        echo $json ;
    }

    if($_GET["id"] == "cancelarFaturaEstacion"){
        $json = null;
        $api = new Api();
        $json = $api->cancelarFaturaEstacionn($_GET["folio"]);
        echo $json ;
    }

    if($_GET["id"] == "GetChoferSinNip"){
        $vector = array();
        $json = null;
        $api = new Api();
        $vector = $api->GetChoferSinNip();
        $json = json_encode($vector);
        echo $json ;
    }


}


if($method == "POST"){

    if($_POST["id"] == "addNip"){
        $vector = array();
        $folios = $_POST["folio"];
        $nips = $_POST["nip"];
        $api = new Api();
        $vector = $api->addNip($folios, $nips);
        $json = json_encode($vector);
        echo $json ;
    }

    if($_POST["id"] == "Addfacturaestacion"){
        $json = null;
        $estacion = $_POST["estacion"];
        $fechainicio = $_POST["fechainicio"];
        $fechafin = $_POST["fechafin"];
        $api = new Api();
        $json = $api->Addfacturaestacion($estacion, $fechainicio, $fechafin);
        echo $json;
    }

    if($_POST["id"] == "UpDateTarjeta"){
        $json = null;
        $tarjeta = $_POST["tarjeta"]; 
        $estado = $_POST["estado"];
        $estacion = $_POST["estacion"];
        $combustible = $_POST["combustible"];
        $horariodia1 = $_POST["horariodia1"];
        $horariodia2 = $_POST["horariodia2"];
        $horariodia3 = $_POST["horariodia3"];
        $horariodia4 = $_POST["horariodia4"];
        $horariodia5 = $_POST["horariodia5"];
        $horariodia6 = $_POST["horariodia6"];
        $horariodia7 = $_POST["horariodia7"];
        $horario1 = $_POST["horario1"];
        $horario2 = $_POST["horario2"];
        $limiteC = $_POST["limiteC"];
        $limiteD = $_POST["limiteD"];
        $limiteP = $_POST["limiteP"];
        $limitetipo = $_POST["limitetipo"];
        $api = new Api();
        $json = $api->UpDateTarjeta($tarjeta, $estado, $estacion, $combustible, $horariodia1, $horariodia2, $horariodia3,
        $horariodia4, $horariodia5, $horariodia6, $horariodia7, $horario1, $horario2, $limiteC, $limiteD, $limiteP,$limitetipo);
    
        echo $json;
        
    
        }

        if($_POST["id"] == "getPrecios"){
            $json = null;
            $estacion = $_POST["estacion"];
            $producto = $_POST["producto"];
            $api = new Api(); 
            $json = $api->getPrecios($estacion,$producto);
            echo $json;
        }

        if($_POST["id"] == "GuardarComplemento"){
            $json = null;
            $folio = $_POST["folio"];
            $nombre = $_POST["nombre"];
            $uuid = $_POST["uuid"];
            $api = new Api(); 
            $json = $api->GuardarComplemento($folio,$nombre,$uuid);
            echo $json;
        }

    if($_POST["id"] == "cambioprecio"){
        $json = null;
        $estacion = $_POST["estacion"]; 
        $fecha = $_POST["fecha"];
        $grupo = $_POST["grupo"];
        $hora = $_POST["hora"]; 
        $magna= $_POST["magna"];
        $premium = $_POST["premium"]; 
        $diesel = $_POST["diesel"];
        $api = new Api(); 
        $json = $api->cambioprecio($estacion, $fecha, $hora, $magna, $premium, $diesel, $grupo);
        echo $json;
        
        
    }
    
    if($_POST["id"] == "altaestacion"){
        $json = null;
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $direc = $_POST["direc"];
        $clave = $_POST["clave"];
        $grupo = $_POST["grupo"];
        $lat = $_POST["lat"];
        $long = $_POST["long"];
        $calle = $_POST["calle"];
        $colonia = $_POST["colonia"]; 
        $api = new Api();
        $json = $api->altaestacion($codigo, $nombre, $direc, $clave, $grupo, $lat, $long, $calle, $colonia);
        echo ($json);
    }

    if($_POST["id"] == "altagrupo"){
        $json = null;
        $nombre = $_POST["nombre"];
        $direccion = $_POST["direccion"];
        $rfc = $_POST["rfc"];
        $api = new Api();
        $json = $api->altagrupo($nombre, $direccion, $rfc);
        echo $json;
    }

    if($_POST["id"] == "cambioieps"){
        $json = null;
        $mieps = $_POST["mieps"];
        $pieps = $_POST["pieps"];
        $dieps = $_POST["dieps"];
        $iva = $_POST["iva"];
        $api = new Api();
        $json = $api->cambioieps($mieps, $pieps, $dieps, $iva);
        echo $json;
    }

    if($_POST["id"] == "logIn"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->LogIn($user, $pass);
        echo json_encode($json);
    }

   /* if($_POST["id"] == "leerEditarcliente"){
        $json = null;
        $cte = $_POST["cte"]; 
        $api = new Api();
        $json = $api->leerEditarcliente($cte);
        echo json_encode($json);
    }*/

    if($_POST["id"] == "Cargos"){
        $json = null;
        $placa = $_POST["placa"]; 
        $api = new Api();
        $json = $api->Cargos($placa);
        echo json_encode($json);
    }

    if($_POST["id"] == "serviciomanual"){
        if($tarjeta != "null"){
        $json = null;
        $tarjeta = $_POST["tarjeta"]; 
        $cliente = $_POST["cliente"]; 
        $estacion = $_POST["estacion"]; 
        $importe = $_POST["importe"]; 
        $producto = $_POST["producto"]; 
        $litros = $_POST["litros"]; 
        $precio = $_POST["precio"];
        $servicio = $_POST["servicio"];
        $chofer = $_POST["chofer"];
        $km = $_POST["km"]; 
        $api = new Api();
        $json = $api->serviciomanual($tarjeta,$cliente,$estacion,$importe,$producto,$litros,$precio,$km,$servicio,$chofer);
        echo json_encode($json);
        }else{
            echo "Error";
        }
    }

    if($_POST["id"] == "agregarCliente"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $rfc = $_POST["rfc"];
        $grupo = $_POST["grupo"];
        $contacto = $_POST["contacto"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $tipo = $_POST["tcliente"];
        $cabono = $_POST["cabono"];
        $ccargo = $_POST["ccargo"];
        $repre = $_POST["Rl"];
        /*$metodopago = $_POST["metodopago"];*/
        if($tipo==1){
            $periodopago = $_POST["periodopago"];
            $limitecredito = $_POST["limitecredito"];
        }else{
            $periodopago = 0;
            $limitecredito = 0;
        }
        
        $colonia = $_POST["colonia"];
        $estado = $_POST["estado"];
        $ciudad = $_POST["ciudad"];
        $cp = $_POST["cp"];
        $usocdfi = $_POST["usocdfi"];
        $domfiscal = $_POST["domfiscal"];
        $regfiscalrec = $_POST["regfiscalrec"];
        $api = new Api();
        $json = $api->addCliente($repre,$cabono,$ccargo,$nombre, $rfc, $grupo, $contacto, $telefono, $direccion,  $colonia, $estado, $ciudad, $cp,$tipo,$periodopago, $limitecredito, $usocdfi, $domfiscal, $regfiscalrec);
        echo $json;
    }
    if($_POST["id"] == "EditarCliente"){
        $json = null;
        $cte = $_POST["cte"]; 
        $rfc = $_POST["rfc"];
        $grupo = $_POST["grupo"];
        $contacto = $_POST["contacto"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $tipo = $_POST["tipo"];
        $metodopago = $_POST["metodopago"];
        $periodopago = $_POST["periodopago"];
        $limitecredito = $_POST["limitecredito"];
        $colonia = $_POST["colonia"];
        $estado = $_POST["estado"];
        $ciudad = $_POST["ciudad"];
        $CuentaA = $_POST["CuentaA"];
        $CuentaC = $_POST["CuentaC"];
        $cp = $_POST["cp"];
        $repre = $_POST["repre"];
        $api = new Api();
        $json = $api->EditarCliente($repre,$CuentaA,$CuentaC,$cte, $contacto, $telefono, $direccion, $tipo, $metodopago, $periodopago, $limitecredito, $colonia, $estado, $ciudad, $cp);
        echo $json;
    }
    if($_POST["id"] == "RRU"){
        //$vector = array();
        $tarjeta = $_POST["tarjeta"];
        $api = new Api();
        $json = $api->RRU($tarjeta);
        $json = json_encode($json);
        echo $json;
    }

    if($_POST["id"] == "agregarUsuarioWeb"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $nombre = $_POST["nombre"]; 
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $tipo = $_POST["tipo"];
        //$administracion = $_POST["administracion"];
        //$reportes = $_POST["reportes"];
        //$graficas = $_POST["graficas"];
        //$seguridad = $_POST["seguridad"];
        $api = new Api();
        $json = $api->addUsuarioWeb($idcliente, $nombre, $usuario, $contrasena, $tipo);
        echo $json;
    }
    if($_POST["id"] == "poliza"){
        //$vector = array();
        $fecha = $_POST["fecha"];
        $api = new Api();
        $json = $api->poliza($fecha);
        $json = json_encode($json);
        echo $json;
    }

    if($_POST["id"] == "agregarUsuario"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $grupo = $_POST["grupo"];
        $gpo = $_POST["gpo"];
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $tipo = $_POST["tipo"];
        //$sistema = $_POST["sistema"];
        $api = new Api();
        $json = $api->addUsuario($nombre, $grupo, $usuario, $contrasena, $tipo, $gpo);
        echo $json;
    }
    
    if($_POST["id"] == "pagosapp"){
        $vector = array();
        $cte = $_POST["cte"]; 
        $fini = $_POST["fini"];
        $ffin = $_POST["ffin"];
        $api = new Api();
        $vector = $api->pagosapp($cte, $fini, $ffin);
        $json = json_encode($vector);
        echo $json;
    }
    

    if($_POST["id"] == "CancelarAbono"){
        $vector = array();
        $abono = $_POST["abono"];
        $api = new Api();
        $json = $api->CancelarAbono($abono);
        
        echo $json;
    }

    if($_POST["id"] == "filtrarAbonos"){
        $vector = array();
        $cte = $_POST["cliente"]; 
        $fini = $_POST["Fechaini"];
        $ffin = $_POST["Fechafin"];
        $api = new Api();
        $vector = $api->filtrarAbonos($cte, $fini, $ffin);
        $json = json_encode($vector);
        echo $json;
    }

    if($_POST["id"] == "agregarChofer"){
        $json = null;
        $nombre = $_POST["nombre"]; 
        $idCliente = $_POST["idCliente"];
        //$idvehiculo = $_POST["idvehiculo"];
        $api = new Api();
        $json = $api->addChofer($nombre, $idCliente);
        echo $json;
    }

    if($_POST["id"] == "agregarVehiculo"){
        $json = null;
        $idCliente = $_POST["idCliente"]; 
        $modelo = $_POST["modelo"]; 
        $ano = $_POST["ano"]; 
        $placas = $_POST["placas"]; 
        $noEconomico = $_POST["noEconomico"]; 
        $tipoVehiculo = $_POST["tipoVehiculo"]; 
        $choferes = $_POST["choferes"];
        //$idTarjeta = $_POST["idTarjeta"]; 
        //$centroCosto = $_POST["centroCosto"]; 
        $controlaOdometro = $_POST["controlaOdometro"]; 
        $kmmx = $_POST["kmmx"]; 
        //$variacion = $_POST["variacion"]; 
        //$odometro = $_POST["odometro"]; 
        //$rendimiento = $_POST["rendimiento"]; 
        $api = new Api();
        $json = $api->addVehiculo($idCliente, $modelo, $ano, $placas, $noEconomico, $tipoVehiculo, $controlaOdometro, $choferes,$kmmx);
        echo $json;
    }

    if($_POST["id"] == "AgregarTarjetas"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $notarjeta = $_POST["notarjeta"]; 
        $idplaca = $_POST["idplaca"]; 
        $activo = $_POST["activo"]; 
        $tipo = $_POST["tipo"]; 
        $combustible = $_POST["combustible"];
        $estacion = $_POST["estacion"];
        $horarioinicial = $_POST["horarioinicial"];
        $horariofinal = $_POST["horariofinal"];
        $lunes = $_POST["lunes"];
        $martes = $_POST["martes"];
        $miercoles = $_POST["miercoles"];
        $jueves = $_POST["jueves"];
        $viernes = $_POST["viernes"];
        $sabado = $_POST["sabado"];
        $domingo = $_POST["domingo"];
        $limitedinero = $_POST["limitedinero"];
        $limitelitros = $_POST["limitelitros"];
        $limitetipo = $_POST["limitetipo"];
        $tipoperiodo = $_POST["tipoperiodo"];
        $nip = $_POST["nip"];
        $api = new Api();
        $json = $api->addTarjeta($idcliente, $notarjeta, $idplaca, $activo, $tipo,$combustible, $horarioinicial, $horariofinal, $lunes, $martes,$miercoles, $jueves,
            $viernes, $sabado, $domingo, $estacion, $limitedinero, $limitelitros, $tipoperiodo, $nip,$limitetipo);
        echo $json;
    }

    if($_POST["id"] == "agregarAbono"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        //$fecha = $_POST["fecha"];
        $importe = $_POST["importe"];
        $formapago = $_POST["formapago"];
        $bancodestino = $_POST["bancodestino"];
        $cuentabancaria = $_POST["cuentabancaria"];
        $referencia = $_POST["referencia"];
        $concepto = $_POST["concepto"];
        $api = new Api();
        $json = $api->addAbono($idcliente, $importe, $formapago, $bancodestino, $cuentabancaria, $referencia, $concepto);
        echo $json;
    }

    if($_POST["id"] == "agregarCargo"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $estacion = $_POST["estacion"]; 
        $fecha = $_POST["fecha"];
        $tarjeta = $_POST["tarjeta"];
        $importe = $_POST["importe"];
        $producto = $_POST["producto"];
        $api = new Api();
        $json = $api->addCargo($idcliente, $estacion, $fecha, $tarjeta, $importe, $producto);
        echo $json;
    }

            /*  CLIENTES  */
    if($_POST["id"] == "C_login"){
        $json = null;
        $user = $_POST["user"]; 
        $pass = $_POST["pass"];
        $api = new Api();
        $json = $api->C_Login($user, $pass);
        echo json_encode($json);
    }
    if($_POST["id"] == "obtenercomplementos"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $fechainicial = $_POST["fechainicial"]; 
        $fechafinal = $_POST["fechafinal"];
        $api = new Api();
        $json = $api->ComplementosCte($idcliente, $fechainicial, $fechafinal);
        echo json_encode($json);
    }

    if($_POST["id"] == "obtenerServicios"){
        $json = null;
        $idcliente = $_POST["idcliente"]; 
        $fechainicial = $_POST["fechainicial"];
        $fechafinal = $_POST["fechafinal"];
        $idtarjeta = $_POST["idtarjeta"];
        $api = new Api();
        $json = $api->obtenerServicios($idcliente, $fechainicial, $fechafinal, $idtarjeta);
        echo json_encode($json);

    }

    if($_POST["id"] == "CancelarServicios"){
        $json = null;
        $servicio = $_POST["servicio"];
        $api = new Api();
        $json = $api->CancelarServicios($servicio);
        echo $json;
    }

    if($_POST["id"] == "CancelarFacturas"){
        $json = null;
        $factura = $_POST["factura"];
        
        $api = new Api();
        $json = $api->CancelarFacturas($factura);
        echo $json;
    }

    if($_POST["id"] == "generarFactura"){
        $json = null;
        $idcliente = $_POST["idcliente"];
        $folio[] = $_POST["folio"];
        $fecha = $_POST["fecha"];   
        $periodoi = $_POST["periodoi"];   
        $periodof = $_POST["periodof"];   
        $api = new Api();
        $json = $api->generarFactura($idcliente, $folio, $fecha, $periodoi, $periodof);
        echo json_encode($json);

    }
    if($_POST["id"] == "obtenerFacturas"){
        $json = null;
        $idcliente = $_POST["idcliente"];
        //$sistema = $_POST["sistema"];
        $api = new Api();
        $json = $api->addFactura($idcliente);
        echo json_encode($json);
    
    }
    if($_POST["id"] == "obtenerFacturasSinrestante"){
        $json = null;
        $idcliente = $_POST["idcliente"];
        //$sistema = $_POST["sistema"];
        $api = new Api();
        $json = $api->getFacturaSinres($idcliente);
        echo json_encode($json);
    
    }
    if($_POST["id"] == "actualizarChofer"){
        $json = null;
        $activo = $_POST["activo"];
        $valor = $_POST["iduser"];
        $api = new Api();
        $json = $api->UpDateChofer($activo, $valor);
        echo $json;
    }
    if($_POST["id"] == "actualizarEstadoTarjeta"){
        $json = null;
        $activo = $_POST["activo"];
        $valor = $_POST["valor"];
        
        $api = new Api();
        $json = $api->UpDateTarjetas($activo, $valor);
        echo $json;
    }
    if($_POST["id"] == "actualizarEstadoVehiculo"){
        $json = null;
        $activo = $_POST["activo"];
        $id = $_POST["valor"];
        $api = new Api();
        $json = $api->UpDateVehiculo($activo, $id);
        echo $json;
    }
    if($_POST["id"] == "actualizarUsuarioWeb"){
        $json = null;
        $activo = $_POST["activo"];
        $id = $_POST["iduser"];
        $api = new Api();
        $json = $api->UpDateUsuarioWeb($activo, $id);
        echo $json;
    }
    if($_POST["id"] == "actualizarUsuario"){
        $json = null;
        $activo = $_POST["activo"];
        $id = $_POST["iduser"];
        $api = new Api();
        $json = $api->UpDateUsuario($activo, $id);
        echo $json;
    }

    if($_POST["id"] == "fRendimiento"){
        $json = null;
        $cte = $_POST["cte"];
        $fechai = $_POST["fechai"];
        $fechaf = $_POST["fechaf"];
        $api = new Api();
        $json = $api->fRendimiento($cte, $fechai, $fechaf);
        echo $json;

    }
    if($_POST["id"] == "Filtrarfac"){
       // echo "hola";
        $json = null;
        $cte = $_POST["cte"];
        $fechai = $_POST["fini"];
        $fechaf = $_POST["ffin"];
        $api = new Api();
        $json = $api->Filtrarfac($cte, $fechai, $fechaf);
        echo $json;

    }

    if($_POST["id"] == "aplicacionPagosCredito"){

         $json = null;
         $foliopago = $_POST["foliopago"];
         $cte = $_POST["cte"];
         $abono = $_POST["abono"];
         $importe = $_POST["importe"];
         $folios = $_POST["folios"];
         $api = new Api();
         $json = $api->aplicacionPagosCredito($cte, $foliopago, $importe, $abono, $folios);
         echo $json;
 
     }


     if($_POST["id"] == "lastCardNumber"){

        $json = null; 
        $api = new Api();
        $json = $api->lastCardNumber();
        echo $json;

    }
    if($_POST["id"] == "actualizarNip"){

        $json = null; 
        $api = new Api();
        $idchofer = $_POST["idchofer"];
        $nip = $_POST["nip"];
        $json = $api->actualizarNip($idchofer, $nip);
        echo $json;

    }
}

if($method=="DELETE"){

}

?>