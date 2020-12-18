<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\CieloSerializable;

class PaymentFraudAnalysis implements \JsonSerializable, CieloSerializable
{

    /**
     * @var string
     */
    private $provider;

    /**
     * @var integer
     */
    private $totalOrderAmount;

    /**
     * @var array
     */
    private $browser;

    /**
     * @var array
     */
    private $cart;

    /**
     * @var array
     */
    private $merchantDefinedFields;

    /**
     * @var array
     */
    private $shipping;

    /**
     * SplitPayment constructor.
     */
    public function __construct()
    {
        $this->browser = new \stdClass();
        $this->browser->ipAddress = null;
        $this->browser->browserFingerPrint = null;

        $this->cart = new \stdClass();
        $this->cart->isgift = false;
        $this->cart->returnsaccepted = false;
        $this->cart->items = null;

        $this->merchantDefinedFields = new \stdClass();
        $this->merchantDefinedFields->items = null;

        $this->shipping = new \stdClass();
        $this->shipping->addressee = null;
        $this->shipping->phone = null;
    }

    /**
     * @param string $json
     *
     * @return SplitPayment
     */
    public static function fromJson($json)
    {
        $object    = \json_decode($json);
        $paymentFraudAnalysis = new PaymentFraudAnalysis();
        $paymentFraudAnalysis->populate($object);

        return $paymentFraudAnalysis;
    }

    /**
     * @inheritdoc
     */
    public function populate(\stdClass $data)
    {
        $this->provider                     = $data->provider ?? null;
        $this->totalOrderAmount             = $data->totalOrderAmount ?? null;
        $this->browser->ipAddress           = $data->browser->ipAddress ?? null;
        $this->browser->browserFingerPrint  = $data->browser->browserFingerPrint ?? null;
        $this->cart->items                  = $data->cart->items ?? null;
        $this->cart->returnsaccepted        = $data->cart->returnsaccepted ?? false;
        $this->cart->isgift                 = $data->cart->isgift ?? false;
        $this->merchantDefinedFields->items = $data->merchantDefinedFields->items ?? null;
        $this->shipping->addressee          = $data->shipping->addressee ?? null;
        $this->shipping->phone              = $data->shipping->phone ?? null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {

        $objects = get_object_vars($this);

        $json = [];

        foreach($objects as $obj => $value){
            switch($obj){
                case 'provider':
                case 'totalOrderAmount':
                    if(!empty($value)) {
                        $json[$obj] = $value;
                    }
                    break;
                case 'browser':
                    if(!empty($value->ipAddress)) {
                        $json[$obj]['ipAddress'] = $value->ipAddress;
                    }

                    if(!empty($value->browserFingerPrint)) {
                        $json[$obj]['browserFingerPrint'] = $value->browserFingerPrint;
                    }
                    break;
                case 'cart':
                    $json[$obj]['isgift'] = $value->isgift;

                    $json[$obj]['returnsaccepted'] = $value->returnsaccepted;

                    if(!empty($value->items)) {
                        $json[$obj]['items'] = $value->items;
//                        $json[$obj] = $value->items;
                    }
                    break;
                case 'merchantDefinedFields':
                    if(!empty($value->items)) {
//                        $json[$obj]['items'] = $value->items;
                        $json[$obj] = $value->items;
                    }
                    break;
                case 'shipping':
                    if(!empty($value->addressee)) {
                        $json[$obj]['addressee'] = $value->addressee;
                    }
                    if(!empty($value->phone)) {
                        $json[$obj]['phone'] = $value->phone;
                    }
                    break;
            }
        }

        return $json;

//        get_object_vars($this);
//        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider ?? null;
    }

    /**
     * @param $provider
     *
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalOrderAmount()
    {
        return $this->totalOrderAmount ?? null;
    }

    /**
     * @param $totalOrderAmount
     *
     * @return $this
     */
    public function setTotalOrderAmount($totalOrderAmount)
    {
        $this->totalOrderAmount = $totalOrderAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser ?? null;
    }

    /**
     * @param $ipAddress
     *
     * @return $this
     */
    public function setBrowserIpAddress($ipAddress)
    {
        $this->browser->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @param $browserFingerPrint
     *
     * @return $this
     */
    public function setBrowserFingerPrint($browserFingerPrint)
    {
        $this->browser->browserFingerPrint = $browserFingerPrint;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param $returnsaccepted
     *
     * @return $this
     */
    public function setCartReturnsAccepted($returnsaccepted)
    {
        $this->cart->returnsaccepted = $returnsaccepted;

        return $this;
    }

    /**
     * @param $isgift
     *
     * @return $this
     */
    public function setCartIsGift($isgift)
    {
        $this->cart->isgift = $isgift;

        return $this;
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function putCartItems(array $items)
    {
        $this->cart->items[] = $items;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantDefinedFields()
    {
        return $this->merchantDefinedFields;
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function putMerchantDefinedFieldsItems(array $items)
    {
        $this->merchantDefinedFields->items[] = $items;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping ?? null;
    }

    /**
     * @param $addressee
     *
     * @return $this
     */
    public function setShippingAddressee($addressee)
    {
        $this->shipping->addressee = $addressee;

        return $this;
    }

    /**
     * @param $phone
     *
     * @return $this
     */
    public function setShippingPhone($phone)
    {
        $this->shipping->phone = $phone;

        return $this;
    }
}
