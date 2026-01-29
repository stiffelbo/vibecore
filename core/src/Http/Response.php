<?php declare(strict_types=1);

namespace VibeCore\Http;

final class Response
{
    public function __construct(
        private readonly int $status,
        private readonly string $body = '',
        private readonly array $headers = [],
    ) {}

    public static function json(
        array|object $data,
        int $status = 200,
        array $headers = []
    ): self {
        return new self(
            $status,
            json_encode($data, JSON_THROW_ON_ERROR),
            array_merge(
                ['Content-Type' => 'application/json; charset=utf-8'],
                $headers
            )
        );
    }

    public static function text(
        string $text,
        int $status = 200,
        array $headers = []
    ): self {
        return new self(
            $status,
            $text,
            array_merge(
                ['Content-Type' => 'text/plain; charset=utf-8'],
                $headers
            )
        );
    }

    public function status(): int
    {
        return $this->status;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function withHeader(string $name, string $value): self
    {
        $headers = $this->headers;
        $headers[$name] = $value;

        return new self($this->status, $this->body, $headers);
    }
}
