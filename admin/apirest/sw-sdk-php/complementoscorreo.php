<?php
  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/SMTP.php";
require_once('../conexion.php');
setlocale(LC_MONETARY, 'es_MX');

$folio = $_POST['folio'];
$cte = $_POST['cte'];
$complemento = $_POST['complemento'];

  $conexion = new Conexion();
  $db = $conexion->getConexion();
  $Query = "SELECT * FROM pagosaplicaciones WHERE folio_p='{$folio}'";
  $consultad = $db->prepare($Query);
  $consultad->execute();
  while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
    $res[] = $filau;
  }
  $resPagoapp= (array)$res[0];
  $Query1 = "SELECT rzonsocial, contacto FROM clientes WHERE idcliente='{$cte}'";
  $consultad = $db->prepare($Query1);
  $consultad->execute();
  while($filau1 = $consultad->fetch(PDO::FETCH_OBJ)){
    $res1[] = $filau1;
  }
  $servicio1= (array)$res1[0];
  $nombre = $servicio1['rzonsocial'];
  $correo = $servicio1['contacto'];
  $importe = $resPagoapp['importe'];
  $abono = $resPagoapp['abono'];
  $fecha = $resPagoapp['fechacaptura'];
  $idfactura = $resPagoapp['idfactura'];
  /*$fecha = substr($fecha, -19,10);
  //$estacion = $servicio['estacion'];

  //$tarjeta = $servicio['tarjeta'];
  //$tarjeta = substr($tarjeta, -4);
  //$litros = $servicio['litros'];
  $QueryEst = "SELECT nombre FROM estaciones WHERE idestacion='{$estacion}'";
  $consultad = $db->prepare($QueryEst);
  $consultad->execute();
  while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
    $res2[] = $filau;
  }
  $NomEstacion= (array)$res2[0];
  $NomEstacion=$NomEstacion['nombre'];

  $QueryProd = "SELECT nombre FROM productos WHERE folio='{$prod}'";
  $consultad = $db->prepare($QueryProd);
  $consultad->execute();
  while($filau = $consultad->fetch(PDO::FETCH_OBJ)){
    $res3[] = $filau;
  }
  $producto1= (array)$res3[0];
  $producto=$producto1['nombre'];*/


		 
		  $enviado = sendMail($nombre,$correo,$importe,$fecha,$abono,$complemento,$idfactura);
			if($enviado){
				echo "Enviado";
			}else{
        echo "0";
      }
      
      
      function formatDate($toFormat){
        $data1 = explode(" ", $toFormat);
        $data = explode("-", $data1[0]);
        $formattedDate = $data[2]."/".$data[1]."/".$data[0]." ".$data1[1];
        return $formattedDate;
    }


