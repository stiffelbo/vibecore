<?php declare(strict_types=1);

namespace VibeCore\Schema\Types;

final class BoolType implements DataType
{
    public function id(): string
    {
        return 'bool';
    }
}
