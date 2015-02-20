<?php
$QrCodeUrl="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:".$invoice->getDestinationAddress()."?amount=".$invoice->getLeftAmount();
?>
<div id="<?php echo($invoice->getInvoiceId())?>">
  <div class="col-sm-12 col-md-6 col-lg-5 text-center"  >
    <div class="account-wall">
      <div class="qr-code">
        <img src=<?php echo($QrCodeUrl) ?> />
      </div>

      <div class="details">
        <ul class="list-group">
          <li class="list-group-item">
            <span class="badge"><?php echo($invoice->getTotalAmount()) ?> BTC</span>
            Invoice total amount
          </li>
          <li class="list-group-item">
            <span class="badge"><?php echo($invoice->getLeftAmount()) ?> BTC</span>
            Amount left to be paid
          </li>
          <li class="list-group-item">
            Destination Address<br>
            <span class="badge text-center"><?php echo($invoice->getDestinationAddress()) ?></span><br>
          </li>
          <li class="list-group-item">
            <span class="badge"><?php echo($invoice->getExpirationDate()) ?> </span>
            Expiration Date
          </li>
        </ul>
      </div>

      <input type="hidden" value=<?php echo($invoice->getInvoiceId()) ?>>
      <button class="btn btn-lg btn-primary btn-block btn-refresh">
        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh
      </button>

    </div>
  </div>
</div>


<script type="text/javascript">
        //Script calling the generator when a resfresh button is pressed
        $(".btn-refresh").click(function(){
            var invoiceId = $(this).prev().val();
            $.ajax({
                type: "GET",
                url: "generator.php",
                data: { invoice_id: invoiceId,
                  action:"display"},
                success: function(response){
                    $('#'+invoiceId).html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    </script>