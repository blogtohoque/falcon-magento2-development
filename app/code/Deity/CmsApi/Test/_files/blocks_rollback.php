<?php
declare(strict_types=1);

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();

/** @var BlockRepositoryInterface $blockRepository */
$blockRepository = $objectManager->get(BlockRepositoryInterface::class);

/** @var SearchCriteriaBuilder $searchCriteriaBuilder */
$searchCriteriaBuilder = $objectManager->get(SearchCriteriaBuilder::class);
$searchCriteria = $searchCriteriaBuilder->addFilter(BlockInterface::IDENTIFIER, 'enabled_block')
    ->create();
$result = $blockRepository->getList($searchCriteria);

/**
 * Tests which are wrapped with MySQL transaction clear all data by transaction rollback.
 * In that case there is "if" which checks that "enabled_block" still exists in database.
 */
foreach ($result->getItems() as $item) {
    $blockRepository->delete($item);
}
