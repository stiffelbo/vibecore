<?php declare(strict_types=1);

namespace VibeCore\Routing;

interface RouterInterface
{
    public function add(Route $route): void;

    public function match(string $method, string $path): ?RouteMatch;
}
