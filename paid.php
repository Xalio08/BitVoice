<!-- View displaying a paid invoice, called by the generator-->
<div class="col-sm-6 col-md-6 col-lg-5 ">
    <div class="account-wall">
        <h3 class="text-center"> Invoice Paid</h3>
          <div>
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge"><?php echo($invoice->getTotalAmount()) ?> BTC</span>
                    Invoice amount
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo($invoice->getDestinationAddress()) ?> </span>
                    Destination Address
                </li>
            </ul>
        </div>
    </div>
</div>
