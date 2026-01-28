<?php declare(strict_types=1);

namespace VibeCore\Schema\Types;

interface DataType
{
    /**
     * Stable identifier for transformers and clients (UI, validation, persistence).
     * Examples: "string", "int", "bool".
     */
    public function id(): string;
}
