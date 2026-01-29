# VibeCore/Validation

## Intent

Provide schema-driven validation primitives that can validate input deterministically.
Validation is derived from Schema intent and produces violations — it does not perform persistence checks.

## Responsibilities

Validation contracts and result objects (violations list, error codes, paths)

Schema-based validation engine (required/min/max/length, etc.)

Field-level validation extraction from ValidationMeta

Support for composing validators (chain/registry) without reflection

## Non-goals

No HTTP request parsing

No database-backed validation (e.g., uniqueness checks) in core

No domain business rules (belongs to VibeApp domain/services)

No UI rendering of errors (only structured violations)

## Public contracts (examples)

ValidatorInterface (validate(data, schema, context): ValidationResult)

ValidationResult (VO)

Violation (VO: path/code/message/meta)

SchemaValidator (default implementation)

ValidationContext (optional VO)

## Dependencies

Depends on Schema (ValidationMeta, FieldSchema)

May depend on Support

Must not depend on Http directly

Must not depend on Persistence implementations