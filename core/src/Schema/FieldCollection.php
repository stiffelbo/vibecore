<?php declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Support\FieldName;

final class FieldCollection implements \IteratorAggregate
{
    /** @var array<string, FieldSchema> */
    private array $byName = [];

    /**
     * @param FieldSchema[] $fields
     */
    public function __construct(array $fields)
    {
        foreach ($fields as $field) {
            $key = $field->name->value();

            if (isset($this->byName[$key])) {
                throw new \InvalidArgumentException("Duplicate field '{$key}' in entity schema.");
            }

            $this->byName[$key] = $field;
        }
    }

    public function has(FieldName $name): bool
    {
        return isset($this->byName[$name->value()]);
    }

    public function get(FieldName $name): FieldSchema
    {
        $key = $name->value();

        if (!isset($this->byName[$key])) {
            throw new \OutOfBoundsException("Unknown field '{$key}' in entity schema.");
        }

        return $this->byName[$key];
    }

    /**
     * @return FieldSchema[]
     */
    public function all(): array
    {
        return array_values($this->byName);
    }

    /**
     * @return \Traversable<FieldSchema>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->all());
    }
}
