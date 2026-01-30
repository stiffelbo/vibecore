<?php declare(strict_types=1);

namespace VibeCore\Validation;

final class ValidationContext
{
    public function __construct(
        public readonly string $source = 'api',          // api|import|cli|sync (app decides)
        public readonly bool $partial = false,           // update/patch semantics (Stage decides)
        public readonly bool $strict = true,             // future: strict vs lenient
    ) {}

    public static function api(bool $partial = false): self
    {
        return new self(source: 'api', partial: $partial, strict: true);
    }

    public static function import(bool $partial = false): self
    {
        return new self(source: 'import', partial: $partial, strict: false);
    }
}
