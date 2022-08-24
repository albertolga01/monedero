<?php

require_once('conexion.php'); 
require_once('api.php');
require_once('cors.php');
 
$connect = mysqli_connect("localhost", "root", "", "compras");
$conexion = new Conexion();
$db = $conexion->getConexion();
$input = file_get_contents('php://input');
$input = json_decode($input);

 session_start();
    //IF DATA IS RECEIVED
if(isset($input)){ 


    $Query = "SELECT * FROM usuarios WHERE Usuario = '".$input[0]."' AND Contra = '".$input[1]."'"; 
   
    $consultau = $db->prepare($Query);
    $consultau->execute();

    while($filau = $consultau->fetch()){
        $usuario = $filau["usuario"]; 
    }
    if(isset($usuario)){
       // $_SESSION['user'] = "aaqa";
      echo "1";
    }else{
       echo "0";
    }

      
}else{
   echo "N00N";
}

?>