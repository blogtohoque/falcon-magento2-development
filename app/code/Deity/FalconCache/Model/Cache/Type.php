<?php
declare(strict_types=1);

namespace Deity\FalconCache\Model\Cache;

use Deity\FalconCacheApi\Model\CacheManagementInterface;
use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\Cache\FrontendInterface;

/**
 * Class Type
 *
 * @package Deity\FalconCache\Model\Cache
 */
class Type extends TagScope
{
    const TYPE_IDENTIFIER = 'falcon';
    const CACHE_TAG = 'falcon';

    /**
     * @var FrontendPool
     */
    private $cacheFrontendPool;

    /**
     * @var CacheManagementInterface
     */
    private $cacheManagement;

    /**
     * @param FrontendPool $cacheFrontendPool
     * @param CacheManagementInterface $cacheManagement
     */
    public function __construct(
        FrontendPool $cacheFrontendPool,
        CacheManagementInterface $cacheManagement
    ) {
        $this->cacheManagement = $cacheManagement;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    /**
     * Retrieve cache frontend instance being decorated
     *
     * @return FrontendInterface
     */
    protected function _getFrontend()
    {
        $frontend = parent::_getFrontend();
        if (!$frontend) {
            $frontend = $this->cacheFrontendPool->get(self::TYPE_IDENTIFIER);
            $this->setFrontend($frontend);
        }
        return $frontend;
    }

    /**
     * Retrieve cache tag name
     *
     * @return string
     */
    public function getTag()
    {
        return self::CACHE_TAG;
    }

    /**
     * Limit the cleaning scope within a tag
     *
     * {@inheritdoc}
     */
    public function clean($mode = \Zend_Cache::CLEANING_MODE_ALL, array $tags = [])
    {
        return $this->cacheManagement->cleanFalconCache();
    }
}
