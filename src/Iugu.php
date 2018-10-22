<?php

namespace Iugu\Sdk;

use Iugu\Sdk\RequestMethods as Method;

class Iugu
{
    /**
     * @version 1.0.6
     */
    const VERSION = "1.0.6";

    /**
     * Iugu API
     *
     * @var string
     */
    protected static $IUGU_URL_API = "https://api.iugu.com/v1";

    /**
     * Iugu access token
     *
     * @var string
     */
    protected $token;

    /**
     * Iugu handler
     *
     * @var string
     */
    protected $handler;

    /**
     * Iugu constructor
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute GET request
     *
     * @param $resource
     * @param array $query
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($resource, array $query = [])
    {
        $exec = $this->execute(Method::$HTTP_GET, $resource, ['query' => $query]);

        return $exec;
    }

    /**
     * Execute POST request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($resource, $data = [])
    {
        $exec = $this->execute(Method::$HTTP_POST, $resource, ['json' => $data]);

        return $exec;
    }

    /**
     * Execute PUT request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($resource, $data = [])
    {
        $exec = $this->execute(Method::$HTTP_PUT, $resource, ['json' => $data]);

        return $exec;
    }

    /**
     * Execute DELETE request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($resource)
    {
        $exec = $this->execute(Method::$HTTP_DELETE, $resource);

        return $exec;
    }

    /**
     * Check and construct an real URL to make request
     *
     * @param $resource
     * @param array $query
     * @return string
     */
    public function makeUrl($resource)
    {
        $uri = self::$IUGU_URL_API;
        if (! preg_match("/^https/", $resource)) {
            if (! preg_match("/^\//", $resource)) {
                $resource = '/' . $resource;
            }
        }
        $uri .= $resource;

        return $uri;
    }

    /**
     * Execute the resource
     *
     * @param $method
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($method, $resource, array $data = [])
    {
        $request = new Request($this->handler);
        $dataResource = $request->execute($method, $this->makeUrl($resource), array_merge($data, [
            'headers' => [
                'Authorization' => sprintf('Basic %s', base64_encode($this->token . ':' . ''))
            ]
        ]));

        return $dataResource;
    }
}
