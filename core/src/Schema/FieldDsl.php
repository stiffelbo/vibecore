<?php

declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Support\FieldName;
use VibeCore\Schema\FieldSchema;
use VibeCore\Schema\Meta\{AccessMeta, DbMeta, ValidationMeta, UiFormMeta, UiGridMeta, UiMeta, WriteMeta, WriteMode};
use VibeCore\Schema\Types\{BoolType, DataType, IntType, StringType, DecimalType};

final class FieldDsl
{
    private UiMeta $ui;
    private ValidationMeta $validation;
    private AccessMeta $access;
    private WriteMeta $write;
    private DbMeta $db;

    private function __construct(
        private FieldName $name,
        private DataType $type,
    ) {
        $this->ui = new UiMeta();
        $this->validation = new ValidationMeta();
        $this->access = new AccessMeta();
        $this->db = new DbMeta();
        $this->write = new WriteMeta();
    }

    // factories
    public static function string(string $name): self
    {
        return new self(FieldName::from($name), new StringType());
    }
    public static function int(string $name): self
    {
        return new self(FieldName::from($name), new IntType());
    }
    public static function bool(string $name): self
    {
        return new self(FieldName::from($name), new BoolType());
    }
    public static function decimal(string $name): self
    {
        return new self(FieldName::from($name), new DecimalType());
    }

    // ---- access ceiling : no with method as only 2 properties
    public function viewable(bool $value = true): self
    {
        $this->access = new AccessMeta(viewable: $value, editable: $this->access->editable);
        return $this;
    }

    public function editable(bool $value = true): self
    {
        $this->access = new AccessMeta(viewable: $this->access->viewable, editable: $value);
        return $this;
    }

    // ---- validation intent
    public function required(bool $value = true): self
    {
        $this->withValidation(required: $value);
        return $this;
    }

    public function minLength(int $n): self
    {
        $this->withValidation(minLength: $n);
        return $this;
    }

    public function maxLength(int $n): self
    {
        $this->withValidation(maxLength: $n);
        return $this;
    }

    public function min(int $n): self
    {
        $this->withValidation(min: $n);
        return $this;
    }

    public function max(int $n): self
    {
        $this->withValidation(max: $n);
        return $this;
    }

    // ---- db intent
    public function column(string $column): self
    {
        $this->withDb(column: $column);
        return $this;
    }

    public function description(string $text): self
    {
        $this->withDb(description: $text);
        return $this;
    }

    public function nullable(bool $value = true): self
    {
        $this->withDb(nullable: $value);
        return $this;
    }

    public function default(mixed $value): self
    {
        $this->withDb(default: $value, setDefault: true);
        return $this;
    }

    public function length(int $n): self
    {
        $this->withDb(length: $n);
        return $this;
    }

    public function precision(int $n): self
    {
        $this->withDb(precision: $n);
        return $this;
    }

    public function scale(int $n): self
    {
        $this->withDb(scale: $n);
        return $this;
    }

    public function unsigned(bool $value = true): self
    {
        $this->withDb(unsigned: $value);
        return $this;
    }

    // ---- write intent

    public function write(
        WriteMode $mode,
        ?string $sourceKey = null,
        ?bool $onCreate = null,
        ?bool $onUpdate = null,
        ?array $extras = null,
    ): self {
        $this->withWrite(
            mode: $mode,
            sourceKey: $sourceKey,
            onCreate: $onCreate,
            onUpdate: $onUpdate,
            extras: $extras,
        );
        return $this;
    }

    public function auto(?string $sourceKey = null, ?bool $onUpdate = null): self
    {
        return $this->write(WriteMode::AUTO, sourceKey: $sourceKey, onUpdate: $onUpdate);
    }

    public function derived(?string $sourceKey = null): self
    {
        // derived usually shouldn't be written on create/update from input
        return $this->write(WriteMode::DERIVED, sourceKey: $sourceKey, onCreate: false, onUpdate: false);
    }

