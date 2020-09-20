<?php

namespace ScrappyTest\Sources;

use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use PHPHtmlParser\Dom\Node\HtmlNode;
use Scrappy\ArrayStorage;
use Scrappy\SourceBase;
use Scrappy\Sources\HtmlSource;
use Scrappy\StorageInterface;

class LamodaSource extends HtmlSource
{

    /**
     * LamodaSource constructor.
     *
     * @param $id
     *   Target item id.
     */
    public function __construct($id, $sid)
    {
        parent::__construct();

        // Set up the target url.
        $this->setUrl(
            "https://www.lamoda.by/p/$id"
        );

        // Set client options.
        $cookies = CookieJar::fromArray([
            'sid' => $sid,
        ], '.lamoda.by');

        $this->setClientOptions([
            'allow_redirects' => true,
            'cookies' => $cookies
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getLookupFields()
    {
        return ['price'];
    }

    /**
     * {@inheritDoc}
     */
    protected function doFetch(): StorageInterface
    {
        // Extract the price.
        $price_element = $this->parser->find('meta[itemprop=price]');
        $price = 0;

        if ($price_element[0] instanceof HtmlNode) {
            $price = $price_element[0]->getAttribute('content');
        }

        return new ArrayStorage([
            'price' => $price,
        ]);
    }

}
