<!-- Page displaying an expired invoice, called by the generator-->

<div class="col-sm-6 col-md-6 col-lg-4 ">
  <div class="account-wall">
    <h3 class="text-center"> Invoice expired</h3>
    <div>
      <ul class="list-group">
        <li class="list-group-item">
          <span class="badge"><?php echo($invoice->getTotalAmount()) ?> BTC</span>
          Invoice amount
        </li>
        <li class="list-group-item">
          <span class="badge"><?php echo($invoice->getLeftAmount()) ?> BTC</span>
          Amount left to pay
        </li>
        <li class="list-group-item">
          <span class="badge"><?php echo($invoice->getExpirationDate()) ?></span>
          Expiration Date
        </li>
      </ul>
    </div>
  </div>
</div>