<?php declare(strict_types=1);

namespace VibeCore\Http;

final class RequestFactory
{
    public static function default(): self
    {
        return new self();
    }

    public function fromGlobals(): Request
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        $query = $_GET ?? [];
        $cookies = $_COOKIE ?? [];

        $headers = $this->extractHeaders($_SERVER);

        $body = $this->readBody($headers);

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        // base path = katalog gdzie leży index.php
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? ''; // np. /vibecore/app/index.php
        $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/'); // /vibecore/app

        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base));
            if ($path === '') $path = '/';
        }

        return new Request(
            method: strtoupper($method),
            path: $path,
            query: $query,
            headers: $headers,
            cookies: $cookies,
            body: $body,
        );
    }

    private function extractHeaders(array $server): array
    {
        $headers = [];

        foreach ($server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = strtolower(str_replace('_', '-', substr($key, 5)));
                $headers[$name] = $value;
            }
        }

        // Content-Type / Content-Length are special-cased in PHP
        if (isset($server['CONTENT_TYPE'])) {
            $headers['content-type'] = $server['CONTENT_TYPE'];
        }
        if (isset($server['CONTENT_LENGTH'])) {
            $headers['content-length'] = $server['CONTENT_LENGTH'];
        }

        return $headers;
    }

    private function readBody(array $headers): mixed
    {
        if (PHP_SAPI === 'cli') {
            return null;
        }

        $raw = file_get_contents('php://input');
        if ($raw === '' || $raw === false) {
            return null;
        }

        $contentType = $headers['content-type'] ?? '';

        if (str_contains($contentType, 'application/json')) {
            try {
                return json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
            } catch (\Throwable) {
                return null; // validation layer will handle invalid JSON
            }
        }

        return $raw;
    }
}
