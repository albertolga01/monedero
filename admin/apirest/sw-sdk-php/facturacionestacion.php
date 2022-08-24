<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/SMTP.php";

include "SWSDK.php";
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
require_once '../conexion.php';  

    // CORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$factura = $_POST['factura'];
$conexion = new Conexion();
$db = $conexion->getConexion();
$rows = array();
$servicios = array();

    $Query = "SELECT t1.folio, t1.fechagenerado, t1.importe, t1.restante, t1.cantidad, t3.nombre, t3.rfc, t3.direccion, t4.*
    FROM facturas t1 
    INNER JOIN estaciones t2
    ON t1.idestacion = t2.idestacion 
    INNER JOIN grupo t3
    ON t2.idgrupoest = t3.idgrupo 
    INNER JOIN datosfacturacion t4
    ON t4.foliodatos='1'
    WHERE folio = '{$factura}'";
    $consulta = $db->prepare($Query);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $rows[] = $filau;
    }


    $Query = "SELECT t1.*, t2.folio as foliofacserv, t2.folio_factura, t2.folio_servicio, t3.claveestacion
        FROM servicios t1 
        INNER JOIN factura_estacion t2
        ON t1.folio = t2.folio_servicio
        INNER JOIN estaciones t3
        ON t1.estacion = t3.idestacion
        WHERE t2.folio_factura ='{$factura}'";
    $consulta = $db->prepare($Query);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $servicios[] = $filau;
    }


$Query1 = "SELECT * FROM productos";
$consulta = $db->prepare($Query1);
    $consulta->execute();
    while($filau = $consulta->fetch(PDO::FETCH_OBJ)){
        $productos[] = $filau;
    }


foreach ($rows as $factura) {
    $toSend = formatData($factura, $servicios, $productos);
    $responseTimbrado = swTimbrado($toSend, $factura->rfc, $factura->folio);
}

