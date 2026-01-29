<?php declare(strict_types=1);

namespace VibeCore\Schema;

final class ActorSpec
{
    public function __construct(
        public readonly string $createdBy = 'created_by',
        public readonly string $updatedBy = 'updated_by',
        public readonly ?string $deletedBy = 'deleted_by',
    ) {}
}
