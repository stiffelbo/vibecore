<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

final class UiMeta
{
    public function __construct(
        public readonly ?string $label = null,
        public readonly ?string $hint = null,
        public readonly ?string $section = null,   // grouping in forms
        public readonly ?int $order = null,        // ordering within a section
        public readonly ?UiFormMeta $form = null,
        public readonly ?UiGridMeta $grid = null,
    ) {}
}
