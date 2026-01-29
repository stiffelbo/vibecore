<?php declare(strict_types=1);

namespace VibeCore\Http;

final class Request
{
    public function __construct(
        private readonly string $method,
        private readonly string $path,
        private readonly array $query = [],
        private readonly array $headers = [],
        private readonly array $cookies = [],
        private readonly mixed $body = null,
        private readonly array $attributes = [], // route params, context hints, etc.
    ) {}

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function query(): array
    {
        return $this->query;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function header(string $name): ?string
    {
        $key = strtolower($name);
        return $this->headers[$key] ?? null;
    }

    public function cookies(): array
    {
        return $this->cookies;
    }

    public function body(): mixed
    {
        return $this->body;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function withAttribute(string $key, mixed $value): self
    {
        $attrs = $this->attributes;
        $attrs[$key] = $value;

        return new self(
            $this->method,
            $this->path,
            $this->query,
            $this->headers,
            $this->cookies,
            $this->body,
            $attrs
        );
    }
}
