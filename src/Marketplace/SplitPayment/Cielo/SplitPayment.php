<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\CieloSerializable;

class SplitPayment implements \JsonSerializable, CieloSerializable
{
    /**
     * @var string $subordinateMerchantId
     */
    private $subordinateMerchantId;

    /**
     * @var integer $amount
     */
    private $amount;

    /**
     * @var string $fare
     */
    private $fares;

    /**
     * SplitPayment constructor.
     */
    public function __construct()
    {
        $this->fares = new \stdClass();
        $this->fares->mdr = null;
        $this->fares->fee = null;
    }

    /**
     * @param string $json
     *
     * @return SplitPayment
     */
    public static function fromJson($json)
    {
        $object    = \json_decode($json);
        $splitPayment = new SplitPayment();
        $splitPayment->populate($object);

        return $splitPayment;
    }

    /**
     * @inheritdoc
     */
    public function populate(\stdClass $data)
    {
        $this->subordinateMerchantId    = $data->subordinateMerchantId ?? null;
        $this->amount                   = $data->amount ?? null;
        $this->fares->mdr               = $data->fares->mdr ?? null;
        $this->fares->fee               = $data->fares->fee ?? null;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $r = fx_array_filter_recursive(
            fx_cast_to_array_recursive(
                get_object_vars($this)
            )
        );

        if(isset($r['fares'])){
            if(empty($r['fares'])){
                unset($r['fares']);
            }
        }

        return $r;
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
    public function getAmount()
    {
        return $this->amount ?? null;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFareMdr()
    {
        return $this->fares->mdr ?? null;
    }

    /**
     * @param $fareMdr
     *
     * @return $this
     */
    public function setFareMdr($fareMdr)
    {
        $this->fares->mdr = $fareMdr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFareFee()
    {
        return $this->fares->fee ?? null;
    }

    /**
     * @param $fareFee
     *
     * @return $this
     */
    public function setFareFee($fareFee)
    {
        $this->fares->fee = $fareFee;

        return $this;
    }
}
