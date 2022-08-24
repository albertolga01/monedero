<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/SMTP.php";

include "SWSDK.php";
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
require_once '../conexion.php';  
require_once 'crXml.php';

    // CORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}
 
$conexion = new Conexion();
$db = $conexion->getConexion(); 


$foliopagoaplicacion = $_POST['foliopagoaplicacion'];

$Q = "Select t1.folio_p,t1.idfactura, t1.foliopago, t1.importe, t1.abono, t2.uuidfactura, t2.folio as foliofactura, t3.fecha, t3.importeabono, t4.rzonsocial, t4.rfc from pagosaplicaciones t1 
inner join facturas t2 on t1.idfactura  = t2.folio 
inner join abonos t3 on t1.foliopago = t3.IDabono
inner join clientes t4 on t2.idcliente = t4.idcliente
where t1.folio_p = '".$foliopagoaplicacion."'";
// echo $Q;
$consultad = $db->prepare($Q);
		$consultad->execute();
		while($filau = $consultad->fetch()){
			$aplicaciones[] = $filau;
            $foliofactura = $filau["foliofactura"];
            $iddocumento = $filau["uuidfactura"];
            $importepago = $filau["importeabono"];
            $fechapago = $filau["fecha"]; 
            $saldoanterior = $filau["importe"];///////////
            $saldoinsoluto = $filau["abono"];///////////
            $rfc = $filau["rfc"];
            $rzonsiocialreceptor = $filau["rzonsocial"];
            $folio = $filau["folio_p"];
		}




$noparcialidad = 1;
//$saldoanterior = 1000; //saldo por pagar antes del abono 
//$saldoinsoluto = 500; //saldo anterior - abono 

 //cambiar por rfc de la caja
 //por confirmar
$json = '
{
    "Version": "3.3",
    "Serie": "C",
    "Folio": "'.$folio.'",
    "Fecha": "'.date('Y-m-d\TH:i:s', strtotime(date('Y-m-d\TH:i:s').'-7 hour')).'",
    "SubTotal": "0",
    "Moneda": "XXX",
    "Total": "0",
    "TipoDeComprobante": "P",
    "LugarExpedicion": "82110",
    "NoCertificado": "",
    "Certificado": "",
    "Sello": "",
    "Emisor": {
       "Rfc": "OSE060323UN7", 
       "RegimenFiscal": "601", 
       "Nombre": "OPERADORA Y SERVICIOS EMPRESARIALES SA DE CV"
    },
    "Receptor": {
       "Rfc": "'.$rfc.'",
       "Nombre": "'.$rzonsiocialreceptor.'",
       "UsoCFDI": "P01"
    },
    "Conceptos": [
        {
          "ClaveProdServ": "84111506",
          "Cantidad": 1,
          "ClaveUnidad": "ACT",
          "Descripcion": "Pago",
          "ValorUnitario": "0",
          "Importe": "0"
        }
    ],
    "Complemento": [
        {
            "Any": [
                {
                    "Pago10:Pagos": {
                        "Pago": [{
                           "FechaPago": "'.$fechapago.'",
                           "FormaDePagoP": "03",
                           "MonedaP": "MXN",
                           "Monto": "'.round($importepago,2).'",
                           "DoctoRelacionado": [{
                              "IdDocumento": "'.$iddocumento.'",
                              "Folio": "'.$foliofactura.'",
                              "MonedaDR": "MXN",
                              "MetodoDePagoDR": "PPD",
                              "NumParcialidad": "'.$noparcialidad.'",
                              "ImpSaldoAnt": "'.round($saldoanterior,2).'", 
                              "ImpPagado": "'.round($importepago,2).'",
                              "ImpSaldoInsoluto": "'.round($saldoanterior-$importepago,2).'"
                           }]
                        }]
                     }
                }
            ]
        }
    ]
 }
'; 
//echo $json;


swTimbrado($json, $rfc, $folio);

function generateQr($qrCode, $rfc, $png){
    $basePath = "../../../DocsClientes/{$rfc}/";  
    if(!imagepng(imagecreatefromstring(base64_decode($qrCode)), $basePath.$png)){
        echo "Error al crear";
    } 
}

function generateXml($xml, $rfc, $xmln){
    
    $basePath  = "../../../DocsClientes/{$rfc}/".$xmln;
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



function swTimbrado($toSend, $rfc, $folio){
    // print_r(json_pretty_print($toSend));
    $params = array( 
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"desarrollo@grupopetromar.com",
        "password"=> "Petromar+SW"
    );

    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV4($toSend);
    
    if((string)$resultadoJson->status == "success"){
        //insertar folio que timbraste 
        //var_dump($resultadoJson);
        $fecha = date('Y-m-d');
        $png = "LACAJAMZT-COMPLEMENTO-{$folio}-{$fecha}.png";
        $xmln = "LACAJAMZT-COMPLEMENTO-{$folio}-{$fecha}.xml";
        generateQr($resultadoJson->data->qrCode, $rfc, $png);
        $rutaxml = generateXml($resultadoJson->data->cfdi, $rfc, $xmln);
        
        $crxml=new crXml(); 
        $xml = file_get_contents($rutaxml);
        $crxml->loadXML($xml); 
        $Comprobantee = 'cfdi:Comprobante';
        $Complemento = 'cfdi:Complemento';
        $timbreFiscalDigital = 'tfd:TimbreFiscalDigital';
        $uuidC = $crxml->$Comprobantee->$Complemento->$timbreFiscalDigital;
        $uuid = $uuidC['UUID'];
        //update pagoaplicacion set timbrado 1, guardar informacion del complemento 

       /* updateBD(
            $resultadoJson->data->fechaTimbrado,
            $resultadoJson->data->uuid,
            $rutaxml,
            $folio
        );*/
        //sendMail($xmln);// mandar hasta generar el pdf 
        $respuesta = array();
        $respuesta[] = array(
            "respuesta" => "1",
            "factura" => $rutaxml,
            "nombre" => "LACAJAMZT-COMPLEMENTO-{$folio}-{$fecha}",
            "Xml" => $uuid
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
 
?>