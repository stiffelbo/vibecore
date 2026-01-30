<?php declare(strict_types=1);

namespace VibeCore\Validation;

use VibeCore\Schema\EntitySchema;

interface ValidatorInterface
{
    /**
     * Validate input data against schema and context.
     *
     * @param array<string, mixed> $input
     */
    public function validate(
        array $input,
        EntitySchema $schema,
        ValidationContext $ctx
    ): ValidationResult;
}
