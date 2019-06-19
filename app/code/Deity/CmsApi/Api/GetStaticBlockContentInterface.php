<?php
declare(strict_types=1);

namespace Deity\CmsApi\Api;

/**
 * Interface GetStaticBlockContentInterface
 *
 * @package Deity\CmsApi\Api
 */
interface GetStaticBlockContentInterface
{
    /**
     * Get content of the static block
     *
     * @param string $identifier
     * @return string
     */
    public function execute(string $identifier): string;
}
