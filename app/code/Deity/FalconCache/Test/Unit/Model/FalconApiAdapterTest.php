<?php

namespace Deity\FalconCache\Test\Unit\Model;

use Deity\FalconCache\Model\ConfigProvider;
use Deity\FalconCache\Model\FalconApiAdapter;
use Generator;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\ClientFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class FalconApiAdapterTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var FalconApiAdapter
     */
    private $falconApiAdapter;

    /**
     * @var SerializerInterface
     */
    private $jsonSerializer;

    /**
     * @var Curl | \PHPUnit_Framework_MockObject_MockObject
     */
    private $curl;

    /**
     * @var ConfigProvider | \PHPUnit_Framework_MockObject_MockObject
     */
    private $configProvider;


    public function setUp()
    {
        $this->curl = $this->createMock(Curl::class);
        $clientFactory = $this->createPartialMock(ClientFactory::class, ['create']);
        $clientFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($this->curl));

        $this->jsonSerializer = $this->getMockBuilder(Json::class)
            ->getMock();

        $this->configProvider = $this->createPartialMock(ConfigProvider::class, ['getFalconApiCacheUrl']);

        $this->objectManager = new ObjectManager($this);

        $this->falconApiAdapter = $this->objectManager->getObject(
            FalconApiAdapter::class, [
                'json' => $this->jsonSerializer,
                'clientFactory' => $clientFactory,
                'configProvider' => $this->configProvider
            ]
        );
    }

    /**
     * @param string $entityType
     * @param bool $expected
     * @dataProvider getEntityTypeData
     * @covers \Deity\FalconCache\Model\FalconApiAdapter::flushCacheForGivenType
     */
    public function testFlushCacheForGivenType($entityType, $expected)
    {
        $headerInfo = [
          'CURLINFO_HTTP_CODE' => 200
        ];
        $this->curl
            ->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($headerInfo));

        $response = $this->falconApiAdapter->flushCacheForGivenType($entityType);

        $this->assertEquals($expected, $response, 'Return value should match');
        $this->assertEquals('', $this->falconApiAdapter->getError(), 'Error message should match');
    }

    /**
     * @covers \Deity\FalconCache\Model\FalconApiAdapter::getError
     */
    public function testFlushCacheWithErrorMessage()
    {
        $errorMessage = 'Error occurred message';
        $this->curl
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($errorMessage));

        $response = $this->falconApiAdapter->flushCacheForGivenType('product');

        $this->assertEquals(false, $response, 'Return value should be false');
        $this->assertEquals($errorMessage, $this->falconApiAdapter->getError(), 'Error message should match');
    }

    /**
     * @covers \Deity\FalconCache\Model\FalconApiAdapter::flushCacheForGivenType
     */
    public function testErrorMessageWhenApiUrlIsNotSet()
    {
        $this->configProvider
            ->expects($this->any())
            ->method('getFalconApiCacheUrl')
            ->will($this->returnValue(''));

        $response = $this->falconApiAdapter->flushCacheForGivenType('product');

        $this->assertEquals(false, $response, 'Api should return false');
    }

    /**
     * Test data
     *
     * @return Generator
     */
    public function getEntityTypeData()
    {
        yield 'product' => ['product', true];
        yield 'category' => ['category', true];
        yield 'any-other' => ['proverbs', true];
    }
}
