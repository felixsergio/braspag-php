<?php

namespace FelixBraspag\Marketplace;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Merchant
 *
 * @package  FelixBraspag\Marketplace
 */
class Logger
{
    private $logger;

    /**
     * Logger constructor.
     * @param string $channel
     */
    public function __construct($channel = 'main')
    {
        $this->logger = new MonologLogger($channel);
        $this->pushHandler(new StreamHandler(getenv('BRASPAG_PHP_LOGFILE'), MonologLogger::INFO));

        return $this->logger;
    }
}
