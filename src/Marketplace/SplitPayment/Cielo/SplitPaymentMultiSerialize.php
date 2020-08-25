<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\CieloSerializable;

class SplitPaymentMultiSerialize implements \JsonSerializable, CieloSerializable
{
    /**
     * @var array $splits
     */
    private $splits;

    /**
     * SplitPayment constructor.
     */
    public function __construct($splits)
    {
        $this->splits = $splits;
    }

    public function populate(\stdClass $data){

    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return ['SplitPayments' => $this->splits];
    }

    /**
     * @return mixed
     */
    public function getSplits()
    {
        return $this->splits ?? null;
    }

    /**
     * @param $splits
     *
     * @return $this
     */
    public function setSplit($splits)
    {
        $this->splits = $splits;

        return $this;
    }
}
