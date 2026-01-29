<?php declare(strict_types=1);

namespace VibeCore\Routing;

final class PathPattern
{
    private function __construct(
        private readonly string $regex,
        /** @var string[] */
        private readonly array $paramNames,
    ) {}

    public static function compile(string $pattern): self
    {
        if ($pattern === '' || $pattern[0] !== '/') {
            throw new \InvalidArgumentException("PathPattern: pattern must start with '/' (got '{$pattern}').");
        }

        $paramNames = [];

        $regex = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            function (array $m) use (&$paramNames): string {
                $paramNames[] = $m[1];
                return '([^\/]+)'; // one path segment
            },
            $pattern
        );

        if ($regex === null) {
            throw new \InvalidArgumentException("PathPattern: invalid pattern '{$pattern}'.");
        }

        return new self('#^' . $regex . '$#', $paramNames);
    }

    /**
     * @return array<string, string>|null
     */
    public function match(string $path): ?array
    {
        if (!preg_match($this->regex, $path, $m)) {
            return null;
        }

        array_shift($m); // drop full match

        $params = [];
        foreach ($this->paramNames as $i => $name) {
            $params[$name] = urldecode((string)($m[$i] ?? ''));
        }

        return $params;
    }
}
