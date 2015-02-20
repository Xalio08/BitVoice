<?php
//Main controller

include 'include.php';
include 'invoice.php';
include 'rates.php';

//Connection to the database
$db=connectDB($mysql_host,$mysql_database,$mysql_username,$mysql_password);


if(isset($_GET["invoice_id"])){
    //This means that the invoice already exists

    //Retrieving the invoice from the database
    $invoice= invoice::getInvoice($db,$_GET["invoice_id"]);

    //According to the state of the database, displaying a different view

    if($_GET["action"]=="display"){//We want the details of the invoice. This method is called by the refresh script and the admin board
        if($invoice->getState()=="paid")//The invoice has been completely paid
            include("paid.php");
        else if($invoice->getState()=="expired")//The invoice has expired
            include("expired.php");
        else//The invoice has been partially paid
            include("partial.php");
    }
    else if($_GET["action"]=="delete"){//Called from the admin board to delete an invoice
        $invoice->deleteInvoice($db);
    }
}

else{//There is no id in the request, we have to create a new invoice

    if(isset($_GET["amount"])&& isset($_GET["currency"])){
        $amount=$_GET["amount"];
        $currency=$_GET["currency"];

        if($currency!="BTC"){
            //The user selected a fiat currency, we convert the amount to bitcoin before creating the invoice
            $rate=getRates($currencies)[$currency];//We get the exchange rate for the selected currency
            $amount=round($amount/$rate,6);//10e-6 seems enough
        }

        //Creation of a new invoice with a random identifier
        $invoice=Invoice::makeNewInvoice($amount);

        //Recording of the new invoice in the database
        $invoice->recordInvoice($db);

        //Displaying of the partially paid view, as the invoice as just been created
        include("partial.php");
    }
}
?>