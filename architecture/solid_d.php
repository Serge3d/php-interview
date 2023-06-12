<?php

interface IXMLHttpService
{
    public function request(string $url, string $method, array $options = null);
}

class XMLHttpService extends XMLHTTPRequestService implements IXMLHttpService
{
    public function request(string $url, string $method, array $options = null)
    {
        //
    }
}

class Http
{
    public function __construct(private IXMLHttpService $service)
    {
        //
    }

    public function get(string $url, array $options)
    {
        $this->service->request($url, 'GET', $options);
    }

    public function post(string $url)
    {
        $this->service->request($url, 'GET');
    }
}