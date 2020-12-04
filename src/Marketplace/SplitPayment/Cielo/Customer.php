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
    private $phone;
    private $mobile;

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $this->billingAddress    = $data->billingAddress ?? null;
        $this->phone    = $data->phone ?? null;
        $this->mobile    = $data->mobile ?? null;
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

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $address
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param $address
     *
     * @return $this
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }
}
