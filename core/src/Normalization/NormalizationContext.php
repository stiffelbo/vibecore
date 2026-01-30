<?php declare(strict_types=1);

namespace VibeCore\Normalization;

final class NormalizationContext
{
    public function __construct(
        public readonly string $source = 'api', // api/import/cli/etc. (app decides)
    ) {}
}
