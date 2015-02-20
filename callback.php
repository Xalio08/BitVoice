<?php
include 'include.php';
include 'invoice.php';

//Retrieveing the data from the blockchain

//$transaction_hash = $_GET['transaction_hash'];
$valueInBtc = $_GET['value'] / 100000000;

if(isset($_GET["invoice_id"])){

  //Connection to the database
  $db=connectDB($mysql_host,$mysql_database,$mysql_username,$mysql_password);

  //Retrieving the invoice from the database
  $invoice= invoice::getInvoice($db,$_GET["invoice_id"]);

  if($invoice!=null){

    //Updating the amount 
    if($invoice->getLeftAmount()-$valueInBtc>=0)
      $leftAmount=$invoice->getLeftAmount()-$valueInBtc;
    else
      $leftAmount=0;
    $invoice->setLeftAmount($leftAmount);//Check, must be >0

    //Updating the state if necessary
    if($invoice->getLeftAmount()==0){
      $invoice->setState("paid");
    }

    //Saving the changes in the database
    $invoice->updateInvoice($db);
  }
}
?>