<?php 

//Helper function getting exchanges rate from blockchain. Called in the generator, for converting the amount in bitcoin
function getRates($currencies){
    $response=array();
    $json = file_get_contents('https://blockchain.info/ticker');
    $result = json_decode($json, true);
    foreach ($currencies as $currency) {
        $response[$currency]=$result[$currency]['last'];
    }
    return $response;
}

if(isset($_GET["request"])){
    //A bit dirty, but useful for the jquery in the index.html page
    echo(file_get_contents('https://blockchain.info/ticker'));
}
 ?>