<?php
declare(strict_types=1);

require_once ROOT . 'app/lib/Prime.php';

final class PrimeNumbers
{
    private $count;
    private $primeNumbers;

    public function __construct(int $count)
    {
        $this->ensureIsValidCount($count);

        $this->count = $count;

        $this->generatePrimeNumbers();
    }

    public function array(): array
    {
        return $this->primeNumbers;
    }

    private function generatePrimeNumbers(): void
    {
        $this->primeNumbers = array();
        $i = 2;
        while(count($this->primeNumbers) < $this->count) {
            try {
                $this->primeNumbers[] = new Prime($i);
            } catch(InvalidArgumentException $e) {
                //echo $e->getMessage();
            } finally {
                $i++;
            }
        }
    }

    private function ensureIsValidCount(int $prime): void
    {
        if (!filter_var($prime, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid count integer',
                    $prime
                )
            );
        }
    }
}