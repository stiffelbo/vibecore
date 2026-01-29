<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class UiFormMeta
{
    /**
     * @param array<string, mixed> $props  JSON-serializable UI props
     * @param array<int, array<string, mixed>>|null $options  e.g. [{value,label}] or richer objects
     */
    public function __construct(
        public readonly ?string $component = null,   // "text" | "number" | "select" | ...
        public readonly ?string $placeholder = null,
        public readonly ?int $width = null,
        public readonly bool $multiline = false,
        public readonly ?int $rows = null,
        public readonly bool $readOnly = false,
        public readonly ?array $options = null,
        public readonly ?string $optionsRef = null,  // reference key (frontend resolves)
        public readonly array $props = [],
    ) {}
}