function formatData($factura, $servicios, $productos){
    $totalImpuestos = 0; 
    $ClaveProdServ="0";
    $producto="0";
    $codigo="0";
    $sumaSubTotal = 0;
    $sumaTotal = 0;
    $cfdi["Version"] = "3.3";// CAMBIAR A 4
    $cfdi["Serie"] = "FC"; 
    $cfdi["Folio"] = $factura->folio;
    $cfdi["Fecha"] = date('Y-m-d\TH:i:s', strtotime(date('Y-m-d\TH:i:s'). ' - 7 hour'));
    $cfdi["Sello"] = "";
    $cfdi["NoCertificado"] = "";
    $cfdi["Certificado"] = "";
    $cfdi["CondicionesDePago"] = "CondicionesDePago";//"03 Transferencia";
   
    $cfdi["MetodoPago"] = $factura->tipocliente=="0" ? "PUE" : "PPD";
    $cfdi["TipoDeComprobante"] = "I";
    $cfdi["Exportacion"] = "01";        //CAMPO 4.0
    $cfdi["FormaPago"] = $factura->tipocliente=="0" ? "03" : "99";
    $cfdi["LugarExpedicion"] = $factura->codigopostal;

        $cfdi["Emisor"]["Rfc"] = $factura->rfcemisor;        
        $cfdi["Emisor"]["Nombre"] = $factura->nombreemisor;
        $cfdi["Emisor"]["RegimenFiscal"] = $factura->RegimenFiscalemisor;

        $cfdi["Receptor"]["Rfc"] = $factura->rfc;
        $cfdi["Receptor"]["Nombre"] = $factura->nombre;
        $cfdi["Receptor"]["ResidenciaFiscalSpecified"] = false;
        $cfdi["Receptor"]["DomicilioFiscalReceptor"] = "82110";       //CAMPO 4.0
        $cfdi["Receptor"]["RegimenFiscalReceptor"] = "601";                     //CAMPO 4.0
        $cfdi["Receptor"]["NumRegIdTrib"] = null;
        $cfdi["Receptor"]["UsoCFDI"] = "P01"; 
        $conceptos = array();
        foreach($servicios as $iterated){
            foreach($productos as $prod){
            if($iterated->producto == $prod->folio){
                $ClaveProdServ = $prod->claveprod;
                $producto = $prod->nombre;
                $codigo = $prod->codigo; 

            $unitario = $iterated->preciounitario;//($iterated->preciounitario) / 1.16;
            $importe = ($iterated->importe) / 1.16;
            $concepto["ClaveProdServ"] = $ClaveProdServ;
            $concepto["NoIdentificacion"] = $codigo;
            $concepto["Cantidad"] = number_format($iterated->litros, 2);
            $concepto["ClaveUnidad"] = "LTR";
            $concepto["Unidad"] = "Litros"; 
            $concepto["Descripcion"] = $codigo." ".$producto;
           // $concepto["ValorUnitario"] = number_format(($iterated->importe / $iterated->litros), 2);
            $concepto["ValorUnitario"] = number_format(($unitario*0.03), 2);
            $concepto["Importe"] = number_format(($iterated->importe*0.03), 2);
            $sumaTotal = $sumaTotal + (($iterated->importe / $iterated->litros)) * ($iterated->litros);
            $concepto["Descuento"] = "0.0"; 

            // $concepto["ObjetoImp"] = "02";      //CAMPO 4.0
                
            $trasladitosC["Base"] = number_format(($iterated->importe*0.03), 2);
            $trasladitosC["Importe"] = number_format(($iterated->importe*0.03)*0.16, 2);
            $sumaTotal = $sumaTotal + ($iterated->importe ) * 0.16;
            $totalImpuestos = $totalImpuestos + (($iterated->importe)*0.03)*0.16;
            $sumaSubTotal = $sumaSubTotal +$iterated->importe;
            $trasladitosC["Impuesto"] = "002"; //iva
            $trasladitosC["TasaOCuota"] = "0.160000";
            $trasladitosC["TipoFactor"] = "Tasa";
            

            $concepto["Impuestos"]["Traslados"][0] = $trasladitosC; 


            $conceptos[] = $concepto;
            }else {
                $ClaveProdServ = null;
                $producto = null;
                $codigo = null;
            }}

            
        }

        $cfdi["Conceptos"] = $conceptos;

        $ImpuestosTotales["Retenciones"] = null;
        $ImpuestosTotales["Traslados"][0]["Impuesto"] = "002";
        $ImpuestosTotales["Traslados"][0]["TipoFactor"] = "Tasa";
        $ImpuestosTotales["Traslados"][0]["TasaOCuota"] = "0.160000";
        $ImpuestosTotales["Traslados"][0]["Importe"] = number_format($totalImpuestos,2);
        $ImpuestosTotales["TotalImpuestosRetenidosSpecified"] = false;
        $ImpuestosTotales["TotalImpuestosTrasladados"] = number_format($totalImpuestos,2);
        $ImpuestosTotales["TotalImpuestosTrasladadosSpecified"] = true;
        $cfdi["Impuestos"] = $ImpuestosTotales;

        $cfdi["Conceptos"] = $conceptos;

        $complementos = array();
        $complementos["HasElements"] = true;

        $estadodecombustible = array();
        $edoCombutibleBody = array();
        $edoCombutibleBody["Version"] = "1.2";
        $edoCombutibleBody["TipoOperacion"] = "Tarjeta";
        $edoCombutibleBody["NumeroDeCuenta"] = "12355";
        $edoCombutibleBody["SubTotal"] = number_format(($sumaSubTotal*0.03)/1.16, 2);//number_format(20.68, 2);
        $edoCombutibleBody["Total"] = number_format(($factura->importe*0.03), 2);//number_format($sumaTotal ,2);
        

       // $estadodecombustible["Ecc12:Estadodecuentacombustible"] = $edoCombutibleBody;
       // $complementos["Any"][0] = $estadodecombustible;
        
       // $cfdi["Impuestos"] = null;
        $cfdi["Complemento"][0] = $complementos;
        $cfdi["SubTotal"] = number_format(($sumaSubTotal*0.03),2); //number_format(($factura->importe * 0.84), 2);//number_format(20.68, 2);//number_format($factura->importe, 2);
        $cfdi["Descuento"] = "0.0";
        $cfdi["Moneda"] = "MXN";
        $cfdi["TipoCambio"] = "1";
        $totalImpuestosTrasladados = $totalImpuestos;
        $ImpuestosTotales["TotalImpuestosTrasladados"] = (string)$totalImpuestosTrasladados;
        $ImpuestosTotales["TotalImpuestosTrasladadosSpecified"] = true;
        $cfdi["Impuestos"] = $ImpuestosTotales;

        $cfdi["Total"] = number_format(($sumaTotal)*0.03,2); //number_format($factura->importe, 2);
        
        // DATA TO JSON AND RESPONSE FROM LIBRARY
    $json_string = json_encode($cfdi, JSON_PRETTY_PRINT);
    
        
    //echo $json_string;
        $toSend = json_encode($cfdi);
    return $toSend;
}

function generateQr($qrCode, $rfc, $folio){
    $basePath = "../../../DocsClientes/{$rfc}/";
    $fecha = date('Y-m-d');
    $filename = "LACAJAMZT-F{$folio}-{$fecha}.png";
    $filenamesf = "LACAJAMZT-F{$folio}-{$fecha}";
    
    if(!imagepng(imagecreatefromstring(base64_decode($qrCode)), $basePath.$filename)){
        echo "Error al crear";
    }

    return $filenamesf;
}

