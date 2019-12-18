<?php
declare(strict_types=1);

namespace Deity\Email\Plugin\Model;

use Deity\EmailApi\Model\UrlReplacerApi;

/**
 * Class Template
 *
 * @package Deity\Email\Plugin\Email
 */
class Template
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

    public function afterGetUrl(\Magento\Email\Model\Template $subject, $result)
    {
        return $this->urlReplacer->replaceLinkToFalcon($result);
    }
}
