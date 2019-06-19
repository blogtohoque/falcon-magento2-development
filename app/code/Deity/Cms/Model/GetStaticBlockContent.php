<?php
declare(strict_types=1);

namespace Deity\Cms\Model;

use Deity\CmsApi\Api\GetStaticBlockContentInterface;

/**
 * Class GetStaticBlockContent
 *
 * @package Deity\Cms\Model
 */
class GetStaticBlockContent implements GetStaticBlockContentInterface
{

    /**
     * Get content of the static block
     *
     * @param string $identifier
     * @return string
     */
    public function execute(string $identifier): string
    {
        // TODO: Implement execute() method.
    }
}
