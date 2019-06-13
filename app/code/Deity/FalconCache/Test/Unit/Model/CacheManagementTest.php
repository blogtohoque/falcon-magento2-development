<?php

namespace Deity\FalconCache\Test\Unit\Model;

use Deity\FalconCache\Model\CacheManagement;
use Deity\FalconCache\Model\FalconApiAdapter;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class CacheManagementTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var FalconApiAdapter | \PHPUnit_Framework_MockObject_MockObject
     */
    private $apiAdapter;

    /**
     * @var CacheManagement
     */
    private $cacheManager;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->apiAdapter = $this->createPartialMock(FalconApiAdapter::class, ['getError', 'flushCacheForGivenType']);

        $this->cacheManager = $this->objectManager->getObject(
            CacheManagement::class,
            [
                'apiAdapter' => $this->apiAdapter
            ]
        );
    }

    /**
     * @covers \Deity\FalconCache\Model\CacheManagement::cleanFalconCache
     */
    public function testCleanFalconCache()
    {
        $this->apiAdapter
            ->expects($this->any())
            ->method('flushCacheForGivenType')
            ->will($this->returnValue(true));

        $result = $this->cacheManager->cleanFalconCache();

        $this->assertEquals(true, $result, 'Clean cache call should match');
    }
}
