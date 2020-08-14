<?php

namespace FelixBraspag\Marketplace;

/**
 * Class Environment
 *
 * @package  FelixBraspag\Marketplace
 */
class Environment
{
    private $api;

    private $apiAuth;

    /**
     * Environment constructor.
     *
     * @param $api
     * @param $apiQuery
     */
    private function __construct($api, $apiAuth)
    {
        $this->api      = $api;
        $this->apiAuth  = $apiAuth;
    }

    /**
     * @return Environment
     */
    public static function sandbox()
    {
        $api      = 'https://splitsandbox.braspag.com.br/';
        $apiAuth = 'https://authsandbox.braspag.com.br/';

        return new Environment($api, $apiAuth);
    }

    /**
     * @return Environment
     */
    public static function production()
    {
        $api      = 'https://split.braspag.com.br/';
        $apiAuth  = 'https://auth.braspag.com.br/';

        return new Environment($api, $apiAuth);
    }

    /**
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiUrl()
    {
        return $this->api;
    }

    /**
     * Gets the environment's Api Auth URL
     *
     * @return string the Api Auth URL
     */
    public function getApiAuthURL()
    {
        return $this->apiAuth;
    }
}
