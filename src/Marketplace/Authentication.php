<?php

namespace FelixBraspag\Marketplace;

use GuzzleHttp\Client;
use FelixBraspag\Marketplace\Environment;

/**
 * Class Merchant
 *
 * @package  FelixBraspag\Marketplace
 */
class Authentication
{
    private $clientId;
    private $clientSecret;
    private $environment;
    private $access_token;
    private $token_type;
    private $token_expires_in;

    /**
     * Merchant constructor.
     *
     * @param $id
     * @param $key
     */
    public function __construct($clientId, $clientSecret, $environment)
    {
        $this->clientId  = $clientId;
        $this->clientSecret = $clientSecret;
        $this->environment = $environment;

        $this->requestAccessToken();
    }

    /**
     * Gets the Client Id on Braspag
     *
     * @return string the Client Id on Braspag
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Gets the Client Secret
     *
     * @return string the Client Secret on Braspag
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getTokenType()
    {
        return $this->token_type;
    }

    public function getTokenExpiresIn()
    {
        return $this->token_expires_in;
    }

    /**
     * Gets token to authorization and get token
     *
     * @return string the merchant identification key on Cielo
     */
    public function requestAccessToken()
    {

        $url = $this->environment->getApiAuthURL() . 'oauth2/token';

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->clientId . ':' . $this->clientSecret);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Braspag PHP SDK');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded', "cache-control: no-cache"]);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        $response   = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($statusCode == 200){
            $response = json_decode($response);

            $this->access_token = $response->access_token ?? null;
            $this->token_expires_in = $response->expires_in ?? null;
            $this->token_type = $response->token_type ?? null;
        }
        return $this;
    }

}
