<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BitVoice Generator</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>BitVoice Generator</h1>


        <div class="col-lg-6">
    <form action="invoice.php" role="form" method="get">
    <div class="form-group">
        <label for="currency">Currency:</label>
        <select class="form-control" id="currency" name="currency">
            <option value="USD">$</option>
            <option value="GBP">£</option>
            <option value="EUR">€</option>  
            <option value="BTC">฿</option>
        </select>
        <label for="amount">Currency:</label>
        <span class="input-group-addon">$</span>
        <input type="text" id="amount" name="amount" class="form-control" aria-label="Amount (to the nearest dollar)">
    </div>
        <button type="submit" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> Generate invoice
        </button>
    </form>
    </div>
        For infos: Value in bitcoin (JS only when fiat)<br>
        Put the select with the amount (left side)<br>
        Verificators<br>
<!-- /.row -->

<?php 
        $json = file_get_contents('https://bitpay.com/api/rates'); // this WILL do an http request for you
        $result = json_decode($json, true);
        $currencies = array('USD','GBP','EUR');
        foreach ($result as $currency) {
            if(in_array($currency['code'], $currencies)){
                echo("Rate BTC ".$currency["name"].": ".$currency["rate"]."<br>");
            }
        }

?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>