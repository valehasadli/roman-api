<?php

declare(strict_types=1);

namespace App\Services\Converter\Registry;

use App\Services\Converter\Contracts\NumberConverterContract;
use Exception;

/**
 * Class NumberConverterTypeRegistry
 * @package App\Services\Converter\Registry
 */
class NumberConverterTypeRegistry
{
    protected array $types = [];

    /**
     * @param string $name
     * @param NumberConverterContract $instance
     * @return $this
     */
    public function register(string $name, NumberConverterContract $instance): self
    {
        $this->types[$name] = $instance;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function get(string $name)
    {
        if (array_key_exists($name, $this->types)) {
            return $this->types[$name];
        }

        throw new Exception('Invalid converter type');
    }
}
