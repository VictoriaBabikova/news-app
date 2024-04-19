<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Exception;

class Name
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->assertNameIsValid($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws Exception
     */
    private function assertNameIsValid(string $value): void
    {
        if (mb_strlen($value) < 1) {
            throw new Exception('Name must have at least 1 character');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
