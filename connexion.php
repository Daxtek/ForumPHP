<?php

require("connect.php");

#Permet la connection a la base de donnée
function connect_bd()
{
	$dsn="mysql:dbname=".BASE.";host=".SERVER;
    try{
      $connexion = new PDO($dsn,USER,PASSWD);
      $connexion->exec("SET CHARACTER SET utf8");
    }
    catch(PDOException $e){
      printf("Échec de la connexion : %s\n", $e->getMessage());
      exit();
    }
    return $connexion;
}

?>