<?php declare(strict_types=1);

namespace VibeCore\Normalization;

use VibeCore\Schema\EntitySchema;
use VibeCore\Schema\FieldSchema;
use VibeCore\Schema\Types\{StringType, IntType, BoolType};

final class SchemaNormalizer implements NormalizerInterface
{
    public function normalize(array $input, EntitySchema $schema, NormalizationContext $ctx): NormalizationResult
    {
        $data = $input;
        $changes = [];

        /** @var FieldSchema $field */
        foreach ($schema->fields as $field) {
            $name = $field->name->value();

            if (!array_key_exists($name, $data)) {
                continue;
            }

            $before = $data[$name];
            $after = $before;

            // ---- 1) trim strings
            if ($field->type instanceof StringType && is_string($after)) {
                $trimmed = trim($after);
                if ($trimmed !== $after) {
                    $changes[] = ['path' => $name, 'from' => $after, 'to' => $trimmed, 'rule' => 'trim'];
                    $after = $trimmed;
                }
            }

            // ---- 2) empty string -> null (nullable columns)
            if ($after === '' && $field->db->nullable === true) {
                $changes[] = ['path' => $name, 'from' => '', 'to' => null, 'rule' => 'empty_to_null'];
                $after = null;
            }

            // ---- 3) cast int
            if ($field->type instanceof IntType) {
                $casted = $this->castInt($after);
                if ($casted !== $after) {
                    $changes[] = ['path' => $name, 'from' => $after, 'to' => $casted, 'rule' => 'cast_int'];
                    $after = $casted;
                }
            }

            // ---- 4) cast bool
            if ($field->type instanceof BoolType) {
                $casted = $this->castBool($after);
                if ($casted !== $after) {
                    $changes[] = ['path' => $name, 'from' => $after, 'to' => $casted, 'rule' => 'cast_bool'];
                    $after = $casted;
                }
            }

            $data[$name] = $after;
        }

        return new NormalizationResult($data, $changes);
    }

    private function castInt(mixed $v): mixed
    {
        if ($v === null) return null;
        if (is_int($v)) return $v;

        if (is_string($v)) {
            $s = trim($v);
            if ($s === '') return $v;
            if (preg_match('/^-?\d+$/', $s)) return (int)$s;
            return $v;
        }

        if (is_float($v) && floor($v) === $v) {
            return (int)$v;
        }

        return $v;
    }

    private function castBool(mixed $v): mixed
    {
        if ($v === null) return null;
        if (is_bool($v)) return $v;

        if (is_int($v) && ($v === 0 || $v === 1)) {
            return (bool)$v;
        }

        if (is_string($v)) {
            $s = strtolower(trim($v));
            if (in_array($s, ['1','true','yes','on'], true)) return true;
            if (in_array($s, ['0','false','no','off'], true)) return false;
        }

        return $v;
    }
}
