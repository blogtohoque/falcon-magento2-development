<?php
declare(strict_types=1);

namespace Deity\Cms\Model;

use Deity\Cms\Model\Template\Filter;
use Deity\CmsApi\Api\GetStaticBlockContentInterface;
use Deity\CmsApi\Model\GetBlockByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class GetStaticBlockContent
 *
 * @package Deity\Cms\Model
 */
class GetStaticBlockContent implements GetStaticBlockContentInterface
{

    /**
     * @var GetBlockByIdentifierInterface
     */
    private $getBlockByIdentifier;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Filter
     */
    private $contentFilter;

    /**
     * GetStaticBlockContent constructor.
     * @param GetBlockByIdentifierInterface $getBlockByIdentifier
     * @param StoreManagerInterface $storeManager
     * @param Filter $filterEmulate
     */
    public function __construct(
        GetBlockByIdentifierInterface $getBlockByIdentifier,
        StoreManagerInterface $storeManager,
        Filter $filterEmulate
    ) {
        $this->contentFilter = $filterEmulate;
        $this->getBlockByIdentifier = $getBlockByIdentifier;
        $this->storeManager = $storeManager;
    }

    /**
     * Get content of the static block
     *
     * @param string $identifier
     * @return string
     * @throws NoSuchEntityException
     */
    public function execute(string $identifier): string
    {
        $storeId = (int)$this->storeManager->getStore()->getId();
        $blockInstance = $this->getBlockByIdentifier->execute($identifier, $storeId);
        return (string)$this->contentFilter->filter($blockInstance->getContent());
    }
}
