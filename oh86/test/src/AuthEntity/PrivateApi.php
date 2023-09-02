<?php

namespace Oh86\Test\AuthEntity;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;

class PrivateApi implements Authenticatable, Arrayable, \JsonSerializable
{
    private string $app;

    /**
     * @param string $app
     */
    public function __construct(string $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function getApp(): string
    {
        return $this->app;
    }

    public function getAuthIdentifierName(): string
    {
        return "";
    }

    public function getAuthIdentifier(): string
    {
        return $this->getApp();
    }

    public function getAuthPassword(): string
    {
        return "";
    }

    public function getRememberToken(): string
    {
        return "";
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName(): string
    {
        return "";
    }

    public function toArray(): array
    {
        return [
            "app" => $this->app,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
