<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo\Request;

use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Environment;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;

/**
 * Class CreateSaleRequest
 *
 * @package Cielo\API30\Ecommerce\Request
 */
class CreateSaleRequest extends AbstractRequest
{

    private $environment;

	/**
	 * CreateSaleRequest constructor.
	 *
	 * @param Authentication $auth
	 * @param Environment $environment
	 * @param LoggerInterface|null $logger
	 */
    public function __construct(Authentication $auth, Environment $environment, LoggerInterface $logger = null)
    {
        parent::__construct($auth, $logger);

        $this->environment = $environment;
    }

    /**
     * @param $sale
     *
     * @return null
     * @throws \Cielo\API30\Ecommerce\Request\CieloRequestException
     * @throws \RuntimeException
     */
    public function execute($sale)
    {
        $url = $this->environment->getApiUrl() . '1/sales/';

        return $this->sendRequest('POST', $url, $sale);
    }

    /**
     * @param $json
     *
     * @return Sale
     */
    protected function unserialize($json)
    {
        return Sale::fromJson($json);
    }
}
