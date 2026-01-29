<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class ValidationMeta
{
    public function __construct(
        public readonly bool $required = false,
        public readonly ?int $minLength = null,
        public readonly ?int $maxLength = null,
        public readonly ?int $min = null,
        public readonly ?int $max = null,
    ) {}
}
