<?php declare(strict_types=1);

namespace VibeCore\Http;

final class RequestContext
{
    public function __construct(
        private readonly array $attributes = [],
    ) {}

    public static function empty(): self
    {
        return new self();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function with(string $key, mixed $value): self
    {
        $attrs = $this->attributes;
        $attrs[$key] = $value;
        return new self($attrs);
    }

    public function all(): array
    {
        return $this->attributes;
    }
}
