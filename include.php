<?php


//URLs
$blockchain_root = "https://blockchain.info/"; 


//Database local
$mysql_host = 'localhost';
$mysql_username = 'root';
$mysql_password = 'pass';
$mysql_database = 'BitVoice';



//Helper function for connexion to the database
function connectDB($mysql_host,$mysql_database,$mysql_username,$mysql_password){

    try{
        $db = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_database,$mysql_username,$mysql_password);
        return $db;
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }   
}

$currencies = array('USD','GBP','EUR');
?>
