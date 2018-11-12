<?php
declare(strict_types=1);

namespace Deity\CatalogApi\Api;

use Deity\CatalogApi\Api\Data\ProductSearchResultsInterface;

class SearchResults extends \Magento\Framework\Api\SearchResults implements ProductSearchResultsInterface
{
    const KEY_FILTERS = 'filters';

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->_get(self::KEY_FILTERS) === null ? [] : $this->_get(self::KEY_FILTERS);
    }

    /**
     * {@inheritdoc}
     */
    public function setFilters($items)
    {
        return $this->setData(self::KEY_FILTERS, $items);
    }
}