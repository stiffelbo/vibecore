<?php declare(strict_types=1);

namespace VibeCore\Schema;

final class BehavioursSchema
{
    public function __construct(
        public readonly ?TimestampsSpec $timestamps = new TimestampsSpec(),
        public readonly ?SoftDeleteSpec $softDelete = null,
        public readonly ?ActorSpec $actor = null,
    ) {}
}
