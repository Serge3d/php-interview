<?php

abstract class SecretKeyStorage
{
    abstract public function getStorage(): ConnectorInterface;

    public function getKey()
    {
        return $this->getStorage()->getKey();
    }
}

class FileSecretKeyStorage extends SecretKeyStorage
{
    public function __construct(private array $config)
    {
        //
    }

    public function getStorage(): ConnectorInterface
    {
        return new FileSecretKeyConnector($this->config);
    }
}

class DatabaseSecretKeyStorage extends SecretKeyStorage
{
    public function __construct(private array $config)
    {
        //
    }

    public function getStorage(): ConnectorInterface
    {
        return new DatabaseSecretKeyConnector($this->config);
    }
}

class RedisSecretKeyStorage extends SecretKeyStorage
{
    public function __construct(private array $config)
    {
        //
    }

    public function getStorage(): ConnectorInterface
    {
        return new RedisSecretKeyConnector($this->config);
    }
}

interface ConnectorInterface
{
    public function getKey();
}

class FileSecretKeyConnector implements ConnectorInterface
{
    public function __construct(private array $config)
    {
       //
    }

    public function getKey()
    {
        //
    }
}

class DatabaseSecretKeyConnector implements ConnectorInterface
{
    public function __construct(private array $config)
    {
        //
    }

    public function getKey()
    {
        //
    }
}

class RedisSecretKeyConnector implements ConnectorInterface
{
    public function __construct(private array $config)
    {
        //
    }

    public function getKey()
    {
        //
    }
}

class Concept
{
    private $client;

    public function __construct(private SecretKeyStorage $secretKeyStorage)
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function setSecretKeyStorage(SecretKeyStorage $secretKeyStorage)
    {
        $this->secretKeyStorage = $secretKeyStorage;
    }

    public function getUserData()
    {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }

    private function getSecretKey(): string
    {
        return $this->getSecretKeyStorage()->getKey();
    }

    private function getSecretKeyStorage(): SecretKeyStorage
    {
        return $this->secretKeyStorage;
    }

    /**
     * Достаточно реализовать простое решение, которое бы позволяло через параметр
     * (в условной "глобальной конфигурации" / внутри класса данного метода),
     * выбирать любой существующий способ хранения.
     */
//    private function getSecretKeyStorage(): SecretKeyStorage
//    {
//        $name = config('secret_key_storage.name');
//        $config = config("secret_key_storage.connections.$name");
//        $class = $name . 'SecretKeyStorage';
//        return new $class($config);
//    }
}