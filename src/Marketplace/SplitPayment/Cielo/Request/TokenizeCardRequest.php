<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo\Request;

use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Environment;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;

/**
 * Class CreateCardTokenRequestHandler
 *
 * @package AppBundle\Handler\Cielo
 */
class TokenizeCardRequest extends AbstractRequest
{

    /**
     * CreateSaleRequest constructor.
     *
     * @param Authentication $auth
     * @param \Cielo\API30\Environment $environment
     * @param LoggerInterface|null $logger
     */
    public function __construct(Authentication $auth, Environment $environment, LoggerInterface $logger = null)
    {
        parent::__construct($auth, $logger);

        $this->environment = $environment;
    }

    /**
     * @inheritdoc
     */
    public function execute($param)
    {
        $url = $this->environment->getApiUrl() . '1/card/';

        return $this->sendRequest('POST', $url, $param);
    }

    /**
     * @inheritdoc
     */
    protected function unserialize($json)
    {
        return CreditCard::fromJson($json);
    }
}
