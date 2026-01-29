<?php declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Schema\{TimestampsSpec, SoftDeleteSpec, ActorSpec};

final class BehavioursSchema
{
    public function __construct(
        public readonly ?TimestampsSpec $timestamps = new TimestampsSpec(),
        public readonly ?SoftDeleteSpec $softDelete = null,
        public readonly ?ActorSpec $actor = null,
    ) {}
}
