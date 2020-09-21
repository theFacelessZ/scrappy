<?php

namespace Scrappy\Sources;

use GuzzleHttp\Client;
use Scrappy\SourceBase;

abstract class JsonSource extends SourceBase {

    /**
     * Http client.
     *
     * @var Client
     */
    protected $client;

    /**
     * A set of http client options.
     *
     * @var array
     */
    protected $options;

    /**
     * JsonSource constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Sets global request options.
     *
     * @param array $options
     *   An array of client options.
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Performs a request.
     *
     * @param $method
     *   Request method.
     * @param $url
     *   Request url.
     * @param array $options
     *   Request options.
     *
     * @return false|string
     *   Json object.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($method, $url, array $options = [])
    {
        $response = $this->client->request(
            $method, $url, array_merge($this->options, $options)
        );

        return json_encode($response->getBody()->getContents());
    }

}
