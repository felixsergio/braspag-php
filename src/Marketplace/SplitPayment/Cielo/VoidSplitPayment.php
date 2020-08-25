<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\CieloSerializable;

class VoidSplitPayment implements \JsonSerializable, CieloSerializable
{
    /**
     * @var string $subordinateMerchantId
     */
    private $subordinateMerchantId;

    /**
     * @var integer $voidedAmount
     */
    private $voidedAmount;

    /**
     * SplitPayment constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $json
     *
     * @return SplitPayment
     */
    public static function fromJson($json)
    {
        $object    = \json_decode($json);
        $splitPayment = new VoidSplitPayment();
        $splitPayment->populate($object);

        return $splitPayment;
    }

    /**
     * @inheritdoc
     */
    public function populate(\stdClass $data)
    {
        $this->subordinateMerchantId    = $data->subordinateMerchantId ?? null;
        $this->voidedAmount                   = $data->amount ?? null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return fx_array_filter_recursive(
            fx_cast_to_array_recursive(
                get_object_vars($this)
            )
        );
    }

    /**
     * @return mixed
     */
    public function getSubordinateMerchantId()
    {
        return $this->subordinateMerchantId ?? null;
    }

    /**
     * @param $subordinateMerchantId
     *
     * @return $this
     */
    public function setSubordinateMerchantId($subordinateMerchantId)
    {
        $this->subordinateMerchantId = $subordinateMerchantId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoidedAmount()
    {
        return $this->amount ?? null;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function setVoidedAmount($voidedAmount)
    {
        $this->voidedAmount = $voidedAmount;

        return $this;
    }
}
