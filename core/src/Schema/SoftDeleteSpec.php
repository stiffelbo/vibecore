<?php declare(strict_types=1);

namespace VibeCore\Schema;

final class SoftDeleteSpec
{
    public function __construct(
        public readonly string $deletedAt = 'deleted_at',
    ) {}
}
