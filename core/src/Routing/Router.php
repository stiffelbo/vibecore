<?php declare(strict_types=1);

namespace VibeCore\Routing;

final class Router implements RouterInterface
{
    /** @var array<int, array{route: Route, compiled: PathPattern}> */
    private array $routes = [];

    public function add(Route $route): void
    {
        $this->routes[] = [
            'route' => $route,
            'compiled' => PathPattern::compile($route->pattern),
        ];
    }

    public function match(string $method, string $path): ?RouteMatch
    {
        $method = strtoupper($method);

        foreach ($this->routes as $item) {
            $route = $item['route'];
            if ($route->methodUpper() !== $method) {
                continue;
            }

            $params = $item['compiled']->match($path);
            if ($params === null) {
                continue;
            }

            return new RouteMatch($route, $params);
        }

        return null;
    }
}
