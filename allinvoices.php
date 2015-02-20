<?php
/* Admin page used to delete invoices or view previous invoices*/
include 'include.php';
include 'invoice.php';
include 'rates.php';

//Connection to the database
$db=connectDB($mysql_host,$mysql_database,$mysql_username,$mysql_password);

$arrayIDs=Invoice::getAllIds($db);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BitVoice Generator</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1 class="text-center">BitVoice Generator</h1>

    <div class="container">
        <div class="row">
            <table class="table table-hover">
                <tr>
                    <th>Invoice ID</th>
                    <th>Invoice Amount</th>
                    <th>State</th>
                    <th>Expiration Date</th>
                    <th>Address</th>
                    <th></th>
                    <th></th>
                </tr>

<?php
foreach ($arrayIDs as $invoiceId) {
    $invoice=Invoice::getInvoice($db,$invoiceId);
    ?>
                <tr class="invoice-row">
                    <td><?php echo($invoice->getInvoiceId())?></td>
                    <td><?php echo($invoice->getTotalAmount())?></td>
                    <td><?php echo($invoice->getState())?></td>
                    <td><?php echo($invoice->getExpirationDate())?></td>
                    <td><?php echo($invoice->getDestinationAddress())?></td>
                    <td>
                        <button value="<?php echo($invoice->getInvoiceId()) ?>" class="btn-primary btn btn-details">Show Details</button>
                    </td>
                    <td>
                        <button value="<?php echo($invoice->getInvoiceId()) ?>" class="btn-danger btn btn-delete">Delete</button>
                    </td>
                </tr>
    <?php
}
?>

            </table>
        </div>
        <div class="row" id="details">
        </div>
    </div>
  </body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">

        //Script calling the generator when a resfresh button is pressed
        $(".btn-details").click(function(){
            var invoiceId = $(this).attr("value");
            $.ajax({
                type: "GET",
                url: "generator.php",
                data: { invoice_id: invoiceId,
                    action:"display"},
                success: function(response){
                    $('#details').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });

        $(".btn-delete").click(function(){
            var invoiceId = $(this).attr("value");
            var row =$(this).parent().parent();
            $.ajax({
                type: "GET",
                url: "generator.php",
                data: { invoice_id: invoiceId,
                    action:"delete"},
                success: function(response){
                    row.remove();
                    $("#details").empty();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    </script>
</html>