<?php declare(strict_types=1);

namespace VibeCore\Support;

final class NonEmptyString
{
    private function __construct(private string $value) {}

    public static function from(string $value, string $label = 'value'): self
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException($label . ' must be a non-empty string.');
        }
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
