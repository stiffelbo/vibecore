<?php declare(strict_types=1);

namespace VibeCore\Schema;

final class DbSchema
{
    /**
     * @param array<int, mixed> $indexes
     * @param array<int, mixed> $uniques
     * @param array<int, mixed> $foreignKeys
     */
    public function __construct(
        public readonly ?string $description = null, // table comment/description intent
        public readonly array $indexes = [],
        public readonly array $uniques = [],
        public readonly array $foreignKeys = [],
    ) {}
}
