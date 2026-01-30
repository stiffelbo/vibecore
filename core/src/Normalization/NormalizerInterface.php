<?php declare(strict_types=1);

namespace VibeCore\Normalization;

use VibeCore\Schema\EntitySchema;

interface NormalizerInterface
{
    /**
     * @param array<string, mixed> $input
     */
    public function normalize(array $input, EntitySchema $schema, NormalizationContext $ctx): NormalizationResult;
}
