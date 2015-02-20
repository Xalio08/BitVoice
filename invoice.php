<?php
class Invoice{
    private $invoiceId;
    private $totalAmount;
    private $leftAmount;
    private $destinationAddress;
    private $state;
    private $expirationDate;

    const BITCOIN_ADDRESS = "1PyHmhotZJu4ULjnzQyCdEt8FAZBTe4Ywx";
    const ROOTURL = 'https://blockchain.info/api/receive';
    const CALLBACK = 'http://astraliagency.fr/Bitvoice/callback.php';
    
    /**
     * Gets the value of totalAmount.
     *
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    
    /**
     * Gets the value of leftAmount.
     *
     * @return mixed
     */
    public function getLeftAmount()
    {
        return $this->leftAmount;
    }
    
    /**
     * Gets the value of destinationAddress.
     *
     * @return mixed
     */
    public function getDestinationAddress()
    {
        return $this->destinationAddress;
    }
    
    /**
     * Gets the value of state.
     *
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

        /**
     * Gets the value of invoiceId.
     *
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

            /**
     * Gets the value of expirationDate.
     *
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Sets the value of totalAmount.
     *
     * @param mixed $totalAmount the totalAmount
     *
     * @return self
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Sets the value of leftAmount.
     *
     * @param mixed $leftAmount the leftAmount
     *
     * @return self
     */
    public function setLeftAmount($leftAmount)
    {
        $this->leftAmount = $leftAmount;

        return $this;
    }

    /**
     * Sets the value of destinationAddress.
     *
     * @param mixed $destinationAddress the destinationAddress
     *
     * @return self
     */
    public function setDestinationAddress($destinationAddress)
    {
        $this->destinationAddress = $destinationAddress;

        return $this;
    }

        /**
     * Sets the value of invoiceId.
     *
     * @param mixed $invoiceId the invoiceId
     *
     * @return self
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

        /**
     * Sets the value of expirationDate.
     *
     * @param mixed $expirationDate the expirationDate
     *
     * @return self
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Sets the value of state.
     *
     * @param mixed $state the state
     *
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    private function __construct($amount){
        $this->invoiceId=uniqid();
        $this->state="partiallyPaid";
        $this->totalAmount=$amount;
        $this->leftAmount=$amount;
        $this->expirationDate=date("Y-m-d H:i:s", strtotime('+1 hour'));//I have choosen to set the expiration date one hour after the creation of th invoice
        $this->destinationAddress=$this->GenerateAddress();
    }

    public static function makeNewInvoice($amount) {//Initialization of an invoice with a random ID
        $invoice = new Invoice($amount);
        return $invoice;
    }

    public static function makeNewInvoiceWithId($invoiceId, $amount) {//Initialization of an invoice with a specific IF
        $invoice = new Invoice($amount); 
        $invoice->setInvoiceId($invoiceId);
        return $invoice;
    }

    private function GenerateAddress(){
        //Generation of a new bitcoin address based on the one provided. All the bitcoins are redirected toward the BITCOIN_ADDRESS constant
        $callback_url=self::CALLBACK."?invoice_id=".$this->invoiceId;
        $parameters = 'method=create&address=' . self::BITCOIN_ADDRESS .'&callback='. urlencode($callback_url);
        $response = file_get_contents( self::ROOTURL. '?' . $parameters);
        $object = json_decode($response);

        //Address to which the bitcoin should be sent by the user
        return $object->input_address;
}

    public function recordInvoice($db){
        //Record an Invoice Object into the database
        $req = $db->prepare('INSERT INTO invoices (invoice_id,total_amount,left_amount,destination_address,state,expiration_date) VALUES(:invoice_id, :total_amount, :left_amount,:destination_address,:state,:expiration_date)');
        $req->execute(array('invoice_id' => $this->invoiceId,
            'total_amount' => $this->totalAmount,
            'left_amount'=>$this->leftAmount,
            'destination_address'=>$this->destinationAddress,
            'state'=>$this->state,
            'expiration_date'=>$this->expirationDate));
        $req->closeCursor();
    }

    public function deleteInvoice($db){
        //Deleting an invoice object
        $req = $db->prepare('DELETE FROM invoices  WHERE invoice_id=:invoice_id');
        $req->execute(array('invoice_id' => $this->invoiceId));
        $req->closeCursor();
    }

    public static function getInvoice($db,$invoiceId){
        //Retrieve an invoice object object from the database
        $stmt = $db->prepare("SELECT * FROM invoices where invoice_id = ?");
        if ($stmt->execute(array($invoiceId))){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $invoice=self::makeNewInvoiceWithId($row["invoice_id"],$row["total_amount"]);
                $invoice->setLeftAmount($row["left_amount"]);
                $invoice->setExpirationDate($row["expiration_date"]);
                $invoice->setDestinationAddress($row["destination_address"]);
                if(time() - strtotime($invoice->getExpirationDate())>0){//The expired date has passed
                    $invoice->setState("expired");
                }
                else if($invoice->getLeftAmount()==0){
                    $invoice->setState("paid");
                }
                else{
                    $invoice->setState("partiallyPaid");//not necesary, here for clarity
                }
                return $invoice;
            }
        }
        return null;
    }

    public function updateInvoice($db){
        //Update the values of an Invoice object
        $req = $db->prepare('UPDATE invoices SET left_amount=:left_amount,state=:state WHERE invoice_id=:invoice_id');
        $req->execute(array('invoice_id' => $this->invoiceId,
            'left_amount'=>$this->leftAmount,
            'state'=>$this->state));
        $req->closeCursor();
    }


    public static function getAllIds($db){
        $response= array();
        $stmt = $db->prepare("SELECT invoice_id FROM invoices");
        if ($stmt->execute() ){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $response[]=$row["invoice_id"];
            }
            return $response;
        }
    }
}

