<?php declare(strict_types=1);

namespace VibeCore\Bootstrap;

final class Env
{
    public static function get(string $key, ?string $default = null): ?string
    {
        $v = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($v === false || $v === null || $v === '') {
            return $default;
        }
        return (string)$v;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $v = self::get($key);
        if ($v === null) return $default;

        return in_array(strtolower($v), ['1','true','yes','on'], true);
    }

    public static function int(string $key, int $default = 0): int
    {
        $v = self::get($key);
        if ($v === null) return $default;

        return (int)$v;
    }
}
