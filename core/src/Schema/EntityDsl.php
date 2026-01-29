<?php declare(strict_types=1);

namespace VibeCore\Schema;

use VibeCore\Support\EntityName;
use VibeCore\Support\FieldName;
use VibeCore\Schema\Meta\{AccessMeta, DbMeta, UiMeta, ValidationMeta, WriteMeta, WriteMode};
use VibeCore\Schema\Types\{DateTimeType, IntType};

final class EntityDsl
{
    /** @var FieldDsl[] */
    private array $fields = [];

    private BehavioursSchema $behaviours;
    private DbSchema $db;
    private ?string $description = null;

    private function __construct(private EntityName $name)
    {
        $this->behaviours = new BehavioursSchema();
        $this->db = new DbSchema();
    }

    public static function define(string $name): self
    {
        return new self(EntityName::from($name));
    }

    public function description(?string $text): self
    {
        $this->description = $text;
        return $this;
    }

    public function fields(FieldDsl ...$fields): self
    {
        foreach ($fields as $f) {
            $this->fields[] = $f;
        }
        return $this;
    }

    // ---- behaviours
    public function timestamps(?string $createdAt = null, ?string $updatedAt = null): self
    {
        $this->behaviours = new BehavioursSchema(
            timestamps: new TimestampsSpec(
                createdAt: $createdAt ?? 'created_at',
                updatedAt: $updatedAt ?? 'updated_at',
            ),
            softDelete: $this->behaviours->softDelete,
            actor: $this->behaviours->actor,
        );
        return $this;
    }

    public function noTimestamps(): self
    {
        $this->behaviours = new BehavioursSchema(
            timestamps: null,
            softDelete: $this->behaviours->softDelete,
            actor: $this->behaviours->actor,
        );
        return $this;
    }

    public function softDelete(?string $deletedAt = null): self
    {
        $this->behaviours = new BehavioursSchema(
            timestamps: $this->behaviours->timestamps,
            softDelete: new SoftDeleteSpec(deletedAt: $deletedAt ?? 'deleted_at'),
            actor: $this->behaviours->actor,
        );
        return $this;
    }

    public function actorSignature(?string $createdBy = null, ?string $updatedBy = null, ?string $deletedBy = 'deleted_by'): self
    {
        $this->behaviours = new BehavioursSchema(
            timestamps: $this->behaviours->timestamps,
            softDelete: $this->behaviours->softDelete,
            actor: new ActorSpec(
                createdBy: $createdBy ?? 'created_by',
                updatedBy: $updatedBy ?? 'updated_by',
                deletedBy: $deletedBy,
            ),
        );
        return $this;
    }

    // ---- db (entity-level)
    public function dbDescription(?string $text): self
    {
        $this->db = new DbSchema(
            description: $text,
            indexes: $this->db->indexes,
            uniques: $this->db->uniques,
            foreignKeys: $this->db->foreignKeys,
        );
        return $this;
    }

    public function toSchema(): EntitySchema
    {
        // 1) freeze explicit fields
        $explicitFieldSchemas = [];
        foreach ($this->fields as $fieldDsl) {
            $explicitFieldSchemas[] = $fieldDsl->toSchema();
        }

        // 2) materialize behaviour fields (and detect conflicts)
        $all = $explicitFieldSchemas;
        $byName = [];
        foreach ($explicitFieldSchemas as $fs) {
            $byName[$fs->name->value()] = true;
        }

        foreach ($this->behaviourFieldSchemas() as $autoField) {
            $key = $autoField->name->value();
            if (isset($byName[$key])) {
                throw new \InvalidArgumentException(
                    "Behaviour field '{$key}' conflicts with explicitly defined field in entity '{$this->name->value()}'."
                );
            }
            $byName[$key] = true;
            $all[] = $autoField;
        }

        return new EntitySchema(
            name: $this->name,
            fields: new FieldCollection($all),
            behaviours: $this->behaviours,
            db: $this->db,
            description: $this->description,
        );
    }

    /**
     * @return FieldSchema[]
     */
    private function behaviourFieldSchemas(): array
    {
        $fields = [];

        // timestamps
        if ($this->behaviours->timestamps !== null) {
            $ts = $this->behaviours->timestamps;

            $fields[] = $this->autoFieldDateTime($ts->createdAt, nullable: false);
            $fields[] = $this->autoFieldDateTime($ts->updatedAt, nullable: false);
        }

        // soft delete
        if ($this->behaviours->softDelete !== null) {
            $sd = $this->behaviours->softDelete;

            $fields[] = $this->autoFieldDateTime($sd->deletedAt, nullable: true);
        }

        // actor signature
        if ($this->behaviours->actor !== null) {
            $a = $this->behaviours->actor;

            $fields[] = $this->autoFieldIntId($a->createdBy, nullable: true);
            $fields[] = $this->autoFieldIntId($a->updatedBy, nullable: true);

            if ($a->deletedBy !== null) {
                $fields[] = $this->autoFieldIntId($a->deletedBy, nullable: true);
            }
        }

        return $fields;
    }

    private function autoFieldDateTime(string $name, bool $nullable): FieldSchema
    {
        return new FieldSchema(
            name: FieldName::from($name),
            type: new DateTimeType(),
            ui: new UiMeta(),
            validation: new ValidationMeta(),
            access: new AccessMeta(viewable: true, editable: false),
            db: new DbMeta(nullable: $nullable),
            write: new WriteMeta(mode: WriteMode::AUTO, onCreate: true, onUpdate: true),
        );
    }

    private function autoFieldIntId(string $name, bool $nullable): FieldSchema
    {
        return new FieldSchema(
            name: FieldName::from($name),
            type: new IntType(),
            ui: new UiMeta(),
            validation: new ValidationMeta(),
            access: new AccessMeta(viewable: true, editable: false),
            db: new DbMeta(nullable: $nullable, unsigned: true),
            write: new WriteMeta(mode: WriteMode::AUTO, onCreate: true, onUpdate: true),
        );
    }
}
