<?php

namespace Oh86\Test\SmCryptorTest;

use Oh86\SmCryptor\Cryptor;

class TestCryptor implements Cryptor
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sm3(string $text): string
    {
        return "sm3-" . $text;
    }

    public function hmacSm3(string $text): string
    {
        return "hmac-sm3-" . $text;
    }

    public function sm4Encrypt(string $text): string
    {
        return "sm4-encrypt-" . $text;
    }

    public function sm4Decrypt(string $cipherText): string
    {
        return "sm4-decrypt-" . $cipherText;
    }
}
