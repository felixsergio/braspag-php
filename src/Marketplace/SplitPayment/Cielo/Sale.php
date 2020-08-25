<?php


namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\Sale as SaleCielo;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Payment;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Customer;

class Sale extends SaleCielo
{

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $dataProps = get_object_vars($data);

        if (isset($dataProps['Customer'])) {
            $customer = new Customer();
            $customer->populate($data->Customer);

            $this->setCustomer($customer);
        }

        if (isset($dataProps['Payment'])) {
            $payment = new Payment();
            $payment->populate($data->Payment);

            $this->setPayment($payment);
        }

        if (isset($dataProps['MerchantOrderId'])) {
            $this->setMerchantOrderId($data->MerchantOrderId);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $obj = parent::jsonSerialize();

        return $obj;
    }

    /**
     * @param     $amount
     * @param int $installments
     *
     * @return Payment
     */
    public function payment($amount, $installments = 1)
    {
        $payment = new Payment($amount, $installments);

        $this->setPayment($payment);

        return $payment;
    }

    /**
     * @param $name
     *
     * @return Customer
     */
    public function customer($name)
    {
        $customer = new Customer($name);

        $this->setCustomer($customer);

        return $customer;
    }
}
