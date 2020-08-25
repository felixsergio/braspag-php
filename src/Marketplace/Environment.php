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

    private $apiOnboarding;

    private $apiAuth;

    /**
     * Environment constructor.
     *
     * @param $api
     * @param $apiQuery
     */
    private function __construct($api, $apiOnboarding, $apiAuth)
    {
        $this->api      = $api;
        $this->apiAuth  = $apiAuth;
        $this->apiOnboarding  = $apiOnboarding;
    }

    /**
     * @return Environment
     */
    public static function sandbox()
    {
        $api            = 'https://splitsandbox.braspag.com.br/';
        $apiOnboarding  = 'https://splitonboardingsandbox.braspag.com.br/';
        $apiAuth        = 'https://authsandbox.braspag.com.br/';

        return new Environment($api, $apiOnboarding, $apiAuth);
    }

    /**
     * @return Environment
     */
    public static function production()
    {
        $api            = 'https://split.braspag.com.br/';
        $apiOnboarding  = 'https://splitonboarding.braspag.com.br/';
        $apiAuth        = 'https://auth.braspag.com.br/';

        return new Environment($api, $apiOnboarding, $apiAuth);
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
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiOnboardingUrl()
    {
        return $this->apiOnboarding;
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
