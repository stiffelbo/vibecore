<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class UiGridMeta
{
    /**
     * @param array<string, mixed> $props JSON-serializable grid column props
     */
    public function __construct(
        public readonly bool $visible = true,
        public readonly ?int $width = null,
        public readonly ?int $minWidth = null,
        public readonly ?int $flex = null,
        public readonly bool $sortable = true,
        public readonly bool $filterable = true,
        public readonly bool $groupable = true,
        public readonly ?string $align = null,      // "left" | "center" | "right"
        public readonly ?string $format = null,     // "date" | "datetime" | "currency" | ...
        public readonly ?string $valueKey = null,   // string key for UI value getter/formatter
        public readonly ?string $aggregation = null, // string key aggregation function in grid
        public readonly array $props = [],
    ) {}
}
