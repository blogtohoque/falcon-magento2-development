<?php
declare(strict_types=1);

namespace Deity\Cms\Model;

use Deity\CmsApi\Api\Data\PageDataInterface;
use Deity\CmsApi\Api\GetStaticPageDataInterface;

/**
 * Class GetStaticPageData
 *
 * @package Deity\Cms\Model
 */
class GetStaticPageData implements GetStaticPageDataInterface
{

    /**
     * Get static page content object
     *
     * @param int $pageId
     * @return \Deity\CmsApi\Api\Data\PageDataInterface
     */
    public function execute(int $pageId): PageDataInterface
    {
        // TODO: Implement execute() method.
    }
}
