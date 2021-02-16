<?php

namespace FelixBraspag\Marketplace\Sellers\Request;

use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\CieloError;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\CieloRequestException;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;
use FelixBraspag\Marketplace\Logger;

/**
 * Class AbstractRequest
 *
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
//        $this->logger = $logger;
        $this->logger = new Logger();
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
            'User-Agent: Felix Braspag / PHP SDK',
            'Authorization: ' . ucfirst($this->auth->getTokenType()) . ' ' . $this->auth->getAccessToken(),
            'RequestId: ' . uniqid()
        ];

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
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
                    json_decode($content)
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

    /**
     * @param $statusCode
     * @param $responseBody
     *
     * @return mixed
     *
     * @throws CieloRequestException
     */
    protected function readResponse($statusCode, $responseBody)
    {

        $unserialized = null;

        switch ($statusCode) {
            case 200:
            case 201:
            case 202:
                $unserialized = $this->unserialize($responseBody);
                break;
            case 400:
                $exception = null;
                $response  = json_decode($responseBody);

                foreach ($response as $error) {
                    $cieloError = new CieloError($error->Message, $error->Code);
                    $exception  = new CieloRequestException('Request Error', $statusCode, $exception);
                    $exception->setCieloError($cieloError);
                }

                throw $exception;
            case 404:
                throw new CieloRequestException('Resource not found', 404, null);
            default:
                throw new CieloRequestException('Unknown status', $statusCode);
        }

        return $unserialized;
    }
}
