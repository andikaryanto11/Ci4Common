<?php

class MidtransLib
{
    private $addition            = 0;
    private $deduction           = 0;
    private $ordernumber         = null;
    private $paymentMethods      = [];
    private $customerDetails     = [];
    private $ItemDetails         = [];
    private $billingAddress      = [];
    private $shippingAddress     = [];
    private static $isProduction = false;

    public function __construct()
    {
        $this->setPaymentMethod(['gopay', 'bank_transfer']);
    }
    /**
     * @param  array paymentMethods
     * @return object
     */
    public function setPaymentMethod($paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
        return $this;
    }

    /**
     * @param  string id
     * @param  string price
     * @param  string quantity
     * @param  string name
     * @return object
     */
    public function setItemDetails($id, $price, $quantity, $name)
    {
        $this->ItemDetails[] = [
            'id'       => $id,
            'price'    => $price,
            'quantity' => $quantity,
            'name'     => $name,
        ];
        return $this;
    }

    /**
     * @param int addition
     */
    public function setAddition($addition)
    {
        $this->addition      = $addition;
        $this->ItemDetails[] = [
            'id'       => rand(),
            'price'    => $addition,
            'quantity' => 1,
            'name'     => 'addition',
        ];
        return $this;
    }

    /**
     * @param int addition
     */
    public function setDeduction($deduction)
    {
        $this->deduction     = $deduction;
        $this->ItemDetails[] = [
            'id'       => rand(),
            'price'    => -1 * $deduction,
            'quantity' => 1,
            'name'     => 'deduction',
        ];
        return $this;
    }

    /**
     * @param  string first_name
     * @param  string last_name
     * @param  string address
     * @param  string city
     * @param  string phone
     * @param  string country_code
     * @return object
     */
    public function setBillingAddress($firstName, $lastName, $address, $city, $postalCode, $phone, $countryCode)
    {
        $this->billingAddress = [
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'address'      => $address,
            'city'         => $city,
            'postal_code'  => $postalCode,
            'phone'        => $phone,
            'country_code' => $countryCode,
        ];
        return $this;
    }

    /**
     * @param  string first_name
     * @param  string last_name
     * @param  string address
     * @param  string city
     * @param  string phone
     * @param  string country_code
     * @return object
     */
    public function setShippingAddress($firstName, $lastName, $address, $city, $postalCode, $phone, $countryCode)
    {
        $this->shippingAddress = [
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'address'      => $address,
            'city'         => $city,
            'postal_code'  => $postalCode,
            'phone'        => $phone,
            'country_code' => $countryCode,
        ];
        return $this;
    }

    /**
     * @param string
     */
    public function setOrderNumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
        return $this;
    }

    /**
     * @return array
     */
    private function getTransactionDetails()
    {
        $transaction_details = [
            'order_id'     => $this->ordernumber,
            'gross_amount' => 0, // no decimal allowed for creditcard
        ];

        foreach ($this->ItemDetails as $item) {
            $transaction_details['gross_amount'] += $item['price'] * $item['quantity'];
        }

        $transaction_details['gross_amount'] += $this->addition;
        $transaction_details['gross_amount'] -= $this->deduction;

        return $transaction_details;
    }

    /**
     * @param  string first_name
     * @param  string last_name
     * @param  string email
     * @param  string phone
     * @return object
     */
    public function setCustomer($firstName, $lastName, $email, $phone)
    {
        $this->customerDetails = [
            'first_name'      => $firstName,
            'last_name'       => $lastName,
            'email'           => $email,
            'phone'           => $phone,
            'billingAddress'  => $this->billingAddress,
            'shippingAddress' => $this->shippingAddress,
        ];

        return $this;
    }

    /**
     * @return string token
     */
    public function getToken()
    {
        $this->setConfiguration();
        $params = [
            'enabled_payments'    => $this->paymentMethods,
            'transaction_details' => $this->getTransactionDetails(),
            'customerDetails'     => $this->customerDetails,
            'ItemDetails'         => $this->ItemDetails,
        ];
        // return $params;
        return \Midtrans\Snap::getSnapToken($params);
    }

    private function setConfiguration()
    {
        $key                            = ! self::$isProduction ? 'SB-Mid-server-LMZDiYoZ1-2uQINDKl4kmw_R' : 'Change to production key here dude' ;
        \Midtrans\Config::$serverKey    = $key;
        \Midtrans\Config::$isProduction = self::$isProduction;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
        return $this;
    }

    public function notification()
    {
        $this->setConfiguration();
        $notif = new \Midtrans\Notification();
        return $notif;
    }

    public static function cancel($orderId)
    {
        // if(!self::$isProduction)
        //     return true;
        $instance = new self();
        $instance->setConfiguration();
        return \Midtrans\Transaction::cancel($orderId) === '200';
    }

    public static function refund($noref, $transNo, $amout, $reason)
    {
        // if(!self::$isProduction)
        //     return true;
        $params   = [
            'refund_key' => $transNo . '-ref-' . $noref,
            'amount'     => $amout,
            'reason'     => $reason,
        ];
        $instance = new self();
        $instance->setConfiguration();
        $refund = \Midtrans\Transaction::refund($noref, $params);
        return ((object)$refund)->status_code === '200';
    }
}
