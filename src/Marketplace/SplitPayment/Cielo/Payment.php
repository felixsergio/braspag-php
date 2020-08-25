<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use FelixBraspag\Marketplace\SplitPayment\Cielo\SplitPayment;
use FelixBraspag\Marketplace\SplitPayment\Cielo\PaymentFraudAnalysis;
use Cielo\API30\Ecommerce\Payment as PaymentCielo;
use Cielo\API30\Ecommerce\CreditCard as CreditCardCielo;

class Payment extends PaymentCielo
{
    const PAYMENTTYPE_SPLITTED_CREDITCARD = 'SplittedCreditCard';

    const PAYMENTTYPE_SPLITTED_DEBITCARD = 'SplittedDebitCard';

    /**
     * @var array $splitPayments
     */
    private $splitPayments;

    /**
     * @var array $fraudAnalysis
     */
    private $fraudAnalysis;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $obj = parent::jsonSerialize();
        $obj['splitPayments'] = $this->splitPayments;
        $obj['fraudAnalysis'] = $this->fraudAnalysis;

        return $obj;
    }

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $this->populate($data);

        if (isset($data->SplitPayments)) {
            $this->splitPayments = new SplitPayment();
            $this->splitPayments->populate($data->SplitPayments);
        }

        if (isset($data->fraudAnalysis)) {
            $this->fraudAnalysis = new PaymentFraudAnalysis();
            $this->fraudAnalysis->populate($data->fraudAnalysis);
        }
    }

    /**
     * @param $securityCode
     * @param $brand
     *
     * @return CreditCard
     */
    private function newCard($securityCode, $brand)
    {
        $card = new CreditCardCielo();
        $card->setSecurityCode($securityCode);
        $card->setBrand($brand);

        return $card;
    }

    /**
     * @param $securityCode
     * @param $brand
     *
     * @return CreditCard
     */
    public function creditCard($securityCode, $brand)
    {
        $card = $this->newCard($securityCode, $brand);

        $this->setType(self::PAYMENTTYPE_SPLITTED_CREDITCARD);
        $this->setCreditCard($card);

        return $card;
    }

    /**
     * @param $securityCode
     * @param $brand
     *
     * @return CreditCard
     */
    public function debitCard($securityCode, $brand)
    {
        $card = $this->newCard($securityCode, $brand);

        $this->setType(self::PAYMENTTYPE_SPLITTED_DEBITCARD);
        $this->setDebitCard($card);

        return $card;
    }

    /**
     * @return mixed
     */
    public function getSplitPayments()
    {
        return $this->splitPayments;
    }

    /**
     * @param CreditCard $creditCard
     *
     * @return $this
     */
    public function putSplitPayment(SplitPayment $splitPayments)
    {
        $this->splitPayments[] = $splitPayments;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFraudAnalysis()
    {
        return $this->fraudAnalysis;
    }

    /**
     * @return PaymentFraudAnalysis $fraudAnalysis
     */
    public function setFraudAnalysis(PaymentFraudAnalysis $fraudAnalysis)
    {
       $this->fraudAnalysis = $fraudAnalysis;

        return $this;
    }

}
