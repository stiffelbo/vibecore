<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class WriteMeta
{
    public function __construct(
        public readonly WriteMode $mode = WriteMode::INPUT,
        public readonly bool $onCreate = true,
        public readonly bool $onUpdate = true,
        public readonly ?string $sourceKey = null, // e.g. "clockify.author" or "resolveUserByEmail"
        public readonly array $extras = [],
    ) {}
}
