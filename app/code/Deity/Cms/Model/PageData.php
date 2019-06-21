<?php
declare(strict_types=1);

namespace Deity\Cms\Model;

use Deity\CmsApi\Api\Data\PageDataInterface;

/**
 * Class PageData
 *
 * @package Deity\Cms\Model
 */
class PageData implements PageDataInterface
{

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var string
     */
    private $metaDescription;

    /**
     * @var string
     */
    private $metaKeywords;

    /**
     * PageData constructor.
     * @param string $content
     * @param string $metaTitle
     * @param string $metaDescription
     * @param string $metaKeywords
     */
    public function __construct(string $content, string $metaTitle, string $metaDescription, string $metaKeywords)
    {
        $this->content = $content;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->metaKeywords = $metaKeywords;
    }


    /**
     * Get content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get meta title
     *
     * @return string
     */
    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    /**
     * Get meta description
     *
     * @return string
     */
    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    /**
     * Get meta keywords
     *
     * @return string
     */
    public function getMetaKeywords(): string
    {
        return $this->metaKeywords;
    }
}