function generateXml($xml, $rfc, $folio){
    $fecha = date('Y-m-d');
    $basePath = $basePath = "../../../DocsClientes/{$rfc}/LACAJAMZT-F{$folio}-{$fecha}.xml";
    if(!file_put_contents($basePath, $xml)){
        echo "Error al generar XML";
    }

    return $basePath;
}

function updateBD($fecha, $uuid, $archivo, $folio){
    $fecha = str_replace("T", " ", $fecha);
    $archivo = explode("/", $archivo)[4];

    $conexionUpdate = new Conexion();
    $dbUpdate = $conexionUpdate->getConexion();
    $Query = "UPDATE facturas 
        SET fechafacturacion='{$fecha}', uuidfactura='{$uuid}', factura='{$archivo}', timbrado=1
        WHERE folio = {$folio} 
        ";
    $consulta = $dbUpdate->prepare($Query);
    $consulta->execute();
}
 

function swTimbrado($toSend, $factura, $folio){
    // print_r(json_pretty_print($toSend));
    $params = array( 
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"desarrollo@grupopetromar.com",
        "password"=> "Petromar+SW"
    );

    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV4($toSend);
    
    if((string)$resultadoJson->status == "success"){
        // var_dump($resultadoJson);
        $nombre = generateQr($resultadoJson->data->qrCode, $factura, $folio);
        $rutaxml = generateXml($resultadoJson->data->cfdi, $factura, $folio);
        updateBD(
            $resultadoJson->data->fechaTimbrado,
            $resultadoJson->data->uuid,
            $rutaxml,
            $folio
        );
        //sendMail();
        $respuesta = array();
        $respuesta[] = array(
            "respuesta" => "1",
            "factura" => $rutaxml,
            "nombre" => $nombre
        );
        echo json_encode($respuesta);
    } else {
        var_dump($resultadoJson);
        $respuesta = array();
        $respuesta[] = array(
            "respuesta" => "0"
        );
        echo json_encode($respuesta);
    }
}


/* 
  $ver4 ='{
            "Version": "4.0",
            "Serie": "SW",
            "Folio": "123456",
            "Fecha": "2022-01-12T00:00:00",
            "Sello": "",
            "NoCertificado": "",
            "Certificado": "",
            "CondicionesDePago": "CondicionesDePago",
            "SubTotal": "10.00",
            "Descuento": "0.00",
            "Moneda": "AMD",
            "TipoCambio": "1",
            "Total": "10.00",
            "TipoDeComprobante": "I",
            "Exportacion": "01",
            "LugarExpedicion": "45610",
            "Emisor": {
            "Rfc": "CPE190207226",
            "Nombre": "ESCUELA KEMPER URGATE SA DE CV",
            "RegimenFiscal": "603"
            },
            "Receptor": {
            "Rfc": "CPE190207226",
            "Nombre": "ESCUELA KEMPER URGATE SA DE CV",
            "DomicilioFiscalReceptor": "26015",
            "RegimenFiscalReceptor": "601",
            "UsoCFDI": "P01"
            },
            "Conceptos": [
            {
                "ClaveProdServ": "50211503",
                "NoIdentificacion": "None",
                "Cantidad": "1.0",
                "ClaveUnidad": "H87",
                "Unidad": "Pieza",
                "Descripcion": "Cigarros",
                "ValorUnitario": "10.00",
                "Importe": "10.00",
                "Descuento": "0.00",
                "ObjetoImp": "02",
                "Impuestos": {
                "Traslados": [
                    {
                    "Base": "1",
                    "Importe": "1",
                    "Impuesto": "002",
                    "TasaOCuota": "0.160000",
                    "TipoFactor": "Tasa"
                    }
                ],
                "Retenciones": [
                    {
                    "Base": "1",
                    "Importe": "1",
                    "Impuesto": "002",
                    "TasaOCuota": "0.040000",
                    "TipoFactor": "Tasa"
                    }
                ]
                }
            }
            ],
            "Impuestos": {
            "TotalImpuestosTrasladados": "1.00",
            "TotalImpuestosRetenidos": "1.00",
            "Retenciones": [
                {
                "Importe": "1.00",
                "Impuesto": "002"
                }
            ],
            "Traslados": [
                {
                "Base": "1.00",
                "Importe": "1.00",
                "Impuesto": "002",
                "TasaOCuota": "0.160000",
                "TipoFactor": "Tasa"
                }
            ]
            }
            }
        ';
      
*/

?>