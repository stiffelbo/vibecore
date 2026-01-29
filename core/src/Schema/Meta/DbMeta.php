<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class DbMeta
{
    public function __construct(
        public readonly ?string $column = null,        // override physical column name
        public readonly ?string $description = null,   // column comment/description intent

        public readonly bool $nullable = false,
        public readonly mixed $default = null,         // scalar default only (dialect expressions later)

        public readonly ?int $length = null,           // varchar/varbinary
        public readonly ?int $precision = null,        // decimal total digits
        public readonly ?int $scale = null,            // decimal fractional digits

        public readonly ?bool $unsigned = null,        // MySQL/MariaDB: INT/DECIMAL UNSIGNED
    ) {}
}
