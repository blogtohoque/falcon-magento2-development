<?php
declare(strict_types=1);

namespace Deity\FalconCache\Model;

use Deity\FalconCacheApi\Model\CacheManagementInterface;
use Deity\FalconCacheApi\Model\FalconApiAdapterInterface;

/**
 * Class CacheManagement
 *
 * @package Deity\FalconCache\Model
 */
class CacheManagement implements CacheManagementInterface
{

    /**
     * @var FalconApiAdapterInterface
     */
    private $apiAdapter;

    /**
     * CacheManagement constructor.
     * @param FalconApiAdapterInterface $apiAdapter
     */
    public function __construct(FalconApiAdapterInterface $apiAdapter)
    {
        $this->apiAdapter = $apiAdapter;
    }


    /**
     * Remove all magento entries in Falcon Cache
     *
     * @return bool
     */
    public function cleanFalconCache(): bool
    {
        $result = true;
        foreach ($this->getAvailableCacheTypes() as $entityType) {
            $result = $result && $this->apiAdapter->flushCacheForGivenType($entityType);
        }
        return $result;
    }

    /**
     *  Get available cache types
     *
     * @return string[]
     */
    private function getAvailableCacheTypes(): array
    {
        return ['product', 'category'];
    }
}
