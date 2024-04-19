<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Exception;

class Address
{
    private string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->assertAddressIsValid($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws Exception
     */
    private function assertAddressIsValid(string $value): void
    {
        $url = filter_var($value, FILTER_VALIDATE_URL);
        if (!$url) {
            throw new Exception("Invalid address");
        }
        $headers = get_headers($value);
        if (!$headers) {
            throw new Exception("Invalid address");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
