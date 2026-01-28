<?php declare(strict_types=1);

namespace VibeCore\Schema\Types;

final class IntType implements DataType
{
    public function id(): string
    {
        return 'int';
    }
}
