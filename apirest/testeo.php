<?php

	$db = new PDO("mysql:host=localhost;dbname=jkmpg7ol_compras;", "jkmpg7ol_sistemas", "5R3U6vvQWI0a");


 	/*
      	$Query = "select * from ordencompra";

      	if($db->query($Query)==TRUE){
		echo $Query;  
          	return $Query;   
      	} else {
		echo "error";
          	return "Error";   
      	}
	*/



$QueryLatest = "select * from ordencompra";

      	$res = $db->prepare($QueryLatest);
      	$res->execute();

      	while($f = $res->fetch()){
		echo "<pre>";
			var_dump($f);
		echo "</pre>";
      	}

$QueryLatest = "select * from requisiciones";

      	$res = $db->prepare($QueryLatest);
      	$res->execute();

      	while($f = $res->fetch()){
		echo "<pre>";
			var_dump($f);
		echo "</pre>";
      	}

?>