function sendMail($nombre,$correo,$importe,$fecha,$abono,$complemento,$idfactura){
    try{
        $mail = new PHPMailer(true);
        $mail->isMail();
        $mail->Host = 'host.grupopetromar.com';
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = "ssl";
        $mail->Username = 'desarrollosistemas@grupopetromar.com';
        $mail->Password = 'nAUZ3N4zMw';
        $mail->Port = 465;   

        //Recipients
        $mail->setFrom('auxdesarrollo@grupopetromar.com', 'La Caja');
        $mail->addAddress($correo, $nombre);

        //Attachments  
        $mail->addAttachment('../../../DocsClientes/CPE190207226/'.$complemento.'.xml');
        $mail->addAttachment('../../../DocsClientes/CPE190207226/'.$complemento.'.pdf');
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Monedero Complemento';
        $mail->Body    = '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <meta charset="utf-8"> <!-- utf-8 works for most cases -->
            <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldnt be necessary -->
            <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
            <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
            <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
        
        
            <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
        
            <!-- CSS Reset : BEGIN -->
        <style>
        
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }
        
        /* What it does: Stops email clients resizing small text. */
      *{
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        
        /* What it does: Centers email on Android 4.4 */
       div[style*="margin: 16px 0"] {
          margin: 0 !important;
        }
        
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        
        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
       }
        
        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }
        
        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
       .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        
        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
        
        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }
        
        /* If the above doesnt work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }
        
        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size youd like to fix */
      
        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
      @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
       @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }
        
        </style>
        
            <!-- CSS Reset : END -->
        
            <!-- Progressive Enhancements : BEGIN -->
        <style>
        
        .primary{
          background: #f3a333;
        }
        
        .bg_white{
          background: #ffffff;
        }
        .bg_light{
          background: #fafafa;
        }
        .bg_black{
          background: #000000;
        }
        .bg_dark{
          background: rgba(0,0,0,.8);
        }
        .email-section{
          padding:2.5em;
        }
        
        /*BUTTON*/
        .btn{
          padding: 10px 15px;
        }
        .btn.btn-primary{
          border-radius: 30px;
          background: #f3a333;
          color: #ffffff;
        }
        
        
        
        h1,h2,h3,h4,h5,h6{
          font-family: "Playfair Display", serif;
          color: #000000;
          margin-top: 0;
        }
        
        body{
          font-family: "Montserrat", sans-serif;
          font-weight: 400;
          font-size: 15px;
          line-height: 1.8;
          color: rgba(0,0,0,.4);
        }
        
        a{
          color: #f3a333;
        }
        
        table{
        }
        /*LOGO*/
        
        .logo h1{
          margin: 0;
        }
        .logo h1 a{
          color: #000;
          font-size: 20px;
          font-weight: 700;
          text-transform: uppercase;
          font-family: "Montserrat", sans-serif;
        }
        
        /*HERO*/
        .hero{
          position: relative;
        }
        .hero img{
        
        }
        .hero .text{
          color: rgba(255,255,255,.8);
        }
        .hero .text h2{
          color: #ffffff;
          font-size: 30px;
          margin-bottom: 0;
        }
        
        
        /*HEADING SECTION*/
        .heading-section{
        }
        .heading-section h2{
          color: #000000;
          font-size: 28px;
          margin-top: 0;
          line-height: 1.4;
        }
        .heading-section .subheading{
          margin-bottom: 20px !important;
          display: inline-block;
          font-size: 13px;
          text-transform: uppercase;
          letter-spacing: 2px;
          color: rgba(0,0,0,.4);
          position: relative;
        }
        .heading-section .subheading::after{
          position: absolute;
          left: 0;
          right: 0;
          bottom: -10px;
          content: "";
          width: 100%;
          height: 2px;
          background: #f3a333;
          margin: 0 auto;
        }
        
        .heading-section-white{
          color: rgba(255,255,255,.8);
        }
        .heading-section-white h2{
          font-size: 28px;
          font-family: 
          line-height: 1;
          padding-bottom: 0;
        }
        .heading-section-white h2{
          color: #ffffff;
        }
        .heading-section-white .subheading{
          margin-bottom: 0;
          display: inline-block;
          font-size: 13px;
          text-transform: uppercase;
          letter-spacing: 2px;
          color: rgba(255,255,255,.4);
        }
        
        
        .icon{
          text-align: center;
        }
        .icon img{
        }
        
        
        /*SERVICES*/
        .text-services{
          padding: 10px 10px 0; 
          text-align: center;
          width : 100%;
        }
        .text-services h3{
          font-size: 20px;
        }
        
        /*BLOG*/
        .text-services .meta{
          text-transform: uppercase;
          font-size: 14px;
          width : 100%;
        }
        
        /*TESTIMONY*/
        .text-testimony .name{
          margin: 0;
        }
        .text-testimony .position{
          color: rgba(0,0,0,.3);
        
        }
        
        
        /*VIDEO*/
        .img{
          width: 100%;
          height: auto;
          position: relative;
        }
        .img .icon{
          position: absolute;
          top: 50%;
          left: 0;
          right: 0;
          bottom: 0;
          margin-top: -25px;
        }
        .img .icon a{
          display: block;
          width: 60px;
          position: absolute;
          top: 0;
          left: 50%;
          margin-left: -25px;
        }
        
        
        
        /*COUNTER*/
       .counter-text{
          text-align: center;
        }
        .counter-text .num{
          display: block;
          color: #ffffff;
          font-size: 34px;
          font-weight: 700;
        }
        .counter-text .name{
          display: block;
          color: rgba(255,255,255,.9);
          font-size: 13px;
        }
        
        
        /*FOOTER*/
        
        .footer{
          color: rgba(255,255,255,.5);
        
        }
        .footer .heading{
          color: #ffffff;
          font-size: 20px;
        }
        .footer ul{
          margin: 0;
          padding: 0;
        }
        .footer ul li{
          list-style: none;
          margin-bottom: 10px;
        }
        .footer ul li a{
          color: rgba(255,255,255,1);
        }
        
        
        @media screen and (max-width: 500px) {
        
          .icon{
            text-align: left;
          }
        
          .text-services{
            padding-left: 0;
            padding-right: 20px;
            text-align: center;
          }
        
        }
        
        </style>
        
        
        </head>
        
        <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;align="center" background-color: #222222;">
          <center style="width: 100%; background-color: #f1f1f1;">
            <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
              &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
            </div>
            <div style="max-width: 100%; margin: 0 auto;align="center"" class="email-container">
              <!-- BEGIN BODY -->
              <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tr>
                  <td class="bg_white logo" style="padding: 1em 2.5em; text-align: center; background-color: #337ab7;">
                    <h1 style="color: white;">La Caja de Mazatlan</h1>
                  </td>
                </tr><!-- end tr -->
                <tr>
                  <td valign="middle" class="hero" style="background-image: url(https://monedero.grupopetromar.com/admin/imagenes/mosaicos.png); background-size: cover; height: 400px;">
                    <table style="width: 100%;">
                      <tr>
                        <td>
                          <div class="text" style="text-align: center;">
                            <h2 style="color: #000;">Notificaci&oacute;n de Complemento</h2>
                            <p><b>Le informamos que se ha generado un complemento con las siguientes caracter&iacute;sticas.</b></p>
                            <p><b>Fecha: '.formatDate($fecha).'</b></p>
                            <p><b>No. Factura: #'.$idfactura.'</b></p>
                            <p><b>Total de Factura: $'.money_format('%i', $importe).'</b></p>
                            <p><b>Importe del abono: $'.money_format('%i', $abono).'</b></p>
                            <p><a href="https://monedero.grupopetromar.com/login.html" class="btn btn-primary">Visita Monedero</a></p>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr><!-- end tr -->
                <tr>
                  <td class="bg_white">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="bg_dark email-section" style="text-align:center;background-color: #337ab7">
                          <div class="heading-section heading-section-white">
                            <h2 class="subheading">Descubre los beneficios que Monedero tiene para ti</h2>
                            <h1 style="color: white;">Cont&aacute;ctanos</h1>
                            <p style="text-decoration: none;">Correo: lacajamzt@grupopetromar.com</p>
                            <p>Tel: (669) 986 1513</p>
                            <p><a href="http://www.lacajademazatlan.com.mx" class="btn btn-primary">Web: http://www.lacajademazatlan.com.mx</a></p>
                          </div>
                        </td>
                      </tr><!-- end: tr -->
                    </table>
                  </td>    
                </tr>
             </table> 
            </div>
          </center>
        </body>
        </html>';//add template
        $mail->AltBody = ' ';//add mensaje

         if(!$mail->send()){
             echo "Error al enviar";
         }else{
			 return true;
		 }
    } catch (Exception $e){
        echo $e;
    }
    
}


?>