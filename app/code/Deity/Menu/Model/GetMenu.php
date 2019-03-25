<?php
declare(strict_types=1);

namespace Deity\Menu\Model;

use Deity\MenuApi\Api\Data\MenuInterface;
use Deity\MenuApi\Api\Data\MenuInterfaceFactory;
use Deity\MenuApi\Api\GetMenuInterface;
use Deity\MenuApi\Model\ConvertCategoryToMenuInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\StateDependentCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class GetMenu
 *
 * @package Deity\Menu\Model
 */
class GetMenu implements GetMenuInterface
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StateDependentCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ConvertCategoryToMenuInterface
     */
    private $convertCategoryToMenu;

    /**
     * GetMenu constructor.
     * @param StoreManagerInterface $storeManager
     * @param ConvertCategoryToMenuInterface $convertCategoryToMenu
     * @param ScopeConfigInterface $scopeConfig
     * @param StateDependentCollectionFactory $collectionFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConvertCategoryToMenuInterface $convertCategoryToMenu,
        ScopeConfigInterface $scopeConfig,
        StateDependentCollectionFactory $collectionFactory
    ) {
        $this->storeManager = $storeManager;
        $this->convertCategoryToMenu = $convertCategoryToMenu;
        $this->scopeConfig = $scopeConfig;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(): array
    {
        $rootId = (int)$this->storeManager->getStore()->getRootCategoryId();
        $storeId = $this->storeManager->getStore()->getId();
        /** @var Collection $collection */
        $collection = $this->getCategoryTree($storeId, $rootId);
        $menuStack = [];
        foreach ($collection as $category) {
            $menuStack[$category->getParentId()][] = $category;
        }

        if (empty($menuStack)) {
            return [];
        }

        return $this->buildTree($menuStack, $rootId);
    }

    /**
     * Build category tree
     *
     * @param array $menuStack
     * @param int $rootId
     * @return \Deity\MenuApi\Api\Data\MenuInterface[]
     */
    private function buildTree(array $menuStack, int $rootId): array
    {
        $resultStack = [];
        foreach ($menuStack[$rootId] as $key => $category) {
            $id = (int)$category->getId();
            $menuObject = $this->convertCategoryToMenu->execute($category);
            if (isset($menuStack[$id])) {
                $menuObject->setChildren($this->buildTree($menuStack, $id));
            }
            $resultStack[$key] = $menuObject;
        }

        return $resultStack;
    }

    /**
     * Get Category Tree
     *
     * @param int $storeId
     * @param int $rootId
     * @return Collection
     * @throws LocalizedException
     */
    private function getCategoryTree($storeId, $rootId)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->setStoreId($storeId);
        $collection->addAttributeToSelect('name');
        $collection->addFieldToFilter('path', ['like' => '1/' . $rootId . '/%']); //load only from store root
        $collection->addAttributeToFilter('include_in_menu', 1);
        $collection->addIsActiveFilter();
        $collection->addUrlRewriteToResult();
        $collection->addOrder('level', Collection::SORT_ORDER_ASC);
        $collection->addOrder('position', Collection::SORT_ORDER_ASC);
        $collection->addOrder('parent_id', Collection::SORT_ORDER_ASC);
        $collection->addOrder('entity_id', Collection::SORT_ORDER_ASC);

        return $collection;
    }
}
