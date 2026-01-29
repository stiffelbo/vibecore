<?php declare(strict_types=1);

namespace VibeCore\Schema\Ui;

final class EntityUiMeta
{
    public function __construct(
        public readonly ?string $labelSingular = null,
        public readonly ?string $labelPlural = null,
          
        public readonly ?string $createLabel = null, // e.g. Dodaj zgłoszenie
        public readonly ?string $editLabel = null, // e.g. "Edycja zgłoszenia"
        public readonly ?string $viewLabel = null,
        public readonly ?string $gridLabel = null,   // e.g. "Lista zgłoszeń"
        public readonly ?string $navGroup = null,    // e.g. "Jira"
        public readonly ?int $navOrder = null,
        public readonly ?string $icon = null,        // string key for frontend icon mapping

        public readonly array $props = [],
    ) {}
}
