<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo\Request;

use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractSaleRequest
 *
 * @package Cielo\API30\Ecommerce\Request
 */
abstract class AbstractRequest extends \Cielo\API30\Ecommerce\Request\AbstractRequest
{

    private $auth;
    private $logger;

	/**
	 * AbstractSaleRequest constructor.
	 *
	 * @param Merchant $merchant
	 * @param LoggerInterface|null $logger
	 */
    public function __construct(Authentication $auth, LoggerInterface $logger = null)
    {
        $this->auth = $auth;
        $this->logger = $logger;
    }

    /**
     * @param                        $method
     * @param                        $url
     * @param \JsonSerializable|null $content
     *
     * @return mixed
     *
     * @throws \Cielo\API30\Ecommerce\Request\CieloRequestException
     * @throws \RuntimeException
     */
    protected function sendRequest($method, $url, \JsonSerializable $content = null)
    {

        $headers = [
            'Accept: application/json',
            'Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'Authorization: ' . $this->auth->getTokenType() . ' ' . $this->auth->getAccessToken(),
            'RequestId: ' . uniqid()
        ];

        header('Content-Type: application/json');
        echo json_encode($content);
        exit;

        dd(json_encode($content));

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        if ($content !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($content));

            $headers[] = 'Content-Type: application/json';
        } else {
            $headers[] = 'Content-Length: 0';
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($this->logger !== null) {
            $this->logger->debug('Requisição', [
                    sprintf('%s %s', $method, $url),
                    $headers,
                    json_decode(preg_replace('/("cardnumber"):"([^"]{6})[^"]+([^"]{4})"/i', '$1:"$2******$3"', json_encode($content)))
                ]
            );
        }

        $response   = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($this->logger !== null) {
            $this->logger->debug('Resposta', [
                sprintf('Código de status: %s', $statusCode),
                json_decode($response)
            ]);
        }

        if (curl_errno($curl)) {
            $message = sprintf('cURL error[%s]: %s', curl_errno($curl), curl_error($curl));

            $this->logger->error($message);

            throw new \RuntimeException($message);
        }

        curl_close($curl);

        return $this->readResponse($statusCode, $response);
    }
}
