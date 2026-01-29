<?php declare(strict_types=1);

namespace VibeCore\Routing;

use VibeCore\Http\HandlerInterface;

final class RouteDsl
{
    private string $prefix = '';

    private function __construct(private readonly RouterInterface $router) {}

    public static function on(RouterInterface $router): self
    {
        return new self($router);
    }

    public function group(string $prefix, callable $fn): self
    {
        $prev = $this->prefix;

        $prefix = trim($prefix);
        $prefix = '/' . trim($prefix, '/');
        if ($prefix === '/') {
            $prefix = '';
        }

        $this->prefix = rtrim($prev . $prefix, '/');

        $fn($this);

        $this->prefix = $prev;
        return $this;
    }

    public function get(string $path, HandlerInterface $handler, ?string $name = null, array $meta = []): self
    {
        return $this->add('GET', $path, $handler, $name, $meta);
    }

    public function post(string $path, HandlerInterface $handler, ?string $name = null, array $meta = []): self
    {
        return $this->add('POST', $path, $handler, $name, $meta);
    }

    public function put(string $path, HandlerInterface $handler, ?string $name = null, array $meta = []): self
    {
        return $this->add('PUT', $path, $handler, $name, $meta);
    }

    public function patch(string $path, HandlerInterface $handler, ?string $name = null, array $meta = []): self
    {
        return $this->add('PATCH', $path, $handler, $name, $meta);
    }

    public function delete(string $path, HandlerInterface $handler, ?string $name = null, array $meta = []): self
    {
        return $this->add('DELETE', $path, $handler, $name, $meta);
    }

    private function add(string $method, string $path, HandlerInterface $handler, ?string $name, array $meta): self
    {
        $path = '/' . ltrim($path, '/');

        $full = $this->prefix . $path;
        $full = '/' . ltrim($full, '/');

        $this->router->add(new Route($method, $full, $handler, $name, $meta));
        return $this;
    }
}
