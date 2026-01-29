<?php declare(strict_types=1);

namespace VibeCore\Schema;

final class TimestampsSpec
{
    public function __construct(
        public readonly string $createdAt = 'created_at',
        public readonly string $updatedAt = 'updated_at',
    ) {}
}
