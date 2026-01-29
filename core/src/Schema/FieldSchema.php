<?php declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Support\FieldName;
use VibeCore\Schema\Types\DataType;
use VibeCore\Schema\Meta\{UiMeta, ValidationMeta, AccessMeta, DbMeta, WriteMeta};

final class FieldSchema
{
    public function __construct(
        public readonly FieldName $name,
        public readonly DataType $type,
        public readonly UiMeta $ui,
        public readonly ValidationMeta $validation,
        public readonly AccessMeta $access,
        public readonly DbMeta $db,
        public readonly WriteMeta $write,
    ) {}
}
