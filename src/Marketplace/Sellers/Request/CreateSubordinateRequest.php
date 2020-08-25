<?php

namespace FelixBraspag\Marketplace\Sellers\Request;

use FelixBraspag\Marketplace\Sellers\Subordinates;
use FelixBraspag\Marketplace\Environment;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;

/**
 * Class CreateSubordinateRequest
 *
 */
class CreateSubordinateRequest extends AbstractRequest
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
    public function execute($subordinate)
    {
        $url = $this->environment->getApiOnboardingUrl() . 'api/subordinates/';

        return $this->sendRequest('POST', $url, $subordinate);
    }

    /**
     * @param $json
     *
     * @return Sale
     */
    protected function unserialize($json)
    {
        return Subordinates::fromJson($json);
    }
}
