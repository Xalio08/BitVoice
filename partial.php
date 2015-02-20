<?php
$QrCodeUrl="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:".$invoice->getDestinationAddress()."?amount=".$invoice->getLeftAmount();
?>
<div class="col-sm-6 col-md-6 col-lg-5 text-center" id="<?php echo($invoice->getInvoiceId())?>" >
  <div class="account-wall form-signin">
  
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
          <span class="badge"><?php echo($invoice->getDestinationAddress()) ?> </span>
          Destination Address
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

