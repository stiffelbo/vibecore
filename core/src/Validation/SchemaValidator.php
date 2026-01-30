<?php declare(strict_types=1);

namespace VibeCore\Validation;

use VibeCore\Schema\EntitySchema;
use VibeCore\Schema\FieldSchema;
use VibeCore\Schema\Types\{StringType};

final class SchemaValidator implements ValidatorInterface
{
    public function validate(array $input, EntitySchema $schema, ValidationContext $ctx): ValidationResult
    {
        $violations = [];

        /** @var FieldSchema $field */
        foreach ($schema->fields as $field) {
            $name = $field->name->value();
            $v = $field->validation;

            // no rules -> skip fast
            if (
                $v->required === false
                && $v->minLength === null
                && $v->maxLength === null
                && $v->min === null
                && $v->max === null
            ) {
                continue;
            }

            $exists = array_key_exists($name, $input);
            $value = $exists ? $input[$name] : null;

            // ---- required
            if ($v->required === true) {
                if (!$exists || $value === null || (is_string($value) && trim($value) === '')) {
                    $violations[] = new Violation(
                        path: $name,
                        code: 'required',
                        message: 'Field is required.',
                    );
                    // jeśli required nie spełnione, dalsze reguły często nie mają sensu
                    continue;
                }
            } else {
                // jeśli nie required i value brak/null -> nie walidujemy reszty
                if (!$exists || $value === null) {
                    continue;
                }
            }

            // ---- string length
            if ($field->type instanceof StringType && is_string($value)) {
                $len = mb_strlen($value);

                if ($v->minLength !== null && $len < $v->minLength) {
                    $violations[] = new Violation(
                        path: $name,
                        code: 'min_length',
                        message: 'Too short.',
                        meta: ['min' => $v->minLength, 'len' => $len],
                    );
                }

                if ($v->maxLength !== null && $len > $v->maxLength) {
                    $violations[] = new Violation(
                        path: $name,
                        code: 'max_length',
                        message: 'Too long.',
                        meta: ['max' => $v->maxLength, 'len' => $len],
                    );
                }
            }

            // ---- numeric min/max
            if (is_int($value) || is_float($value) || (is_string($value) && is_numeric($value))) {
                $num = is_string($value) ? (float)$value : (float)$value;

                if ($v->min !== null && $num < (float)$v->min) {
                    $violations[] = new Violation(
                        path: $name,
                        code: 'min',
                        message: 'Value is too small.',
                        meta: ['min' => $v->min, 'value' => $num],
                    );
                }

                if ($v->max !== null && $num > (float)$v->max) {
                    $violations[] = new Violation(
                        path: $name,
                        code: 'max',
                        message: 'Value is too large.',
                        meta: ['max' => $v->max, 'value' => $num],
                    );
                }
            }
        }

        return new ValidationResult($violations);
    }
}
