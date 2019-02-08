<?php
declare(strict_types=1);

namespace Deity\SalesApi\Test\Api;

use Magento\Framework\App\Config;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Model\ResourceModel\Sale\Collection;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Class OrderManagementTest
 * @package Deity\SalesApi\Test\Api
 */
class OrderManagementTest extends WebapiAbstract
{
    /**
     * Service constants
     */
    const RESOURCE_PATH_MY_ORDERS = '/V1/orders/mine';

    const RESOURCE_PATH_ORDER_INFO = '/V1/orders/:orderId/order-info';

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     *  setup before every test run. Update app config
     */
    protected function setUp()
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $appConfig = $this->objectManager->get(Config::class);
        $appConfig->clean();
    }

    /**
     * @magentoApiDataFixture Magento/Sales/_files/order_with_customer.php
     */
    public function testGetItem()
    {
        $this->_markTestAsRestOnly();

        // get customer ID token
        /** @var \Magento\Integration\Api\CustomerTokenServiceInterface $customerTokenService */
        $customerTokenService = $this->objectManager->create(
            \Magento\Integration\Api\CustomerTokenServiceInterface::class
        );
        $token = $customerTokenService->createCustomerAccessToken('customer@example.com', 'password');

        $serviceInfo = [
            'rest' => [
                'resourcePath' => str_replace(':orderId', $this->getFixtureCustomerOrderId(), self::RESOURCE_PATH_ORDER_INFO),
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
                'token' => $token
            ],
        ];

        $orderInfo = $this->_webApiCall($serviceInfo, []);
        $this->assertArrayHasKey('items', $orderInfo, 'Response should contain items key');
        $this->assertEquals(1, count($orderInfo['items']), 'Exaclty one order item should be returned');
    }

    /**
     * @return int
     */
    private function getFixtureCustomerOrderId():int
    {
        /** @var  Collection $collectionModel */
        $collectionModel = Bootstrap::getObjectManager()->create(
            Collection::class
        );
        $collectionModel->setCustomerIdFilter(1);
        $order = $collectionModel->getFirstItem();
        return (int)$order->getEntityId();
    }

}
