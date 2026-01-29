<?php declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Support\EntityName;

final class EntitySchema
{
    public function __construct(
        public readonly EntityName $name,
        public readonly FieldCollection $fields,
        public readonly BehavioursSchema $behaviours,
        public readonly DbSchema $db,
        public readonly ?string $description = null, // neutral (docs/UI); db->description = table intent
    ) {}
}
