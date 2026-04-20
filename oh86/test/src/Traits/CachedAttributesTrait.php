<?php

namespace Oh86\Test\Traits;

/**
 * 缓存属性
 */
trait CachedAttributesTrait
{
    /**
     * @var array<string, mixed>
     */
    protected $cachedAttributes = [];

    /**
     * @param string $name
     * @return mixed
     */
    public function getCachedAttribute(string $name)
    {
        return $this->cachedAttributes[$name] ?? null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setCachedAttribute(string $name, $value)
    {
        $this->cachedAttributes[$name] = $value;
    }

    public function debugCachedAttributes()
    {
        var_dump($this->cachedAttributes);
    }
}