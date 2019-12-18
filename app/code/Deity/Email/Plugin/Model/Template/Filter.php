<?php
declare(strict_types=1);

namespace Deity\Email\Plugin\Model\Template;

use Deity\EmailApi\Model\UrlReplacerApi;

/**
 * Class Filter
 *
 * @package Deity\Email\Plugin\Model\Template
 */
class Filter
{
    /**
     * @var UrlReplacerApi
     */
    private $urlReplacer;

    /**
     * UrlDecorator constructor.
     * @param UrlReplacerApi $urlReplacer
     */
    public function __construct(UrlReplacerApi $urlReplacer)
    {
        $this->urlReplacer = $urlReplacer;
    }

    public function afterStoreDirective(\Magento\Email\Model\Template\Filter $subject, $result)
    {
        return $this->urlReplacer->replaceLinkToFalcon($result);
    }
}
