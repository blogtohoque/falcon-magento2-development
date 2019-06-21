<?php
declare(strict_types=1);

namespace Deity\CmsApi\Api\Data;

/**
 * Interface PageDataInterface
 *
 * @package Deity\CmsApi\Api\Data
 */
interface PageDataInterface
{
    /**
     * Get content
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get meta title
     *
     * @return string
     */
    public function getMetaTitle(): string;

    /**
     * Get meta description
     *
     * @return string
     */
    public function getMetaDescription(): string;

    /**
     * Get meta keywords
     *
     * @return string
     */
    public function getMetaKeywords(): string;
}
