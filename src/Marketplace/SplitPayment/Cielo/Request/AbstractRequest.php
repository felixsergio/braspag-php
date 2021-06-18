<?php

namespace FelixBraspag\Marketplace\SplitPayment\Cielo\Request;

use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\CieloError;
use FelixBraspag\Marketplace\SplitPayment\Cielo\Request\CieloRequestException;
use FelixBraspag\Marketplace\Authentication;
use Psr\Log\LoggerInterface;
use FelixBraspag\Marketplace\Logger;

/**
 * Class AbstractSaleRequest
 *
 * @package Cielo\API30\Ecommerce\Request
 */
abstract class AbstractRequest extends \Cielo\API30\Ecommerce\Request\AbstractRequest
{

    private $auth;
    private $logger;
    private $request;

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
        $logger = new Logger();
        $this->logger = $logger->execute();

        $this->request = new \stdClass();
        $this->request->url = null;
        $this->request->method = null;
        $this->request->content = null;
        $this->request->authorization = null;
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
            'Authorization: ' . $this->auth->getTokenType() . ' ' . $this->auth->getAccessToken(),
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
            $log = preg_replace('/("cardnumber"):([0-9]{6})[0-9]+([0-9]{4})/i', '$1:"************$3"', json_encode($content));
            $log = preg_replace('/("securityCode"):([0-9]{3})/i', '$1:"***"', $log);
            $log = json_decode($log);

            $this->logger->debug('Requisição', [
                    sprintf('%s %s', $method, $url),
                    $headers,
                    $log
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

        $this->request->url = $url;
        $this->request->method = $method;
        $this->request->content = json_encode($content);
        $this->request->authorization = $this->auth->getTokenType() . ' ' . $this->auth->getAccessToken();

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
                $unserialized = $this->unserialize($responseBody);
                break;
            case 400:
                $exception = null;
                $response  = json_decode($responseBody);

                foreach ($response as $error) {

                    if ($this->logger !== null) {
                        $this->logger->error('Request Error Braspag', [
                            'message' => $error->Message,
                            'code' => $error->Code,
                            'url' => $this->request->url,
                            'method' => $this->request->method,
                            'authorization' => $this->request->authorization,
                            'content' => $this->request->content,
                        ]);
                    }

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
