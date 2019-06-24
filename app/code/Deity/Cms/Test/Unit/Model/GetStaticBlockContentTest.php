<?php

namespace Deity\Cms\Model;

use Deity\Cms\Model\Template\Filter;
use Magento\Cms\Model\Block;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class GetStaticBlockContentTest extends TestCase
{

    /**
     * @var GetStaticBlockContent
     */
    private $getStaticBlockContent;

    /**
     * @var GetBlockByIdentifier | MockObject
     */
    private $getBlockByIdentifier;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var StoreManager | MockObject
     */
    private $storeManager;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->getBlockByIdentifier = $this->createPartialMock(
            GetBlockByIdentifier::class,
            ['execute']
        );

        $storeObject = $this->createPartialMock(
            Store::class,
            ['getId']
        );
        $storeObject
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));
        $this->storeManager = $this->createPartialMock(
            StoreManager::class,
            ['getStore']
        );

        $this->storeManager->expects($this->any())
            ->method('getStore')
            ->will($this->returnValue($storeObject));

        $filterEmulate = $this->createMock(Filter::class);
        $filterEmulate->expects($this->any())
            ->method('filter')
            ->will($this->returnArgument(0));

        $this->getStaticBlockContent = $this->objectManager->getObject(
            GetStaticBlockContent::class,
            [
                'storeManager' => $this->storeManager,
                'getBlockByIdentifier' => $this->getBlockByIdentifier,
                'filterEmulate' => $filterEmulate
            ]
        );
    }

    public function testExecute()
    {
        $testIdentifier = 'any-block';
        $testBlockContent = 'any-content';

        $block = $this->createMock(Block::class);

        $block->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($testBlockContent));
        $this->getBlockByIdentifier
            ->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($block));

        $blockContent = $this->getStaticBlockContent->execute($testIdentifier);
        $this->assertEquals(
            $testBlockContent,
            $blockContent,
            'Service should return block content'
        );
    }
}

