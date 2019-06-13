<?php

namespace Deity\FalconCache\Model\Cache;

use Deity\FalconCache\Model\CacheManagement;
use Deity\FalconCache\Model\FalconApiAdapter;
use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Type
     */
    private $cacheType;

    /**
     * @var CacheManagement | \PHPUnit_Framework_MockObject_MockObject
     */
    private $cacheManagement;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $frontendPool = $this->getMockBuilder(FrontendPool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cacheManagement = $this->createPartialMock(CacheManagement::class, ['cleanFalconCache']);

        $this->cacheType = $this->objectManager->getObject(
            Type::class,
            [
                'cacheFrontendPool' => $frontendPool,
                'cacheManagement' => $this->cacheManagement
            ]
        );
    }

    /**
     * @covers \Deity\FalconCache\Model\Cache\Type::getTag
     */
    public function testGetTag()
    {
        $tag = $this->cacheType->getTag();
        $this->assertEquals(Type::CACHE_TAG, $tag, 'Cache tag should match');
    }

    /**
     * @covers \Deity\FalconCache\Model\Cache\Type::clean
     */
    public function testClean()
    {
        $this->cacheManagement
            ->expects($this->any())
            ->method('cleanFalconCache')
            ->will($this->returnValue(true));

        $cleanResult = $this->cacheType->clean();

        $this->assertEquals(true, $cleanResult, 'clean result should be true');
    }
}
