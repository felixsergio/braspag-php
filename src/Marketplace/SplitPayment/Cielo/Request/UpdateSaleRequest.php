<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo\Request;

use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Environment;
use FelixBraspag\Marketplace\Authentication;
use FelixBraspag\Marketplace\SplitPayment\Cielo\SplitPaymentMultiSerialize;
use FelixBraspag\Marketplace\SplitPayment\Cielo\VoidSplitPaymentMultiSerialize;
use Psr\Log\LoggerInterface;

/**
 * Class UpdateSaleRequest
 *
 * @package Cielo\API30\Ecommerce\Request
 */
class UpdateSaleRequest extends AbstractRequest
{

    private $environment;

    private $type;

    private $serviceTaxAmount;

    private $amount;

    private $splitPayments;

    private $voidSplitPayments;

    private $isVoidTotal;

    private $isVoidPartial;

    /**
     * CreateSaleRequest constructor.
     *
     * @param Authentication $auth
     * @param Environment $environment
     * @param LoggerInterface|null $logger
     */
    public function __construct($type, Authentication $auth, Environment $environment, LoggerInterface $logger = null)
    {
        parent::__construct($auth, $logger);

        $this->environment = $environment;
        $this->type        = $type;
        $this->isVoidTotal = false;
        $this->isVoidPartial = false;
    }

    /**
     * @param $paymentId
     *
     * @return null
     * @throws \Cielo\API30\Ecommerce\Request\CieloRequestException
     * @throws \RuntimeException
     */
    public function execute($paymentId)
    {
        $url    = $this->environment->getApiUrl() . '1/sales/' . $paymentId . '/' . $this->type;

        $params = [];

        if ($this->amount != null) {
            $params['amount'] = $this->amount;
        }

        if ($this->serviceTaxAmount != null) {
            $params['serviceTaxAmount'] = $this->serviceTaxAmount;
        }

        $url .= '?' . http_build_query($params);

        if($this->type == 'void'){
            switch (true){
                case $this->isVoidTotal:
                    return $this->sendRequest('PUT', $url, null);
                    break;
                case $this->isVoidPartial:
                    $splits = new VoidSplitPaymentMultiSerialize($this->getVoidSplitPayments());
                    return $this->sendRequest('PUT', $url, $splits);
                    break;
            }
        }

        $splits = new SplitPaymentMultiSerialize($this->getSplitPayments());

        return $this->sendRequest('PUT', $url, $splits);
    }

    /**
     * @param $json
     *
     * @return Payment
     */
    protected function unserialize($json)
    {
        return Payment::fromJson($json);
    }

    /**
     * @return mixed
     */
    public function getServiceTaxAmount()
    {
        return $this->serviceTaxAmount;
    }

    /**
     * @param $serviceTaxAmount
     *
     * @return $this
     */
    public function setServiceTaxAmount($serviceTaxAmount)
    {
        $this->serviceTaxAmount = $serviceTaxAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
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
    public function getSplitPayments()
    {
        return $this->splitPayments;
    }

    /**
     * @param $splitPayments
     *
     * @return $this
     */
    public function setSplitPayments($splitPayments)
    {
        $this->splitPayments = $splitPayments;

        return $this;
    }
/**
     * @return mixed
     */
    public function getVoidSplitPayments()
    {
        return $this->voidSplitPayments;
    }

    /**
     * @param $voidSplitPayments
     *
     * @return $this
     */
    public function setVoidSplitPayments($voidSplitPayments)
    {
        $this->voidSplitPayments = $voidSplitPayments;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsVoidTotal()
    {
        return $this->isVoidTotal;
    }

    /**
     * @param $isVoidTotal
     *
     * @return $this
     */
    public function setIsVoidTotal($isVoidTotal)
    {
        $this->isVoidTotal = $isVoidTotal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsVoidPartial()
    {
        return $this->isVoidPartial;
    }

    /**
     * @param $isVoidPartial
     *
     * @return $this
     */
    public function setIsVoidPartial($isVoidPartial)
    {
        $this->isVoidPartial = $isVoidPartial;

        return $this;
    }
}
