<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class AccessMeta
{
    public function __construct(
        public readonly bool $viewable = true,
        public readonly bool $editable = false, // capability ceiling
    ) {}
}
