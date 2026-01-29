<?php declare(strict_types=1);

namespace VibeCore\Routing;

use VibeCore\Http\HandlerInterface;

final class Route
{
    /**
     * @param array<string, mixed> $meta
     */
    public function __construct(
        public readonly string $method,
        public readonly string $pattern,
        public readonly HandlerInterface $handler,
        public readonly ?string $name = null,
        public readonly array $meta = [],
    ) {
        $m = strtoupper($this->method);
        if (!in_array($m, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'], true)) {
            throw new \InvalidArgumentException("Route: unsupported HTTP method '{$this->method}'.");
        }
        if ($this->pattern === '' || $this->pattern[0] !== '/') {
            throw new \InvalidArgumentException("Route: pattern must start with '/' (got '{$this->pattern}').");
        }
    }

    public function methodUpper(): string
    {
        return strtoupper($this->method);
    }
}
