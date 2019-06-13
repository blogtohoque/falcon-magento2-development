<?php
declare(strict_types=1);

namespace Deity\FalconCache\Model;

use Deity\FalconCacheApi\Model\FalconApiAdapterInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\ClientFactory;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class FalconApiAdapter
 *
 * @package Deity\FalconCache\Model
 */
class FalconApiAdapter implements FalconApiAdapterInterface
{
    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var SerializerInterface
     */
    private $jsonEncode;

    /**
     * @var string
     */
    private $error = '';

    /**
     * FalconApiAdapter constructor.
     * @param ClientFactory $clientFactory
     * @param SerializerInterface $json
     */
    public function __construct(ClientFactory $clientFactory, SerializerInterface $json)
    {
        $this->clientFactory = $clientFactory;
        $this->jsonEncode = $json;
    }

    /**
     * Get Client object
     *
     * @param array $params
     * @return bool
     */
    private function makeRequest(array $params): bool
    {
        /** @var Curl $curlClient */
        $curlClient = $this->clientFactory->create();
        $curlClient->addHeader('Content-Type', 'application/json');
        $curlClient->post('localhost', $this->jsonEncode->serialize($params));
        $headers = $curlClient->getHeaders();
        $responseHttpCode = $headers['CURLINFO_HTTP_CODE'] ?? 400;
        if ($responseHttpCode === 200) {
            return true;
        }
        $this->error = $curlClient->getBody();
        return false;
    }

    /**
     * Flush the cache storage of falcon
     *
     * @param string $entityTypeCode
     * @return bool
     */
    public function flushCacheForGivenType(string $entityTypeCode): bool
    {
        $bodyRequest= [['type' => $entityTypeCode]];
        return $this->makeRequest($bodyRequest);
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}
