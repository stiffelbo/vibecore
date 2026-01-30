<?php declare(strict_types=1);

namespace VibeCore\Normalization;

final class NormalizationResult
{
    /**
     * @param array<string, mixed> $data
     * @param array<int, array{path: string, from: mixed, to: mixed, rule: string}> $changes
     */
    public function __construct(
        public readonly array $data,
        public readonly array $changes = [],
    ) {}

    public static function unchanged(array $data): self
    {
        return new self($data, []);
    }

    public function changed(): bool
    {
        return $this->changes !== [];
    }
}