    public function inputOrAuto(?string $sourceKey = null): self
    {
        return $this->write(WriteMode::INPUT_OR_AUTO, sourceKey: $sourceKey);
    }

    // ---- ui intent (field)
    public function uiLabel(string $label, ?string $hint = null): self
    {
        $this->withUi(label: $label, hint: $hint);
        return $this;
    }

    public function section(string $section, ?int $order = null): self
    {
        $this->withUi(section: $section, order: $order);
        return $this;
    }

    public function order(int $order): self
    {
        $this->withUi(order: $order);
        return $this;
    }

    public function form(
        ?string $component = null,
        ?int $width = null,
        ?string $placeholder = null,
        array $props = [],
    ): self {
        $this->withUi(form: new UiFormMeta(
            component: $component,
            width: $width,
            placeholder: $placeholder,
            props: $props,
        ));
        return $this;
    }

    public function grid(
        ?int $width = null,
        ?int $flex = null,
        ?string $format = null,
        bool $visible = true,
    ): self {
        $this->withUi(grid: new UiGridMeta(
            visible: $visible,
            width: $width,
            flex: $flex,
            format: $format,
        ));
        return $this;
    }

    // sugar
    public function uiText(string $label, ?int $width = null): self
    {
        return $this->uiLabel($label)->form(component: 'text', width: $width);
    }

    //resolver

    public function toSchema(): FieldSchema
    {
        return new FieldSchema(
            name: $this->name,
            type: $this->type,
            ui: $this->ui,
            validation: $this->validation,
            access: $this->access,
            db: $this->db,
            write: $this->write,
        );
    }

    //Helpers

    private function withDb(
        ?string $column = null,
        ?string $description = null,
        ?bool $nullable = null,
        mixed $default = null,
        bool $setDefault = false,
        ?int $length = null,
        ?int $precision = null,
        ?int $scale = null,
        ?bool $unsigned = null,
    ): void {
        $this->db = new DbMeta(
            column: $column ?? $this->db->column,
            description: $description ?? $this->db->description,
            nullable: $nullable ?? $this->db->nullable,
            default: $setDefault ? $default : $this->db->default,
            length: $length ?? $this->db->length,
            precision: $precision ?? $this->db->precision,
            scale: $scale ?? $this->db->scale,
            unsigned: $unsigned ?? $this->db->unsigned,
        );
    }

    private function withWrite(
        ?\VibeCore\Schema\Meta\WriteMode $mode = null,
        ?bool $onCreate = null,
        ?bool $onUpdate = null,
        ?string $sourceKey = null,
        ?array $extras = null,
    ): void {
        $this->write = new WriteMeta(
            mode: $mode ?? $this->write->mode,
            onCreate: $onCreate ?? $this->write->onCreate,
            onUpdate: $onUpdate ?? $this->write->onUpdate,
            sourceKey: $sourceKey ?? $this->write->sourceKey,
            extras: $extras ?? $this->write->extras,
        );
    }

    private function withValidation(
        ?bool $required = null,
        ?int $minLength = null,
        ?int $maxLength = null,
        ?int $min = null,
        ?int $max = null,
    ): void {
        $this->validation = new ValidationMeta(
            required: $required ?? $this->validation->required,
            minLength: $minLength ?? $this->validation->minLength,
            maxLength: $maxLength ?? $this->validation->maxLength,
            min: $min ?? $this->validation->min,
            max: $max ?? $this->validation->max,
        );
    }

    private function withUi(
        ?string $label = null,
        ?string $hint = null,
        ?string $section = null,
        ?int $order = null,
        ?UiFormMeta $form = null,
        ?UiGridMeta $grid = null,
    ): void {
        $this->ui = new UiMeta(
            label: $label ?? $this->ui->label,
            hint: $hint ?? $this->ui->hint,
            section: $section ?? $this->ui->section,
            order: $order ?? $this->ui->order,
            form: $form ?? $this->ui->form,
            grid: $grid ?? $this->ui->grid,
        );
    }
}
