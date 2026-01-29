<?php declare(strict_types=1);

namespace VibeCore\Schema\Meta;

enum WriteMode: string
{
    case INPUT = 'input';          // only from request/input
    case AUTO = 'auto';            // only computed/system-filled
    case INPUT_OR_AUTO = 'either'; // can be provided, but may be overridden
    case DERIVED = 'derived';      // computed from other fields, never accepted directly
}
