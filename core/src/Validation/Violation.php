<?php declare(strict_types=1);

namespace VibeCore\Validation;

final class Violation
{
    /**
     * @param array<string, mixed> $meta
     */
    public function __construct(
        public readonly string $path,     // field name (or dotted path later)
        public readonly string $code,     // e.g. required, min_length
        public readonly string $message,  // human readable (MVP)
        public readonly array $meta = [],
    ) {}
}
