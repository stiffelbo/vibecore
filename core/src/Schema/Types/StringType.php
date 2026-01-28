<?php declare(strict_types=1);

namespace VibeCore\Schema\Types;

final class StringType implements DataType
{
    public function id(): string
    {
        return 'string';
    }
}
