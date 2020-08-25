<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\Customer as CustomerCielo;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Address;

class Customer extends CustomerCielo
{
    /**
     * @var array $billingAddress
     */
    private $billingAddress;

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $this->billingAddress    = $data->billingAddress ?? null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $obj = parent::jsonSerialize();
        $obj['billingAddress'] = $this->billingAddress;

//        return fx_array_filter_recursive(
//            fx_cast_to_array_recursive(
//                get_object_vars($obj)
//            )
//        );

        return $obj;
    }

    /**
     * @return Address
     */
    public function billingAddress()
    {
        $address = new Address();

        $this->setBillingAddress($address);

        return $address;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param $billingAddress
     *
     * @return $this
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }
}
