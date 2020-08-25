<?php


namespace FelixBraspag\Marketplace\Sellers;


use FelixBraspag\Marketplace\Sellers\Request\CreateSubordinateRequest;
use FelixBraspag\Marketplace\Sellers\Request\ViewSubordinateRequest;
use FelixBraspag\Marketplace\Environment;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;

class Merchant
{

    private $auth;
    private $environment;
    private $logger;

    public function __construct(Authentication $auth, Environment $environment = null, LoggerInterface $logger = null)
    {

        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->auth = $auth;
        $this->environment = $environment;
        $this->logger = $logger;

    }

    public function createSubordinate(Subordinates $subordinate)
    {
        $createSubordinateRequest = new CreateSubordinateRequest($this->auth, $this->environment, $this->logger);

        return $createSubordinateRequest->execute($subordinate);
    }

    public function viewSubordinate($merchantId)
    {
        $viewSubordinateRequest = new ViewSubordinateRequest($this->auth, $this->environment, $this->logger);

        return $viewSubordinateRequest->execute($merchantId);
    }
}
