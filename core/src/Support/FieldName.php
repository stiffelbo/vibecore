<?php declare(strict_types=1);

namespace VibeCore\Support;

final class FieldName
{
    private function __construct(private NonEmptyString $name) {}

    public static function from(string $name): self
    {
        return new self(NonEmptyString::from($name, 'FieldName'));
    }

    public function value(): string
    {
        return $this->name->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
