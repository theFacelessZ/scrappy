<?php

namespace Scrappy\Sources;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use Scrappy\SourceBase;

abstract class HtmlSource extends SourceBase {

    /**
     * Html dom parser.
     *
     * @var Dom
     */
    protected $parser;

    /**
     * Http client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Target url.
     *
     * @var string
     */
    protected $url;

    /**
     * A set of http client options.
     *
     * @var array
     */
    protected $options;

    /**
     * HtmlSource constructor.
     */
    public function __construct()
    {
        $this->parser = new Dom();
        $this->client = new Client([
            'allow_redirects' => true,
        ]);
    }

    /**
     * Sets source url.
     *
     * @param $url
     *   Target url.
     *
     * @return $this
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Sets client options.
     *
     * @param array $options
     *   A set of client options.
     *
     * @return $this
     */
    public function setClientOptions(array $options = []) {
        $this->options = $options;

        return $this;
    }

    /**
     * Initialises the parser before extracting the information.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\ContentLengthException
     * @throws \PHPHtmlParser\Exceptions\LogicalException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    protected function initialiseParser() {
        // Perform source loading first.
        // But before we load the resource, make sure it's not moved.
        $content = $this->client->get($this->url, $this->options)
            ->getBody()->getContents();
        $this->parser->loadStr($content);
    }

    /**
     * {@inheritDoc}
     */
    public function fetch()
    {
        // Initialise the parser first.
        $this->initialiseParser();

        // Perform the fetching.
        return parent::fetch();
    }

}
