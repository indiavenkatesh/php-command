<?php
declare(strict_types=1);

final class Prime
{
    private $prime;

    public function __construct(int $prime)
    {
        $this->ensureIsValidInteger($prime);

        $this->ensureIsValidPrime($prime);

        $this->prime = $prime;
    }

    public function __toString(): string
    {
        return '' . $this->prime;
    }

    public function toInt(): int
    {
        return $this->prime;
    }

    private function ensureIsValidInteger(int $prime): void
    {
        if (!filter_var($prime, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid integer',
                    $prime
                )
            );
        }
    }

    private function ensureIsValidPrime(int $prime): void
    {
        for($j=2; $j<=$prime; $j++) {
            if($j != $prime && $prime % $j == 0) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"%s" is not a prime integer',
                        $prime
                    )
                );
            }
        }
    }
}