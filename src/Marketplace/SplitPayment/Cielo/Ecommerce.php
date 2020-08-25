<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo;

use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Environment;
use FelixBraspag\Marketplace\Authentication;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\CreateSaleRequest;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\QueryRecurrentPaymentRequest;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\QuerySaleRequest;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\TokenizeCardRequest;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\UpdateSaleRequest;
use Cielo\API30\Ecommerce\Sale;
use Psr\Log\LoggerInterface;

/**
 * Class Merchant
 *
 * @package  FelixBraspag\Marketplace
 */
class Ecommerce extends \Cielo\API30\Ecommerce\CieloEcommerce
{
    private $merchant;

    private $environment;

    private $logger;

    /**
     * Create an instance of CieloEcommerce choosing the environment where the
     * requests will be send
     *
     * @param Authentication $auth
     *            The merchant credentials
     * @param Environment environment
     *            The environment: {@link Environment::production()} or
     *            {@link Environment::sandbox()}
     * @param LoggerInterface|null $logger
     */
    public function __construct(Authentication $auth, Environment $environment = null, LoggerInterface $logger = null)
    {
        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->merchant    = $auth;
        $this->environment = $environment;
        $this->logger      = $logger;
    }

    public function createSale(Sale $sale)
    {
        $createSaleRequest = new CreateSaleRequest($this->merchant, $this->environment, $this->logger);

        return $createSaleRequest->execute($sale);
    }

    public function getSale($paymentId)
    {
        $querySaleRequest = new QuerySaleRequest($this->merchant, $this->environment, $this->logger);

        return $querySaleRequest->execute($paymentId);
    }

    public function cancelSaleWithSplit($paymentId)
    {
        $updateSaleRequest = new UpdateSaleRequest('void', $this->merchant, $this->environment, $this->logger);
        $updateSaleRequest->setIsVoidTotal(true);

        return $updateSaleRequest->execute($paymentId);
    }


    public function cancelSaleWithSplitPartial($paymentId, $amount, $voidSplitPayments)
    {
        $updateSaleRequest = new UpdateSaleRequest('void', $this->merchant, $this->environment, $this->logger);

        $updateSaleRequest->setAmount($amount);
        $updateSaleRequest->setIsVoidPartial(true);
        $updateSaleRequest->setVoidSplitPayments($voidSplitPayments);

        return $updateSaleRequest->execute($paymentId);
    }


    public function captureSaleWithSplit($paymentId, $splitPayments)
    {

        $updateSaleRequest = new UpdateSaleRequest('capture', $this->merchant, $this->environment, $this->logger);

        $updateSaleRequest->setSplitPayments($splitPayments);

        return $updateSaleRequest->execute($paymentId);
    }

}
